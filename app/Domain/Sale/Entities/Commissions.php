<?php

namespace App\Domain\Sale\Entities;
use InvalidArgumentException;

final class Commissions
{
    

    public function __construct(private float $plataforma, private float $produtor, private float $afiliado)
    {
        if ($plataforma < 0 || $produtor < 0 || $afiliado < 0) {
            throw new InvalidArgumentException("Os valores das comissões não podem ser negativos.");
        }

        $this->plataforma = $plataforma;
        $this->produtor = $produtor;
        $this->afiliado = $afiliado;
    }

    public function getPlataforma(): float
    {
        return $this->plataforma;
    }

    public function getProdutor(): float
    {
        return $this->produtor;
    }

    public function getAfiliado(): float
    {
        return $this->afiliado;
    }

    public function equals(self $other): bool
    {
        return $this->plataforma === $other->plataforma &&
               $this->produtor === $other->produtor &&
               $this->afiliado === $other->afiliado;
    }

    public function toArray(): array
    {
        return [
            'plataforma' => $this->plataforma,
            'produtor' => $this->produtor,
            'afiliado' => $this->afiliado,
        ];
    }

}
