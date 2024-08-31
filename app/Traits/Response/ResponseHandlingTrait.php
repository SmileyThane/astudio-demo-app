<?php

namespace App\Traits\Response;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\MessageBag;

trait ResponseHandlingTrait
{
    final public function returnValidationErrors(MessageBag $errors): void
    {
        throw new HttpResponseException(
            response()->json(['errors' => $errors],
                422
            )
        );
    }

}
