<?php

/**
 * Plugin Name: Headless URL Exception Manager
 * Plugin URI: https://github.com/kahnu044/headless-url-exception-manager
 * Description: Allows users to input URLs that should be ignored from redirection in Headless Mode.
 * Version: 1.0.0
 * Author: kahnu044
 * Author URI: https://github.com/kahnu044
 */


//  Admin menu in setting page
add_action('admin_menu', 'headless_url_exception_manager_menu');

function headless_url_exception_manager_menu()
{
    add_options_page(
        'Headless URL Exception',
        'Headless URL Exception',
        'manage_options',
        'headless-url-exception-manager',
        'headless_url_exception_manager_settings_page'
    );
}

function headless_url_exception_manager_settings_page()
{
?>
    <div class="wrap">
        <h1>Headless URL Exception Manager</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('headless_url_exception_manager_options_group');
            do_settings_sections('headless-url-exception-manager');
            submit_button();
            ?>
        </form>
    </div>
<?php
}

add_action('admin_init', 'headless_url_exception_settings');
function headless_url_exception_settings()
{
    register_setting('headless_url_exception_manager_options_group', 'headless_url_exception_ignored_urls', array(
        'type' => 'string',
        'sanitize_callback' => 'headless_url_exception_sanitize_urls',
        'default' => ''
    ));

    add_settings_section('headless_url_exception_section', '', null, 'headless-url-exception-manager');
    add_settings_field(
        'headless_url_exception_ignored_urls',
        'Ignored URLs (one per line)',
        'headless_url_exception_ignored_urls_render',
        'headless-url-exception-manager',
        'headless_url_exception_section'
    );
}

// Render the textarea field for ignored URLs
function headless_url_exception_ignored_urls_render()
{
    $ignored_urls = get_option('headless_url_exception_ignored_urls', '');
    echo '<textarea name="headless_url_exception_ignored_urls" rows="10" class="regular-text">' . esc_textarea($ignored_urls) . '</textarea>';
}

// Sanitize the input URLs to handle full URLs, trailing slashes
function headless_url_exception_sanitize_urls($input)
{
    // Split by new line to get each URL separately
    $urls = explode("\n", $input);
    $sanitized_urls = array();

    foreach ($urls as $url) {
        $url = trim($url);

        // get only the path from full URL
        $parsed_url = parse_url($url);
        if (isset($parsed_url['path'])) {
            $url = $parsed_url['path'];
        }

        // Remove leading and trailing slashes
        $url = trim($url, '/');

        // Add slashes back
        if (!preg_match('/^\/.*\/$/', $url)) {
            $url = '/' . $url;
        }

        $sanitized_urls[] = $url;

    }

    return implode("\n", $sanitized_urls);
}

add_filter('headless_mode_will_redirect', 'headless_url_exception_ignored_urls_filter', 10, 2);
function headless_url_exception_ignored_urls_filter($will_redirect, $new_url)
{
    global $wp;

    $ignored_urls = get_option('headless_url_exception_ignored_urls', '');

    if (!empty($ignored_urls)) {

        $ignored_urls_array = array_map('trim', explode("\n", $ignored_urls));

        // Get the current request path
        $current_request = $wp->request;

        // Skip redirection
        foreach ($ignored_urls_array as $ignored_url) {

            // Skip redirect if regex matches
            if (handle_regex_exceptions($ignored_url, $current_request)) {
                return false;
            }

            // If it's a path, use strpos for normal URL path matching
            if (strpos($current_request, trim($ignored_url, '/')) !== false) {
                return false;
            }
        }
    }

    // For no exception match, proceed with redirection
    return $will_redirect;
}

function handle_regex_exceptions($regex, $current_request)
{
    $trimmed_regex = ltrim(rtrim(trim($regex), '/'), '/');
    if (!empty($trimmed_regex) && preg_match("|{$trimmed_regex}|", $current_request)) {
        return true;
    }
    return false;
}
