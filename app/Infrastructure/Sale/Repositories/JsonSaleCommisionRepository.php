<?php

namespace App\Infrastructure\Sale\Repositories;

use App\Domain\Sale\Contracts\SaleComissionRepositoryInterface;
use App\Domain\Sale\Entities\Sale;
use Illuminate\Support\Facades\Storage;

class JsonSaleCommisionRepository implements SaleComissionRepositoryInterface
{
    protected string $diskName = 'local';
    protected string $fileName = 'sales.json';

    public function __construct()
    {
        if (!Storage::disk($this->diskName)->exists($this->fileName)) {
            Storage::disk($this->diskName)->put($this->fileName, json_encode([]));
        }
    }

    protected function readFromFile(): array
    {
        $contents = Storage::disk($this->diskName)->get($this->fileName);
        return json_decode($contents, true) ?? [];
    }

    protected function writeToFile(array $data): void
    {
        Storage::disk($this->diskName)->put($this->fileName, json_encode($data, JSON_PRETTY_PRINT));
    }

    public function save(Sale $sale): Sale
    {
        $salesData = $this->readFromFile();

        if ($sale->getId() === null) {
            $nextId = empty($salesData) ? 1 : max(array_column($salesData, 'id') ?: [0]) + 1;
            $sale->setId($nextId);
            $salesData[] = $sale->toArray();
        }

        $this->writeToFile($salesData);
        return $sale;
    }

    public function findAll(): array
    {
        $salesData = $this->readFromFile();
        
        return array_map(fn($data) => Sale::fromArray($data), $salesData);
    }

    public function delete(int $id): bool
    {
        $salesData = $this->readFromFile();
        $initialCount = count($salesData);
        $salesData = array_filter($salesData, fn($data) => $data['id'] !== $id);

        if (count($salesData) < $initialCount) {
            $this->writeToFile(array_values($salesData));
            return true;
        }
        return false;
    }
}
