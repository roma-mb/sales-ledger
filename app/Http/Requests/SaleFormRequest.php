<?php

namespace App\Http\Requests;

use Illuminate\Support\Arr;

class SaleFormRequest extends FormRequestAbstract
{
    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $method = $this->route()->getActionMethod();

        return Arr::get([
            'store' => self::store(),
            'update' => self::update(),
        ], $method, []);
    }

    private static function store(): array
    {
        return [
            'seller_id' => 'required|integer',
            'description' => 'required|string|max:255',
            'value' => 'required|numeric',
        ];
    }

    private static function update(): array
    {
        return [
            'seller_id' => 'sometimes|integer',
            'description' => 'sometimes|string|max:255',
            'value' => 'sometimes|numeric',
        ];
    }
}
