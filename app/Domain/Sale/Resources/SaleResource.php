<?php

namespace App\Domain\Sale\Resources;

use App\Domain\Sale\Entities\Sale;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if (! $this->resource instanceof Sale) {
            return parent::toArray($request);
        }

        $commssions = $this->resource->getCommissions();

        return [
            'id' => $this->resource->getId(),
            'valor_total' => $this->resource->getValorTotal(),
            'tipo_venda' => $this->resource->getTipoVenda(),
            'comissoes' => [
                'plataforma' => $commssions->getPlataforma(),
                'produtor' => $commssions->getProdutor(),
                'afiliado' => $commssions->getAfiliado(),
            ],
        ];
    }
}
