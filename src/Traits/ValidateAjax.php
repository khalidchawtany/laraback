<?php

namespace Kjdion84\Laraback\Traits;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

trait ValidateAjax
{
    public function validateAjax(Request $request, $rules, $allow_demo = false)
    {
        if (config('laraback.demo') && !$allow_demo) {
            // stop request if in demo mode
            throw new HttpResponseException(response()->json(['message' => 'Feature disabled in demo.'], 422));
        }
        else {
            // validate request, throwing errors if invalid
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }
        }
    }
}