<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Track extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'icon', 'color'];

    /** Branches that belong to this track */
    public function branches(): HasMany
    {
        return $this->hasMany(Branch::class)->orderBy('order');
    }

    /** Users currently in this track */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'current_track_id');
    }
}
