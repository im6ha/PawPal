<?php

namespace App\Http\Controllers;

use App\Models\LostPet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LostPetController extends Controller
{
    public function index()
    {
        return view('main-pages.lost-pets');
    }

    public function create()
    {
        return view('other-pages.report-lost');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
    'petType' => 'required|string',
    'wilaya' => 'required|string',
    'lastSeen' => 'required|string',
    'description' => 'required|string',
    'petPhoto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
]);

        $imagePath = 'media/images/default.png';

        if ($request->hasFile('petPhoto')) {
            $file = $request->file('petPhoto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('media/images/lost-pets'), $filename);
            $imagePath = 'media/images/lost-pets/' . $filename;
        }

        $lostPet = LostPet::create([
            'user_id' => auth()->id(),
            'post_type' => 'lost',
            'pet_type' => $validated['petType'],
            'location' => $validated['wilaya'],
            'last_seen_area' => $validated['lastSeen'],
            'date_lost_found' => now()->toDateString(),
            'description' => $validated['description'],
            'image_path' => $imagePath,
            'status' => auth()->user()->trust_score > 3 ? 'accepted' : 'pending',
        ]);

        return redirect()->route('lost-pets')->with('success', 'Your lost pet report has been submitted!');
    }

    public function apiIndex(Request $request)
    {
        $query = LostPet::where('status', 'accepted')->where('post_type', 'lost');
        
        if ($request->has('pet_types')) {
            $types = explode(',', $request->pet_types);
            $query->whereIn('pet_type', $types);
        }

        if ($request->has('locations')) {
            $locations = explode(',', $request->locations);
            $query->whereIn('location', $locations);
        }

        

        return response()->json($query->with('user')->latest()->get()->map(function ($lostPet) {
            return [
                'id' => $lostPet->id,
                'user_id' => $lostPet->user_id,
                'imageUrl' => asset($lostPet->image_path),
                'type' => $lostPet->pet_type,
                'description' => $lostPet->description,
                'location' => $lostPet->wilaya_name,
                'lastSeen' => $lostPet->last_seen_area,
                'status' => $lostPet->post_type,
                'contactText' => 'Contact Owner'
            ];
        }));
    }
}