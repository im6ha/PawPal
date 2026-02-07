<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\SavedPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavedPostController extends Controller
{
    public function toggle(Request $request)
    {
        $validated = $request->validate([
            'saveable_id'   => 'required|integer',
            'saveable_type' => 'required|string',
        ]);

        $userId = Auth::id();

        $existing = SavedPost::where('user_id', $userId)
            ->where('saveable_id', $validated['saveable_id'])
            ->where('saveable_type', $validated['saveable_type'])
            ->first();

        if ($existing) {
            $existing->delete();
            return response()->json(['status' => 'removed', 'message' => 'Post unsaved']);
        }

        SavedPost::create([
            'user_id'       => $userId,
            'saveable_id'   => $validated['saveable_id'],
            'saveable_type' => $validated['saveable_type'],
        ]);

        return response()->json(['status' => 'saved', 'message' => 'Post saved']);
    }
}