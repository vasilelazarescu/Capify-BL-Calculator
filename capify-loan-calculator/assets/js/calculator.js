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
            // Get configuration from data attributes
            const $wrapper = $('.capify-loan-calculator-wrapper');

            // Read settings from data attributes with fallback defaults
            this.borrowFactor = parseFloat($wrapper.data('borrow-factor')) || 1.26;
            this.grossPercentageSum = parseFloat($wrapper.data('gross-percentage')) || 0.13;
            this.borrowLoanCap = parseFloat($wrapper.data('loan-cap')) || 500000;
            this.currencySymbol = $wrapper.data('currency') || '£';
            this.loanCapActive = 1; // Enable loan cap

            // Initialize from slider values
            this.monthlyTurnover = parseInt($('#turnover-slider').val()) || 10000;
            this.loanDuration = parseInt($('#duration-slider').val()) || 24;

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
         * Calculate loan details based on turnover (matching original formula)
         */
        calculateLoan() {
            const turnover = this.monthlyTurnover;
            const borrowTerm = this.loanDuration;

            // Calculate gross percentage (monthly repayment amount)
            const grossPercentage = turnover * this.grossPercentageSum;

            // Calculate total repayment (gross result)
            let grossResult = grossPercentage * borrowTerm;

            // Apply loan cap to total repayment if active
            if (this.loanCapActive === 1) {
                const grossCap = this.borrowLoanCap * this.borrowFactor;
                if (grossResult >= grossCap) {
                    grossResult = grossCap;
                }
            }

            // Calculate eligible amount (total result)
            let totalResult = (grossPercentage * borrowTerm) / this.borrowFactor;

            // Apply loan cap to eligible amount if active
            if (this.loanCapActive === 1) {
                const totalCap = (this.borrowLoanCap * this.borrowFactor) / this.borrowFactor;
                if (totalResult >= totalCap) {
                    totalResult = totalCap;
                }
            }

            // Calculate total cost of loan
            const costResult = parseInt(grossResult) - parseInt(totalResult);

            // Calculate monthly repayments
            const monthlyResult = grossResult / borrowTerm;

            // Calculate daily repayments (20 business days per month)
            const dailyResult = grossResult / (20 * borrowTerm);

            // Update the display
            this.updateResults(
                parseInt(totalResult),    // Eligible amount
                parseInt(dailyResult),    // Daily repayment
                parseInt(monthlyResult),  // Monthly repayment
                parseInt(costResult),     // Total cost
                parseInt(grossResult)     // Total repayment
            );
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
