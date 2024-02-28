<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DatasetItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'weight' => $this->weight,
            'dataset_id' => $this->dataset_id,
            'question_id' => $this->question_id,
            'dataset' => $this->whenLoaded('dataset', new DatasetItemCollection($this->dataset)),
            'question' => $this->whenLoaded('question', new DatasetItemCollection($this->question)),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
