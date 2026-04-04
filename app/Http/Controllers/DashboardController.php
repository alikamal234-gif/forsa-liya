<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user()->load([
            'currentTrack',
            'currentBranch',
            'skillsProgress.branch',
        ]);

        // If no track selected, redirect to track selection
        if (!$user->current_track_id) {
            return redirect()->route('tracks.index')
                ->with('info', 'Please select your learning track to get started!');
        }

        $stats = $user->stats();
        $activeProject = $user->activeProject();

        // Load recent results (last 5)
        $recentResults = $user->results()
            ->with(['project.branch'])
            ->latest()
            ->limit(5)
            ->get();

        // Skills progress for current track
        $skillsProgress = $user->skillsProgress()
            ->with('branch.track')
            ->whereHas('branch', fn($q) => $q->where('track_id', $user->current_track_id))
            ->get();

        return view('dashboard.index', compact(
            'user', 'stats', 'activeProject', 'recentResults', 'skillsProgress'
        ));
    }
}
