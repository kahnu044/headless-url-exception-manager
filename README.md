# Headless URL Exception Manager

Headless URL Exception Manager is a WordPress plugin that allows administrators to manage URLs that should be ignored from redirection when in Headless Mode. This plugin provides an easy way to input a list of URLs that will be exempt from any headless mode redirection.

## Features

- Admin settings page for adding and managing ignored URLs.
- URLs can be added line-by-line via a simple textarea input.
- Prevents specific URLs from being redirected in Headless Mode.
- Supports partial URL matching, allowing flexibility in ignoring sub-paths or full URLs.

## Installation

1. Download the plugin as a `.zip` file or clone the repository.
   ```bash
   git clone https://github.com/kahnu044/headless-url-exception-manager.git
   ```
2. Upload the plugin folder to the `/wp-content/plugins/` directory.
3. Activate the plugin through the 'Plugins' menu in WordPress.
4. Navigate to the **Settings > Headless URL Exception** page to configure the URLs you wish to exclude from redirection.

## Usage

1. After activation, go to the **Settings > Headless URL Exception** page.
2. In the textarea, add URLs you wish to exclude from redirection. Each URL should be on a new line. For example:
   ```
   /sample-page
   /another-page
   /category/example
   ```
3. Save your changes.
4. The URLs listed in the textarea will now be ignored by the Headless Mode redirection mechanism.

### URL Matching

The plugin matches URLs using a partial match strategy. This means if the current request path contains any of the ignored URLs you input, the page will be excluded from redirection.

For example, if you input `/sample-page`, the plugin will prevent redirection for any request containing that string, including:
- `/sample-page`
- `/sample-page/sub-page`

## Hooks

This plugin utilizes the `headless_mode_will_redirect` filter to control whether a redirect should occur.

### Filter: `headless_mode_will_redirect`

This filter checks the list of ignored URLs before allowing any redirection. If a URL matches any of the ignored patterns, the redirection is skipped.

```php
apply_filters('headless_mode_will_redirect', $will_redirect, $new_url);
```

## Customization

You can customize the plugin by modifying the URLs excluded from redirection via the **Ignored URLs** setting. This can be done directly from the WordPress admin panel without needing to touch the code.

## Development

Feel free to fork this repository and contribute to its development. You can install the plugin as follows:

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
```

### Key Sections:
- **Features**: A quick summary of what the plugin does.
- **Installation**: How to install and activate the plugin in WordPress.
- **Usage**: Instructions on how to use the plugin once it's installed.
- **Hooks**: Information about any WordPress hooks used in the plugin.
- **Customization**: How to modify the settings dynamically via the admin panel.
- **Development**: For developers who want to contribute or fork the project.

Feel free to modify the `README.md` further as needed!