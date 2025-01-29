# Headless URL Exception Manager

**Headless URL Exception Manager** is a WordPress plugin that allows administrators to manage URLs that should be excluded from redirection in **Headless Mode**. This plugin provides an easy interface for inputting a list of URLs or regex patterns that will be ignored during redirection, giving flexibility to bypass specific paths.

## Features

- Admin settings page for adding and managing ignored URLs or regex patterns.
- URLs or patterns can be added line-by-line via a simple textarea input.
- Prevents specific URLs or regex-matching URLs from being redirected in Headless Mode.
- Supports regex-based matching, allowing flexible exclusion for complex patterns.
- Normal paths can be added and ignored using exact partial matches.
- Handles dynamic and complex URL structures.

## Installation

### Prerequisites

Before installing **Headless URL Exception Manager**, you need to install and activate the **Headless Mode** plugin. The **Headless Mode** plugin is responsible for performing the redirection logic, and this plugin adds the functionality to exclude certain URLs from being redirected.

1. Install **[Headless Mode](https://github.com/Shelob9/headless-mode)** by following the instructions in their [repository](https://github.com/Shelob9/headless-mode).
2. After installing the **Headless Mode** plugin, download and install **Headless URL Exception Manager**:

   - Download the plugin as a `.zip` file or clone the repository:
     ```bash
     git clone https://github.com/kahnu044/headless-url-exception-manager.git
     ```
   - Upload the plugin folder to the `/wp-content/plugins/` directory.
   - Activate the plugin through the **Plugins** menu in WordPress.

### Configure the Plugin

After activation, follow these steps to configure the plugin:

1. Go to **Settings > Headless URL Exception** in the WordPress admin menu.
2. In the **Ignored URLs** textarea, add the URLs or regex patterns you want to exclude from redirection. Each URL or pattern should be on a new line. For example:
   ```
   /sample-page
   /another-page
   /category/example
   /(.*)\.xml
   /(.*)\.json
   ```
3. Save your changes. The listed URLs and regex patterns will now be excluded from redirection by the **Headless Mode** plugin.

## Usage

- The URLs and regex patterns listed in the **Ignored URLs** setting will be checked against the current request path. If a match is found (either partial or regex), the URL will be excluded from redirection in **Headless Mode**.

### URL Matching

- The plugin supports **partial URL matching** and **regex-based matching**.
  - For exact matches (e.g., `/sample-page`), redirection will be excluded if the request contains this path.
  - For regex patterns (e.g., `/(.*)\.xml`), the request path is checked against the pattern, and if it matches, the redirection is skipped.

## Filter Hook

This plugin utilizes the `headless_mode_will_redirect` filter hook provided by the **Headless Mode** plugin. This hook checks the list of ignored URLs and regex patterns before allowing any redirection. If a URL matches any of the ignored patterns, the redirection will be skipped.

### Example Usage of the Filter Hook:

```php
apply_filters('headless_mode_will_redirect', $will_redirect, $new_url);
```

- `$will_redirect`: A boolean value indicating whether the redirection should occur.
- `$new_url`: The URL the request is attempting to redirect to.

You can customize redirection behavior by using this filter hook in your theme or plugin.

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

This plugin is open-source and licensed under the [MIT License](https://opensource.org/license/mit).
