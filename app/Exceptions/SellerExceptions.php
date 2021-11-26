<?php

namespace App\Exceptions;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Lang;

class SellerExceptions extends BuildException
{
    public const SELLER_HAS_NOT_BEEN_SAVED = 'sellerHasNotBeenSaved';

    public static function sellerHasNotBeenSaved(): BuildException
    {
        return new BuildException([
            'shortMessage' => self::SELLER_HAS_NOT_BEEN_SAVED,
            'message'      => Lang::get('exceptions.' . self::SELLER_HAS_NOT_BEEN_SAVED),
            'httpCode'     => Response::HTTP_UNPROCESSABLE_ENTITY,
        ]);
    }
}
