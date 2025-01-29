# Headless URL Exception Manager

Headless URL Exception Manager is a WordPress plugin that allows administrators to manage URLs that should be ignored from redirection when in Headless Mode. This plugin provides an easy way to input a list of URLs that will be exempt from any headless mode redirection.

## Features

- Admin settings page for adding and managing ignored URLs.
- URLs can be added line-by-line via a simple textarea input.
- Prevents specific URLs from being redirected in Headless Mode.
- Supports partial URL matching, allowing flexibility in ignoring sub-paths or full URLs.

## Installation

### Prerequisites

Before installing **Headless URL Exception Manager**, you need to install and activate the **Headless Mode** plugin. The **Headless Mode** plugin is responsible for performing the redirection logic, and this plugin adds the functionality to exclude certain URLs from being redirected.

1. Install **[Headless Mode](https://github.com/Shelob9/headless-mode)** by following the instructions in their [repository](https://github.com/Shelob9/headless-mode).
2. After installing the **Headless Mode** plugin, download and install **Headless URL Exception Manager**:

   - Download the plugin as a `.zip` file or clone the repository.
     ```bash
     git clone https://github.com/kahnu044/headless-url-exception-manager.git
     ```
   - Upload the plugin folder to the `/wp-content/plugins/` directory.
   - Activate the plugin through the **Plugins** menu in WordPress.

### Configure the Plugin

After activation, follow these steps to configure the plugin:

1. Go to **Settings > Headless URL Exception** in the WordPress admin menu.
2. In the **Ignored URLs** textarea, add the URLs you want to exclude from redirection. Each URL should be on a new line. For example:
   ```
   /sample-page
   /another-page
   /category/example
   ```
3. Save your changes. The listed URLs will now be excluded from redirection by the **Headless Mode** plugin.

## Usage

- The URLs listed in the **Ignored URLs** setting will be checked against the current request path. If a match is found, the URL will be excluded from redirection in **Headless Mode**.

### URL Matching

The plugin matches URLs using a partial match strategy. For example, if you input `/sample-page`, it will prevent redirection for any request containing `/sample-page`.

## Filter Hook

This plugin uses the `headless_mode_will_redirect` filter hook provided by the **Headless Mode** plugin. The hook checks the list of ignored URLs before allowing any redirection. If a URL matches any of the ignored patterns, the redirection is skipped.

### Filter Hook Example:

```php
apply_filters('headless_mode_will_redirect', $will_redirect, $new_url);
```

- `$will_redirect`: Boolean value indicating whether the redirection should happen.
- `$new_url`: The URL to which the request is attempting to redirect.

You can customize the redirection behavior by utilizing this filter hook if needed.

## Development

Feel free to fork this repository and contribute to its development. To install the plugin for development, follow these steps:

```bash
git clone https://github.com/kahnu044/headless-url-exception-manager.git
cd headless-url-exception-manager
```

### Version

1.0.0

## Author

- [kahnu044](https://github.com/kahnu044)

## License

This plugin is open-source and licensed under the [MIT License](LICENSE).
