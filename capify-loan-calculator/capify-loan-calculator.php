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

        // Initialize Elementor integration
        add_action('elementor/widgets/register', array($this, 'register_elementor_widgets'));
        add_action('elementor/elements/categories_registered', array($this, 'register_elementor_category'));
    }

    /**
     * Register Elementor widget category
     */
    public function register_elementor_category($elements_manager) {
        $elements_manager->add_category(
            'capify-widgets',
            [
                'title' => __('Capify Widgets', 'capify-loan-calculator'),
                'icon' => 'fa fa-calculator',
            ]
        );
    }

    /**
     * Register Elementor widgets
     */
    public function register_elementor_widgets($widgets_manager) {
        require_once plugin_dir_path(__FILE__) . 'widgets/elementor-widget.php';
        $widgets_manager->register(new \Capify_Loan_Calculator_Elementor_Widget());
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
            'show_trustpilot' => 'yes',
            'show_header' => 'yes',
            'header_title' => 'Business Loan Calculator',
            'show_intro' => 'yes',
            'intro_text' => 'Use our SME Business Loan Calculator below to find out how much you can borrow to take your business to the next level.',
            'section_title' => 'Want to understand the cost of your loan?',
            'section_description' => 'Use our business loan calculator below to find out how much you can borrow to take your business to the next level.',
            'amount_label' => 'Loan amount',
            'rate_label' => 'Annual interest rate',
            'rate_help_text' => 'Interest rates vary depending on the lender. Use 10% if you\'re unsure',
            'duration_label' => 'Loan duration',
            'calculate_button_text' => 'Calculate',
            'quote_button_text' => 'Get a quote',
            'disclaimer_text' => 'Calculations are indicative only and intended as a guide only. The figures calculated are not a statement of the actual repayments that will be charged on any actual loan and do not constitute a loan offer.',
            'results_title' => 'Your estimate',
            'monthly_payment_label' => 'Monthly payments',
            'monthly_interest_label' => 'Monthly interest',
            'total_interest_label' => 'Total interest',
            'loan_length_label' => 'Length of loan',
            'total_cost_label' => 'Total cost of loan',
        ), $atts);

        ob_start();
        ?>
        <div class="capify-loan-calculator-wrapper">
            <?php if ($atts['show_header'] === 'yes'): ?>
            <div class="calculator-header">
                <h1><?php echo esc_html($atts['header_title']); ?></h1>
                <?php if ($atts['show_trustpilot'] === 'yes'): ?>
                <div class="trustpilot-badge">
                    <div class="trustpilot-stars">★★★★★</div>
                    <div class="trustpilot-text">TrustScore 4.8 | 1,334 reviews</div>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <?php if ($atts['show_intro'] === 'yes' && !empty($atts['intro_text'])): ?>
            <div class="calculator-intro">
                <p><?php echo esc_html($atts['intro_text']); ?></p>
            </div>
            <?php endif; ?>

            <div class="calculator-container">
                <div class="calculator-left">
                    <div class="calculator-section-header">
                        <h2><?php echo esc_html($atts['section_title']); ?></h2>
                        <span class="info-icon">ⓘ</span>
                    </div>

                    <?php if (!empty($atts['section_description'])): ?>
                    <p class="calculator-description"><?php echo esc_html($atts['section_description']); ?></p>
                    <?php endif; ?>

                    <div class="calculator-form">
                        <div class="form-group slider-primary">
                            <label class="slider-label"><?php echo esc_html($atts['amount_label']); ?></label>
                            <div class="slider-value-display" id="amount-display">
                                <?php echo esc_html($atts['currency_symbol']); ?><span id="amount-value"><?php echo number_format($atts['default_amount']); ?></span>
                            </div>
                            <div class="slider-wrapper">
                                <input type="range" id="loan-amount-slider" class="range-slider primary" min="1000" max="1000000" step="1000" value="<?php echo esc_attr($atts['default_amount']); ?>" aria-label="<?php echo esc_attr($atts['amount_label']); ?>" />
                            </div>
                            <div class="slider-range-labels">
                                <span><?php echo esc_html($atts['currency_symbol']); ?>1,000</span>
                                <span><?php echo esc_html($atts['currency_symbol']); ?>1,000,000</span>
                            </div>
                        </div>

                        <div class="form-group slider-primary">
                            <label class="slider-label"><?php echo esc_html($atts['duration_label']); ?></label>
                            <div class="slider-value-display" id="duration-display">
                                <span id="duration-value"><?php echo esc_attr($atts['default_duration']); ?></span> months
                            </div>
                            <div class="slider-wrapper">
                                <input type="range" id="duration-slider" class="range-slider primary" min="12" max="72" step="12" value="<?php echo esc_attr($atts['default_duration']); ?>" aria-label="<?php echo esc_attr($atts['duration_label']); ?>" />
                            </div>
                            <div class="slider-range-labels">
                                <span>12 months</span>
                                <span>72 months</span>
                            </div>
                        </div>

                        <div class="form-group slider-primary">
                            <label class="slider-label"><?php echo esc_html($atts['rate_label']); ?></label>
                            <div class="slider-value-display" id="rate-display">
                                <span id="rate-value"><?php echo esc_attr($atts['default_rate']); ?></span>%
                            </div>
                            <div class="slider-wrapper">
                                <input type="range" id="interest-rate-slider" class="range-slider primary" min="0.1" max="30" step="0.1" value="<?php echo esc_attr($atts['default_rate']); ?>" aria-label="<?php echo esc_attr($atts['rate_label']); ?>" />
                            </div>
                            <?php if (!empty($atts['rate_help_text'])): ?>
                            <p class="help-text"><?php echo esc_html($atts['rate_help_text']); ?></p>
                            <?php endif; ?>
                            <div class="slider-range-labels">
                                <span>0.1%</span>
                                <span>30%</span>
                            </div>
                        </div>
                    </div>

                    <?php if (!empty($atts['disclaimer_text'])): ?>
                    <p class="disclaimer"><?php echo esc_html($atts['disclaimer_text']); ?></p>
                    <?php endif; ?>
                </div>

                <div class="calculator-right">
                    <div class="results-header">
                        <h2>Your Estimate</h2>
                        <p class="results-subtitle">Based on your selections</p>
                    </div>

                    <div class="highlight-result">
                        <div class="highlight-label"><?php echo esc_html($atts['monthly_payment_label']); ?></div>
                        <div class="highlight-value" id="monthly-payment" aria-live="polite">
                            <?php echo esc_html($atts['currency_symbol']); ?>4,221.57
                        </div>
                        <div class="highlight-period">per month</div>
                    </div>

                    <div class="repayment-breakdown">
                        <h3>Repayment Breakdown</h3>

                        <div class="breakdown-row">
                            <span class="breakdown-label">Loan Amount</span>
                            <span class="breakdown-value" id="loan-principal"><?php echo esc_html($atts['currency_symbol']); ?>100,000</span>
                        </div>

                        <div class="breakdown-row">
                            <span class="breakdown-label"><?php echo esc_html($atts['total_interest_label']); ?></span>
                            <span class="breakdown-value" id="total-interest" aria-live="polite"><?php echo esc_html($atts['currency_symbol']); ?>1,317.78</span>
                        </div>

                        <div class="breakdown-row">
                            <span class="breakdown-label"><?php echo esc_html($atts['loan_length_label']); ?></span>
                            <span class="breakdown-value" id="loan-length" aria-live="polite">24 months</span>
                        </div>

                        <div class="breakdown-row total-row">
                            <span class="breakdown-label"><?php echo esc_html($atts['total_cost_label']); ?></span>
                            <span class="breakdown-value total" id="total-cost" aria-live="polite"><?php echo esc_html($atts['currency_symbol']); ?>101,317.78</span>
                        </div>
                    </div>

                    <button type="button" class="quote-btn primary-cta">
                        <span class="btn-text"><?php echo esc_html($atts['quote_button_text']); ?></span>
                        <span class="btn-arrow">→</span>
                    </button>

                    <p class="results-disclaimer">Representative example. Actual rates may vary.</p>
                </div>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}

// Initialize the plugin
new Capify_Loan_Calculator();
