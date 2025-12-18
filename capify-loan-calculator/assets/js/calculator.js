/**
 * Capify Business Loan Calculator JavaScript
 * Version: 1.0.0
 */

(function($) {
    'use strict';

    /**
     * Loan Calculator Class
     */
    class LoanCalculator {
        constructor() {
            this.monthlyTurnover = 10000;
            this.loanDuration = 24;
            this.factorRate = 1.26;
            this.turnoverMultiplier = 1.24; // How much can borrow based on turnover
            this.currencySymbol = '£';

            this.init();
        }

        /**
         * Initialize the calculator
         */
        init() {
            this.cacheDOMElements();
            this.bindEvents();
            this.formatInputs();
            this.initializeSliders();
            this.calculateLoan();
        }

        /**
         * Initialize range sliders
         */
        initializeSliders() {
            if (this.$turnoverSlider && this.$turnoverSlider.length) {
                this.updateSliderProgress(this.$turnoverSlider);
            }
            if (this.$durationSlider && this.$durationSlider.length) {
                this.updateSliderProgress(this.$durationSlider);
            }
        }

        /**
         * Format inputs
         */
        formatInputs() {
            // No text inputs to format anymore
        }

        /**
         * Cache DOM elements
         */
        cacheDOMElements() {
            // Sliders
            this.$turnoverSlider = $('#turnover-slider');
            this.$durationSlider = $('#duration-slider');

            // Value displays
            this.$turnoverValue = $('#turnover-value');
            this.$durationValue = $('#duration-value');

            // Results elements
            this.$eligibleAmount = $('#eligible-amount');
            this.$dailyPayment = $('#daily-payment');
            this.$monthlyPayment = $('#monthly-payment');
            this.$totalCost = $('#total-cost');
            this.$totalRepayment = $('#total-repayment');

            // Calculate button
            this.$calculateButton = $('#calculate-btn');

            // Get currency symbol from first result element
            const firstResult = this.$eligibleAmount.text();
            const match = firstResult.match(/^[£$€]/);
            if (match) {
                this.currencySymbol = match[0];
            }
        }

        /**
         * Bind event listeners
         */
        bindEvents() {
            const self = this;

            // Turnover slider
            if (this.$turnoverSlider.length) {
                this.$turnoverSlider.on('input', function() {
                    const value = parseInt($(this).val());
                    self.monthlyTurnover = value;
                    self.$turnoverValue.text(value.toLocaleString());
                    self.updateSliderProgress($(this));
                });
            }

            // Duration slider
            if (this.$durationSlider.length) {
                this.$durationSlider.on('input', function() {
                    const value = parseInt($(this).val());
                    self.loanDuration = value;
                    self.$durationValue.text(value);
                    self.updateSliderProgress($(this));
                });
            }

            // Calculate button
            if (this.$calculateButton.length) {
                this.$calculateButton.on('click', function(e) {
                    e.preventDefault();
                    $(this).addClass('btn-clicked');
                    setTimeout(function() {
                        self.$calculateButton.removeClass('btn-clicked');
                    }, 200);
                    self.calculateLoan();
                });
            }
        }


        /**
         * Calculate loan details based on turnover
         */
        calculateLoan() {
            // Calculate eligible loan amount based on monthly turnover
            const eligibleAmount = Math.round(this.monthlyTurnover * this.turnoverMultiplier);

            // Calculate total repayment using factor rate
            const totalRepayment = Math.round(eligibleAmount * this.factorRate);

            // Calculate total cost (interest)
            const totalCost = totalRepayment - eligibleAmount;

            // Calculate monthly repayment
            const monthlyRepayment = Math.round(totalRepayment / this.loanDuration);

            // Calculate daily repayment (assuming 20 business days per month)
            const dailyRepayment = Math.round(monthlyRepayment / 20);

            // Update the display
            this.updateResults(eligibleAmount, dailyRepayment, monthlyRepayment, totalCost, totalRepayment);
        }

        /**
         * Update result displays
         */
        updateResults(eligibleAmount, dailyRepayment, monthlyRepayment, totalCost, totalRepayment) {
            // Add animation class
            $('.eligible-amount, .breakdown-value').addClass('updated');

            // Update values
            this.$eligibleAmount.text(this.formatCurrency(eligibleAmount));
            this.$dailyPayment.text(this.formatCurrency(dailyRepayment));
            this.$monthlyPayment.text(this.formatCurrency(monthlyRepayment));
            this.$totalCost.text(this.formatCurrency(totalCost));
            this.$totalRepayment.text(this.formatCurrency(totalRepayment));

            // Remove animation class after animation completes
            setTimeout(function() {
                $('.eligible-amount, .breakdown-value').removeClass('updated');
            }, 400);
        }

        /**
         * Format number as currency
         */
        formatCurrency(amount) {
            // Round to 2 decimal places
            const rounded = Math.round(amount * 100) / 100;

            // Format with commas and 2 decimal places
            const formatted = rounded.toLocaleString('en-GB', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });

            return this.currencySymbol + formatted;
        }

        /**
         * Update slider progress/fill
         */
        updateSliderProgress($slider) {
            if (!$slider.length) return;

            const min = parseFloat($slider.attr('min')) || 0;
            const max = parseFloat($slider.attr('max')) || 100;
            const value = parseFloat($slider.val());
            const percentage = ((value - min) / (max - min)) * 100;

            $slider.css('background', `linear-gradient(to right, #10b981 0%, #10b981 ${percentage}%, #e0e0e0 ${percentage}%, #e0e0e0 100%)`);
        }
    }

    /**
     * Initialize calculator when document is ready
     */
    $(document).ready(function() {
        if ($('.capify-loan-calculator-wrapper').length) {
            new LoanCalculator();
        }
    });

})(jQuery);
