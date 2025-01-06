<?php

namespace App\Traits;

use App\Models\DiscountRule;
use App\Models\Discounts;

trait HasDiscount
{

    public function applyDiscount(Discounts $discount, float $totalAmount, int $itemCount) {
        $validate = $this->validateDiscount($discount);

        // Throw error if the discount is invalid
        if (!$validate['valid']) {
            throw new \Exception($validate['error']);
        }

        // Apply and validate discount rules
        $allRulesValid = true;

        foreach ($discount->rules as $rule) {
            $dependentValue = $rule->dependent == 'item' ? $itemCount : $totalAmount;
            $isRuleValid = $this->applyRule($rule, $dependentValue);

            // If the rule fails
            if (!$isRuleValid) {
                $allRulesValid = false;
                break;
            }
        }

        // Throw an error if at least one rule fails
        !$allRulesValid && throw new \Exception('The discount is not valid.');

        // Apply discount based on discount type
        $amountOff = 0;

        if ($discount->discount_types == 'percentage') {
            $amountOff = $totalAmount * ($discount->discount_value / 100);
        } else if ($discount->discount_types == 'fixed') {
            $amountOff = $discount->discount_value;
        } else {
            // Mixed: Set the amount off to the greater discount value
            $percentageAmount = $totalAmount * ($discount->discount_value / 100);
            $fixedAmount = $discount->discount_value;

            $amountOff = $percentageAmount > $fixedAmount ? $percentageAmount : $fixedAmount;
        }

        // Return discounted amount
        return $totalAmount - $amountOff;
    }


    private function validateDiscount(Discounts $discount) {
        $currentDate = now();

        if ($currentDate->isBefore($discount->start_date)) {
            return ['valid' => false, 'error' => 'The discount is not active yet.'];
        } elseif ($currentDate->isAfter($discount->end_date)) {
            return ['valid' => false, 'error' => 'The discount has expired.'];
        }

        return ['valid' => true];
    }


    private function applyRule(DiscountRule $rule, float|int $dependentValue) {
        $isRuleValid = match ($rule->condition) {
            'greater than' => $dependentValue > $rule->value,
            'greater than or equal' => $dependentValue >= $rule->value,
            'less than' => $dependentValue < $rule->value,
            'less than or equal' => $dependentValue <= $rule->value,

            // Equals
            default => $dependentValue == $rule->value,
        };

        return $isRuleValid;
    }
}
