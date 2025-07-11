<?php

namespace App\Domain\Sale\Contracts;

use App\Domain\Sale\Entities\Sale;

interface SaleComissionRepositoryInterface
{
    public function save(Sale $simulacao): Sale;

    public function findAll(): array;

    public function delete(int $id): bool;
}
