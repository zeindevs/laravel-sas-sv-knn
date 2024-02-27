<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ApiWeightCreateRequest;
use App\Http\Requests\Api\ApiWeightUpdateRequest;
use App\Http\Resources\WeightCollection;
use App\Http\Resources\WeightResource;
use App\Models\Weight;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApiWeightController extends Controller
{

    private function getWeight(string $id): Weight
    {
        $weight = Weight::find($id);
        if (!$weight) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    'message' => 'Weight not found.'
                ],
            ], Response::HTTP_NOT_FOUND));
        }

        return $weight;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): WeightCollection
    {
        $limit = $request->get('limit', 10);

        $weights = Weight::query();

        $weights = $weights->where(function (Builder $builder) use ($request) {
            $id = $request->get('id');
            if ($id) {
                $builder->orWhere('id', $id);
            }
            $name = $request->get('name');
            if ($name) {
                $builder->orWhere('name', 'like', '%' . $name . '%');
            }
        });

        $weights = $weights->paginate(perPage: $limit);

        return new WeightCollection($weights);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ApiWeightCreateRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $weight = Weight::create($validated);

        return response()->json([
            'data' => $weight,
            'message' => 'Weight created successfully.',
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): WeightResource
    {
        $weight = $this->getWeight($id);

        return new WeightResource($weight);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ApiWeightUpdateRequest $request, string $id): JsonResponse
    {
        $weight = $this->getWeight($id);

        $validated = $request->validated();

        $weight->update($validated);

        return response()->json([
            'data' => $weight,
            'message' => 'Weight updated successfully.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $weight = $this->getWeight($id);

        $weight->delete();

        return response()->json([
            'message' => 'Weight deleted successfully.',
        ]);
    }
}
