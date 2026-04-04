<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Track;
use Illuminate\Http\Request;

class TrackController extends Controller
{
    /** Show the track & branch selection page */
    public function index(Request $request)
    {
        $tracks = Track::with('branches')->get();
        $user = $request->user();

        return view('tracks.index', compact('tracks', 'user'));
    }

    /** Store the user's track and branch selection */
    public function select(Request $request)
    {
        $request->validate([
            'track_id'  => ['required', 'exists:tracks,id'],
            'branch_id' => ['required', 'exists:branches,id'],
        ]);

        $branch = Branch::with('track')->findOrFail($request->branch_id);

        // Ensure the branch belongs to the selected track
        if ($branch->track_id != $request->track_id) {
            return back()->withErrors(['branch_id' => 'Invalid branch for selected track.']);
        }

        $request->user()->update([
            'current_track_id'  => $request->track_id,
            'current_branch_id' => $request->branch_id,
        ]);

        return redirect()->route('dashboard')
            ->with('success', "You're now learning {$branch->name} in the {$branch->track->name} track! 🚀");
    }
}
