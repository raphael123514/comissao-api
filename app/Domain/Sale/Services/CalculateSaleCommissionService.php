<?php

namespace App\Domain\Sale\Services;

use App\Domain\Sale\Contracts\CommissionCalculationStrategy;
use App\Domain\Sale\Entities\Sale;
use App\Domain\Sale\Strategies\AffiliateSaleCommissionsStrategy;
use App\Domain\Sale\Strategies\DirectSaleCommissionsStrategy;
use App\Infrastructure\Sale\Factorys\CommissionStrategyFactory;
use InvalidArgumentException;

class CalculateSaleCommissionService
{
    public function __construct(private CommissionStrategyFactory $strategyFactory)
    {
    }

    public function calculateCommission(Sale $sale): Sale
    {
        $strategy = $this->strategyFactory->getStrategy($sale->getTipoVenda());

        return $strategy->calculate($sale);
    }

}
