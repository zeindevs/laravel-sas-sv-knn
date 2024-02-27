<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ApiQuestionCreateRequest;
use App\Http\Requests\Api\ApiQuestionUpdateRequest;
use App\Http\Resources\QuestionCollection;
use App\Http\Resources\QuestionResource;
use App\Models\Question;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApiQuestionController extends Controller
{

    private function getQuestion(string $id): Question
    {
        $question = Question::find($id);

        if (!$question) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    'message' => 'Question not found.'
                ],
            ], Response::HTTP_NOT_FOUND));
        }

        return $question;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): QuestionCollection
    {
        $limit = $request->get('limit', 10);

        $questions = Question::query();

        $questions = $questions->where(function (Builder $builder) use ($request) {
            $id = $request->get('id');
            if ($id) {
                $builder->orWhere('id', $id);
            }
            $name = $request->get('name');
            if ($name) {
                $builder->orWhere('name', 'like', '%' . $name . '%');
            }
        });

        $questions = $questions->paginate(perPage: $limit);

        return new QuestionCollection($questions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ApiQuestionCreateRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $question = Question::create($validated);

        return response()->json([
            'data' => $question,
            'message' => 'Question created successfully.',
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): QuestionResource
    {
        $question = $this->getQuestion($id);

        return new QuestionResource($question);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ApiQuestionUpdateRequest $request, string $id): JsonResponse
    {
        $question = $this->getQuestion($id);

        $validated = $request->validated();

        $question->update($validated);

        return response()->json([
            'data' => $question,
            'message' => 'Question updated successfully.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $question = $this->getQuestion($id);

        $question->delete();

        return response()->json([
            'message' => 'Question deleted successfully.',
        ]);
    }
}
