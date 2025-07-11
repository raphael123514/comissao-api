<?php

namespace App\Infrastructure\Sale\Factorys;

use App\Domain\Sale\Contracts\CommissionCalculationStrategy;
use App\Domain\Sale\Strategies\AffiliateSaleCommissionsStrategy;
use App\Domain\Sale\Strategies\DirectSaleCommissionsStrategy;
use Illuminate\Contracts\Container\Container;
use InvalidArgumentException;

class CommissionStrategyFactory
{

    public function __construct(private Container $container)
    {
    }

    // Mapeamento dos tipos de venda para as classes das estratégias
    private array $strategyMap = [
        'direta' => DirectSaleCommissionsStrategy::class,
        'afiliada' => AffiliateSaleCommissionsStrategy::class,
    ];

    /**
     * Retorna a estratégia de cálculo de comissão apropriada para o tipo de venda.
     * @param string $saleType
     * @return CommissionCalculationStrategy
     * @throws InvalidArgumentException
     */
    public function getStrategy(string $saleType): CommissionCalculationStrategy
    {
        if (!isset($this->strategyMap[$saleType])) {
            throw new InvalidArgumentException("Tipo de venda desconhecido para cálculo de comissão: {$saleType}.");
        }

        return $this->container->make($this->strategyMap[$saleType]);
    }
}
