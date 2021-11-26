<?php

use App\Enumerations\Exceptions;
use App\Exceptions\SaleExceptions;
use App\Exceptions\SellerExceptions;

return [
    Exceptions::NOT_FOUND                       => 'Not Found.',
    SaleExceptions::SALE_HAS_NOT_BEEN_SAVED     => 'An error occurs, sale has not been saved.',
    SellerExceptions::SELLER_HAS_NOT_BEEN_SAVED => 'An error occurs, seller has not been saved.',
];
