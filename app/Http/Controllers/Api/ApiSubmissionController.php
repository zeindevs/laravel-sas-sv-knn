<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ApiSubmissionCreateRequest;
use App\Http\Requests\Api\ApiSubmissionUpdateRequest;
use App\Http\Resources\SubmissionCollection;
use App\Http\Resources\SubmissionResource;
use App\Models\Submission;
use App\Models\Weight;
use App\Services\PredictionService;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ApiSubmissionController extends Controller
{
    private PredictionService $predictionService;

    public function __construct(PredictionService $service)
    {
        $this->predictionService = $service;
    }

    private function getSubmission(string $id): Submission
    {
        $submision = Submission::find($id);

        if (!$submision) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    'message' => 'Submission not found.'
                ],
            ], Response::HTTP_NOT_FOUND));
        }

        return $submision;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): SubmissionCollection
    {
        $limit = $request->get('limit', 10);

        $submisions = Submission::query()->with('items');

        $submisions = $submisions->where(function (Builder $builder) use ($request) {
            $id = $request->get('id');
            if ($id) {
                $builder->orWhere('id', $id);
            }
            $name = $request->get('name');
            if ($name) {
                $builder->orWhere('name', 'like', '%' . $name . '%');
            }
        });

        $submisions = $submisions->paginate(perPage: $limit);

        return new SubmissionCollection($submisions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ApiSubmissionCreateRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();

            $questions = [];

            // Get list answer id
            foreach ($validated['questions'] as $qa) {
                array_push($questions, $qa['answer']);
            }

            DB::beginTransaction();

            $weights = Weight::select('Weight')->whereIn('id', $questions)->get();

            $answers = [];

            // Get list answer weight
            foreach ($weights as $item) {
                array_push($answers, $item['weight']);
            };

            $submision = new Submission();
            $submision->name = $validated['name'];
            $submision->prediction = $this->predictionService->predict($answers);
            $submision->save();

            // Store submission item
            foreach ($validated['questions'] as $qa) {
                $submision->items()->create([
                    'question_id' => $qa['id'],
                    'weight_id' => $qa['answer'],
                ]);
            }

            DB::commit();

            return response()->json([
                'data' => $submision,
                'message' => 'Submission created successfully.',
            ], Response::HTTP_CREATED);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'errors' => $e->getMessage(),
                'message' => 'Submission created failed.',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): SubmissionResource
    {
        $submision = $this->getSubmission($id);

        return new SubmissionResource($submision);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ApiSubmissionUpdateRequest $request, string $id): JsonResponse
    {
        $submision = $this->getSubmission($id);

        $validated = $request->validated();

        $submision->update($validated);

        return response()->json([
            'data' => $submision,
            'message' => 'Submission updated successfully.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $submision = $this->getSubmission($id);

        $submision->delete();

        return response()->json([
            'message' => 'Submission deleted successfully.',
        ]);
    }
}
