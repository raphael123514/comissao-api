<?php

namespace App\Domain\Sale\Contracts;

use App\Domain\Sale\Entities\Sale;

/**
 * Interface CommissionCalculationStrategy
 * Define o contrato para estratégias de cálculo de comissões de venda.
 */
interface CommissionCalculationStrategy
{
    /**
     * Calcula as comissões para a venda fornecida e as define na entidade Sale.
     *
     * @param  Sale  $sale  A entidade Sale que contém o valor total e tipo de venda,
     *                      e onde as comissões calculadas serão definidas.
     * @return Sale A entidade Sale com as comissões já calculadas e preenchidas.
     */
    public function calculate(Sale $sale): Sale;
}
