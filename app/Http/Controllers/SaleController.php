<?php

namespace App\Http\Controllers;

use App\Domain\Sale\Requests\SaleCreateRequest;
use App\Domain\Sale\Resources\SaleResource;
use App\Domain\Sale\Services\ProcessSaleComissionService;
use InvalidArgumentException;

class SaleController extends Controller
{

    public function __construct(private ProcessSaleComissionService $processSaleComissionService) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sales = $this->processSaleComissionService->getAllSales();
        return SaleResource::collection($sales);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaleCreateRequest $request)
    {
        try {
            $validatedData = $request->validated();
    
            $sale = $this->processSaleComissionService->createSale(
                $validatedData['tipo_venda'],
                $validatedData['valor_total']
            );
            return new SaleResource($sale);
        } catch (InvalidArgumentException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocorreu um erro interno.'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if ($this->processSaleComissionService->deleteSale($id)) {
            return response()->noContent();
        }
        return response()->json(['message' => 'Comissão de venda não encontrada.'], 404);
    }
}
