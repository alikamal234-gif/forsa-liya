<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SkillProgress extends Model
{
    protected $table = 'skills_progress';

    protected $fillable = ['user_id', 'branch_id', 'projects_completed', 'projects_passed', 'is_validated'];

    protected $casts = [
        'is_validated' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }
}
