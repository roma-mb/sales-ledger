<?php

namespace App\Http\Controllers;

use App\Enumerations\Messages;
use App\Http\Requests\SellerFormRequest;
use App\Models\Seller;
use App\Services\SellerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Lang;

class SellerController extends Controller
{
    private SellerService $sellerService;

    public function __construct(SellerService $sellerService)
    {
        $this->sellerService = $sellerService;
    }

    public function index(): JsonResponse
    {
        return response()
            ->json($this->sellerService->getAll(), Response::HTTP_OK);
    }

    /**
     * @throws \Throwable
     */
    public function store(SellerFormRequest $sellerFormRequest): JsonResponse
    {
        return response()
            ->json($this->sellerService->store($sellerFormRequest->validated()), Response::HTTP_CREATED);
    }

    public function show(Seller $seller): JsonResponse
    {
        return response()
            ->json($this->sellerService->find($seller), Response::HTTP_OK);
    }

    public function edit(Seller $seller): Seller
    {
        return $seller;
    }

    public function update(SellerFormRequest $sellerFormRequest, Seller $seller): JsonResponse
    {
        $message = $this->sellerService->update($sellerFormRequest->validated(), $seller)
            ? Messages::SELLER_UPDATED
            : Messages::SELLER_NOT_UPDATED;

        return response()
            ->json([
                'message' => Lang::get('messages.' . $message),
            ], Response::HTTP_OK);
    }

    public function destroy(Seller $seller): JsonResponse
    {
        $message = $this->sellerService->delete($seller)
            ? Messages::SELLER_DELETED
            : Messages::SELLER_NOT_DELETED;

        return response()
            ->json([
                'message' => Lang::get('messages.' . $message),
            ], Response::HTTP_OK);
    }
}
