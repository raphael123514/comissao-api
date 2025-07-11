<?php

namespace App\Domain\Sale\Strategies;

use App\Domain\Sale\Contracts\CommissionCalculationStrategy;
use App\Domain\Sale\Entities\Commissions;
use App\Domain\Sale\Entities\Sale;

abstract class AbstractCommissionCalculationStrategy implements CommissionCalculationStrategy
{
    public function calculate(Sale $sale): Sale
    {
        $valorTotal = $sale->getValorTotal();

        $platformCommission = round($valorTotal * 0.10, 2); // 10% para plataforma 

        list($producerCommission, $affiliateCommission) = $this->calculateSpecificCommissions($valorTotal);

        $commissions = new Commissions($platformCommission, $producerCommission, $affiliateCommission);
        $sale->setCommissions($commissions);

        return $sale;
    }

    /**
     * Método abstrato que as subclasses devem implementar para fornecer
     * a lógica específica de cálculo de produtor e afiliado.
     * @param float $valorTotal O valor total da venda.
     * @return array Um array contendo [producerCommission, affiliateCommission].
     */
    abstract protected function calculateSpecificCommissions(float $valorTotal): array;

}
