<?php

namespace App\Domain\Sale\Strategies;

class AffiliateSaleCommissionsStrategy extends AbstractCommissionCalculationStrategy
{
    protected function calculateSpecificCommissions(float $valorTotal): array
    {
        $producerCommission = round($valorTotal * 0.60, 2); // 60% para produtor
        $affiliateCommission = round($valorTotal * 0.30, 2); // 30% para afiliado

        return [$producerCommission, $affiliateCommission];
    }
}
