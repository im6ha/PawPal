<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Adoption;
use Illuminate\Support\Facades\Auth;

class AdoptionController extends Controller
{
    public function create()
    {
        return view('other-pages.adoption-form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'petType' => 'required|in:dog,cat,rabbit,bird,hamster,fish,other',
            'wilaya' => 'required|string',
            'petGender' => 'required|in:male,female',
            'description' => 'nullable|string|max:100',
            'petPhoto' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);

        $imagePath = 'media/images/default.png';
        if ($request->hasFile('petPhoto')) {
            $file = $request->file('petPhoto');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('media/pet_pictures'), $filename);
            $imagePath = 'media/pet_pictures/' . $filename;
        }

        $adoption = Adoption::create([
            'user_id' => Auth::id(),
            'pet_type' => $data['petType'],
            'gender' => $data['petGender'],
            'location' => $data['wilaya'],
            'description' => $data['description'] ?? '',
            'image_path' => $imagePath,
            'status' => Auth::user()->trust_score > 3 ? 'accepted' : 'pending'
        ]);

        return redirect()->route('adopt')->with('success', 'Pet submitted for adoption successfully!');
    }

    public function index() 
    {
        return view('main-pages.adopt');
    }

    public function apiIndex(Request $request)
    {
        $query = Adoption::where('status', 'accepted');
        
        if ($request->has('pet_types')) {
            $types = explode(',', $request->pet_types);
            $query->whereIn('pet_type', $types);
        }

        if ($request->has('locations')) {
            $locations = explode(',', $request->locations);
            $query->whereIn('location', $locations);
        }

        if ($request->has('genders')) {
            $genders = explode(',', $request->genders);
            $query->whereIn('gender', $genders);
        }

        return response()->json($query->with('user')->latest()->get()->map(function ($adoption) {
            return [
                'id' => $adoption->id,
                'user_id' => $adoption->user_id,
                'imageUrl' => asset($adoption->image_path),
                'type' => $adoption->pet_type,
                'description' => $adoption->description,
                'location' => $adoption->wilaya_name,
                'gender' => ucfirst($adoption->gender),
                'contactText' => 'Contact Owner'
            ];
        }));
    }
}
