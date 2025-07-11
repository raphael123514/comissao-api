<?php

namespace App\Domain\Sale\Entities;

use InvalidArgumentException;

class Sale
{
    private Commissions $commissions;

    public function __construct(private float $valorTotal, private string $tipoVenda, private ?int $id = null)
    {
        if ($valorTotal <= 0) {
            throw new InvalidArgumentException('O valor total deve ser positivo.');
        }
        if (! in_array($tipoVenda, ['direta', 'afiliada'])) {
            throw new InvalidArgumentException("Tipo de venda inválido: {$tipoVenda}. Os tipos permitidos são 'direta' ou 'afiliada'.");
        }

        $this->id = $id;
        $this->valorTotal = $valorTotal;
        $this->tipoVenda = $tipoVenda;

        $this->commissions = new Commissions(0.0, 0.0, 0.0);

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValorTotal(): float
    {
        return $this->valorTotal;
    }

    public function getTipoVenda(): string
    {
        return $this->tipoVenda;
    }

    public function getCommissions(): Commissions
    {
        return $this->commissions;
    }

    public function setId(int $id): void
    {
        if ($this->id !== null) {
            throw new \BadMethodCallException('ID cannot be changed once set.');
        }
        $this->id = $id;
    }

    public function setCommissions(Commissions $commissions): void
    {
        $this->commissions = $commissions;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'valor_total' => $this->valorTotal,
            'tipo_venda' => $this->tipoVenda,
            'comissoes' => $this->commissions->toArray(),
        ];
    }

    public static function fromArray(array $data): self
    {
        $sale = new self(
            $data['valor_total'],
            $data['tipo_venda'],
            $data['id'] ?? null
        );

        if (isset($data['comissoes'])) {
            $sale->setCommissions(new Commissions(
                $data['comissoes']['plataforma'] ?? 0.0,
                $data['comissoes']['produtor'] ?? 0.0,
                $data['comissoes']['afiliado'] ?? 0.0
            ));
        }

        return $sale;
    }
}
