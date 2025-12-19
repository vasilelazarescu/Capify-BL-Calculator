# Loan Calculator - Calculation Logic Analysis

## Current Implementation

The calculator uses the **Standard Loan Amortization Formula**:

### Formula:
```
M = P × [r(1+r)^n] / [(1+r)^n - 1]
```

Where:
- **M** = Monthly Payment
- **P** = Principal (Loan Amount)
- **r** = Monthly Interest Rate (Annual Rate ÷ 12 ÷ 100)
- **n** = Number of Months

### Step-by-Step Calculation:

#### Step 1: Convert Annual Rate to Monthly Rate
```javascript
annualRate = interestRate / 100          // Convert percentage to decimal
monthlyRate = annualRate / 12            // Convert annual to monthly
```

#### Step 2: Calculate Monthly Payment
```javascript
if (monthlyRate === 0) {
    // Interest-free loan
    monthlyPayment = principal / months
} else {
    // Standard loan formula
    x = (1 + monthlyRate)^months
    monthlyPayment = principal × (monthlyRate × x) / (x - 1)
}
```

#### Step 3: Calculate Totals
```javascript
totalPayment = monthlyPayment × months
totalInterest = totalPayment - principal
monthlyInterest = totalInterest / months  // Average monthly interest
```

## Example Calculation

### Given:
- Loan Amount: **£100,000**
- Annual Interest Rate: **1.26%**
- Loan Duration: **24 months**

### Calculation Process:

**Step 1: Monthly Rate**
```
Annual Rate = 1.26 / 100 = 0.0126
Monthly Rate = 0.0126 / 12 = 0.00105
```

**Step 2: Monthly Payment**
```
x = (1 + 0.00105)^24 = 1.02544
monthlyPayment = 100,000 × (0.00105 × 1.02544) / (1.02544 - 1)
monthlyPayment = 100,000 × 0.001077 / 0.02544
monthlyPayment = £4,233.12
```

**Step 3: Totals**
```
Total Payment = 4,233.12 × 24 = £101,594.88
Total Interest = 101,594.88 - 100,000 = £1,594.88
Monthly Interest = 1,594.88 / 24 = £66.45
```

## Displayed Values:

1. **Monthly payments**: £4,233.12
2. **Monthly interest**: £66.45 (average)
3. **Total interest**: £1,594.88
4. **Length of loan**: 24 months
5. **Total cost of loan**: £101,594.88

## Alternative Calculation Methods

### Method 1: Simple Interest (Not Currently Used)
```
Total Interest = Principal × Rate × Time
Total Payment = Principal + Total Interest
Monthly Payment = Total Payment / Months
```

### Method 2: Compound Interest - Single Payment (Not Currently Used)
```
A = P(1 + r)^n
```

### Method 3: Amortized Loan (CURRENTLY IMPLEMENTED) ✓
```
M = P × [r(1+r)^n] / [(1+r)^n - 1]
```
This is the standard formula used by banks and financial institutions.

## Why This Formula?

The amortized loan formula is used because:
1. ✓ **Industry Standard** - Used by all banks and lenders
2. ✓ **Equal Payments** - Each monthly payment is the same
3. ✓ **Accurate** - Accounts for compound interest properly
4. ✓ **Transparent** - Shows true cost of borrowing
5. ✓ **Fair** - Interest calculated on reducing balance

## Verification

To verify the calculation is correct:
- Sum of all monthly payments = Total Cost
- Total Cost - Principal = Total Interest
- Early payments have more interest, later payments have more principal
- This creates a standard amortization schedule

## Notes

- **Monthly Interest shown** is the AVERAGE monthly interest over the loan term
- **Actual monthly interest** varies each month (high at start, low at end)
- If you need an exact amortization schedule showing each month's interest vs principal breakdown, that would require additional code
