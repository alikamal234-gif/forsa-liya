<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Branch extends Model
{
    protected $fillable = ['track_id', 'name', 'slug', 'description', 'order', 'icon'];

    /** The track this branch belongs to */
    public function track(): BelongsTo
    {
        return $this->belongsTo(Track::class);
    }

    /** Projects created for this branch */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    /** Skill progress records for this branch */
    public function skillsProgress(): HasMany
    {
        return $this->hasMany(SkillProgress::class);
    }
}
