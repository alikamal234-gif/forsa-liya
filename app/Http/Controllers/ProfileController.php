<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /** Show user profile with progress overview */
    public function show(Request $request)
    {
        $user = $request->user()->load([
            'currentTrack',
            'currentBranch',
            'skillsProgress.branch.track',
            'projects' => fn($q) => $q->latest()->limit(10),
            'projects.branch',
            'projects.result',
        ]);

        $stats = $user->stats();

        return view('profile.show', compact('user', 'stats'));
    }

    /** Update the user's current branch (change focus without losing track) */
    public function changeBranch(Request $request)
    {
        $request->validate([
            'branch_id' => ['required', 'exists:branches,id'],
        ]);

        $user = $request->user();

        // Ensure branch belongs to current track
        $branch = \App\Models\Branch::findOrFail($request->branch_id);
        if ($branch->track_id !== $user->current_track_id) {
            return back()->with('error', 'Branch does not belong to your current track.');
        }

        // Can only change branch if no active project
        if ($user->activeProject()) {
            return back()->with('error', 'Complete your active project before changing branches.');
        }

        $user->update(['current_branch_id' => $request->branch_id]);

        return back()->with('success', "Switched to {$branch->name} branch! 🎯");
    }
}
