<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sitter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class SitterController extends Controller
{

    public function getSitters()
    {
        try {
            $sitters = Sitter::with('user')->where('status', 'published')->get();
        } catch (QueryException $e) {

            $sitters = Sitter::with('user')->get();
        }

        return response()->json($sitters);
    }

    public function index()
    {
        try {
            $sitters = Sitter::where('status', 'published')->latest()->get();
        } catch (QueryException $e) {
            $sitters = Sitter::latest()->get();
        }

        return view('main-pages.sitters', compact('sitters'));
    }


public function store(Request $request)
{
    if (Sitter::where('user_id', Auth::id())->exists()) {
        return redirect()->route('find-sitters')
                         ->with('error', 'You are already registered as a sitter!');
    }

    $request->validate([
        'wilaya' => 'required|string|max:50',
        'description' => 'required|string|max:500',
        'hourlyPay' => 'required|numeric|min:0',
    ]);

    $user = Auth::user();
    $status = ($user && ($user->trust_score ?? 0) > 3) ? 'published' : 'pending';

    $payload = [
        'user_id'            => Auth::id(),
        'location'           => $request->wilaya, 
        'bio'                => $request->description,
        'fee_per_day'        => $request->hourlyPay,    
        'profile_image_path' => null,
        'status'             => $status,    
    ];

    Sitter::create($payload);

    $message = ($status === 'published')
        ? 'Your sitter profile is published!'
        : 'Your application is pending review.';

    return redirect()->route('find-sitters')->with('success', $message);
}



    /**
     * Show current user's pending sitter applications (requests).
     */
    public function myRequests()
    {
        try {
            $requests = Sitter::where('user_id', Auth::id())
                              ->where('status', 'pending')
                              ->latest()
                              ->get();
        } catch (QueryException $e) {
            // if no status column, show all user's records as "requests"
            $requests = Sitter::where('user_id', Auth::id())->latest()->get();
        }

        return view('user.sitter-requests', compact('requests'));
    }

    /**
     * Approve a sitter (set status => published).
     * Protect this route with admin middleware / policy in routes/web.php.
     */
    public function approve(Sitter $sitter)
    {
        // Protect this route in routes (example: ->middleware('can:approve-sitters') or isAdmin)
        try {
            $sitter->update(['status' => 'published']);
        } catch (QueryException $e) {
            // If status column doesn't exist, no-op or handle as you prefer
            return back()->with('error', 'Cannot approve: status column missing in DB.');
        }

        return back()->with('success', 'Sitter approved.');
    }
}
