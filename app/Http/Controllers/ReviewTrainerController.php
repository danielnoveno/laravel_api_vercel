<?php

namespace App\Http\Controllers;

use App\Models\ReviewTrainer;
use Illuminate\Http\Request;

class ReviewTrainerController extends Controller
{
    /**
     * Display a listing of the reviews.
     */
    public function index(Request $request)
    {
        try {
            $query = ReviewTrainer::query();

            // Pencarian berdasarkan review
            if ($request->has('search')) {
                $search = $request->search;
                $query->where('review', 'like', "%{$search}%");
            }

            $reviews = $query->with(['trainer', 'pelanggan'])->get();

            return response()->json([
                'status' => true,
                'message' => 'Reviews fetched successfully',
                'data' => $reviews
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error fetching data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created review.
     */
    public function store(Request $request)
    {
        try {
            // Validasi data input
            $validated = $request->validate([
                'id_trainer' => 'required|exists:trainers,id_trainer',
                'id_pelanggan' => 'required|exists:pelanggans,id_pelanggan',
                'tanggal_review' => 'required|date',
                'review' => 'required|string',
            ]);

            // Membuat review baru
            $review = ReviewTrainer::create($validated);

            return response()->json([
                'status' => true,
                'message' => 'Review created successfully',
                'data' => $review
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error storing data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified review.
     */
    public function show($id)
    {
        try {
            $review = ReviewTrainer::with(['trainer', 'pelanggan'])->find($id);

            if ($review) {
                return response()->json([
                    'status' => true,
                    'message' => 'Review found',
                    'data' => $review
                ], 200);
            }

            return response()->json([
                'status' => false,
                'message' => 'Review not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error fetching data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified review.
     */
    public function update(Request $request, $id)
    {
        try {
            $review = ReviewTrainer::find($id);

            if ($review) {
                // Validasi data input
                $validated = $request->validate([
                    'id_trainer' => 'sometimes|required|exists:trainers,id_trainer',
                    'id_pelanggan' => 'sometimes|required|exists:pelanggans,id_pelanggan',
                    'tanggal_review' => 'sometimes|required|date',
                    'review' => 'sometimes|required|string',
                ]);

                // Update data review
                $review->update($validated);

                return response()->json([
                    'status' => true,
                    'message' => 'Review updated successfully',
                    'data' => $review
                ], 200);
            }

            return response()->json([
                'status' => false,
                'message' => 'Review not found'
            ], 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error updating data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified review.
     */
    public function destroy($id)
    {
        try {
            $review = ReviewTrainer::find($id);

            if ($review) {
                $review->delete();

                return response()->json([
                    'status' => true,
                    'message' => 'Review deleted successfully'
                ], 200);
            }

            return response()->json([
                'status' => false,
                'message' => 'Review not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error deleting data',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
