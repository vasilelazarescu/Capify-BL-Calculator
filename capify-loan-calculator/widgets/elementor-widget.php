<?php
/**
 * Capify Loan Calculator Elementor Widget
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Capify_Loan_Calculator_Elementor_Widget extends \Elementor\Widget_Base {

    /**
     * Get widget name
     */
    public function get_name() {
        return 'capify_loan_calculator';
    }

    /**
     * Get widget title
     */
    public function get_title() {
        return __('Business Loan Calculator', 'capify-loan-calculator');
    }

    /**
     * Get widget icon
     */
    public function get_icon() {
        return 'eicon-calculator';
    }

    /**
     * Get widget categories
     */
    public function get_categories() {
        return ['capify-widgets'];
    }

    /**
     * Get widget keywords
     */
    public function get_keywords() {
        return ['loan', 'calculator', 'business', 'capify', 'finance'];
    }

    /**
     * Register widget controls
     */
    protected function register_controls() {

        // Content Section - Borrow Form
        $this->start_controls_section(
            'borrow_form_section',
            [
                'label' => __('Borrow Form', 'capify-loan-calculator'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'borrow_form_intro',
            [
                'label' => __('Borrow Form Intro', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => 'Get an estimate of how much you might be able to borrow in under a minute.',
                'description' => __('Intro above the borrow forms', 'capify-loan-calculator'),
            ]
        );

        $this->add_control(
            'borrow_business_intro',
            [
                'label' => __('Borrow Business Intro', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'How long do you want to lend over?',
                'description' => __('Intro above the business slider', 'capify-loan-calculator'),
            ]
        );

        $this->add_control(
            'borrow_turnover_intro',
            [
                'label' => __('Borrow Turnover Intro', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'What is your monthly average turnover?',
                'description' => __('Intro above the turnover slider', 'capify-loan-calculator'),
            ]
        );

        $this->add_control(
            'borrow_months_min',
            [
                'label' => __('Borrow Months Min', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 3,
                'min' => 1,
                'max' => 100,
                'step' => 1,
                'description' => __('Minimum slider value', 'capify-loan-calculator'),
            ]
        );

        $this->add_control(
            'borrow_months_maximum',
            [
                'label' => __('Borrow Months Maximum', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 12,
                'min' => 1,
                'max' => 100,
                'step' => 1,
                'description' => __('Maximum slider value', 'capify-loan-calculator'),
            ]
        );

        $this->add_control(
            'borrow_turnover_min',
            [
                'label' => __('Borrow Turnover Min', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 10000,
                'min' => 0,
                'step' => 1000,
                'description' => __('Minimum slider value. No commas please', 'capify-loan-calculator'),
            ]
        );

        $this->add_control(
            'borrow_turnover_maximum',
            [
                'label' => __('Borrow Turnover Maximum', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 500000,
                'min' => 0,
                'step' => 1000,
                'description' => __('Maximum slider value. No commas please', 'capify-loan-calculator'),
            ]
        );

        $this->add_control(
            'loan_cap',
            [
                'label' => __('Loan Cap', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 500000,
                'min' => 0,
                'step' => 1000,
                'description' => __('Maximum loan value one can be quoted for. No commas please', 'capify-loan-calculator'),
            ]
        );

        $this->add_control(
            'borrow_factor',
            [
                'label' => __('Borrow Factor', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 1.26,
                'min' => 0.01,
                'max' => 10,
                'step' => 0.01,
                'description' => __('Factor (divided by turnover * borrow_term)', 'capify-loan-calculator'),
            ]
        );

        $this->add_control(
            'gross_percentage',
            [
                'label' => __('Gross Percentage', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 0.13,
                'min' => 0,
                'max' => 1,
                'step' => 0.001,
                'description' => __('Calculate Montly Repayments', 'capify-loan-calculator'),
            ]
        );

        $this->add_control(
            'default_duration',
            [
                'label' => __('Default Loan Duration (months)', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 24,
                'min' => 1,
                'max' => 100,
                'step' => 1,
                'description' => __('The default loan duration', 'capify-loan-calculator'),
            ]
        );

        $this->add_control(
            'currency_symbol',
            [
                'label' => __('Currency Symbol', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '£',
                'description' => __('The currency symbol to display (£, $, €, etc.)', 'capify-loan-calculator'),
            ]
        );

        $this->end_controls_section();

        // Content Section - Display Options
        $this->start_controls_section(
            'display_options_section',
            [
                'label' => __('Display Options', 'capify-loan-calculator'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_trustpilot',
            [
                'label' => __('Show Trustpilot Badge', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'capify-loan-calculator'),
                'label_off' => __('Hide', 'capify-loan-calculator'),
                'return_value' => 'yes',
                'default' => 'yes',
                'description' => __('Show or hide the Trustpilot rating badge', 'capify-loan-calculator'),
            ]
        );

        $this->add_control(
            'show_header',
            [
                'label' => __('Show Header', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'capify-loan-calculator'),
                'label_off' => __('Hide', 'capify-loan-calculator'),
                'return_value' => 'yes',
                'default' => 'yes',
                'description' => __('Show or hide the calculator header section', 'capify-loan-calculator'),
            ]
        );

        $this->add_control(
            'header_title',
            [
                'label' => __('Header Title', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Business Loan Calculator',
                'condition' => [
                    'show_header' => 'yes',
                ],
                'description' => __('The main heading text', 'capify-loan-calculator'),
            ]
        );

        $this->add_control(
            'show_intro',
            [
                'label' => __('Show Introduction Text', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'capify-loan-calculator'),
                'label_off' => __('Hide', 'capify-loan-calculator'),
                'return_value' => 'yes',
                'default' => 'yes',
                'description' => __('Show or hide the introduction paragraph', 'capify-loan-calculator'),
            ]
        );

        $this->add_control(
            'intro_text',
            [
                'label' => __('Introduction Text', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => 'Use our SME Business Loan Calculator below to find out how much you can borrow to take your business to the next level.',
                'condition' => [
                    'show_intro' => 'yes',
                ],
                'description' => __('The introduction text below the header', 'capify-loan-calculator'),
            ]
        );

        $this->end_controls_section();

        // Content Section - Form Labels
        $this->start_controls_section(
            'form_labels_section',
            [
                'label' => __('Form Labels & Text', 'capify-loan-calculator'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'section_title',
            [
                'label' => __('Section Title', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Want to understand the cost of your loan?',
                'description' => __('The title above the calculator form', 'capify-loan-calculator'),
            ]
        );

        $this->add_control(
            'section_description',
            [
                'label' => __('Section Description', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => 'Use our business loan calculator below to find out how much you can borrow to take your business to the next level.',
                'description' => __('The description text below section title', 'capify-loan-calculator'),
            ]
        );

        $this->add_control(
            'amount_label',
            [
                'label' => __('Loan Amount Label', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Loan amount',
                'description' => __('Label for the loan amount field', 'capify-loan-calculator'),
            ]
        );

        $this->add_control(
            'rate_label',
            [
                'label' => __('Interest Rate Label', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Annual interest rate',
                'description' => __('Label for the interest rate field', 'capify-loan-calculator'),
            ]
        );

        $this->add_control(
            'rate_help_text',
            [
                'label' => __('Interest Rate Help Text', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Interest rates vary depending on the lender. Use 10% if you\'re unsure',
                'description' => __('Help text below the interest rate field', 'capify-loan-calculator'),
            ]
        );

        $this->add_control(
            'duration_label',
            [
                'label' => __('Loan Duration Label', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Loan duration',
                'description' => __('Label for the loan duration buttons', 'capify-loan-calculator'),
            ]
        );

        $this->add_control(
            'calculate_button_text',
            [
                'label' => __('Calculate Button Text', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Calculate',
                'description' => __('Text for the calculate button', 'capify-loan-calculator'),
            ]
        );

        $this->add_control(
            'quote_button_text',
            [
                'label' => __('Quote Button Text', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Get a quote',
                'description' => __('Text for the get quote button', 'capify-loan-calculator'),
            ]
        );

        $this->add_control(
            'disclaimer_text',
            [
                'label' => __('Disclaimer Text', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => 'Calculations are indicative only and intended as a guide only. The figures calculated are not a statement of the actual repayments that will be charged on any actual loan and do not constitute a loan offer.',
                'description' => __('Disclaimer text at the bottom', 'capify-loan-calculator'),
            ]
        );

        $this->end_controls_section();

        // Content Section - Results Labels
        $this->start_controls_section(
            'results_labels_section',
            [
                'label' => __('Results Labels', 'capify-loan-calculator'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'results_title',
            [
                'label' => __('Results Section Title', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Your estimate',
                'description' => __('Title for the results section', 'capify-loan-calculator'),
            ]
        );

        $this->add_control(
            'monthly_payment_label',
            [
                'label' => __('Monthly Payment Label', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Monthly payments',
                'description' => __('Label for monthly payment result', 'capify-loan-calculator'),
            ]
        );

        $this->add_control(
            'monthly_interest_label',
            [
                'label' => __('Monthly Interest Label', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Monthly interest',
                'description' => __('Label for monthly interest result', 'capify-loan-calculator'),
            ]
        );

        $this->add_control(
            'total_interest_label',
            [
                'label' => __('Total Interest Label', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Total interest',
                'description' => __('Label for total interest result', 'capify-loan-calculator'),
            ]
        );

        $this->add_control(
            'loan_length_label',
            [
                'label' => __('Loan Length Label', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Length of loan',
                'description' => __('Label for loan length result', 'capify-loan-calculator'),
            ]
        );

        $this->add_control(
            'total_cost_label',
            [
                'label' => __('Total Cost Label', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Total cost of loan',
                'description' => __('Label for total cost result', 'capify-loan-calculator'),
            ]
        );

        $this->end_controls_section();

        // Style Section - Colors
        $this->start_controls_section(
            'style_colors_section',
            [
                'label' => __('Colors', 'capify-loan-calculator'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'primary_color',
            [
                'label' => __('Primary Color', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#7c3aed',
                'description' => __('Primary color for buttons and accents', 'capify-loan-calculator'),
            ]
        );

        $this->add_control(
            'secondary_color',
            [
                'label' => __('Secondary Color', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#4c1d95',
                'description' => __('Secondary color for hover states', 'capify-loan-calculator'),
            ]
        );

        $this->add_control(
            'background_color',
            [
                'label' => __('Background Color', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'description' => __('Background color for calculator sections', 'capify-loan-calculator'),
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => __('Text Color', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#1f2937',
                'description' => __('Main text color', 'capify-loan-calculator'),
            ]
        );

        $this->end_controls_section();

        // Style Section - Typography
        $this->start_controls_section(
            'style_typography_section',
            [
                'label' => __('Typography', 'capify-loan-calculator'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'header_typography',
                'label' => __('Header Typography', 'capify-loan-calculator'),
                'selector' => '{{WRAPPER}} .calculator-header h1',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'section_title_typography',
                'label' => __('Section Title Typography', 'capify-loan-calculator'),
                'selector' => '{{WRAPPER}} .calculator-section-header h2',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'body_typography',
                'label' => __('Body Typography', 'capify-loan-calculator'),
                'selector' => '{{WRAPPER}} .calculator-intro p, {{WRAPPER}} .calculator-description',
            ]
        );

        $this->end_controls_section();

        // Style Section - Spacing
        $this->start_controls_section(
            'style_spacing_section',
            [
                'label' => __('Spacing', 'capify-loan-calculator'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'calculator_padding',
            [
                'label' => __('Calculator Padding', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .calculator-left, {{WRAPPER}} .calculator-right' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'form_group_spacing',
            [
                'label' => __('Form Group Spacing', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .form-group' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render widget output on the frontend
     */
    protected function render() {
        $settings = $this->get_settings_for_display();

        // Build shortcode attributes
        $atts = array(
            'borrow_form_intro' => isset($settings['borrow_form_intro']) ? $settings['borrow_form_intro'] : 'Get an estimate of how much you might be able to borrow in under a minute.',
            'borrow_business_intro' => isset($settings['borrow_business_intro']) ? $settings['borrow_business_intro'] : 'How long do you want to lend over?',
            'borrow_turnover_intro' => isset($settings['borrow_turnover_intro']) ? $settings['borrow_turnover_intro'] : 'What is your monthly average turnover?',
            'borrow_months_min' => isset($settings['borrow_months_min']) ? $settings['borrow_months_min'] : 3,
            'borrow_months_maximum' => isset($settings['borrow_months_maximum']) ? $settings['borrow_months_maximum'] : 12,
            'borrow_turnover_min' => isset($settings['borrow_turnover_min']) ? $settings['borrow_turnover_min'] : 10000,
            'borrow_turnover_maximum' => isset($settings['borrow_turnover_maximum']) ? $settings['borrow_turnover_maximum'] : 500000,
            'loan_cap' => isset($settings['loan_cap']) ? $settings['loan_cap'] : 500000,
            'borrow_factor' => isset($settings['borrow_factor']) ? $settings['borrow_factor'] : 1.26,
            'gross_percentage' => isset($settings['gross_percentage']) ? $settings['gross_percentage'] : 0.13,
            'default_duration' => isset($settings['default_duration']) ? $settings['default_duration'] : 24,
            'currency_symbol' => isset($settings['currency_symbol']) ? $settings['currency_symbol'] : '£',
            'show_trustpilot' => isset($settings['show_trustpilot']) ? $settings['show_trustpilot'] : 'yes',
            'show_header' => isset($settings['show_header']) ? $settings['show_header'] : 'yes',
            'header_title' => isset($settings['header_title']) ? $settings['header_title'] : 'Business Loan Calculator',
            'show_intro' => isset($settings['show_intro']) ? $settings['show_intro'] : 'yes',
            'intro_text' => isset($settings['intro_text']) ? $settings['intro_text'] : '',
            'section_title' => isset($settings['section_title']) ? $settings['section_title'] : 'Want to understand the cost of your loan?',
            'section_description' => isset($settings['section_description']) ? $settings['section_description'] : '',
            'amount_label' => isset($settings['amount_label']) ? $settings['amount_label'] : 'Loan amount',
            'rate_label' => isset($settings['rate_label']) ? $settings['rate_label'] : 'Annual interest rate',
            'rate_help_text' => isset($settings['rate_help_text']) ? $settings['rate_help_text'] : '',
            'duration_label' => isset($settings['duration_label']) ? $settings['duration_label'] : 'Loan duration',
            'calculate_button_text' => isset($settings['calculate_button_text']) ? $settings['calculate_button_text'] : 'Calculate',
            'quote_button_text' => isset($settings['quote_button_text']) ? $settings['quote_button_text'] : 'Get a quote',
            'disclaimer_text' => isset($settings['disclaimer_text']) ? $settings['disclaimer_text'] : '',
            'results_title' => isset($settings['results_title']) ? $settings['results_title'] : 'Your estimate',
            'monthly_payment_label' => isset($settings['monthly_payment_label']) ? $settings['monthly_payment_label'] : 'Monthly payments',
            'monthly_interest_label' => isset($settings['monthly_interest_label']) ? $settings['monthly_interest_label'] : 'Monthly interest',
            'total_interest_label' => isset($settings['total_interest_label']) ? $settings['total_interest_label'] : 'Total interest',
            'loan_length_label' => isset($settings['loan_length_label']) ? $settings['loan_length_label'] : 'Length of loan',
            'total_cost_label' => isset($settings['total_cost_label']) ? $settings['total_cost_label'] : 'Total cost of loan',
        );

        // Add custom CSS for color customization
        if (!empty($settings['primary_color']) || !empty($settings['secondary_color']) ||
            !empty($settings['background_color']) || !empty($settings['text_color'])) {
            ?>
            <style>
                <?php if (!empty($settings['primary_color'])): ?>
                .elementor-element-<?php echo $this->get_id(); ?> .calculate-btn,
                .elementor-element-<?php echo $this->get_id(); ?> .quote-btn,
                .elementor-element-<?php echo $this->get_id(); ?> .duration-btn.active {
                    background-color: <?php echo esc_attr($settings['primary_color']); ?> !important;
                }
                <?php endif; ?>

                <?php if (!empty($settings['secondary_color'])): ?>
                .elementor-element-<?php echo $this->get_id(); ?> .calculate-btn:hover,
                .elementor-element-<?php echo $this->get_id(); ?> .quote-btn:hover {
                    background-color: <?php echo esc_attr($settings['secondary_color']); ?> !important;
                }
                <?php endif; ?>

                <?php if (!empty($settings['background_color'])): ?>
                .elementor-element-<?php echo $this->get_id(); ?> .calculator-left,
                .elementor-element-<?php echo $this->get_id(); ?> .calculator-right {
                    background-color: <?php echo esc_attr($settings['background_color']); ?> !important;
                }
                <?php endif; ?>

                <?php if (!empty($settings['text_color'])): ?>
                .elementor-element-<?php echo $this->get_id(); ?> .capify-loan-calculator-wrapper {
                    color: <?php echo esc_attr($settings['text_color']); ?> !important;
                }
                <?php endif; ?>
            </style>
            <?php
        }

        // Render the calculator using the main plugin class
        $calculator = new Capify_Loan_Calculator();
        echo $calculator->render_calculator($atts);
    }
}
