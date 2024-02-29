<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubmissionSubmitRequest;
use App\Models\Dataset;
use App\Models\Question;
use App\Models\Submission;
use App\Models\Weight;
use App\Services\PredictionService;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
    public function index(): Renderable
    {
        $questions = Question::all();
        $answers = Weight::all();

        return view('welcome', [
            'questions' => $questions,
            'answers' => $answers
        ]);
    }

    /**
     * Show the prediction predict.
     * 
     * @param \App\Http\Request\SubmissionSubmitRequest $request;
     * @return \Illuminate\Http\RedirectResponse
     */
    public function predict(SubmissionSubmitRequest $request): RedirectResponse
    {
        try {
            $submission = $this->predictionService->predictAndSave($request);

            return redirect('/result/' . $submission->id);
        } catch (Exception $e) {
            DB::rollBack();

            return redirect('/')->withErrors($e);
        }
    }

    /**
     * Show the prediction result.
     * 
     * @param string $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function result(string $id): Renderable
    {
        $submission = Submission::find($id);

        if (!$submission) {
            return redirect('/');
        }

        return view('result', [
            'title' => 'Result',
            'submission' => $submission
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard(): Renderable
    {
        $total_submited = Submission::count();
        $total_dataset = Dataset::count();
        $submited = Submission::limit(10)->orderBy('created_at', 'desc')->get();

        return view('home', [
            'title' => 'Dashboard',
            'total_dataset' => $total_dataset,
            'total_submited' => $total_submited,
            'submited' => $submited,
        ]);
    }

    /**
     * Show the application dataset.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dataset(Request $request): Renderable
    {
        $limit = $request->get('limit', 10);

        $datasets = Dataset::with('items')->paginate(perPage: $limit);

        return view('dataset', [
            'title' => 'Dataset',
            'datasets' => $datasets
        ]);
    }

    /**
     * Show the application submission.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function submission(Request $request): Renderable
    {
        $limit = $request->get('limit', 10);

        $submissions = Submission::paginate(perPage: $limit);

        return view('submission', [
            'title' => 'Submission',
            'submissions' => $submissions
        ]);
    }
}
