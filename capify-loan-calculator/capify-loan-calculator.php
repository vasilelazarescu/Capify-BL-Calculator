<?php
/**
 * Plugin Name: Capify Business Loan Calculator
 * Plugin URI: https://github.com/vasilelazarescu/Capify-BL-Calculator
 * Description: A professional business loan calculator widget for WordPress with real-time calculations
 * Version: 1.0.0
 * Author: Capify
 * Author URI: https://capify.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: capify-loan-calculator
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class Capify_Loan_Calculator {

    /**
     * Constructor
     */
    public function __construct() {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_shortcode('capify_loan_calculator', array($this, 'render_calculator'));
    }

    /**
     * Enqueue styles and scripts
     */
    public function enqueue_scripts() {
        // Enqueue CSS
        wp_enqueue_style(
            'capify-loan-calculator-style',
            plugin_dir_url(__FILE__) . 'assets/css/calculator.css',
            array(),
            '1.0.0'
        );

        // Enqueue JavaScript
        wp_enqueue_script(
            'capify-loan-calculator-script',
            plugin_dir_url(__FILE__) . 'assets/js/calculator.js',
            array('jquery'),
            '1.0.0',
            true
        );
    }

    /**
     * Render the calculator HTML
     */
    public function render_calculator($atts) {
        // Parse attributes
        $atts = shortcode_atts(array(
            'default_amount' => '100000',
            'default_rate' => '1.26',
            'default_duration' => '24',
            'currency_symbol' => '£',
            'show_trustpilot' => 'yes'
        ), $atts);

        ob_start();
        ?>
        <div class="capify-loan-calculator-wrapper">
            <div class="calculator-header">
                <h1>Business Loan Calculator</h1>
                <?php if ($atts['show_trustpilot'] === 'yes'): ?>
                <div class="trustpilot-badge">
                    <div class="trustpilot-stars">★★★★★</div>
                    <div class="trustpilot-text">TrustScore 4.8 | 1,334 reviews</div>
                </div>
                <?php endif; ?>
            </div>

            <div class="calculator-intro">
                <p>Use our SME Business Loan Calculator below to find out how much you can borrow to take your business to the next level.</p>
            </div>

            <div class="calculator-container">
                <div class="calculator-left">
                    <div class="calculator-section-header">
                        <h2>Want to understand the cost of your loan?</h2>
                        <span class="info-icon">ⓘ</span>
                    </div>

                    <p class="calculator-description">Use our business loan calculator below to find out how much you can borrow to take your business to the next level.</p>

                    <div class="calculator-form">
                        <div class="form-group">
                            <label for="loan-amount">Loan amount</label>
                            <div class="input-wrapper">
                                <span class="currency-symbol"><?php echo esc_html($atts['currency_symbol']); ?></span>
                                <input type="text" id="loan-amount" class="form-control" value="<?php echo esc_attr($atts['default_amount']); ?>" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="interest-rate">Annual interest rate</label>
                            <div class="input-wrapper">
                                <span class="percent-symbol">%</span>
                                <input type="text" id="interest-rate" class="form-control" value="<?php echo esc_attr($atts['default_rate']); ?>" />
                            </div>
                            <p class="help-text">Interest rates vary depending on the lender. Use 10% if you're unsure</p>
                        </div>

                        <div class="form-group">
                            <label>Loan duration</label>
                            <div class="duration-buttons">
                                <button type="button" class="duration-btn" data-months="12">12<br>months</button>
                                <button type="button" class="duration-btn active" data-months="24">24<br>months</button>
                                <button type="button" class="duration-btn" data-months="36">36<br>months</button>
                            </div>
                            <div class="duration-buttons">
                                <button type="button" class="duration-btn" data-months="48">48<br>months</button>
                                <button type="button" class="duration-btn" data-months="60">60<br>months</button>
                                <button type="button" class="duration-btn" data-months="72">72<br>months</button>
                            </div>
                        </div>

                        <button type="button" id="calculate-btn" class="calculate-btn">Calculate</button>
                    </div>

                    <p class="disclaimer">Calculations are indicative only and intended as a guide only. The figures calculated are not a statement of the actual repayments that will be charged on any actual loan and do not constitute a loan offer.</p>
                </div>

                <div class="calculator-right">
                    <h2>Your estimate</h2>

                    <div class="result-item">
                        <div class="result-label">Monthly payments</div>
                        <div class="result-value" id="monthly-payment"><?php echo esc_html($atts['currency_symbol']); ?>4,221.57</div>
                    </div>

                    <div class="result-item">
                        <div class="result-label">Monthly interest</div>
                        <div class="result-value" id="monthly-interest"><?php echo esc_html($atts['currency_symbol']); ?>54.91</div>
                    </div>

                    <div class="result-item">
                        <div class="result-label">Total interest</div>
                        <div class="result-value" id="total-interest"><?php echo esc_html($atts['currency_symbol']); ?>1,317.78</div>
                    </div>

                    <div class="result-item">
                        <div class="result-label">Length of loan</div>
                        <div class="result-value" id="loan-length">24 months</div>
                    </div>

                    <div class="result-item total">
                        <div class="result-label">Total cost of loan</div>
                        <div class="result-value" id="total-cost"><?php echo esc_html($atts['currency_symbol']); ?>101,317.78</div>
                    </div>

                    <button type="button" class="quote-btn">Get a quote</button>
                </div>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}

// Initialize the plugin
new Capify_Loan_Calculator();
