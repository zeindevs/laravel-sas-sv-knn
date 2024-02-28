<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubmissionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'submission_id',
        'question_id',
        'weight_id',
    ];

    public function submission(): BelongsTo
    {
        return $this->belongsTo(Submission::class, 'submission_id', 'id');
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class, 'question_id', 'id');
    }

    public function weight(): BelongsTo
    {
        return $this->belongsTo(Weight::class, 'weight_id', 'id');
    }
}
