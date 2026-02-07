<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Adoption;
use App\Models\LostPet;
use App\Models\Sitter;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AdminController extends Controller
{
    public function getPosts($type, $status)
    {
        $model = match ($type) {
            'products' => Product::class,
            'adoption' => Adoption::class,
            'lost-pets' => LostPet::class,
            'sitters'  => Sitter::class,
            default    => null
        };

        if (!$model) {
            return response()->json(['error' => 'Invalid post type'], 400);
        }

        $posts = $model::with('user')
            ->where('status', $status)
            ->latest()
            ->get();

        return response()->json(['data' => $posts]);
    }




   public function updatePostStatus(Request $request, $type, $id)
{
    try {
        $model = match ($type) {
            'products'  => Product::class,
            'adoption'  => Adoption::class,
            'lost-pets' => LostPet::class,
            'sitters'   => Sitter::class,
            default     => null
        };

        if (!$model) {
            return response()->json(['error' => "Type $type not found"], 400);
        }

        $post = $model::find($id);

        if (!$post) {
            return response()->json(['error' => "Record #$id not found in $type"], 404);
        }

        if ($request->action === 'approve') {
    $post->status = 'accepted';
    $post->save();
    
    $user = $post->user;
    if ($user) {
        $user->trust_score = ($user->trust_score ?? 0) + 1;
        $user->save();
    }
    
    return response()->json(['message' => 'Post accepted successfully']);
}

        if (in_array($request->action, ['reject', 'delete'])) {
            $post->delete();
            return response()->json(['message' => 'Post removed successfully']);
        }

        return response()->json(['error' => 'Invalid action'], 400);

    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

public function getReports($type)
{
    $modelClass = match ($type) {
        'products' => \App\Models\Product::class,
        'adoption' => \App\Models\Adoption::class,
        'lost-pets' => \App\Models\LostPet::class,
        'sitters'  => \App\Models\Sitter::class,
        default    => null
    };

    if (!$modelClass) {
        return response()->json(['error' => 'Invalid report type'], 400);
    }

    $reports = Report::where('post_type', $type)
        ->where('status', 'pending')
        ->latest()
        ->get();

    $validReports = [];

    foreach ($reports as $report) {
        $post = $modelClass::with('user')->find($report->reportable_id);
        if ($post) {
            $report->reportable = $post;
            $validReports[] = $report;
        }
    }

    return response()->json(['data' => $validReports]);
}


public function handleReportAction(Request $request, $id)
{
    try {
        $report = Report::findOrFail($id);
        
        $modelClass = match ($report->post_type) {
            'products'  => \App\Models\Product::class,
            'adoption'  => \App\Models\Adoption::class,
            'lost-pets' => \App\Models\LostPet::class,
            'sitters'   => \App\Models\Sitter::class,
            default     => null
        };

        $post = $modelClass ? $modelClass::find($report->reportable_id) : null;
        $user = $post ? $post->user : \App\Models\User::find($request->user_id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        switch ($request->action) {
            case 'resolve':
    $user->trust_score = max(0, $user->trust_score - 1);
    $user->save();
    $report->delete(); 
    break;

            case 'delete_post':
                $user->trust_score = 0;
                $user->save();
                if ($post) {
                    $post->delete();
                }
                $report->delete();
                break;

            case 'delete_report':
                $report->delete();
                break;

            case 'ban':
    $user->status = 'banned';
    $user->save();
    $report->delete();
    break;
        }

        return response()->json(['message' => 'Action executed successfully']);

    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


public function getUsers()
{
    try {
        $users = \App\Models\User::select('id', 'name', 'email', 'trust_score', 'status', 'created_at', 'profile_image')
            ->where('is_admin', 0)
            ->latest()
            ->get();

    return response()->json(['data' => $users]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

public function updateUserStatus(Request $request, $id)
{
    try {
        $user = \App\Models\User::findOrFail($id);
        $user->status = $request->status;
        $user->save();

        return response()->json(['message' => "User status updated to {$request->status}"]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

public function getStats()
{
    return response()->json([
        'total_posts' => \App\Models\Adoption::count() + 
                         \App\Models\Product::count() + 
                         \App\Models\LostPet::count() + 
                         \App\Models\Sitter::count(),
        'active_reports' => \App\Models\Report::where('status', 'pending')->count(),
        'active_users' => \App\Models\User::where('status', 'active')->where('is_admin', 0)->count()
    ]);
}

}