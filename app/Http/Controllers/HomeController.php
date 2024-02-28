<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubmissionSubmitRequest;
use App\Models\Question;
use App\Models\Submission;
use App\Models\Weight;
use App\Services\PredictionService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    private PredictionService $predictionService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(PredictionService $service)
    {
        $this->predictionService = $service;
    }

    /**
     * Show the application welcome.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $questions = Question::all();
        $answers = Weight::all();

        return view('welcome', ['questions' => $questions, 'answers' => $answers]);
    }

     /**
     * Show the prediction result.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function result(SubmissionSubmitRequest $request)
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

            return view('result', ['submission' => $submision]);
        } catch (Exception $e) {
            DB::rollBack();

            return redirect('/')->withErrors($e->getMessage());
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
    {
        return view('home');
    }
}
