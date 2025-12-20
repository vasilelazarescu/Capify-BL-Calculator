/**
 * Capify Business Loan Calculator JavaScript
 * Version: 2.4.0
 * Using custom lightweight slider for full style control and optimized mobile performance
 */

(function($) {
    'use strict';

    /**
     * Custom Slider Class
     * Lightweight, performant, fully styleable slider
     */
    class CustomSlider {
        constructor(container, options) {
            this.container = container;
            this.options = Object.assign({
                min: 0,
                max: 100,
                start: 0,
                step: 1,
                onChange: null,
                onSlide: null,
                onUpdate: null
            }, options);

            this.value = this.options.start;
            this.isDragging = false;
            this.init();
        }

        init() {
            // Create slider HTML structure
            this.container.innerHTML = `
                <div class="custom-slider-track">
                    <div class="custom-slider-progress"></div>
                    <div class="custom-slider-handle">
                        <div class="custom-slider-handle-dot"></div>
                    </div>
                </div>
            `;

            this.track = this.container.querySelector('.custom-slider-track');
            this.progress = this.container.querySelector('.custom-slider-progress');
            this.handle = this.container.querySelector('.custom-slider-handle');

            this.attachEvents();
            this.setValue(this.value);
        }

        attachEvents() {
            // Mouse events
            this.handle.addEventListener('mousedown', this.onStart.bind(this));
            this.track.addEventListener('mousedown', this.onTrackClick.bind(this));
            document.addEventListener('mousemove', this.onMove.bind(this));
            document.addEventListener('mouseup', this.onEnd.bind(this));

            // Touch events
            this.handle.addEventListener('touchstart', this.onStart.bind(this), { passive: false });
            this.track.addEventListener('touchstart', this.onTrackClick.bind(this), { passive: false });
            document.addEventListener('touchmove', this.onMove.bind(this), { passive: false });
            document.addEventListener('touchend', this.onEnd.bind(this));
        }

        onStart(e) {
            e.preventDefault();
            this.isDragging = true;
            this.handle.classList.add('dragging');
        }

        onTrackClick(e) {
            if (e.target === this.handle || this.handle.contains(e.target)) return;

            const rect = this.track.getBoundingClientRect();
            const x = (e.clientX || e.touches[0].clientX) - rect.left;
            const percentage = Math.max(0, Math.min(1, x / rect.width));
            const value = this.percentageToValue(percentage);

            this.setValue(value);
            this.triggerCallback('onChange');
            this.triggerCallback('onSlide');
        }

        onMove(e) {
            if (!this.isDragging) return;
            e.preventDefault();

            const rect = this.track.getBoundingClientRect();
            const x = (e.clientX || e.touches[0].clientX) - rect.left;
            const percentage = Math.max(0, Math.min(1, x / rect.width));
            const value = this.percentageToValue(percentage);

            this.setValue(value);
            this.triggerCallback('onSlide');
        }

        onEnd() {
            if (!this.isDragging) return;

            this.isDragging = false;
            this.handle.classList.remove('dragging');
            this.triggerCallback('onChange');
        }

        percentageToValue(percentage) {
            const range = this.options.max - this.options.min;
            let value = this.options.min + (range * percentage);

            // Apply step
            if (this.options.step) {
                value = Math.round(value / this.options.step) * this.options.step;
            }

            return Math.max(this.options.min, Math.min(this.options.max, value));
        }

        valueToPercentage(value) {
            const range = this.options.max - this.options.min;
            return ((value - this.options.min) / range) * 100;
        }

        setValue(value) {
            this.value = Math.max(this.options.min, Math.min(this.options.max, value));
            const percentage = this.valueToPercentage(this.value);

            // Use transform for GPU acceleration
            this.handle.style.left = percentage + '%';
            this.progress.style.width = percentage + '%';

            this.triggerCallback('onUpdate');
        }

        getValue() {
            return this.value;
        }

        triggerCallback(callbackName) {
            if (this.options[callbackName] && typeof this.options[callbackName] === 'function') {
                this.options[callbackName](this.value);
            }
        }

        destroy() {
            this.handle.removeEventListener('mousedown', this.onStart);
            this.track.removeEventListener('mousedown', this.onTrackClick);
            this.handle.removeEventListener('touchstart', this.onStart);
            this.track.removeEventListener('touchstart', this.onTrackClick);
        }
    }

    /**
     * Capify Loan Calculator Class
     */
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
            this.currentDuration = this.minDuration;

            // Turnover slider config
            this.minTurnover = parseInt($wrapper.attr('data-min-turnover')) || 10000;
            this.maxTurnover = parseInt($wrapper.attr('data-max-turnover')) || 500000;
            this.currentTurnover = this.minTurnover;

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
            this.setupDurationSlider();
            this.setupTurnoverSlider();
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

            this.durationSliderInstance = new CustomSlider(this.$durationSlider, {
                min: this.minDuration,
                max: this.maxDuration,
                start: this.minDuration,
                step: 1,
                onUpdate: function(value) {
                    self.currentDuration = Math.round(value);
                    self.$durationDisplay.text(self.currentDuration + ' months');
                },
                onSlide: function() {
                    if (!self.hasInteracted) {
                        self.hasInteracted = true;
                        self.showResults();
                    }
                    self.calculateLoan();
                },
                onChange: function() {
                    self.calculateLoan();
                }
            });
        }

        setupTurnoverSlider() {
            const self = this;

            this.turnoverSliderInstance = new CustomSlider(this.$turnoverSlider, {
                min: this.minTurnover,
                max: this.maxTurnover,
                start: this.minTurnover,
                step: 1000,
                onUpdate: function(value) {
                    self.currentTurnover = Math.round(value / 1000) * 1000;
                    self.$turnoverDisplay.text(self.currencySymbol + ' ' + self.formatNumber(self.currentTurnover));
                },
                onSlide: function() {
                    if (!self.hasInteracted) {
                        self.hasInteracted = true;
                        self.showResults();
                    }
                    self.calculateLoan();
                },
                onChange: function() {
                    self.calculateLoan();
                }
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

    // Initialize calculator function
    function initCalculators() {
        $('.capify-loan-calculator-wrapper').each(function() {
            // Check if already initialized
            if (!$(this).data('calculator-initialized')) {
                new CapifyLoanCalculator($(this));
                $(this).data('calculator-initialized', true);
            }
        });
    }

    // Initialize on DOM ready
    $(document).ready(function() {
        initCalculators();
    });

    // Initialize in Elementor editor
    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/capify_loan_calculator.default', function($scope) {
            initCalculators();
        });
    });

})(jQuery);
