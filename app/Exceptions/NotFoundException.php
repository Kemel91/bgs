<?php

namespace App\Exceptions;

use Exception;

/**
 * Class NotFoundException
 * @package App\Exceptions
 */
class NotFoundException extends Exception
{
    /**
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request) {
        return response()->json([
            'data' => [
                'error' => 'Выбранный объект не найден'
            ]
        ], 404);
    }
}
