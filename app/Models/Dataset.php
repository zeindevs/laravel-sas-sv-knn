<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dataset extends Model
{
    use HasFactory;

    protected $fillable = [
        'prediction',
    ];

    public function items(): HasMany
    {
        return $this->HasMany(DatasetItem::class, 'dataset_id', 'id');
    }
}
