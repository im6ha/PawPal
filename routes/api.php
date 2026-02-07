<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


use App\Models\Adoption;

Route::get('/pets/adoption', function () {
    return response()->json(Adoption::all());
});