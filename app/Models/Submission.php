<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'prediction',
    ];

    public function items(): HasMany
    {
        return $this->HasMany(SubmissionItem::class, 'submission_id', 'id');
    }
}
