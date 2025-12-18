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
            'borrow_form_intro' => 'Get an estimate of how much you might be able to borrow in under a minute.',
            'borrow_business_intro' => 'How long do you want to lend over?',
            'borrow_turnover_intro' => 'What is your monthly average turnover?',
            'borrow_months_min' => '3',
            'borrow_months_maximum' => '12',
            'borrow_turnover_min' => '10000',
            'borrow_turnover_maximum' => '500000',
            'loan_cap' => '500000',
            'borrow_factor' => '1.26',
            'gross_percentage' => '0.13',
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
        <div class="capify-loan-calculator-wrapper"
             data-borrow-factor="<?php echo esc_attr($atts['borrow_factor']); ?>"
             data-gross-percentage="<?php echo esc_attr($atts['gross_percentage']); ?>"
             data-loan-cap="<?php echo esc_attr($atts['loan_cap']); ?>"
             data-currency="<?php echo esc_attr($atts['currency_symbol']); ?>">
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

            <?php if (!empty($atts['borrow_form_intro'])): ?>
            <div class="borrow-form-intro">
                <p><?php echo esc_html($atts['borrow_form_intro']); ?></p>
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
                            <label class="slider-label"><?php echo esc_html($atts['borrow_business_intro']); ?></label>
                            <div class="slider-value-display" id="duration-display">
                                <span id="duration-value"><?php echo esc_attr($atts['default_duration']); ?></span> months
                            </div>
                            <div class="slider-wrapper">
                                <input type="range" id="duration-slider" class="range-slider primary"
                                       min="<?php echo esc_attr($atts['borrow_months_min']); ?>"
                                       max="<?php echo esc_attr($atts['borrow_months_maximum']); ?>"
                                       step="1"
                                       value="<?php echo esc_attr($atts['default_duration']); ?>"
                                       aria-label="Loan duration" />
                            </div>
                            <div class="slider-range-labels">
                                <span><?php echo esc_html($atts['borrow_months_min']); ?> months</span>
                                <span><?php echo esc_html($atts['borrow_months_maximum']); ?> months</span>
                            </div>
                        </div>

                        <div class="form-group slider-primary">
                            <label class="slider-label"><?php echo esc_html($atts['borrow_turnover_intro']); ?></label>
                            <div class="slider-value-display" id="turnover-display">
                                <?php echo esc_html($atts['currency_symbol']); ?><span id="turnover-value"><?php echo number_format($atts['borrow_turnover_min']); ?></span>
                            </div>
                            <div class="slider-wrapper">
                                <input type="range" id="turnover-slider" class="range-slider primary"
                                       min="<?php echo esc_attr($atts['borrow_turnover_min']); ?>"
                                       max="<?php echo esc_attr($atts['borrow_turnover_maximum']); ?>"
                                       step="1000"
                                       value="<?php echo esc_attr($atts['borrow_turnover_min']); ?>"
                                       aria-label="Monthly turnover" />
                            </div>
                            <div class="slider-range-labels">
                                <span><?php echo esc_html($atts['currency_symbol']); ?><?php echo number_format($atts['borrow_turnover_min']); ?></span>
                                <span><?php echo esc_html($atts['currency_symbol']); ?><?php echo number_format($atts['borrow_turnover_maximum']); ?></span>
                            </div>
                        </div>

                        <button type="button" id="calculate-btn" class="calculate-btn">Calculate</button>
                    </div>

                    <?php if (!empty($atts['disclaimer_text'])): ?>
                    <p class="disclaimer"><?php echo esc_html($atts['disclaimer_text']); ?></p>
                    <?php endif; ?>
                </div>

                <div class="calculator-right">
                    <div class="congratulations-message" id="congrats-message">
                        <h2>Congratulations!</h2>
                        <p class="congrats-text">You may be eligible for a loan amount up to</p>
                        <div class="eligible-amount" id="eligible-amount" aria-live="polite">
                            <?php echo esc_html($atts['currency_symbol']); ?>12,380
                        </div>
                        <p class="congrats-disclaimer">* Subject to Capify's standard credit assessment criteria terms & conditions</p>
                    </div>

                    <div class="repayment-breakdown">
                        <h3>Your Repayment</h3>

                        <div class="breakdown-row">
                            <span class="breakdown-label">Daily repayments:</span>
                            <span class="breakdown-value" id="daily-payment" aria-live="polite"><?php echo esc_html($atts['currency_symbol']); ?>65</span>
                        </div>

                        <div class="breakdown-row">
                            <span class="breakdown-label">Monthly repayments:</span>
                            <span class="breakdown-value" id="monthly-payment" aria-live="polite"><?php echo esc_html($atts['currency_symbol']); ?>1,300</span>
                        </div>

                        <div class="breakdown-row">
                            <span class="breakdown-label">Total Cost of Loan:</span>
                            <span class="breakdown-value" id="total-cost" aria-live="polite"><?php echo esc_html($atts['currency_symbol']); ?>3,220</span>
                        </div>

                        <div class="breakdown-row total-row">
                            <span class="breakdown-label">Total Repayment:</span>
                            <span class="breakdown-value total" id="total-repayment" aria-live="polite"><?php echo esc_html($atts['currency_symbol']); ?>15,600</span>
                        </div>
                    </div>

                    <button type="button" class="quote-btn primary-cta">
                        <span class="btn-text">Check eligibility</span>
                        <span class="btn-arrow">→</span>
                    </button>

                    <p class="results-disclaimer">This calculator is for illustrative purposes only and is based on an example factor rate of 1.26. The factor rate offered to your business may vary based on your circumstances and loan terms. Processing and origination fees may apply. Repayments are collected by Direct Debit, meaning payments are taken on business days only.</p>
                </div>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}

// Initialize the plugin
new Capify_Loan_Calculator();
