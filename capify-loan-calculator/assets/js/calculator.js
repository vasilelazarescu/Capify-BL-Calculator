/**
 * Capify Business Loan Calculator JavaScript
 * Version: 2.5.0
 * Performance optimized
 */

(function($) {
    'use strict';

    // Constants
    const DEBOUNCE_DELAY = 200; // milliseconds
    const ANIMATION_DURATION = 300; // milliseconds

    /**
     * Loan Calculator Class
     */
    class LoanCalculator {
        constructor() {
            this.loanAmount = 100000;
            this.interestRate = 1.26;
            this.loanDuration = 24;
            this.currencySymbol = '£';
            this.debounceTimer = null;

            this.init();
        }

        /**
         * Initialize the calculator
         */
        init() {
            this.cacheDOMElements();
            this.bindEvents();
            this.formatInputs();
            this.calculateLoan();
        }

        /**
         * Cache DOM elements
         */
        cacheDOMElements() {
            this.$loanAmountInput = $('#loan-amount');
            this.$interestRateInput = $('#interest-rate');
            this.$durationButtons = $('.duration-btn');
            this.$calculateButton = $('#calculate-btn');

            // Results elements
            this.$monthlyPayment = $('#monthly-payment');
            this.$monthlyInterest = $('#monthly-interest');
            this.$totalInterest = $('#total-interest');
            this.$loanLength = $('#loan-length');
            this.$totalCost = $('#total-cost');

            // Cache all result values for animation
            this.$allResults = $('.result-value');

            // Get currency symbol from data attribute or first result element
            const currencyData = this.$loanAmountInput.closest('.capify-loan-calculator-wrapper').data('currency');
            if (currencyData) {
                this.currencySymbol = currencyData;
            } else {
                const firstResult = this.$monthlyPayment.text();
                const match = firstResult.match(/^[£$€]/);
                if (match) {
                    this.currencySymbol = match[0];
                }
            }
        }

        /**
         * Bind event listeners
         */
        bindEvents() {
            const self = this;

            // Input changes with debounced calculation
            this.$loanAmountInput.on('input', function() {
                self.handleLoanAmountChange($(this));
                self.debouncedCalculate();
            });

            this.$loanAmountInput.on('blur', function() {
                self.formatLoanAmount($(this));
            });

            this.$interestRateInput.on('input', function() {
                self.handleInterestRateChange($(this));
                self.debouncedCalculate();
            });

            // Duration button clicks
            this.$durationButtons.on('click', function() {
                self.handleDurationChange($(this));
            });

            // Calculate button click
            this.$calculateButton.on('click', function() {
                self.calculateLoan();
            });
        }

        /**
         * Debounced calculation to prevent excessive calculations
         */
        debouncedCalculate() {
            clearTimeout(this.debounceTimer);
            this.debounceTimer = setTimeout(() => {
                if (this.validateInput()) {
                    this.calculateLoan();
                }
            }, DEBOUNCE_DELAY);
        }

        /**
         * Format inputs
         */
        formatInputs() {
            this.formatLoanAmount(this.$loanAmountInput);
        }

        /**
         * Sanitize numeric input (removes commas and non-digits)
         */
        sanitizeNumericInput(value) {
            return value.replace(/,/g, '').replace(/[^\d]/g, '');
        }

        /**
         * Handle loan amount change
         */
        handleLoanAmountChange($input) {
            const value = this.sanitizeNumericInput($input.val());

            if (value) {
                this.loanAmount = parseInt(value);
            }
        }

        /**
         * Format loan amount with commas
         */
        formatLoanAmount($input) {
            const value = this.sanitizeNumericInput($input.val());

            if (value) {
                const formatted = parseInt(value).toLocaleString();
                $input.val(formatted);
            }
        }

        /**
         * Handle interest rate change
         */
        handleInterestRateChange($input) {
            let value = $input.val();

            // Allow numbers and decimal point
            value = value.replace(/[^\d.]/g, '');

            // Ensure only one decimal point
            const parts = value.split('.');
            if (parts.length > 2) {
                value = parts[0] + '.' + parts.slice(1).join('');
            }

            $input.val(value);

            if (value) {
                this.interestRate = parseFloat(value);
            }
        }

        /**
         * Handle duration change
         */
        handleDurationChange($button) {
            this.$durationButtons.removeClass('active');
            $button.addClass('active');
            this.loanDuration = parseInt($button.data('months'));
            this.calculateLoan();
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
            // Add animation class using cached elements
            this.$allResults.addClass('updated');

            // Update values
            this.$monthlyPayment.text(this.formatCurrency(monthlyPayment));
            this.$monthlyInterest.text(this.formatCurrency(monthlyInterest));
            this.$totalInterest.text(this.formatCurrency(totalInterest));
            this.$loanLength.text(months + ' months');
            this.$totalCost.text(this.formatCurrency(totalPayment));

            // Remove animation class after animation completes
            const self = this;
            setTimeout(() => {
                self.$allResults.removeClass('updated');
            }, ANIMATION_DURATION);
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
         * Validate input
         */
        validateInput() {
            let isValid = true;

            if (this.loanAmount <= 0 || isNaN(this.loanAmount)) {
                isValid = false;
                this.$loanAmountInput.css('border-color', '#f44336');
            } else {
                this.$loanAmountInput.css('border-color', '#e0e0e0');
            }

            if (this.interestRate < 0 || isNaN(this.interestRate)) {
                isValid = false;
                this.$interestRateInput.css('border-color', '#f44336');
            } else {
                this.$interestRateInput.css('border-color', '#e0e0e0');
            }

            return isValid;
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
