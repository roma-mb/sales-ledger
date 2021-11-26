<?php

namespace App\Http\Requests;

use Illuminate\Support\Arr;

class SellerFormRequest extends FormRequestAbstract
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
            'name' => 'required|string|max:200',
            'email' => 'required|email',
        ];
    }

    private static function update(): array
    {
        return [
            'name' => 'sometimes|string|max:200',
            'email' => 'sometimes|email',
        ];
    }
}
