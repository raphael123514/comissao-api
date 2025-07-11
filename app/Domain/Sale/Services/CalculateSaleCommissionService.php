<?php

namespace App\Domain\Sale\Services;

use App\Domain\Sale\Entities\Sale;
use App\Infrastructure\Sale\Factorys\CommissionStrategyFactory;

class CalculateSaleCommissionService
{
    public function __construct(private CommissionStrategyFactory $strategyFactory) {}

    public function calculateCommission(Sale $sale): Sale
    {
        $strategy = $this->strategyFactory->getStrategy($sale->getTipoVenda());

        return $strategy->calculate($sale);
    }
}
