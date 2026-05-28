<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CollectData extends Model
{
    public function collect(): BelongsTo
    {
        return $this->belongsTo(Collect::class);
    }
}
