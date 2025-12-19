<?php
/**
 * Plugin Name: Capify Business Loan Calculator
 * Plugin URI: https://github.com/vasilelazarescu/Capify-BL-Calculator
 * Description: A professional business loan calculator widget for WordPress with real-time calculations
 * Version: 2.0.4
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
            '2.0.4'
        );

        // Enqueue JavaScript
        wp_enqueue_script(
            'capify-loan-calculator-script',
            plugin_dir_url(__FILE__) . 'assets/js/calculator.js',
            array('jquery'),
            '2.0.4',
            true
        );
    }

    /**
     * Render the calculator HTML
     */
    public function render_calculator($atts) {
        // Parse attributes
        $atts = shortcode_atts(array(
            'header_title' => 'Business Loan Calculator',
            'header_subtitle' => 'Get an estimate of how much you might be able to borrow in under a minute.',
            'duration_label' => 'How long do you want to lend over?',
            'turnover_label' => 'What is your monthly average turnover?',
            'borrow_months_min' => '3',
            'borrow_months_maximum' => '12',
            'borrow_turnover_min' => '10000',
            'borrow_turnover_maximum' => '500000',
            'default_duration' => '6',
            'default_turnover' => '110000',
            'loan_cap' => '500000',
            'borrow_factor' => '1.26',
            'gross_percentage' => '0.13',
            'currency_symbol' => '£',
            'calculate_button_text' => 'Calculate',
            'results_title' => 'Congratulations!',
            'results_subtitle' => 'You may be eligible for a loan amount up to:',
            'disclaimer_text' => '* Subject to Capify\'s standard credit assessment criterial terms & conditions',
            'repayment_section_label' => 'Your Repayment:',
            'daily_repayment_label' => 'Daily repayments:',
            'monthly_repayment_label' => 'Monthly repayments:',
            'total_cost_label' => 'Total Cost of Loan:',
            'total_repayment_label' => 'Total Repayment:',
        ), $atts);

        ob_start();
        ?>
        <div class="capify-loan-calculator-wrapper"
             data-borrow-factor="<?php echo esc_attr($atts['borrow_factor']); ?>"
             data-gross-percentage="<?php echo esc_attr($atts['gross_percentage']); ?>"
             data-loan-cap="<?php echo esc_attr($atts['loan_cap']); ?>"
             data-currency="<?php echo esc_attr($atts['currency_symbol']); ?>"
             data-min-duration="<?php echo esc_attr($atts['borrow_months_min']); ?>"
             data-max-duration="<?php echo esc_attr($atts['borrow_months_maximum']); ?>"
             data-min-turnover="<?php echo esc_attr($atts['borrow_turnover_min']); ?>"
             data-max-turnover="<?php echo esc_attr($atts['borrow_turnover_maximum']); ?>">

            <div class="calculator-card">
                <!-- Header Section -->
                <div class="header">
                    <h1 class="title"><?php echo esc_html($atts['header_title']); ?></h1>
                    <p class="subtitle"><?php echo esc_html($atts['header_subtitle']); ?></p>
                </div>

                <!-- Loan Duration Section -->
                <div class="input-section">
                    <label class="input-label"><?php echo esc_html($atts['duration_label']); ?></label>
                    <p class="input-value" id="duration-display"><?php echo esc_attr($atts['default_duration']); ?> months</p>
                    <div class="slider-container" id="duration-slider-container">
                        <div class="slider-track"></div>
                        <div class="slider-progress" id="duration-progress"></div>
                        <div class="slider-thumb" id="duration-thumb"></div>
                    </div>
                </div>

                <!-- Monthly Turnover Section -->
                <div class="input-section">
                    <label class="input-label"><?php echo esc_html($atts['turnover_label']); ?></label>
                    <p class="input-value" id="turnover-display"><?php echo esc_html($atts['currency_symbol']); ?> <?php echo number_format($atts['default_turnover']); ?></p>
                    <div class="slider-container" id="turnover-slider-container">
                        <div class="slider-track"></div>
                        <div class="slider-progress" id="turnover-progress"></div>
                        <div class="slider-thumb" id="turnover-thumb"></div>
                    </div>
                </div>

                <!-- Calculate Button -->
                <button type="button" class="calculate-btn" id="calculate-btn"><?php echo esc_html($atts['calculate_button_text']); ?></button>

                <!-- Results Panel -->
                <div class="results-panel">
                    <div class="results-header">
                        <h2 class="results-title"><?php echo esc_html($atts['results_title']); ?></h2>
                        <p class="results-subtitle"><?php echo esc_html($atts['results_subtitle']); ?></p>
                        <p class="loan-amount" id="loan-amount"><?php echo esc_html($atts['currency_symbol']); ?>0</p>
                        <p class="disclaimer"><?php echo esc_html($atts['disclaimer_text']); ?></p>
                    </div>

                    <div class="divider"></div>

                    <p class="section-label"><?php echo esc_html($atts['repayment_section_label']); ?></p>

                    <div class="repayment-grid">
                        <div class="repayment-item">
                            <p class="repayment-label"><?php echo esc_html($atts['daily_repayment_label']); ?></p>
                            <p class="repayment-value" id="daily-payment"><?php echo esc_html($atts['currency_symbol']); ?>0</p>
                        </div>
                        <div class="vertical-divider"></div>
                        <div class="repayment-item">
                            <p class="repayment-label"><?php echo esc_html($atts['monthly_repayment_label']); ?></p>
                            <p class="repayment-value" id="monthly-payment"><?php echo esc_html($atts['currency_symbol']); ?>0</p>
                        </div>
                        <div class="vertical-divider"></div>
                        <div class="repayment-item">
                            <p class="repayment-label"><?php echo esc_html($atts['total_cost_label']); ?></p>
                            <p class="repayment-value" id="total-cost"><?php echo esc_html($atts['currency_symbol']); ?>0</p>
                        </div>
                    </div>

                    <div class="divider"></div>

                    <div class="total-section">
                        <p class="total-label"><?php echo esc_html($atts['total_repayment_label']); ?></p>
                        <p class="total-value" id="total-repayment"><?php echo esc_html($atts['currency_symbol']); ?>0</p>
                    </div>
                </div>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}

// Initialize the plugin
new Capify_Loan_Calculator();
