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
            this.loanAmount = 100000;
            this.interestRate = 1.26;
            this.loanDuration = 24;
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
            if (this.$loanAmountSlider.length) {
                this.updateSliderProgress(this.$loanAmountSlider);
            }
            if (this.$interestRateSlider.length) {
                this.updateSliderProgress(this.$interestRateSlider);
            }
        }

        /**
         * Cache DOM elements
         */
        cacheDOMElements() {
            // Sliders
            this.$loanAmountSlider = $('#loan-amount-slider');
            this.$interestRateSlider = $('#interest-rate-slider');
            this.$durationSlider = $('#duration-slider');

            // Value displays
            this.$amountValue = $('#amount-value');
            this.$rateValue = $('#rate-value');
            this.$durationValue = $('#duration-value');

            // Results elements
            this.$monthlyPayment = $('#monthly-payment');
            this.$totalInterest = $('#total-interest');
            this.$loanLength = $('#loan-length');
            this.$totalCost = $('#total-cost');
            this.$loanPrincipal = $('#loan-principal');

            // Get currency symbol from first result element
            const firstResult = this.$monthlyPayment.text();
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

            // Loan amount slider
            if (this.$loanAmountSlider.length) {
                this.$loanAmountSlider.on('input', function() {
                    const value = parseInt($(this).val());
                    self.loanAmount = value;
                    self.$amountValue.text(value.toLocaleString());
                    self.updateSliderProgress($(this));
                    self.calculateLoan();
                });
            }

            // Interest rate slider
            if (this.$interestRateSlider.length) {
                this.$interestRateSlider.on('input', function() {
                    const value = parseFloat($(this).val());
                    self.interestRate = value;
                    self.$rateValue.text(value.toFixed(2));
                    self.updateSliderProgress($(this));
                    self.calculateLoan();
                });
            }

            // Duration slider
            if (this.$durationSlider.length) {
                this.$durationSlider.on('input', function() {
                    const value = parseInt($(this).val());
                    self.loanDuration = value;
                    self.$durationValue.text(value);
                    self.updateSliderProgress($(this));
                    self.calculateLoan();
                });
            }
        }


        /**
         * Calculate loan details
         */
        calculateLoan() {
            // Get current values
            const principal = this.loanAmount;
            const annualRate = this.interestRate / 100;
            const months = this.loanDuration;

            // Calculate monthly interest rate
            const monthlyRate = annualRate / 12;

            // Calculate monthly payment using loan payment formula
            // M = P * [r(1+r)^n] / [(1+r)^n - 1]
            let monthlyPayment;

            if (monthlyRate === 0) {
                // If interest rate is 0, simple division
                monthlyPayment = principal / months;
            } else {
                const x = Math.pow(1 + monthlyRate, months);
                monthlyPayment = principal * (monthlyRate * x) / (x - 1);
            }

            // Calculate total payment and interest
            const totalPayment = monthlyPayment * months;
            const totalInterest = totalPayment - principal;

            // Calculate average monthly interest
            const monthlyInterest = totalInterest / months;

            // Update the display
            this.updateResults(monthlyPayment, monthlyInterest, totalInterest, totalPayment, months);
        }

        /**
         * Update result displays
         */
        updateResults(monthlyPayment, monthlyInterest, totalInterest, totalPayment, months) {
            // Add animation class
            $('.highlight-value, .breakdown-value').addClass('updated');

            // Update values
            this.$monthlyPayment.text(this.formatCurrency(monthlyPayment));
            this.$totalInterest.text(this.formatCurrency(totalInterest));
            this.$loanLength.text(months + ' months');
            this.$totalCost.text(this.formatCurrency(totalPayment));

            if (this.$loanPrincipal) {
                this.$loanPrincipal.text(this.formatCurrency(this.loanAmount));
            }

            // Remove animation class after animation completes
            setTimeout(function() {
                $('.highlight-value, .breakdown-value').removeClass('updated');
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
