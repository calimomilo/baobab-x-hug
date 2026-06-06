<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['company_name', 'address', 'contact_address', 'contact_name', 'email', 'phone', 'slug', 'primary_color', 'secondary_color', 'logo_url', 'anonymous'])]
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

    public function link()
    {
        return config('app.url').'/'.$this->get('slug');
    }
}
