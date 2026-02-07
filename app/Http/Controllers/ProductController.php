<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
{
    $query = Product::where('status', 'accepted');
    if ($request->has('categories')) {
        $categories = explode(',', $request->categories);
        $query->whereIn('category', $categories);
    }

    if ($request->has('locations')) {
        $locations = explode(',', $request->locations);
        $query->whereIn('location', $locations);
    }

    if ($request->has('min_price')) {
        $query->where('price', '>=', $request->min_price);
    }
    if ($request->has('max_price')) {
        $query->where('price', '<=', $request->max_price);
    }
    if ($request->has('pet_types')) {
    $types = explode(',', $request->pet_types);
    $query->whereIn('pet_type', $types);
}

    return response()->json($query->latest()->get());
}

public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric|min:0',
        'category' => 'required|string',
        'petType' => 'required|string',
        'wilaya' => 'required|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $imagePath = 'media/images/default.png';

    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('media/images/products'), $filename);
        $imagePath = 'media/images/products/' . $filename;
    }

    $product = Product::create([
        'user_id' => auth()->id(),
        'name' => $validated['name'],
        'description' => $validated['description'],
        'price' => $validated['price'],
        'category' => $validated['category'],
        'pet_type' => $validated['petType'],
        'location' => $validated['wilaya'],
        'image_path' => $imagePath, 
        'status' => auth()->user()->trust_score > 3 ? 'accepted' : 'pending',    ]);

    return response()->json(['message' => 'Product created successfully!', 'product' => $product], 201);
}
    
}

