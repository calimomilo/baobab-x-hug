<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['year_of', 'status'])]
class Season extends Model
{
    public function collects(): HasMany
    {
        return $this->hasMany(Collect::class);
    }

    public function wins(): BelongsToMany
    {
        return $this->belongsToMany(Company::class, 'wins')->using(Win::class)->withPivot('category');
    }
}
