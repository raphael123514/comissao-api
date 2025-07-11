<?php

namespace App\Domain\Sale\Services;

use App\Domain\Sale\Contracts\CommissionCalculationStrategy;
use App\Domain\Sale\Contracts\SaleComissionRepositoryInterface;
use App\Domain\Sale\Entities\Sale;

class ProcessSaleComissionService
{   
    public function __construct(private SaleComissionRepositoryInterface $saleRepository, private CalculateSaleCommissionService $commissionService) {
    }

    public function getAllSales() {
        return $this->saleRepository->findAll();
    }

    public function createSale(string $tipoVenda, float $valorTotal) 
    {
        $sale = new Sale($valorTotal, $tipoVenda);
        $sale = $this->commissionService->calculateCommission($sale);

        return $this->saleRepository->save($sale);
    }

    public function deleteSale(string $id) {
        return $this->saleRepository->delete($id);
    }
}
