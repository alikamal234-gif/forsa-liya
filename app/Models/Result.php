<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Result extends Model
{
    protected $fillable = [
        'project_id', 'user_id', 'submission_id',
        'quiz_score', 'quiz_answers', 'passed', 'action_plan', 'evaluated_at','code_feedback',
    ];

    protected $casts = [
        'quiz_score'   => 'float',
        'quiz_answers' => 'array',
    'code_feedback' => 'array',
        'passed'       => 'boolean',
        'action_plan'  => 'array',
        'evaluated_at' => 'datetime',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function submission(): BelongsTo
    {
        return $this->belongsTo(Submission::class);
    }

    /** Formatted score display */
    public function scoreLabel(): string
    {
        return number_format($this->quiz_score, 1) . '%';
    }
}
