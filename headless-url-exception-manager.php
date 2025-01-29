<?php

/**
 * Plugin Name: Headless URL Exception Manager
 * Description: Allows users to input URLs that should be ignored from redirection in Headless Mode.
 * Version: 1.0.0
 * Author: kahnu044
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
        'sanitize_callback' => 'sanitize_textarea_field',
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
            if (strpos($current_request, $ignored_url) !== false) {
                return false;
            }
        }
    }

    // For no exception match, proceed with redirection
    return $will_redirect;
}
