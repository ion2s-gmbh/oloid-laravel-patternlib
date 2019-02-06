<?php

namespace Oloid\Exceptions;


use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MissingValuesException extends Exception
{
    public function render(Request $request)
    {
        $message = $this->getPrevious()->message;
        if ($request->wantsJson()) {
            return JsonResponse::create([
                'message' => $message
            ], 422);
        } else {
            return view('workshop::missingValuesException', compact('message'));
        }
    }
}
