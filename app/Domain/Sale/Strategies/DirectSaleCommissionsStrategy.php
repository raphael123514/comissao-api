<?php

namespace App\Domain\Sale\Strategies;

class DirectSaleCommissionsStrategy extends AbstractCommissionCalculationStrategy
{
    protected function calculateSpecificCommissions(float $valorTotal): array
    {
        $producerCommission = round($valorTotal * 0.90, 2); // 90% para produtor
        $affiliateCommission = 0.0; // Afiliado não participa na venda direta

        return [$producerCommission, $affiliateCommission];
    }
}
