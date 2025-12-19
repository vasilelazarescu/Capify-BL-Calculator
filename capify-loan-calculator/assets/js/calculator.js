/**
 * Capify Business Loan Calculator JavaScript
 * Version: 2.0.4
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
            this.currentDuration = 6; // Default

            // Turnover slider config
            this.minTurnover = parseInt($wrapper.attr('data-min-turnover')) || 10000;
            this.maxTurnover = parseInt($wrapper.attr('data-max-turnover')) || 500000;
            this.currentTurnover = 110000; // Default

            // DOM elements
            this.$durationDisplay = $wrapper.find('#duration-display');
            this.$durationProgress = $wrapper.find('#duration-progress');
            this.$durationThumb = $wrapper.find('#duration-thumb');
            this.$durationContainer = $wrapper.find('#duration-slider-container');

            this.$turnoverDisplay = $wrapper.find('#turnover-display');
            this.$turnoverProgress = $wrapper.find('#turnover-progress');
            this.$turnoverThumb = $wrapper.find('#turnover-thumb');
            this.$turnoverContainer = $wrapper.find('#turnover-slider-container');

            this.$calculateBtn = $wrapper.find('#calculate-btn');

            this.$loanAmount = $wrapper.find('#loan-amount');
            this.$dailyPayment = $wrapper.find('#daily-payment');
            this.$monthlyPayment = $wrapper.find('#monthly-payment');
            this.$totalCost = $wrapper.find('#total-cost');
            this.$totalRepayment = $wrapper.find('#total-repayment');

            this.init();
        }

        init() {
            this.setupDurationSlider();
            this.setupTurnoverSlider();
            this.setupCalculateButton();

            // Calculate initial values
            this.calculateLoan();
        }

        setupDurationSlider() {
            const self = this;
            let isDragging = false;

            // Update slider position
            this.updateDurationSlider(this.currentDuration);

            // Mouse down on container
            this.$durationContainer.on('mousedown', function(e) {
                isDragging = true;
                self.handleDurationDrag(e);
                e.preventDefault();
            });

            // Mouse move on document
            $(document).on('mousemove.duration', function(e) {
                if (isDragging) {
                    self.handleDurationDrag(e);
                }
            });

            // Mouse up on document
            $(document).on('mouseup.duration', function() {
                if (isDragging) {
                    isDragging = false;
                }
            });

            // Touch support
            this.$durationContainer.on('touchstart', function(e) {
                isDragging = true;
                const touch = e.originalEvent.touches[0];
                self.handleDurationDrag(touch);
                e.preventDefault();
            });

            $(document).on('touchmove.duration', function(e) {
                if (isDragging) {
                    const touch = e.originalEvent.touches[0];
                    self.handleDurationDrag(touch);
                }
            });

            $(document).on('touchend.duration', function() {
                if (isDragging) {
                    isDragging = false;
                }
            });
        }

        handleDurationDrag(e) {
            const container = this.$durationContainer[0];
            const rect = container.getBoundingClientRect();
            const offsetX = e.clientX - rect.left;
            const percentage = Math.max(0, Math.min(1, offsetX / rect.width));

            // Calculate duration value
            const range = this.maxDuration - this.minDuration;
            const value = Math.round(this.minDuration + (percentage * range));

            this.currentDuration = value;
            this.updateDurationSlider(value);
            this.calculateLoan();
        }

        updateDurationSlider(value) {
            const range = this.maxDuration - this.minDuration;
            const percentage = ((value - this.minDuration) / range) * 100;

            this.$durationProgress.css('width', percentage + '%');
            this.$durationThumb.css('left', 'calc(' + percentage + '% - 14px)');
            this.$durationDisplay.text(value + ' months');
        }

        setupTurnoverSlider() {
            const self = this;
            let isDragging = false;

            // Update slider position
            this.updateTurnoverSlider(this.currentTurnover);

            // Mouse down on container
            this.$turnoverContainer.on('mousedown', function(e) {
                isDragging = true;
                self.handleTurnoverDrag(e);
                e.preventDefault();
            });

            // Mouse move on document
            $(document).on('mousemove.turnover', function(e) {
                if (isDragging) {
                    self.handleTurnoverDrag(e);
                }
            });

            // Mouse up on document
            $(document).on('mouseup.turnover', function() {
                if (isDragging) {
                    isDragging = false;
                }
            });

            // Touch support
            this.$turnoverContainer.on('touchstart', function(e) {
                isDragging = true;
                const touch = e.originalEvent.touches[0];
                self.handleTurnoverDrag(touch);
                e.preventDefault();
            });

            $(document).on('touchmove.turnover', function(e) {
                if (isDragging) {
                    const touch = e.originalEvent.touches[0];
                    self.handleTurnoverDrag(touch);
                }
            });

            $(document).on('touchend.turnover', function() {
                if (isDragging) {
                    isDragging = false;
                }
            });
        }

        handleTurnoverDrag(e) {
            const container = this.$turnoverContainer[0];
            const rect = container.getBoundingClientRect();
            const offsetX = e.clientX - rect.left;
            const percentage = Math.max(0, Math.min(1, offsetX / rect.width));

            // Calculate turnover value (in steps of 1000)
            const range = this.maxTurnover - this.minTurnover;
            const rawValue = this.minTurnover + (percentage * range);
            const value = Math.round(rawValue / 1000) * 1000;

            this.currentTurnover = value;
            this.updateTurnoverSlider(value);
            this.calculateLoan();
        }

        updateTurnoverSlider(value) {
            const range = this.maxTurnover - this.minTurnover;
            const percentage = ((value - this.minTurnover) / range) * 100;

            this.$turnoverProgress.css('width', percentage + '%');
            this.$turnoverThumb.css('left', 'calc(' + percentage + '% - 14px)');
            this.$turnoverDisplay.text(this.currencySymbol + ' ' + this.formatNumber(value));
        }

        setupCalculateButton() {
            const self = this;
            this.$calculateBtn.on('click', function() {
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
