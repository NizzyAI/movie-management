<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Http\JsonResponse;

class MovieController extends Controller
{
    
    public function index(): JsonResponse
    {
        $movies = Movie::all();
        return response()->json($movies);
    }

    
    public function show($id): JsonResponse
    {
        $movie = Movie::find($id);

        if (!$movie) {
            return response()->json(['message' => 'Movie not found'], 404);
        }

        return response()->json($movie);
    }

    public function store(Request $request): JsonResponse
    {
        
        $this->authorize('isAdmin', User::class);

       
        $request->validate([
            'title' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'director' => 'required|string',
            'release_date' => 'required|date',
            'synopsis' => 'required|string',
            'poster' => 'nullable|image|max:2048',
        ]);

      
        $imagePath = null;
        if ($request->hasFile('poster')) {
            $imagePath = $request->file('poster')->store('posters', 'public');
        }

       
        $movie = Movie::create([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'director' => $request->director,
            'release_date' => $request->release_date,
            'synopsis' => $request->synopsis,
            'poster' => $imagePath,
        ]);

        return response()->json($movie, 201);
    }

   
    public function update(Request $request, $id): JsonResponse
    {
       
        $this->authorize('isAdmin', User::class);

      
        $movie = Movie::find($id);

        if (!$movie) {
            return response()->json(['message' => 'Movie not found'], 404);
        }

        
        $request->validate([
            'title' => 'sometimes|string',
            'category_id' => 'sometimes|exists:categories,id',
            'director' => 'sometimes|string',
            'release_date' => 'sometimes|date',
            'synopsis' => 'sometimes|string',
            'poster' => 'nullable|image|max:2048',
        ]);

        
        if ($request->hasFile('poster')) {
           
            if ($movie->poster && Storage::disk('public')->exists($movie->poster)) {
                Storage::disk('public')->delete($movie->poster);
            }

          
            $imagePath = $request->file('poster')->store('posters', 'public');
            $movie->poster = $imagePath;
        }

        $movie->title = $request->input('title', $movie->title);
        $movie->category_id = $request->input('category_id', $movie->category_id);
        $movie->director = $request->input('director', $movie->director);
        $movie->release_date = $request->input('release_date', $movie->release_date);
        $movie->synopsis = $request->input('synopsis', $movie->synopsis);

        $movie->save();

        return response()->json($movie);
    }

  
    public function destroy($id): JsonResponse
    {
     
        $this->authorize('isAdmin', User::class);

      
        $movie = Movie::find($id);

        if (!$movie) {
            return response()->json(['message' => 'Movie not found'], 404);
        }

        
        if ($movie->poster && Storage::disk('public')->exists($movie->poster)) {
            Storage::disk('public')->delete($movie->poster);
        }

      
        $movie->delete();

        return response()->json(['message' => 'Movie deleted']);
    }
}