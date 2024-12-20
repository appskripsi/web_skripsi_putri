<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRatingRequest;
use App\Models\BookRating;
use Illuminate\Http\JsonResponse;

class BookRatingController extends Controller
{
    public function store(BookRatingRequest $request): JsonResponse
    {
        if ($request->ajax()) {
            $validated = $request->validated();

            $exist = BookRating::where('book_id', $validated['book_id'])
                ->where('student_id', $validated['student_id'])
                ->first();

            if ($exist) {
                return response()->json([
                    'code' => 400,
                    'message' => 'Sudah pernah memberikan rating!'
                ], 200);
            }

            if (BookRating::create($validated)) {
                return response()->json([
                    'code' => 201,
                    'message' => 'Berhasil memberikan rating!'
                ], 200);
            }

            return response()->json([
                'code' => 500,
                'message' => 'Exception'
            ], 500);
        }

        return response()->json([
            'code' => 400,
            'message' => 'Request must be with ajax'
        ], 400);
    }
}
