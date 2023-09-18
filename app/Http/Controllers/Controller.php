<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Custom request validation method.
     *
     * @param \Illuminate\Http\Request $request The HTTP request to validate.
     * @param array $rules The validation rules to apply.
     *
     * @return array
     */
    protected function myValidate(Request $request, array $rule)
    {
        $validation = ['success' => true];

        try {
            $request->validate($rule);
        } catch (ValidationException $e) {
            $validation = [
                'success' => false,
                'error' => [
                    'message' => $e->getMessage(),
                    'status' => $e->status
                ]
            ];
        }

        return $validation;
    }
}
