<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    public function collects(): HasMany
    {
        return $this->hasMany(Collect::class);
    }

    public function wins(): BelongsToMany
    {
        return $this->belongsToMany(Season::class, 'wins')->using(Win::class)->withPivot('category');
    }

    public function displayData()
    {
        return $this->get(['slug', 'primary_color', 'secondary_color', 'logo_url']);
    }
}
