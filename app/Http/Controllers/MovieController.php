<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;

class MovieController extends Controller
{
    public function index(): JsonResponse
    {
        $movies = Movie::all()->map(function ($movie) {
            return $movie->toArray() + ['poster_url' => $movie->poster_url];
        });

        return response()->json($movies);
    }

    public function show($id): JsonResponse
    {
        $movie = Movie::with('reviews')->findOrFail($id);

        return response()->json($movie->toArray() + ['poster_url' => $movie->poster_url]);
    }

    public function getReviews($movieId)
    {
        $movie = Movie::findOrFail($movieId);
        return response()->json($movie->reviews);
    }

    public function store(Request $request): JsonResponse
    {
        $this->authorize('isAdmin', User::class);

        $validatedData = $request->validate([
            'title' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'director' => 'required|string',
            'release_date' => 'required|date',
            'synopsis' => 'required|string',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $posterPath = null;
        if ($request->hasFile('poster')) {
            $posterPath = $request->file('poster')->store('posters', 'public');
        }

        $movie = Movie::create(array_merge($validatedData, ['poster' => $posterPath]));

        return response()->json($movie->toArray() + ['poster_url' => $movie->poster_url], 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $this->authorize('isAdmin', User::class);

        $movie = Movie::findOrFail($id);

        $validatedData = $request->validate([
            'title' => 'sometimes|string',
            'category_id' => 'sometimes|exists:categories,id',
            'director' => 'sometimes|string',
            'release_date' => 'sometimes|date',
            'synopsis' => 'sometimes|string',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('poster')) {
            if ($movie->poster && Storage::disk('public')->exists($movie->poster)) {
                Storage::disk('public')->delete($movie->poster);
            }

            $posterPath = $request->file('poster')->store('posters', 'public');
            $validatedData['poster'] = $posterPath;
        }

        $movie->update($validatedData);

        return response()->json($movie->toArray() + ['poster_url' => $movie->poster_url]);
    }

    public function destroy($id): JsonResponse
    {
        $this->authorize('isAdmin', User::class);

        $movie = Movie::findOrFail($id);

        if ($movie->poster && Storage::disk('public')->exists($movie->poster)) {
            Storage::disk('public')->delete($movie->poster);
        }

        $movie->delete();

        return response()->json(['message' => 'Movie deleted']);
    }
}
