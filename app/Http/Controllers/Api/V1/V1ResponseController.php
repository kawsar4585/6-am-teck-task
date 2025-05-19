<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiResponseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\MessageBag;

class V1ResponseController extends ApiResponseController
{

    protected function successResponse(array|object $data=[], $description='Success'): JsonResponse
    {
        $response = [
            'message' => 'OK',
            'description' => $description,
            'data' => $data
        ];
        return response()->json($response, 200);
    }

    protected function validationError(MessageBag|array $errorBag): JsonResponse
    {

        if (is_array($errorBag)) {
            $errorMessages = $this->convertMultiDimensionalArrayToString($errorBag);
        } else {
            $errorMessages = implode("\n", $errorBag->all());
        }
        $response = [
            'message' => 'VALIDATION_ERROR',
            'description' => $errorMessages,
            'errors' => [
                'detail' => $errorBag
            ]
        ];
        return response()->json($response, 400);
    }

    protected function convertMultiDimensionalArrayToString($array): string
    {
        if (count($array) == count($array, COUNT_RECURSIVE)) {
            return implode("\n", $array);
        } else {
            return implode("\n", array_map(function ($a) {
                return implode("\n", $a);
            }, $array));
        }
    }

    protected function serverError(string $msg): \Illuminate\Http\JsonResponse
    {
        $response = [
            'message' => 'SERVER_ERROR',
            'description' => 'Internal Server Error',
            'errors' => [
                'detail' => [$msg]
            ]
        ];
        return response()->json($response,500);
    }

    protected function customError(int $code, string $description, string $msg): \Illuminate\Http\JsonResponse
    {
        $response = [
            'message' => 'ERROR',
            'description' => $description,
            'errors' => [
                'detail' => [$msg]
            ]
        ];
        return response()->json($response, $code);
    }

    protected function customErrorWithData(int $code, string $description, array $errors=[], array $data=[]): \Illuminate\Http\JsonResponse
    {
        $response = [
            'message' => 'ERROR',
            'description' => $description,
            'errors' => [
                'detail' => $errors
            ],
            'data' => $data
        ];
        return response()->json($response, $code);
    }

    protected function customSuccessWithData(int $code, string $description, array $data=[]): \Illuminate\Http\JsonResponse
    {
        $response = [
            'message' => 'SUCCESS',
            'description' => $description,
            'data' => $data
        ];
        return response()->json($response, $code);
    }

    protected function notFoundError(string $msg): \Illuminate\Http\JsonResponse
    {
        $response = [
            'message' => 'ERROR',
            'description' => "Not Found!",
            'errors' => [
                'detail' => [$msg]
            ]
        ];
        return response()->json($response, 404);
    }

    protected function unauthorizedResponse($message = "Unauthorized Access"): \Illuminate\Http\JsonResponse
    {
        $response = [
            'message' => 'ERROR',
            'description' => "Unauthorized!",
            'errors' => [
                'detail' => [$message]
            ]
        ];
        return response()->json($response, 401);
    }

    protected function successPaginatedResponse($paginatedData, $resourceCollection, $description = 'Success'): JsonResponse
    {
        $response = [
            'message' => 'OK',
            'description' => $description,
            'data' => $resourceCollection,
            'pagination' => $this->getPaginatedData($paginatedData),
        ];

        return response()->json($response, 200);
    }

    protected function getPaginatedData($data) {
        return [
            'per_page' => $data->perPage(),
            'from' => $data->firstItem(),
            'to' => $data->lastItem(),
            'total' => $data->total(),
            'current_page' => $data->currentPage(),
            'last_page' => $data->lastPage(),
            'prev_page_url' => $data->previousPageUrl(),
            'first_page_url' => $data->url(1),
            'next_page_url' => $data->nextPageUrl(),
            'last_page_url' => $data->url($data->lastPage())
        ];
    }
}
