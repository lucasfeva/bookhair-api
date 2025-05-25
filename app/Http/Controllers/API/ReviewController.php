<?php

namespace App\Http\Controllers\API;

use App\Models\Review;
use App\Models\Barbearia;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(int $barbeariaId): JsonResponse
    {
        Barbearia::findOrFail($barbeariaId);

        $reviews = Review::where('barbearia_id', $barbeariaId)
            ->with('user:id,name')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json($reviews);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'barbearia_id' => 'required|exists:barbearias,id',
            'nota' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string|max:500',
        ]);

        $review = Review::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'barbearia_id' => $request->barbearia_id
            ],
            [
                'nota' => $request->nota,
                'comentario' => $request->comentario,
            ]
        );

        return response()->json($review->load('user'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Review $review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $review = Review::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $review->delete();

        return response()->json(['message' => 'Review removido']);
    }
}
