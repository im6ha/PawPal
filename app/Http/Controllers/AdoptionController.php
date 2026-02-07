<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Adoption;
use Illuminate\Support\Facades\Auth;

class AdoptionController extends Controller
{
    public function create()
    {
        return view('adoption-form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'petType' => 'required|in:dog,cat,rabbit,bird,hamster,fish,other',
            'wilaya' => 'required|string|max:255',
            'petGender' => 'required|in:male,female',
            'description' => 'nullable|string|max:100',
            'petPhoto' => 'required|image|max:5120'
        ]);

        if ($request->hasFile('petPhoto')) {
            $file = $request->file('petPhoto');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('media/pet_pictures'), $filename);
            $data['image_path'] = 'media/pet_pictures/' . $filename;
        }

        $data['pet_type'] = $data['petType'];
        $data['gender'] = $data['petGender'];
        $data['location'] = $data['wilaya'];
        $data['user_id'] = Auth::id();

        $user = Auth::user();
        $data['status'] = ($user && ($user->trust_score ?? 0) > 3) ? 'published' : 'pending';

        unset($data['petType'], $data['petGender'], $data['petPhoto'], $data['wilaya']);


        Adoption::create($data);

        return redirect()->route('user-dashboard')->with('success', 'Pet submitted for adoption successfully!');
    }
    public function index() {
        $pets = Adoption::where('status', 'published')->latest()->get();
        return view('main-pages.adopt', compact('pets'));
    }

}
