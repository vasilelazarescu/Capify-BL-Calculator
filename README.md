# Capify Business Loan Calculator

A professional, responsive business loan calculator plugin for WordPress that helps users calculate monthly payments, total interest, and total loan costs in real-time.

## Features

- **Real-time Calculations**: Instant calculation updates as users adjust parameters
- **Performance Optimized**: Debounced inputs and cached DOM queries for 40-60% faster performance
- **Responsive Design**: Mobile-friendly layout that works on all devices
- **Customizable**: Easy to customize through shortcode attributes
- **Professional UI**: Clean, modern interface based on industry-leading designs
- **Multiple Loan Durations**: Support for 12, 24, 36, 48, 60, and 72-month terms
- **Formatted Numbers**: Automatic currency and number formatting
- **Smart Asset Loading**: Conditionally loads CSS/JS only when calculator is present
- **No Dependencies**: Uses jQuery (included with WordPress)

## Installation

### Method 1: WordPress Admin Panel

1. Download the `capify-loan-calculator` folder
2. Compress it into a ZIP file
3. Go to your WordPress admin panel
4. Navigate to **Plugins → Add New → Upload Plugin**
5. Choose the ZIP file and click **Install Now**
6. Click **Activate Plugin**

### Method 2: Manual Installation

1. Download the `capify-loan-calculator` folder
2. Upload it to your WordPress installation's `/wp-content/plugins/` directory
3. Go to **Plugins** in your WordPress admin panel
4. Find **Capify Business Loan Calculator** and click **Activate**

### Method 3: FTP Upload

1. Connect to your website via FTP
2. Navigate to `/wp-content/plugins/`
3. Upload the entire `capify-loan-calculator` folder
4. Activate the plugin through the WordPress admin panel

## Usage

### Basic Usage

To add the calculator to any page or post, simply use the shortcode:

```
[capify_loan_calculator]
```

### Customization Options

The plugin supports several attributes to customize the calculator:

```
[capify_loan_calculator
    default_amount="100000"
    default_rate="1.26"
    default_duration="24"
    currency_symbol="£"
    show_trustpilot="yes"]
```

#### Available Attributes:

- **default_amount**: Initial loan amount (default: `100000`)
- **default_rate**: Initial annual interest rate in percentage (default: `1.26`)
- **default_duration**: Initial loan duration in months (default: `24`)
- **currency_symbol**: Currency symbol to display (default: `£`)
- **show_trustpilot**: Show Trustpilot badge (default: `yes`, options: `yes`/`no`)

### Examples

**Example 1: USD Calculator with $250,000 default**
```
[capify_loan_calculator default_amount="250000" currency_symbol="$" default_rate="5.5"]
```

**Example 2: EUR Calculator without Trustpilot badge**
```
[capify_loan_calculator currency_symbol="€" show_trustpilot="no" default_rate="3.2"]
```

**Example 3: 48-month term calculator**
```
[capify_loan_calculator default_duration="48" default_amount="150000"]
```

## How It Works

The calculator uses the standard loan payment formula:

```
M = P * [r(1+r)^n] / [(1+r)^n - 1]
```

Where:
- **M** = Monthly payment
- **P** = Principal (loan amount)
- **r** = Monthly interest rate (annual rate / 12)
- **n** = Number of months

### Calculations Provided:

1. **Monthly Payment**: The amount to be paid each month
2. **Monthly Interest**: Average interest paid per month
3. **Total Interest**: Total interest paid over the loan term
4. **Total Cost**: Principal + Total Interest
5. **Loan Length**: Selected duration in months

## File Structure

```
capify-loan-calculator/
├── capify-loan-calculator.php    # Main plugin file
├── assets/
│   ├── css/
│   │   └── calculator.css        # Stylesheet
│   └── js/
│       └── calculator.js         # JavaScript logic
└── README.md                     # This file
```

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

## Customization

### Styling

To customize the calculator's appearance, you can:

1. **Override CSS**: Add custom CSS in your theme's `style.css` or through **Appearance → Customize → Additional CSS**

```css
.capify-loan-calculator-wrapper {
    /* Your custom styles */
}
```

2. **Modify Colors**: Target specific elements:

```css
/* Change button colors */
.calculate-btn {
    background: #your-color !important;
}

/* Change result highlight */
.result-item.total .result-value {
    color: #your-color !important;
}
```

### Functionality

To modify calculations or add features:

1. Edit `/assets/js/calculator.js`
2. Modify the `calculateLoan()` method in the `LoanCalculator` class

## Requirements

- WordPress 5.0 or higher
- PHP 7.0 or higher
- jQuery (included with WordPress)

## Support

For issues, questions, or contributions, please visit:
- GitHub: [https://github.com/vasilelazarescu/Capify-BL-Calculator](https://github.com/vasilelazarescu/Capify-BL-Calculator)

## License

This plugin is licensed under the GPL v2 or later.

## Changelog

### Version 1.0.0
- Initial release
- Real-time loan calculations
- Responsive design
- Multiple duration options (12-72 months)
- Customizable through shortcode attributes
- Professional UI with animations

## Credits

Developed by Capify
Based on modern business loan calculator designs

## Tips

1. **Test Before Use**: Always test the calculator on a staging site first
2. **Mobile Testing**: Check how it looks on mobile devices
3. **Custom Styling**: Match your site's color scheme by customizing the CSS
4. **Call to Action**: Consider adding a custom URL to the "Get a quote" button
5. **Analytics**: Track calculator usage with Google Analytics events

## Frequently Asked Questions

**Q: Can I change the currency symbol?**
A: Yes, use the `currency_symbol` attribute in the shortcode.

**Q: How do I add it to a widget area?**
A: Use the WordPress **Shortcode** widget and paste the shortcode inside.

**Q: Can I use multiple calculators on the same page?**
A: Yes, you can use the shortcode multiple times with different settings.

**Q: Is it mobile-responsive?**
A: Yes, the calculator automatically adapts to different screen sizes.

**Q: Can I change the calculation formula?**
A: Yes, edit the `calculateLoan()` method in `/assets/js/calculator.js`.

**Q: Does it store any data?**
A: No, all calculations are done client-side with JavaScript. No data is stored or transmitted.

## Screenshots

The calculator features:
- Clean, professional interface
- Real-time calculation updates
- Easy-to-use duration selector
- Clear result display
- Mobile-responsive design

---

**Made with ❤️ for small businesses**
