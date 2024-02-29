<?php

namespace App\Services;

use App\Models\Submission;
use Exception;
use Illuminate\Http\Request;

interface PredictionService
{
	public function predict(array $testPoint): string|int|null;

	public function predictAndSave(Request $request): Submission|Exception;
}
