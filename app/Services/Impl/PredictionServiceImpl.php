<?php

namespace App\Services\Impl;

use App\Models\Dataset;
use App\Models\Submission;
use App\Models\Weight;
use App\Services\PredictionService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PredictionServiceImpl implements PredictionService
{
	/**
	 * Function to calculate Euclidean distance between two points	
	 *  
	 * @param array $point1 
	 * @param array $point2
	 * @return float
	 */
	private function euclideanDistance(array $point1, array $point2)
	{
		$sum = 0;
		$n = count($point1);
		for ($i = 0; $i < $n; $i++) {
			$sum += pow($point1[$i] - $point2[$i], 2);
		}
		return sqrt($sum);
	}

	/**
	 * Function to perform KNN classification
	 * 
	 * @param int $k 
	 * @param array $answer
	 * @param array $dateset
	 * @return string|int|null
	 * */
	private function knn(int $k, array $answer, array $dataset)
	{
		$distances = [];

		foreach ($dataset as $data) {
			$features = array_slice($data, 0, -1); // Exclude the label
			$label = end($data); // Get the label
			$distance = $this->euclideanDistance($answer, $features);
			$distances[] = [$distance, $label];
		}

		// Sort distances
		usort($distances, function ($a, $b) {
			return $a[0] <=> $b[0];
		});

		// Get the k-nearest neighbors
		$neighbors = array_slice($distances, 0, $k);

		// Count the occurrences of each label
		$counts = array_count_values(array_column($neighbors, 1));

		// Find the label with the highest count
		arsort($counts);

		// Return the label with the highest count
		return key($counts);
	}

	/**
	 * SAS-SV-KNN Prediction
	 * 
	 * @param array $answer
	 * @return string|int|null
	 * */
	public function predict(array $answer): string|int|null
	{
		// Sample dataset - You should replace this with your actual dataset
		// $dataset = [
		// 	[3, 4, 5, 5, 2, 3, 5, 6, 1, 5, 'Addiction'],
		// 	[2, 3, 4, 5, 6, 4, 6, 3, 4, 5, 'Mon Addiction'],
		// 	[1, 2, 1, 2, 4, 6, 2, 4, 1, 2, 'Low'],
		// 	// Add more data points here
		// ];

		$datasets = [];
		$dataset = Dataset::with('items')->get();

		foreach ($dataset as $item) {
			$value = [];
			foreach ($item->items as $v) {
				array_push($value, $v['weight']);
			}
			array_push($datasets, [...$value, $item['prediction']]);
		};

		// Log::info(json_encode($datasets, JSON_PRETTY_PRINT));

		// Example usage
		// $answer = [2, 2, 3, 5, 1, 3, 6, 4, 2, 3]; // Test data point

		$k = 3; // Number of nearest neighbors to consider
		$result = $this->knn($k, $answer, $datasets);

		return $result;
	}

	/**
	 * SAS-SV-KNN Prediction and SAve
	 * 
	 * @param \Illuminate\Http\Request $request
	 * @return \App\Models\Submission|\Exception
	 * */
	public function predictAndSave(Request $request): Submission
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
			$submision->prediction = $this->predict($answers);
			$submision->save();

			// Store submission item
			foreach ($validated['questions'] as $qa) {
				$submision->items()->create([
					'question_id' => $qa['id'],
					'weight_id' => $qa['answer'],
				]);
			}

			DB::commit();

			return $submision;
		} catch (Exception $e) {
			DB::rollBack();

			throw $e;
		}
	}
}
