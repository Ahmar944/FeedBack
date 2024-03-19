<?php

namespace App\Http\Controllers\API;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\User;
use App\Models\FeedbackComment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class FeedbackCommentController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'feedback_id' => 'required|exists:feedback,id',
            'user_id' => 'required|exists:users,id',
            'content' => 'required|string',
        ]);

        $comment = FeedbackComment::create($validatedData);

        return response()->json([
            'statusCode' => 200,
            'data' => $comment,
        ], 200);
    }

    public function index(Request $request)
    {
        try {
            $feedback_id = $request->query('feedback_id');
            $perPage = $request->input('perPage', 10); // Default per page is 10, you can change as needed
            $feedbackComments = FeedbackComment::with('user') // Eager load the 'user' relationship
                                ->where('feedback_id', $feedback_id)
                                ->paginate($perPage);
    
            return response()->json([
                'statusCode' => 200,
                'data' => $feedbackComments,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'message' => 'Internal server error.',
            ], 500);
        }
    }
    

    public function paginate($data, $perPage, $page)
    {
        // Create a new Laravel collection from the array data
        $collection = new Collection($data);
    
        // Slice the collection to get the items to display in the current page
        $currentPageResults = $collection->slice(($page - 1) * $perPage, $perPage)->values();
    
        // Get total number of items
        $totalItems = $collection->count();
    
        // Calculate total pages
        $totalPages = ceil($totalItems / $perPage);
    
        // Return paginated data along with pagination metadata
        return [
            'current_page' => $page,
            'data' => $currentPageResults,
            'from' => (($page - 1) * $perPage) + 1,
            'to' => min($page * $perPage, $totalItems),
            'total' => $totalItems,
            'per_page' => $perPage,
            'last_page' => $totalPages,
        ];
    }
}