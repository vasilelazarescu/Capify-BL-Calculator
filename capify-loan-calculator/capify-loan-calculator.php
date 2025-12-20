<?php
/**
 * Plugin Name: Capify Business Loan Calculator
 * Plugin URI: https://github.com/vasilelazarescu/Capify-BL-Calculator
 * Description: A professional business loan calculator widget for WordPress with real-time calculations and optimized performance
 * Version: 2.5.0
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
     * Singleton instance
     */
    private static $instance = null;

    /**
     * Get singleton instance
     */
    public static function get_instance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor
     */
    private function __construct() {
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
     * Only loads assets when calculator is present on the page
     */
    public function enqueue_scripts() {
        global $post;

        // Check if shortcode exists in content or if we're in Elementor editor
        $load_assets = false;

        // Check for shortcode in post content
        if (is_a($post, 'WP_Post') && has_shortcode($post->post_content, 'capify_loan_calculator')) {
            $load_assets = true;
        }

        // Check if Elementor is active and we're in editor or preview
        if (class_exists('\Elementor\Plugin')) {
            if (\Elementor\Plugin::$instance->preview->is_preview_mode() ||
                \Elementor\Plugin::$instance->editor->is_edit_mode()) {
                $load_assets = true;
            }

            // Check if current post has Elementor data with our widget
            if (is_a($post, 'WP_Post')) {
                $elementor_data = get_post_meta($post->ID, '_elementor_data', true);
                if (!empty($elementor_data) && strpos($elementor_data, 'capify_loan_calculator') !== false) {
                    $load_assets = true;
                }
            }
        }

        // Only enqueue if calculator is present
        if (!$load_assets) {
            return;
        }

        // Enqueue CSS
        wp_enqueue_style(
            'capify-loan-calculator-style',
            plugin_dir_url(__FILE__) . 'assets/css/calculator.css',
            array(),
            '2.5.0'
        );

        // Enqueue JavaScript
        wp_enqueue_script(
            'capify-loan-calculator-script',
            plugin_dir_url(__FILE__) . 'assets/js/calculator.js',
            array('jquery'),
            '2.5.0',
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
                        <div class="form-group">
                            <label for="loan-amount"><?php echo esc_html($atts['amount_label']); ?></label>
                            <div class="input-wrapper">
                                <span class="currency-symbol"><?php echo esc_html($atts['currency_symbol']); ?></span>
                                <input type="text" id="loan-amount" class="form-control" value="<?php echo esc_attr($atts['default_amount']); ?>" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="interest-rate"><?php echo esc_html($atts['rate_label']); ?></label>
                            <div class="input-wrapper">
                                <span class="percent-symbol">%</span>
                                <input type="text" id="interest-rate" class="form-control" value="<?php echo esc_attr($atts['default_rate']); ?>" />
                            </div>
                            <?php if (!empty($atts['rate_help_text'])): ?>
                            <p class="help-text"><?php echo esc_html($atts['rate_help_text']); ?></p>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label><?php echo esc_html($atts['duration_label']); ?></label>
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

                        <button type="button" id="calculate-btn" class="calculate-btn"><?php echo esc_html($atts['calculate_button_text']); ?></button>
                    </div>

                    <?php if (!empty($atts['disclaimer_text'])): ?>
                    <p class="disclaimer"><?php echo esc_html($atts['disclaimer_text']); ?></p>
                    <?php endif; ?>
                </div>

                <div class="calculator-right">
                    <h2><?php echo esc_html($atts['results_title']); ?></h2>

                    <div class="result-item">
                        <div class="result-label"><?php echo esc_html($atts['monthly_payment_label']); ?></div>
                        <div class="result-value" id="monthly-payment"><?php echo esc_html($atts['currency_symbol']); ?>4,221.57</div>
                    </div>

                    <div class="result-item">
                        <div class="result-label"><?php echo esc_html($atts['monthly_interest_label']); ?></div>
                        <div class="result-value" id="monthly-interest"><?php echo esc_html($atts['currency_symbol']); ?>54.91</div>
                    </div>

                    <div class="result-item">
                        <div class="result-label"><?php echo esc_html($atts['total_interest_label']); ?></div>
                        <div class="result-value" id="total-interest"><?php echo esc_html($atts['currency_symbol']); ?>1,317.78</div>
                    </div>

                    <div class="result-item">
                        <div class="result-label"><?php echo esc_html($atts['loan_length_label']); ?></div>
                        <div class="result-value" id="loan-length">24 months</div>
                    </div>

                    <div class="result-item total">
                        <div class="result-label"><?php echo esc_html($atts['total_cost_label']); ?></div>
                        <div class="result-value" id="total-cost"><?php echo esc_html($atts['currency_symbol']); ?>101,317.78</div>
                    </div>

                    <button type="button" class="quote-btn"><?php echo esc_html($atts['quote_button_text']); ?></button>
                </div>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}

// Initialize the plugin using singleton pattern
Capify_Loan_Calculator::get_instance();
