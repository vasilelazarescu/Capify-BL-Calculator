# Development Environment Setup Guide

This guide will help you set up the development environment for the Capify Business Loan Calculator plugin with modern dependency management and build tools.

## Prerequisites

- **PHP:** 7.4 or higher
- **Node.js:** 14.0 or higher
- **npm:** 6.0 or higher
- **Composer:** 2.0 or higher

## Quick Start

### 1. Install Dependencies

```bash
# Install PHP dependencies (development tools)
composer install

# Install Node.js dependencies (build tools)
npm install
```

### 2. Build Assets

```bash
# Build minified CSS and JavaScript files
npm run build

# Or watch for changes during development
npm run dev
```

### 3. Run Code Quality Checks

```bash
# Check PHP code style
composer phpcs

# Fix PHP code style issues automatically
composer phpcs:fix

# Run PHP static analysis
composer phpstan

# Check JavaScript code style
npm run lint:js

# Fix JavaScript code style issues automatically
npm run lint:js:fix
```

## Available Commands

### NPM Scripts

| Command | Description |
|---------|-------------|
| `npm run build` | Build minified production assets |
| `npm run build:js` | Build JavaScript only |
| `npm run build:css` | Build CSS only |
| `npm run watch` | Watch for changes and rebuild automatically |
| `npm run dev` | Alias for watch (development mode) |
| `npm run lint:js` | Check JavaScript code style |
| `npm run lint:js:fix` | Fix JavaScript code style issues |
| `npm run clean` | Remove all built files |

### Composer Scripts

| Command | Description |
|---------|-------------|
| `composer phpcs` | Check PHP code against WordPress standards |
| `composer phpcs:fix` | Automatically fix PHP code style issues |
| `composer phpstan` | Run static analysis on PHP code |
| `composer check` | Run all checks (phpcs + phpstan) |

## Development Workflow

### 1. Making Code Changes

```bash
# Start the watch process
npm run dev

# Make your changes to:
# - capify-loan-calculator/assets/js/calculator.js
# - capify-loan-calculator/assets/css/calculator.css
# - capify-loan-calculator/**/*.php

# Files will automatically rebuild on save
```

### 2. Before Committing

```bash
# Run all quality checks
composer check
npm run lint:js

# Build production assets
npm run build

# Test the plugin in WordPress
```

### 3. Production Deployment

The plugin should be deployed with minified assets:

```bash
# Build production assets
npm run build

# The following files will be created:
# - capify-loan-calculator/assets/js/calculator.min.js
# - capify-loan-calculator/assets/css/calculator.min.css

# Update the plugin to use minified assets (see below)
```

## Using Minified Assets in Production

After running `npm run build`, you can update the plugin to use minified assets:

### Option 1: Automatic Detection (Recommended)

Update `capify-loan-calculator/capify-loan-calculator.php` to automatically use minified assets in production:

```php
public function enqueue_scripts() {
    $suffix = (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? '' : '.min';

    wp_enqueue_style(
        'capify-loan-calculator-style',
        plugin_dir_url(__FILE__) . "assets/css/calculator{$suffix}.css",
        array(),
        '1.0.0'
    );

    wp_enqueue_script(
        'capify-loan-calculator-script',
        plugin_dir_url(__FILE__) . "assets/js/calculator{$suffix}.js",
        array('jquery'),
        '1.0.0',
        true
    );
}
```

### Option 2: Always Use Minified

Simply change the file paths to use `.min.js` and `.min.css`.

## Code Quality Standards

### PHP Standards

- **WordPress Coding Standards:** All PHP code follows WordPress coding standards
- **PHP 7.4+ Compatibility:** Code is tested for PHP 7.4+ compatibility
- **Security:** All output is escaped, all input is validated
- **Internationalization:** All strings are translatable

### JavaScript Standards

- **WordPress JavaScript Standards:** Follows WordPress JavaScript coding standards
- **ES6+:** Modern JavaScript features with backward compatibility
- **No Console Logs:** Production code should not contain console.log statements
- **Strict Mode:** All code runs in strict mode

### CSS Standards

- **BEM Methodology:** Block Element Modifier naming convention
- **Mobile First:** Responsive design with mobile-first approach
- **Browser Compatibility:** Supports modern browsers (last 2 versions)

## Troubleshooting

### "Command not found" errors

Make sure you've installed dependencies:

```bash
npm install
composer install
```

### ESLint errors about WordPress config

Install the WordPress ESLint config:

```bash
npm install --save-dev eslint-config-wordpress
```

### PHPCS errors about WordPress standards

The WordPress Coding Standards should be installed automatically via Composer. If not:

```bash
composer require --dev wp-coding-standards/wpcs
```

## CI/CD Integration

### GitHub Actions (Example)

Create `.github/workflows/quality.yml`:

```yaml
name: Code Quality

on: [push, pull_request]

jobs:
  php:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      - uses: php-actions/composer@v6
      - run: composer check

  javascript:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      - uses: actions/setup-node@v3
        with:
          node-version: '18'
      - run: npm install
      - run: npm run lint:js
      - run: npm run build
```

## Additional Resources

- [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/)
- [WordPress Plugin Handbook](https://developer.wordpress.org/plugins/)
- [Elementor Developers Documentation](https://developers.elementor.com/)
- [ESLint Documentation](https://eslint.org/docs/latest/)
- [PHP_CodeSniffer Documentation](https://github.com/squizlabs/PHP_CodeSniffer/wiki)

## Next Steps

1. Review the [DEPENDENCY_AUDIT.md](./DEPENDENCY_AUDIT.md) for detailed security and optimization recommendations
2. Consider implementing the Phase 1 improvements for better performance
3. Set up automated testing for calculation logic
4. Configure CI/CD for automated quality checks

## Support

For issues or questions:
- GitHub Issues: https://github.com/vasilelazarescu/Capify-BL-Calculator/issues
- WordPress Support: https://wordpress.org/support/
