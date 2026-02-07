<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'reportable_id' => 'required|integer',
            'post_type'     => 'required|string',
        ]);

        Report::create([
            'reportable_id' => $validated['reportable_id'],
            'post_type'     => $validated['post_type'],
            'status'        => 'pending'
        ]);

        return response()->json(['message' => 'Report submitted successfully.']);
    }
}