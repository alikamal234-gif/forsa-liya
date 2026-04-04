<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Project extends Model
{
    protected $fillable = [
        'user_id', 'branch_id', 'title', 'description',
        'requirements', 'constraints', 'expected_features',
        'difficulty', 'deadline', 'status', 'ai_generated_data',
    ];

    protected $casts = [
        'requirements'       => 'array',
        'constraints'        => 'array',
        'expected_features'  => 'array',
        'ai_generated_data'  => 'array',
        'deadline'           => 'datetime',
    ];

    /** The user who owns this project */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** The branch this project belongs to */
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    /** The user's code submission */
    public function submission(): HasOne
    {
        return $this->hasOne(Submission::class);
    }

    /** Quiz questions generated for this project */
    public function quizQuestions(): HasMany
    {
        return $this->hasMany(QuizQuestion::class)->orderBy('order');
    }

    /** The final evaluation result */
    public function result(): HasOne
    {
        return $this->hasOne(Result::class);
    }

    /** Check if project is expired (past deadline, still active) */
    public function isExpired(): bool
    {
        return $this->deadline && $this->deadline->isPast() && $this->status === 'active';
    }

    /** Days remaining until deadline */
    public function daysRemaining(): int
    {
        if (!$this->deadline) return 0;
        return max(0, now()->diffInDays($this->deadline, false));
    }
}
