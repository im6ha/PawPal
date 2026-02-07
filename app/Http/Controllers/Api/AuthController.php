<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
   

    public function register(Request $request)
{
    $validator = Validator::make($request->all(), [
        'full_name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email',
        'phone_number' => 'required|string|max:20',
        'password' => 'required|string|min:8|confirmed',
        'user_pic' => 'nullable|image|max:2048', 
    ]);

    if ($validator->fails()) {
        return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
    }

    try {
        $imagePath = 'media/images/users/default.png';

        if ($request->hasFile('user_pic')) {
            $file = $request->file('user_pic');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('media/images/users'), $filename);
            $imagePath = 'media/images/users/' . $filename;
        }

        $user = User::create([
            'name'          => $request->full_name,
            'email'         => $request->email,
            'phone'         => $request->phone_number,
            'password'      => Hash::make($request->password),
            'profile_image' => $imagePath,
            'status'        => 'active',
            'trust_score'   => 0,
        ]);

        auth()->login($user);
        $request->session()->regenerate();

        return response()->json(['success' => true], 201);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
}


   
    public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (auth()->attempt($credentials)) {
        $user = auth()->user();

        if ($user->status === 'banned') {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return response()->json([
                'success' => false,
                'message' => 'Your account has been banned!',
            ], 403);
        }
    
        $request->session()->regenerate();

        return response()->json([
            'success' => true,
            'user' => $user
        ]);
    }

    return response()->json([
        'success' => false,
        'message' => 'Invalid email or password.',
    ], 401);
}

public function updateProfile(Request $request)
{
    $user = auth()->user();

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'phone' => 'required|string|max:20',
        'profile_image' => 'nullable|image|max:2048',
    ]);

    $user->name = $request->name;
    $user->email = $request->email;
    $user->phone = $request->phone;

    if ($request->hasFile('profile_image')) {
        $file = $request->file('profile_image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('media/images/users'), $filename);
        
        $user->profile_image = 'media/images/users/' . $filename;
    }

    $user->save();

    return response()->json(['success' => true]);
}


public function changePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|min:8|confirmed',
    ]);

    $user = auth()->user();

    if (!Hash::check($request->current_password, $user->password)) {
        return response()->json(['success' => false, 'message' => 'Current password is incorrect'], 422);
    }

    $user->password = Hash::make($request->new_password);
    $user->save();

    return response()->json(['success' => true]);
}

public function deleteAccount()
{
    $user = auth()->user();
    auth()->logout();
    $user->delete();

return response()->json(['success' => true], 200);}


}