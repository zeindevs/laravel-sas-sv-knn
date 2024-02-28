<?php

namespace App\Services;

interface PredictionService
{
	public function euclideanDistance(array $point1, array $point2);

	public function knn(int $k, array $testPoint, array $dataset);

	public function predict(array $testPoint);
}
