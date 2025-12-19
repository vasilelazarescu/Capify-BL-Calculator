<?php
/**
 * Capify Loan Calculator Elementor Widget
 * Version: 2.1.0
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

        // ========== CONTENT TAB ==========

        // Text & Labels Section
        $this->start_controls_section(
            'text_labels_section',
            [
                'label' => __('Text & Labels', 'capify-loan-calculator'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'header_title',
            [
                'label' => __('Header Title', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Business Loan Calculator',
            ]
        );

        $this->add_control(
            'header_subtitle',
            [
                'label' => __('Header Subtitle', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Get an estimate of how much you might be able to borrow in under a minute.',
            ]
        );

        $this->add_control(
            'duration_label',
            [
                'label' => __('Duration Label', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'How long do you want to lend over?',
            ]
        );

        $this->add_control(
            'turnover_label',
            [
                'label' => __('Turnover Label', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'What is your monthly average turnover?',
            ]
        );

        $this->add_control(
            'calculate_button_text',
            [
                'label' => __('Calculate Button Text', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Calculate',
            ]
        );

        $this->add_control(
            'results_title',
            [
                'label' => __('Results Title', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Congratulations!',
            ]
        );

        $this->add_control(
            'results_subtitle',
            [
                'label' => __('Results Subtitle', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'You may be eligible for a loan amount up to:',
            ]
        );

        $this->add_control(
            'disclaimer_text',
            [
                'label' => __('Disclaimer Text', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => '* Subject to Capify\'s standard credit assessment criterial terms & conditions',
            ]
        );

        $this->add_control(
            'repayment_section_label',
            [
                'label' => __('Repayment Section Label', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Your Repayment:',
            ]
        );

        $this->add_control(
            'daily_repayment_label',
            [
                'label' => __('Daily Repayment Label', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Daily repayments:',
            ]
        );

        $this->add_control(
            'monthly_repayment_label',
            [
                'label' => __('Monthly Repayment Label', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Monthly repayments:',
            ]
        );

        $this->add_control(
            'total_cost_label',
            [
                'label' => __('Total Cost Label', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Total Cost of Loan:',
            ]
        );

        $this->add_control(
            'total_repayment_label',
            [
                'label' => __('Total Repayment Label', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Total Repayment:',
            ]
        );

        $this->add_control(
            'currency_symbol',
            [
                'label' => __('Currency Symbol', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '£',
            ]
        );

        $this->add_control(
            'empty_state_title',
            [
                'label' => __('Empty State Title', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Your estimate will appear here',
            ]
        );

        $this->add_control(
            'empty_state_subtitle',
            [
                'label' => __('Empty State Subtitle', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Move the sliders to get your instant loan estimate',
            ]
        );

        $this->end_controls_section();

        // Calculator Settings Section
        $this->start_controls_section(
            'calculator_settings_section',
            [
                'label' => __('Calculator Settings', 'capify-loan-calculator'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'borrow_months_min',
            [
                'label' => __('Min Duration (months)', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 3,
                'min' => 1,
            ]
        );

        $this->add_control(
            'borrow_months_maximum',
            [
                'label' => __('Max Duration (months)', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 12,
                'min' => 1,
            ]
        );

        $this->add_control(
            'default_duration',
            [
                'label' => __('Default Duration (months)', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 6,
                'min' => 1,
            ]
        );

        $this->add_control(
            'borrow_turnover_min',
            [
                'label' => __('Min Turnover', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 10000,
                'min' => 0,
                'step' => 1000,
            ]
        );

        $this->add_control(
            'borrow_turnover_maximum',
            [
                'label' => __('Max Turnover', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 500000,
                'min' => 0,
                'step' => 1000,
            ]
        );

        $this->add_control(
            'default_turnover',
            [
                'label' => __('Default Turnover', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 110000,
                'min' => 0,
                'step' => 1000,
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
            ]
        );

        $this->add_control(
            'borrow_factor',
            [
                'label' => __('Borrow Factor', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 1.26,
                'min' => 0.01,
                'step' => 0.01,
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
            ]
        );

        $this->end_controls_section();

        // ========== STYLE TAB ==========

        // Calculator Card Style
        $this->start_controls_section(
            'card_style_section',
            [
                'label' => __('Calculator Card', 'capify-loan-calculator'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'card_padding',
            [
                'label' => __('Padding', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .calculator-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'card_background',
            [
                'label' => __('Background Color', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .calculator-card' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'card_border',
                'selector' => '{{WRAPPER}} .calculator-card',
            ]
        );

        $this->add_control(
            'card_border_radius',
            [
                'label' => __('Border Radius', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .calculator-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'card_box_shadow',
                'selector' => '{{WRAPPER}} .calculator-card',
            ]
        );

        $this->end_controls_section();

        // Header Style
        $this->start_controls_section(
            'header_style_section',
            [
                'label' => __('Header', 'capify-loan-calculator'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_heading',
            [
                'label' => __('Title', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::HEADING,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .title',
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __('Title Color', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => __('Title Margin', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'subtitle_heading',
            [
                'label' => __('Subtitle', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'subtitle_typography',
                'selector' => '{{WRAPPER}} .subtitle',
            ]
        );

        $this->add_control(
            'subtitle_color',
            [
                'label' => __('Subtitle Color', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'subtitle_margin',
            [
                'label' => __('Subtitle Margin', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'subtitle_padding',
            [
                'label' => __('Subtitle Padding', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .subtitle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Slider Style
        $this->start_controls_section(
            'slider_style_section',
            [
                'label' => __('Sliders', 'capify-loan-calculator'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'slider_label_heading',
            [
                'label' => __('Label', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::HEADING,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'slider_label_typography',
                'selector' => '{{WRAPPER}} .input-label',
            ]
        );

        $this->add_control(
            'slider_label_color',
            [
                'label' => __('Label Color', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .input-label' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'slider_value_heading',
            [
                'label' => __('Value', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'slider_value_typography',
                'selector' => '{{WRAPPER}} .input-value',
            ]
        );

        $this->add_control(
            'slider_value_color',
            [
                'label' => __('Value Color', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .input-value' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'slider_track_heading',
            [
                'label' => __('Track', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'slider_track_color',
            [
                'label' => __('Track Color', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .slider-track' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'slider_progress_color',
            [
                'label' => __('Progress Color', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .slider-progress' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'slider_thumb_color',
            [
                'label' => __('Thumb Color', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .slider-thumb' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Button Style
        $this->start_controls_section(
            'button_style_section',
            [
                'label' => __('Calculate Button', 'capify-loan-calculator'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'selector' => '{{WRAPPER}} .calculate-btn',
            ]
        );

        $this->start_controls_tabs('button_tabs');

        $this->start_controls_tab(
            'button_normal_tab',
            [
                'label' => __('Normal', 'capify-loan-calculator'),
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label' => __('Text Color', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .calculate-btn' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_background',
            [
                'label' => __('Background Color', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .calculate-btn' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'button_hover_tab',
            [
                'label' => __('Hover', 'capify-loan-calculator'),
            ]
        );

        $this->add_control(
            'button_hover_color',
            [
                'label' => __('Text Color', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .calculate-btn:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_background',
            [
                'label' => __('Background Color', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .calculate-btn:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'button_padding',
            [
                'label' => __('Padding', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .calculate-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'selector' => '{{WRAPPER}} .calculate-btn',
            ]
        );

        $this->add_control(
            'button_border_radius',
            [
                'label' => __('Border Radius', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .calculate-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Results Panel Style
        $this->start_controls_section(
            'results_style_section',
            [
                'label' => __('Results Panel', 'capify-loan-calculator'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'results_background',
            [
                'label' => __('Background Color', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .results-panel' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'results_background_image',
            [
                'label' => __('Background Image', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'selectors' => [
                    '{{WRAPPER}} .results-panel' => 'background-image: url("{{URL}}");',
                ],
            ]
        );

        $this->add_responsive_control(
            'results_padding',
            [
                'label' => __('Padding', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .results-panel' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'results_margin',
            [
                'label' => __('Margin', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .results-panel' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'results_border',
                'selector' => '{{WRAPPER}} .results-panel',
            ]
        );

        $this->add_control(
            'results_border_radius',
            [
                'label' => __('Border Radius', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .results-panel' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'results_title_heading',
            [
                'label' => __('Title', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'results_title_typography',
                'selector' => '{{WRAPPER}} .results-title',
            ]
        );

        $this->add_control(
            'results_title_color',
            [
                'label' => __('Title Color', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .results-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'loan_amount_heading',
            [
                'label' => __('Loan Amount', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'loan_amount_typography',
                'selector' => '{{WRAPPER}} .loan-amount',
            ]
        );

        $this->add_control(
            'loan_amount_color',
            [
                'label' => __('Loan Amount Color', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .loan-amount' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'divider_heading',
            [
                'label' => __('Dividers', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'divider_color',
            [
                'label' => __('Divider Color', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .divider' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .vertical-divider' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Repayment Style
        $this->start_controls_section(
            'repayment_style_section',
            [
                'label' => __('Repayment Values', 'capify-loan-calculator'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'repayment_label_heading',
            [
                'label' => __('Labels', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::HEADING,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'repayment_label_typography',
                'selector' => '{{WRAPPER}} .repayment-label',
            ]
        );

        $this->add_control(
            'repayment_label_color',
            [
                'label' => __('Label Color', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .repayment-label' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'repayment_value_heading',
            [
                'label' => __('Values', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'repayment_value_typography',
                'selector' => '{{WRAPPER}} .repayment-value',
            ]
        );

        $this->add_control(
            'repayment_value_color',
            [
                'label' => __('Value Color', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .repayment-value' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render widget output
     */
    protected function render() {
        $settings = $this->get_settings_for_display();

        // Build shortcode attributes
        $atts = [
            'header_title' => $settings['header_title'],
            'header_subtitle' => $settings['header_subtitle'],
            'duration_label' => $settings['duration_label'],
            'turnover_label' => $settings['turnover_label'],
            'calculate_button_text' => $settings['calculate_button_text'],
            'results_title' => $settings['results_title'],
            'results_subtitle' => $settings['results_subtitle'],
            'disclaimer_text' => $settings['disclaimer_text'],
            'repayment_section_label' => $settings['repayment_section_label'],
            'daily_repayment_label' => $settings['daily_repayment_label'],
            'monthly_repayment_label' => $settings['monthly_repayment_label'],
            'total_cost_label' => $settings['total_cost_label'],
            'total_repayment_label' => $settings['total_repayment_label'],
            'currency_symbol' => $settings['currency_symbol'],
            'empty_state_title' => $settings['empty_state_title'],
            'empty_state_subtitle' => $settings['empty_state_subtitle'],
            'borrow_months_min' => $settings['borrow_months_min'],
            'borrow_months_maximum' => $settings['borrow_months_maximum'],
            'default_duration' => $settings['default_duration'],
            'borrow_turnover_min' => $settings['borrow_turnover_min'],
            'borrow_turnover_maximum' => $settings['borrow_turnover_maximum'],
            'default_turnover' => $settings['default_turnover'],
            'loan_cap' => $settings['loan_cap'],
            'borrow_factor' => $settings['borrow_factor'],
            'gross_percentage' => $settings['gross_percentage'],
        ];

        // Get the calculator instance
        $calculator = new Capify_Loan_Calculator();
        echo $calculator->render_calculator($atts);
    }
}
