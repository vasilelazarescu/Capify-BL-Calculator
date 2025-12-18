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
            this.$loanAmountInput = $('#loan-amount');
            this.$loanAmountSlider = $('#loan-amount-slider');
            this.$interestRateInput = $('#interest-rate');
            this.$interestRateSlider = $('#interest-rate-slider');
            this.$durationButtons = $('.duration-btn');
            this.$calculateButton = $('#calculate-btn');

            // Results elements
            this.$monthlyPayment = $('#monthly-payment');
            this.$monthlyInterest = $('#monthly-interest');
            this.$totalInterest = $('#total-interest');
            this.$loanLength = $('#loan-length');
            this.$totalCost = $('#total-cost');

            // Visual breakdown elements
            this.$principalBar = $('#principal-bar');
            this.$interestBar = $('#interest-bar');
            this.$principalAmount = $('#principal-amount');
            this.$interestAmount = $('#interest-amount');

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

            // Loan amount input changes
            this.$loanAmountInput.on('input', function() {
                self.handleLoanAmountChange($(this));
                self.syncSliderFromInput('amount');
                self.calculateLoan();
            });

            this.$loanAmountInput.on('blur', function() {
                self.formatLoanAmount($(this));
            });

            this.$loanAmountInput.on('focus', function() {
                $(this).parent().addClass('input-focused');
            });

            this.$loanAmountInput.on('blur', function() {
                $(this).parent().removeClass('input-focused');
            });

            // Loan amount slider
            if (this.$loanAmountSlider.length) {
                this.$loanAmountSlider.on('input', function() {
                    self.handleSliderChange('amount', $(this).val());
                });
            }

            // Interest rate input changes
            this.$interestRateInput.on('input', function() {
                self.handleInterestRateChange($(this));
                self.syncSliderFromInput('rate');
                self.calculateLoan();
            });

            this.$interestRateInput.on('focus', function() {
                $(this).parent().addClass('input-focused');
            });

            this.$interestRateInput.on('blur', function() {
                $(this).parent().removeClass('input-focused');
            });

            // Interest rate slider
            if (this.$interestRateSlider.length) {
                this.$interestRateSlider.on('input', function() {
                    self.handleSliderChange('rate', $(this).val());
                });
            }

            // Duration button clicks with haptic feedback
            this.$durationButtons.on('click', function() {
                self.handleDurationChange($(this));
            });

            // Calculate button click
            this.$calculateButton.on('click', function(e) {
                e.preventDefault();
                $(this).addClass('btn-clicked');
                setTimeout(function() {
                    self.$calculateButton.removeClass('btn-clicked');
                }, 200);
                self.calculateLoan();
            });

            // Keyboard accessibility
            this.$durationButtons.on('keypress', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    $(this).click();
                }
            });
        }

        /**
         * Format inputs
         */
        formatInputs() {
            this.formatLoanAmount(this.$loanAmountInput);
        }

        /**
         * Handle loan amount change
         */
        handleLoanAmountChange($input) {
            let value = $input.val().replace(/,/g, '');

            // Only allow numbers
            value = value.replace(/[^\d]/g, '');

            if (value) {
                this.loanAmount = parseInt(value);
            }
        }

        /**
         * Format loan amount with commas
         */
        formatLoanAmount($input) {
            let value = $input.val().replace(/,/g, '');
            value = value.replace(/[^\d]/g, '');

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
            // Update active state and ARIA attributes
            this.$durationButtons.removeClass('active').attr('aria-pressed', 'false');
            $button.addClass('active').attr('aria-pressed', 'true');
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
            // Add animation class
            $('.result-value').addClass('updated');

            // Update values
            this.$monthlyPayment.text(this.formatCurrency(monthlyPayment));
            this.$monthlyInterest.text(this.formatCurrency(monthlyInterest));
            this.$totalInterest.text(this.formatCurrency(totalInterest));
            this.$loanLength.text(months + ' months');
            this.$totalCost.text(this.formatCurrency(totalPayment));

            // Update visual breakdown chart
            this.updateVisualBreakdown(this.loanAmount, totalInterest);

            // Remove animation class after animation completes
            setTimeout(function() {
                $('.result-value').removeClass('updated');
            }, 300);
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
                this.$loanAmountInput.parent().addClass('input-error');
            } else {
                this.$loanAmountInput.parent().removeClass('input-error');
            }

            if (this.interestRate < 0 || isNaN(this.interestRate)) {
                isValid = false;
                this.$interestRateInput.parent().addClass('input-error');
            } else {
                this.$interestRateInput.parent().removeClass('input-error');
            }

            return isValid;
        }

        /**
         * Handle slider change
         */
        handleSliderChange(type, value) {
            if (type === 'amount') {
                this.loanAmount = parseInt(value);
                this.$loanAmountInput.val(this.loanAmount.toLocaleString());
            } else if (type === 'rate') {
                this.interestRate = parseFloat(value);
                this.$interestRateInput.val(this.interestRate);
            }
            this.calculateLoan();
        }

        /**
         * Sync slider from input
         */
        syncSliderFromInput(type) {
            if (type === 'amount' && this.$loanAmountSlider.length) {
                this.$loanAmountSlider.val(this.loanAmount);
                this.updateSliderProgress(this.$loanAmountSlider);
            } else if (type === 'rate' && this.$interestRateSlider.length) {
                this.$interestRateSlider.val(this.interestRate);
                this.updateSliderProgress(this.$interestRateSlider);
            }
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

            $slider.css('background', `linear-gradient(to right, #7c3aed 0%, #7c3aed ${percentage}%, #e0e0e0 ${percentage}%, #e0e0e0 100%)`);
        }

        /**
         * Update visual breakdown chart
         */
        updateVisualBreakdown(principal, totalInterest) {
            if (!this.$principalBar || !this.$interestBar) return;

            const total = principal + totalInterest;
            const principalPercentage = (principal / total) * 100;
            const interestPercentage = (totalInterest / total) * 100;

            // Update bar widths with animation
            this.$principalBar.css('width', principalPercentage + '%');
            this.$interestBar.css('width', interestPercentage + '%');

            // Update amounts if elements exist
            if (this.$principalAmount) {
                this.$principalAmount.text(this.formatCurrency(principal));
            }
            if (this.$interestAmount) {
                this.$interestAmount.text(this.formatCurrency(totalInterest));
            }
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
