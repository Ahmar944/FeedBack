<?php

namespace App\Http\Controllers\API;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class FeedbackController extends Controller
{
    

    public function index(Request $request)
    {
        $perPage = $request->input('size'); // Default per page value is 15
        $feedback = Feedback::paginate($perPage);
        return response()->json([
            'statusCode' => 200,
            'data' => $feedback,
        ], 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'category' => 'required|string',
            'user_name' => 'required|string',
            'user_email' => 'required|string',
        ]);

        $feedback = Feedback::create($validatedData + ['user_id' => auth()->id()]);

        return response()->json([
            'status' => 'success',
            'statusCode' => Response::HTTP_OK,
            'data' => $feedback
        ], Response::HTTP_OK);
    }

    
    public function show(Request $request)
    {
        // Retrieve request parameters
        $perPage = $request->input('per_page', 10); // Number of items per page, default is 10
        $page = $request->input('page', 1); // Current page, default is 1
    
        // Retrieve all feedback items
        $feedbacks = Feedback::all();
    
        // Paginate the feedback items
        $paginatedFeedbacks = $this->paginate($feedbacks, $perPage, $page);
    
        return response()->json($paginatedFeedbacks);
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
    public function update(Request $request, Feedback $feedback)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'category' => 'required|string',
        ]);

        $feedback->update($validatedData);

        return response()->json($feedback, 200);
    }

    public function destroy(Request $request)
    {
        try {
            $id = $request->input('feedback_id');
        
            $feedback = Feedback::findOrFail($id);
            $feedback->delete();
        
            return response()->json([
                'message' => 'Feedback deleted successfully',
                'deleted_feedback' => $feedback
            ], Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'No feedback found with the specified ID',
            ], Response::HTTP_NOT_FOUND);
        }
    }
}