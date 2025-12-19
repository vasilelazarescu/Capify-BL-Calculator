/**
 * Capify Business Loan Calculator JavaScript
 * Version: 2.1.0
 * Using noUiSlider for optimized mobile performance
 */

(function($) {
    'use strict';

    class CapifyLoanCalculator {
        constructor($wrapper) {
            this.$wrapper = $wrapper;

            // Get configuration from data attributes
            this.borrowFactor = parseFloat($wrapper.attr('data-borrow-factor')) || 1.26;
            this.grossPercentageSum = parseFloat($wrapper.attr('data-gross-percentage')) || 0.13;
            this.loanCap = parseFloat($wrapper.attr('data-loan-cap')) || 500000;
            this.currencySymbol = $wrapper.attr('data-currency') || '£';

            // Duration slider config
            this.minDuration = parseInt($wrapper.attr('data-min-duration')) || 3;
            this.maxDuration = parseInt($wrapper.attr('data-max-duration')) || 12;
            this.currentDuration = this.minDuration; // Start with minimum

            // Turnover slider config
            this.minTurnover = parseInt($wrapper.attr('data-min-turnover')) || 10000;
            this.maxTurnover = parseInt($wrapper.attr('data-max-turnover')) || 500000;
            this.currentTurnover = this.minTurnover; // Start with minimum

            // Track if user has interacted
            this.hasInteracted = false;

            // DOM elements
            this.$durationDisplay = $wrapper.find('#duration-display');
            this.$durationSlider = $wrapper.find('#duration-slider-container')[0];

            this.$turnoverDisplay = $wrapper.find('#turnover-display');
            this.$turnoverSlider = $wrapper.find('#turnover-slider-container')[0];

            this.$emptyState = $wrapper.find('#empty-state');
            this.$resultsContent = $wrapper.find('#results-content');

            this.$loanAmount = $wrapper.find('#loan-amount');
            this.$dailyPayment = $wrapper.find('#daily-payment');
            this.$monthlyPayment = $wrapper.find('#monthly-payment');
            this.$totalCost = $wrapper.find('#total-cost');
            this.$totalRepayment = $wrapper.find('#total-repayment');

            // Slider instances
            this.durationSliderInstance = null;
            this.turnoverSliderInstance = null;

            this.init();
        }

        init() {
            // Check if noUiSlider is available
            if (typeof noUiSlider === 'undefined') {
                console.error('noUiSlider library not loaded');
                return;
            }

            this.setupDurationSlider();
            this.setupTurnoverSlider();

            // Show empty state initially
            this.showEmptyState();
        }

        showEmptyState() {
            this.$emptyState.show();
            this.$resultsContent.hide();
        }

        showResults() {
            this.$emptyState.hide();
            this.$resultsContent.show();
        }

        setupDurationSlider() {
            const self = this;

            // Create noUiSlider
            this.durationSliderInstance = noUiSlider.create(this.$durationSlider, {
                start: [this.minDuration],
                connect: [true, false],
                range: {
                    'min': this.minDuration,
                    'max': this.maxDuration
                },
                step: 1,
                tooltips: false,
                animate: true,
                animationDuration: 300,
                behaviour: 'tap-drag',
                format: {
                    to: function(value) {
                        return Math.round(value);
                    },
                    from: function(value) {
                        return Number(value);
                    }
                }
            });

            // Update on slider change
            this.durationSliderInstance.on('update', function(values, handle) {
                const value = parseInt(values[handle]);
                self.currentDuration = value;
                self.$durationDisplay.text(value + ' months');
            });

            // Calculate on slider slide (while dragging)
            this.durationSliderInstance.on('slide', function() {
                // Show results on first interaction
                if (!self.hasInteracted) {
                    self.hasInteracted = true;
                    self.showResults();
                }

                self.calculateLoan();
            });

            // Also calculate on change (when released)
            this.durationSliderInstance.on('change', function() {
                self.calculateLoan();
            });
        }

        setupTurnoverSlider() {
            const self = this;

            // Create noUiSlider
            this.turnoverSliderInstance = noUiSlider.create(this.$turnoverSlider, {
                start: [this.minTurnover],
                connect: [true, false],
                range: {
                    'min': this.minTurnover,
                    'max': this.maxTurnover
                },
                step: 1000,
                tooltips: false,
                animate: true,
                animationDuration: 300,
                behaviour: 'tap-drag',
                format: {
                    to: function(value) {
                        return Math.round(value / 1000) * 1000;
                    },
                    from: function(value) {
                        return Number(value);
                    }
                }
            });

            // Update on slider change
            this.turnoverSliderInstance.on('update', function(values, handle) {
                const value = parseInt(values[handle]);
                self.currentTurnover = value;
                self.$turnoverDisplay.text(self.currencySymbol + ' ' + self.formatNumber(value));
            });

            // Calculate on slider slide (while dragging)
            this.turnoverSliderInstance.on('slide', function() {
                // Show results on first interaction
                if (!self.hasInteracted) {
                    self.hasInteracted = true;
                    self.showResults();
                }

                self.calculateLoan();
            });

            // Also calculate on change (when released)
            this.turnoverSliderInstance.on('change', function() {
                self.calculateLoan();
            });
        }

        calculateLoan() {
            const turnover = this.currentTurnover;
            const borrowTerm = this.currentDuration;

            // Calculate using gross percentage method
            const grossPercentage = turnover * this.grossPercentageSum;
            let eligibleAmount = (grossPercentage * borrowTerm) / this.borrowFactor;
            let totalRepayment = grossPercentage * borrowTerm;

            // Apply loan cap
            if (eligibleAmount > this.loanCap) {
                eligibleAmount = this.loanCap;
                totalRepayment = this.loanCap * this.borrowFactor;
            }

            // Calculate repayments
            const totalCost = totalRepayment - eligibleAmount;
            const monthlyPayment = totalRepayment / borrowTerm;
            const dailyPayment = monthlyPayment / 20; // Assuming ~20 business days per month

            // Update display
            this.$loanAmount.text(this.formatCurrency(eligibleAmount));
            this.$dailyPayment.text(this.formatCurrency(dailyPayment));
            this.$monthlyPayment.text(this.formatCurrency(monthlyPayment));
            this.$totalCost.text(this.formatCurrency(totalCost));
            this.$totalRepayment.text(this.formatCurrency(totalRepayment));
        }

        formatNumber(num) {
            return Math.round(num).toLocaleString('en-GB');
        }

        formatCurrency(amount) {
            const rounded = Math.round(amount);
            const formatted = rounded.toLocaleString('en-GB');
            return this.currencySymbol + formatted;
        }
    }

    // Initialize calculator when DOM is ready
    $(document).ready(function() {
        $('.capify-loan-calculator-wrapper').each(function() {
            new CapifyLoanCalculator($(this));
        });
    });

})(jQuery);
