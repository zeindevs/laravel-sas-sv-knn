<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubmissionItemResource extends JsonResource
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
            'submission_id' => $this->submission_id,
            'question_id' => $this->question_id,
            'weight_id' => $this->weight_id,
            // 'submission_id' => $this->whenLoaded('submission', new SubmissionResource($this->submission)),
            // 'question' => $this->whenLoaded('question', new QuestionResource($this->question)),
            // 'weight' => $this->whenLoaded('weight', new WeightResource($this->weight)),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
