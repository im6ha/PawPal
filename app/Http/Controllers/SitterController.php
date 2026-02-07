<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sitter;
use Illuminate\Support\Facades\Auth;

class SitterController extends Controller
{
    public function index()
{
    return view('main-pages.find-sitters');
}
    public function store(Request $request)
    {
        if (Sitter::where('user_id', Auth::id())->exists()) {
            return redirect()->route('find-sitters')
                           ->with('error', 'You are already registered as a sitter!');
        }

        $request->validate([
            'wilaya' => 'required|string',
            'description' => 'required|string|max:500',
            'hourlyPay' => 'required|numeric|min:0.01',
        ]);

        $sitter = Sitter::create([
            'user_id' => Auth::id(),
            'location' => $request->wilaya,
            'bio' => $request->description,
            'fee_per_day' => $request->hourlyPay,
            'profile_image_path' => null,
            'status' => Auth::user()->trust_score > 3 ? 'accepted' : 'pending'
        ]);

        return redirect()->route('find-sitters')->with('success', 'Your sitter application has been submitted!');
    }

    public function getSitters(Request $request)
    {
        $query = Sitter::where('status', 'accepted')->with('user');
        
        if ($request->has('locations')) {
            $locations = explode(',', $request->locations);
            $query->whereIn('location', $locations);
        }

        if ($request->has('min_price')) {
            $query->where('fee_per_day', '>=', $request->min_price);
        }
        if ($request->has('max_price')) {
            $query->where('fee_per_day', '<=', $request->max_price);
        }

        return response()->json($query->latest()->get()->map(function ($sitter) {
            return [
                'id' => $sitter->id,
                'user_id' => $sitter->user_id,
                'name' => $sitter->user->name,
                'location' => $sitter->wilaya_name,
                'description' => $sitter->bio,
                'fee' => $sitter->fee_per_day . ' DA/24h',
                'avatarUrl' => $sitter->user->profile_image ? asset($sitter->user->profile_image) : null
            ];
        }));
    }
}
