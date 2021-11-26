<?php

namespace App\Exceptions;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Lang;

class SaleExceptions extends BuildException
{
    public const SALE_HAS_NOT_BEEN_SAVED = 'saleHasNotBeenSaved';

    public static function saleHasNotBeenSaved(): BuildException
    {
        return new BuildException([
            'shortMessage' => self::SALE_HAS_NOT_BEEN_SAVED,
            'message'      => Lang::get('exceptions.' . self::SALE_HAS_NOT_BEEN_SAVED),
            'httpCode'     => Response::HTTP_UNPROCESSABLE_ENTITY,
        ]);
    }
}
