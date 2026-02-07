<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceRequestController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'receiver_id'      => 'required|exists:users,id',
            'requestable_id'   => 'required|integer',
            'requestable_type' => 'required|string', 
        ]);

        $serviceRequest = ServiceRequest::create([
            'sender_id'        => Auth::id(),
            'receiver_id'      => $validated['receiver_id'],
            'requestable_id'   => $validated['requestable_id'],
            'requestable_type' => $validated['requestable_type'],
            'status'           => 'pending',
        ]);

        return response()->json([
            'message' => 'Service request sent!',
            'data'    => $serviceRequest
        ], 201);
    }

    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:accepted,declined',
        ]);

        $serviceRequest = ServiceRequest::where('id', $id)
            ->where('receiver_id', Auth::id())
            ->firstOrFail();

        $serviceRequest->update(['status' => $validated['status']]);

        return response()->json(['message' => 'Status updated to ' . $validated['status']]);
    }
}