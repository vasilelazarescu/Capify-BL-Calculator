<?php
/**
 * Capify Loan Calculator Elementor Widget
 * Version: 2.3.0
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
        return 'eicon-number-field';
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
            'show_header_icon',
            [
                'label' => __('Show Header Icon', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'capify-loan-calculator'),
                'label_off' => __('No', 'capify-loan-calculator'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'header_icon',
            [
                'label' => __('Header Icon', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-calculator',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'show_header_icon' => 'yes',
                ],
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
                'default' => 3,
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
                'default' => 10000,
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

        $this->add_responsive_control(
            'column_spacing',
            [
                'label' => __('Column Spacing', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .calculator-left' => 'padding-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .calculator-right' => 'padding-left: {{SIZE}}{{UNIT}};',
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
            'icon_heading',
            [
                'label' => __('Icon', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'condition' => [
                    'show_header_icon' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'header_icon_size',
            [
                'label' => __('Icon Size', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 16,
                        'max' => 200,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 48,
                ],
                'selectors' => [
                    '{{WRAPPER}} .header-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .header-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .header-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'show_header_icon' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'header_icon_color',
            [
                'label' => __('Icon Color', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .header-icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .header-icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .header-icon svg' => 'fill: {{VALUE}};',
                ],
                'condition' => [
                    'show_header_icon' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'header_icon_margin',
            [
                'label' => __('Icon Margin', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .header-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'show_header_icon' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'title_heading',
            [
                'label' => __('Title', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
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
                    '{{WRAPPER}} .custom-slider-track' => 'background-color: {{VALUE}}; background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'slider_progress_color',
            [
                'label' => __('Progress Color', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .custom-slider-progress' => 'background-color: {{VALUE}}; background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'slider_thumb_color',
            [
                'label' => __('Thumb Color', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .custom-slider-handle' => 'background-color: {{VALUE}}; background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'slider_dimensions_heading',
            [
                'label' => __('Track Dimensions', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'slider_track_height',
            [
                'label' => __('Track Height', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 2,
                        'max' => 20,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'size' => 8,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .custom-slider-track' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'slider_track_border_radius',
            [
                'label' => __('Track Border Radius', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'size' => 32,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .custom-slider-track' => 'border-radius: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .custom-slider-progress' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'slider_thumb_heading',
            [
                'label' => __('Thumb (Handle)', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'slider_thumb_size',
            [
                'label' => __('Thumb Size', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 16,
                        'max' => 48,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'size' => 28,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .custom-slider-handle' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; margin-left: calc(-{{SIZE}}{{UNIT}} / 2); margin-top: calc(-{{SIZE}}{{UNIT}} / 2);',
                ],
            ]
        );

        $this->add_responsive_control(
            'slider_thumb_border_radius',
            [
                'label' => __('Thumb Border Radius', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'size' => 50,
                    'unit' => '%',
                ],
                'selectors' => [
                    '{{WRAPPER}} .custom-slider-handle' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'slider_thumb_box_shadow',
                'label' => __('Thumb Box Shadow', 'capify-loan-calculator'),
                'selector' => '{{WRAPPER}} .custom-slider-handle',
            ]
        );

        $this->add_control(
            'slider_thumb_dot_heading',
            [
                'label' => __('Thumb Center Dot', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'slider_thumb_dot_color',
            [
                'label' => __('Dot Color', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .custom-slider-handle-dot' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'slider_thumb_dot_size',
            [
                'label' => __('Dot Size', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 20,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'size' => 12,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .custom-slider-handle-dot' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
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

        $this->add_control(
            'results_background_position',
            [
                'label' => __('Background Position', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'center center',
                'options' => [
                    'center center' => __('Center Center', 'capify-loan-calculator'),
                    'center left' => __('Center Left', 'capify-loan-calculator'),
                    'center right' => __('Center Right', 'capify-loan-calculator'),
                    'top center' => __('Top Center', 'capify-loan-calculator'),
                    'top left' => __('Top Left', 'capify-loan-calculator'),
                    'top right' => __('Top Right', 'capify-loan-calculator'),
                    'bottom center' => __('Bottom Center', 'capify-loan-calculator'),
                    'bottom left' => __('Bottom Left', 'capify-loan-calculator'),
                    'bottom right' => __('Bottom Right', 'capify-loan-calculator'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .results-panel' => 'background-position: {{VALUE}};',
                ],
                'condition' => [
                    'results_background_image[url]!' => '',
                ],
            ]
        );

        $this->add_control(
            'results_background_size',
            [
                'label' => __('Background Size', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'cover',
                'options' => [
                    'cover' => __('Cover', 'capify-loan-calculator'),
                    'contain' => __('Contain', 'capify-loan-calculator'),
                    'auto' => __('Auto', 'capify-loan-calculator'),
                    '100% 100%' => __('100% 100%', 'capify-loan-calculator'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .results-panel' => 'background-size: {{VALUE}};',
                ],
                'condition' => [
                    'results_background_image[url]!' => '',
                ],
            ]
        );

        $this->add_control(
            'results_background_repeat',
            [
                'label' => __('Background Repeat', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'no-repeat',
                'options' => [
                    'no-repeat' => __('No Repeat', 'capify-loan-calculator'),
                    'repeat' => __('Repeat', 'capify-loan-calculator'),
                    'repeat-x' => __('Repeat X', 'capify-loan-calculator'),
                    'repeat-y' => __('Repeat Y', 'capify-loan-calculator'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .results-panel' => 'background-repeat: {{VALUE}};',
                ],
                'condition' => [
                    'results_background_image[url]!' => '',
                ],
            ]
        );

        $this->add_control(
            'results_background_attachment',
            [
                'label' => __('Background Attachment', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'scroll',
                'options' => [
                    'scroll' => __('Scroll', 'capify-loan-calculator'),
                    'fixed' => __('Fixed', 'capify-loan-calculator'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .results-panel' => 'background-attachment: {{VALUE}};',
                ],
                'condition' => [
                    'results_background_image[url]!' => '',
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
            'results_subtitle_heading',
            [
                'label' => __('Subtitle', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'results_subtitle_typography',
                'selector' => '{{WRAPPER}} .results-subtitle',
            ]
        );

        $this->add_control(
            'results_subtitle_color',
            [
                'label' => __('Subtitle Color', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .results-subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'results_subtitle_margin',
            [
                'label' => __('Subtitle Margin', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .results-subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'disclaimer_heading',
            [
                'label' => __('Disclaimer', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'disclaimer_typography',
                'selector' => '{{WRAPPER}} .disclaimer',
            ]
        );

        $this->add_control(
            'disclaimer_color',
            [
                'label' => __('Disclaimer Color', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .disclaimer' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'disclaimer_margin',
            [
                'label' => __('Disclaimer Margin', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .disclaimer' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        $this->add_responsive_control(
            'repayment_grid_gap',
            [
                'label' => __('Values Gap', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 16,
                ],
                'selectors' => [
                    '{{WRAPPER}} .repayment-grid' => 'gap: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();

        // Empty State Style
        $this->start_controls_section(
            'empty_state_style_section',
            [
                'label' => __('Empty State', 'capify-loan-calculator'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'empty_state_custom_icon',
            [
                'label' => __('Custom Icon/Image', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => '',
                ],
            ]
        );

        $this->add_control(
            'empty_state_icon_position',
            [
                'label' => __('Icon Position', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'before',
                'options' => [
                    'before' => __('Before Text', 'capify-loan-calculator'),
                    'after' => __('After Text', 'capify-loan-calculator'),
                ],
            ]
        );

        $this->add_responsive_control(
            'empty_state_icon_size',
            [
                'label' => __('Icon Size', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 40,
                        'max' => 300,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 120,
                ],
                'selectors' => [
                    '{{WRAPPER}} .empty-state-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .empty-state-icon img' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
                ],
            ]
        );

        $this->add_control(
            'empty_state_icon_opacity',
            [
                'label' => __('Icon Opacity', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'size' => 0.6,
                ],
                'selectors' => [
                    '{{WRAPPER}} .empty-state-icon' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'empty_state_padding',
            [
                'label' => __('Padding', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .empty-state' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'empty_state_min_height',
            [
                'label' => __('Min Height', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 800,
                        'step' => 10,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 300,
                ],
                'selectors' => [
                    '{{WRAPPER}} .empty-state' => 'min-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'empty_state_title_heading',
            [
                'label' => __('Title', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'empty_state_title_typography',
                'selector' => '{{WRAPPER}} .empty-state-title',
            ]
        );

        $this->add_control(
            'empty_state_title_color',
            [
                'label' => __('Title Color', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .empty-state-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'empty_state_title_margin',
            [
                'label' => __('Title Margin', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .empty-state-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'empty_state_subtitle_heading',
            [
                'label' => __('Subtitle', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'empty_state_subtitle_typography',
                'selector' => '{{WRAPPER}} .empty-state-subtitle',
            ]
        );

        $this->add_control(
            'empty_state_subtitle_color',
            [
                'label' => __('Subtitle Color', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .empty-state-subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'empty_state_subtitle_margin',
            [
                'label' => __('Subtitle Margin', 'capify-loan-calculator'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .empty-state-subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
            'show_header_icon' => $settings['show_header_icon'],
            'header_icon' => isset($settings['header_icon']) ? $settings['header_icon'] : '',
            'header_title' => $settings['header_title'],
            'header_subtitle' => $settings['header_subtitle'],
            'duration_label' => $settings['duration_label'],
            'turnover_label' => $settings['turnover_label'],
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
            'empty_state_custom_icon' => isset($settings['empty_state_custom_icon']['url']) ? $settings['empty_state_custom_icon']['url'] : '',
            'empty_state_icon_position' => $settings['empty_state_icon_position'],
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
