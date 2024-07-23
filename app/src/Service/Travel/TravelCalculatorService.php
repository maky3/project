<?php

namespace App\Service\Travel;

class TravelCalculatorService
{
    public function calculateTotalPrice(float $basePrice, int $childAge, \DateTime $travelStartDate, \DateTime $paymentDate): float
    {
        $childDiscount = $this->calculateChildDiscount($basePrice, $childAge);
        $earlyBookingDiscount = $this->calculateEarlyBookingDiscount($basePrice - $childDiscount, $travelStartDate, $paymentDate);

        return $basePrice - $childDiscount - $earlyBookingDiscount;
    }

    private function calculateChildDiscount(float $basePrice, int $childAge): float
    {
        if ($childAge >= 3 && $childAge < 6) {
            return $basePrice * 0.8;
        } elseif ($childAge >= 6 && $childAge < 12) {
            return min($basePrice * 0.3, 4500);
        } elseif ($childAge >= 12) {
            return $basePrice * 0.1;
        }

        return 0;
    }

    private function calculateEarlyBookingDiscount(float $priceAfterChildDiscount, \DateTime $travelStartDate, \DateTime $paymentDate): float
    {
        $travelMonth = (int)$travelStartDate->format('n');
        $paymentMonth = (int)$paymentDate->format('n');
        $paymentYear = (int)$paymentDate->format('Y');

        if ($travelMonth >= 4 && $travelMonth <= 9) {
            if ($paymentMonth == 11) {
                return min($priceAfterChildDiscount * 0.07, 1500);
            } elseif ($paymentMonth == 12) {
                return min($priceAfterChildDiscount * 0.05, 1500);
            } elseif ($paymentMonth == 1) {
                return min($priceAfterChildDiscount * 0.03, 1500);
            }
        } elseif ($travelMonth >= 10 || ($travelMonth >= 1 && $travelMonth <= 1)) {
            if ($paymentMonth == 3) {
                return min($priceAfterChildDiscount * 0.07, 1500);
            } elseif ($paymentMonth == 4) {
                return min($priceAfterChildDiscount * 0.05, 1500);
            } elseif ($paymentMonth == 5) {
                return min($priceAfterChildDiscount * 0.03, 1500);
            }
        } elseif ($travelMonth >= 1 && $travelMonth <= 12) {
            if ($paymentMonth == 8) {
                return min($priceAfterChildDiscount * 0.07, 1500);
            } elseif ($paymentMonth == 9) {
                return min($priceAfterChildDiscount * 0.05, 1500);
            } elseif ($paymentMonth == 10) {
                return min($priceAfterChildDiscount * 0.03, 1500);
            }
        }

        return 0;
    }
}