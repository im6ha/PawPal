<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SavedPost;
use App\Models\ServiceRequest;
use App\Models\Adoption;
use App\Models\Product;
use App\Models\Sitter;
use App\Models\LostPet;

class UserDashboardController extends Controller
{
    public function getSavedItems($type)
{
    $user = Auth::user();
    $savedRecords = SavedPost::where('user_id', $user->id)
        ->where('saveable_type', $type)
        ->latest()
        ->get();

    $items = $savedRecords->map(function ($record) {
        return $record->saveable; 
    })->filter()->values(); 

    return response()->json(['data' => $items]);
}

    public function unsaveItem(Request $request)
    {
        SavedPost::where('user_id', Auth::id())
            ->where('saveable_type', $request->type)
            ->where('saveable_id', $request->id)
            ->delete();

        return response()->json(['message' => 'Removed successfully']);
    }

public function getSentRequests($type)
{
    try {
        $user = Auth::user();
        
        $requests = ServiceRequest::with('requestable')
            ->where('sender_id', $user->id)
            ->where('requestable_type', $type)
            ->latest()
            ->get();

        return response()->json(['data' => $requests]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
    public function cancelRequest(Request $request)
    {
        ServiceRequest::where('id', $request->id)
            ->where('sender_id', Auth::id())
            ->where('status', 'pending')
            ->delete();

        return response()->json(['message' => 'Request cancelled']);
    }

    public function getMyPosts($type)
    {
        $user = Auth::user();
        $modelClass = $this->getModelClass($type);

        $posts = $modelClass::where('user_id', $user->id)
            ->withCount(['serviceRequests as incoming_count'])
            ->latest()
            ->get();

        return response()->json(['data' => $posts]);
    }

    public function getPostIncomingRequests($type, $id)
{
    try {
        $post = $this->getModelClass($type)::where('id', $id)
            ->where('user_id', \Auth::id())
            ->firstOrFail();

        $requests = \App\Models\ServiceRequest::where('requestable_type', $type)
            ->where('requestable_id', $id)
            ->with('sender:id,name,phone')
            ->latest()
            ->get();

        return response()->json([
            'post' => $post,
            'requests' => $requests
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

    public function handleRequestAction(Request $request)
    {
        $serviceRequest = ServiceRequest::where('id', $request->request_id)
            ->where('receiver_id', Auth::id())
            ->firstOrFail();

        $serviceRequest->update([
            'status' => $request->action === 'accept' ? 'accepted' : 'declined'
        ]);

        return response()->json(['message' => 'Request ' . $request->action . 'ed']);
    }

    public function deletePost(Request $request)
    {
        $modelClass = $this->getModelClass($request->type);
        
        $post = $modelClass::where('id', $request->id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $post->delete();

        return response()->json(['message' => 'Post deleted successfully']);
    }

    public function getStats()
{
    try {
        $user = Auth::user();
        
        $postsCount = Adoption::where('user_id', $user->id)->count() + 
                    Product::where('user_id', $user->id)->count() +
                    Sitter::where('user_id', $user->id)->count() +
                    LostPet::where('user_id', $user->id)->count();

        return response()->json([
            'saved' => SavedPost::where('user_id', $user->id)->count(),
            'sent' => ServiceRequest::where('sender_id', $user->id)->count(),
            'incoming' => ServiceRequest::where('receiver_id', $user->id)
                        ->where('status', 'pending')->count(),
            'posts' => $postsCount
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

    private function getModelClass($type)
    {
        return match ($type) {
            'adoption' => Adoption::class,
            'products' => Product::class,
            'sitters'  => Sitter::class,
            'lost-pets' => LostPet::class,
            default => throw new \Exception("Invalid type"),
        };
    }
}