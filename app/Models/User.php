<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
        'level', 'current_track_id', 'current_branch_id',
        'xp_points', 'projects_completed', 'projects_passed',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // ─── Relationships ───────────────────────────────────────────────────────

    public function currentTrack(): BelongsTo
    {
        return $this->belongsTo(Track::class, 'current_track_id');
    }

    public function currentBranch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'current_branch_id');
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class);
    }

    public function results(): HasMany
    {
        return $this->hasMany(Result::class);
    }

    public function skillsProgress(): HasMany
    {
        return $this->hasMany(SkillProgress::class);
    }

    // ─── Helpers ─────────────────────────────────────────────────────────────

    /** Get the user's active (current) project */
    public function activeProject(): ?Project
    {
        return $this->projects()->where('status', 'active')->latest()->first();
    }

    /** Get dashboard stats summary */
    public function stats(): array
    {
        return [
            'total'     => $this->projects_completed,
            'passed'    => $this->projects_passed,
            'failed'    => $this->projects_completed - $this->projects_passed,
            'skills'    => $this->skillsProgress()->where('is_validated', true)->count(),
            'xp'        => $this->xp_points,
        ];
    }

    /** Determine level label based on xp */
    public function levelLabel(): string
    {
        return match ($this->level) {
            'beginner'     => 'Beginner',
            'intermediate' => 'Intermediate',
            'advanced'     => 'Advanced',
            default        => 'Beginner',
        };
    }

    /** Avatar initials */
    public function initials(): string
    {
        $words = explode(' ', $this->name);
        return strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
    }
}
