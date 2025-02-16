<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller {


    public function index(): JsonResponse
    {
        $reviews = Review::all();
        return response()->json($reviews);
    }

    public function store(Request $request) {
      
        $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string',
        ]);
     
         
        $review = Review::create([
            'user_id' => auth()->id(),
            'movie_id' => $request->movie_id,
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        return response()->json([
            'message' => 'Review created successfully',
            'review' => $review,
        ], 201);
    }
}