<?php

namespace App\Http\Controllers;

use App\Enumerations\Messages;
use App\Http\Requests\SaleFormRequest;
use App\Models\Sale;
use App\Services\SaleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Lang;

class SaleController extends Controller
{
    private SaleService $saleService;

    public function __construct(SaleService $saleService)
    {
        $this->saleService = $saleService;
    }

    public function index(): JsonResponse
    {
        return response()
            ->json($this->saleService->getAll(), Response::HTTP_OK);
    }

    /**
     * @throws \Throwable
     */
    public function store(SaleFormRequest $saleFormRequest): JsonResponse
    {
        return response()
            ->json($this->saleService->store($saleFormRequest->validated()), Response::HTTP_CREATED);
    }

    public function show(Sale $sale): JsonResponse
    {
        return response()
            ->json($this->saleService->find($sale), Response::HTTP_OK);
    }

    public function edit(Sale $sale): Sale
    {
        return $sale;
    }

    public function update(SaleFormRequest $saleFormRequest, Sale $sale): JsonResponse
    {
        $message = $this->saleService->update($saleFormRequest->validated(), $sale)
            ? Messages::SALE_UPDATED
            : Messages::SALE_NOT_UPDATED;

        return response()
            ->json([
                'message' => Lang::get('messages.' . $message),
            ], Response::HTTP_OK);
    }

    public function destroy(Sale $sale): JsonResponse
    {
        $message = $this->saleService->delete($sale)
            ? Messages::SALE_DELETED
            : Messages::SALE_NOT_DELETED;

        return response()
            ->json([
                'message' => Lang::get('messages.' . $message),
            ], Response::HTTP_OK);
    }
}
