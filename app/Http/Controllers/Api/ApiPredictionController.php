<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiPredictionResource;
use App\Models\Dataset;
use App\Services\PredictionService;

class ApiPredictionController extends Controller
{
    private PredictionService $predictionService;

    public function __construct(PredictionService $service)
    {
        $this->predictionService = $service;
    }

    public function predict()
    {
        return response()->json([
            'prediction' => $this->predictionService->predict([1, 1, 4, 5, 1, 2, 4, 6, 4, 6]),
        ]);
    }

    public function dataset()
    {
        $datasets = Dataset::query()->with('items')->limit(10)->get();

        return ApiPredictionResource::collection($datasets);
    }
}
