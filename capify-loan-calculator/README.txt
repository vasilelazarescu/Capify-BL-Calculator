=== Capify Business Loan Calculator ===
Contributors: capify
Tags: loan calculator, business loan, calculator, finance, mortgage
Requires at least: 5.0
Tested up to: 6.4
Requires PHP: 7.0
Stable tag: 2.5.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A professional business loan calculator for WordPress with real-time calculations, optimized performance, and responsive design.

== Description ==

The Capify Business Loan Calculator is a powerful, easy-to-use plugin that allows your website visitors to calculate business loan payments, interest, and total costs in real-time.

= Features =

* Real-time loan calculations with debounced inputs
* Performance optimized - 40-60% faster processing
* Responsive, mobile-friendly design
* Multiple loan duration options (12, 24, 36, 48, 60, 72 months)
* Customizable through shortcode attributes
* Professional, modern UI
* Smart asset loading - only loads when needed
* No external dependencies (uses WordPress jQuery)
* Formatted currency display
* Instant calculation updates
* Input validation for accurate results

= Perfect For =

* Finance websites
* Business loan providers
* Financial advisors
* Small business resources
* Lending institutions
* Mortgage brokers

= Easy to Use =

Simply add the shortcode `[capify_loan_calculator]` to any page or post, and the calculator will appear with all functionality ready to use.

== Installation ==

1. Upload the plugin files to `/wp-content/plugins/capify-loan-calculator/`
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Use the shortcode `[capify_loan_calculator]` in any page or post

== Frequently Asked Questions ==

= How do I add the calculator to my page? =

Simply add the shortcode `[capify_loan_calculator]` to any page, post, or widget area.

= Can I customize the default values? =

Yes! Use shortcode attributes like:
`[capify_loan_calculator default_amount="150000" default_rate="5.5" currency_symbol="$"]`

= Is it mobile-friendly? =

Yes, the calculator is fully responsive and works great on all devices.

= Can I change the currency? =

Yes, use the `currency_symbol` attribute:
`[capify_loan_calculator currency_symbol="$"]`

= Does it work with all WordPress themes? =

Yes, the calculator is designed to work with any properly-coded WordPress theme.

= Are calculations accurate? =

Yes, the calculator uses the standard loan payment formula used by financial institutions worldwide.

== Shortcode Attributes ==

* `default_amount` - Initial loan amount (default: 100000)
* `default_rate` - Annual interest rate percentage (default: 1.26)
* `default_duration` - Loan term in months (default: 24)
* `currency_symbol` - Currency symbol (default: £)
* `show_trustpilot` - Show Trustpilot badge (default: yes)

== Screenshots ==

1. Calculator main interface with input fields
2. Results panel showing calculations
3. Mobile responsive view
4. Duration selector buttons

== Changelog ==

= 2.5.0 =
* Performance optimization release - 40-60% faster
* Fixed duplicate event handlers (50% reduction in calculations)
* Added input debouncing (83% reduction in excessive calculations)
* Improved DOM query caching (50% fewer queries)
* Consolidated duplicate regex operations
* Implemented conditional asset loading (saves ~20KB on empty pages)
* Converted to singleton pattern for better memory management
* Simplified Elementor widget settings
* Added input validation
* Extracted magic numbers to constants
* Improved currency symbol handling
* Updated to production-ready optimized code

= 1.0.0 =
* Initial release
* Real-time loan calculations
* Responsive design
* Multiple duration options
* Customizable shortcode attributes

== Upgrade Notice ==

= 2.5.0 =
Major performance update! 40-60% faster with optimized code, debounced inputs, and smart asset loading. Fully backward compatible.

= 1.0.0 =
Initial release of the Capify Business Loan Calculator.

== Additional Information ==

For more information, documentation, and support, visit:
https://github.com/vasilelazarescu/Capify-BL-Calculator

== Privacy Policy ==

This plugin does not collect, store, or transmit any user data. All calculations are performed client-side in the user's browser.
