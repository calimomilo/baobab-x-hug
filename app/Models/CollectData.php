<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['session_id', 'data_type'])]
class CollectData extends Model
{
    public function collect(): BelongsTo
    {
        return $this->belongsTo(Collect::class);
    }
}
