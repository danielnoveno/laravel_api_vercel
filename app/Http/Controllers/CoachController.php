<?php

namespace App\Http\Controllers;

use App\Models\Coach;
use Illuminate\Http\Request;

class CoachController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = Coach::query();

            // Pencarian berdasarkan nama_coach
            if ($request->has('search')) {
                $search = $request->input('search');
                $query->where('nama_coach', 'like', "%$search%");
            }

            $coaches = $query->get();

            return response()->json([
                'status' => true,
                'message' => 'Get successful',
                'data' => $coaches
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'nama_coach' => 'required|string|max:255',
            ]);

            // Menyimpan coach
            $coach = Coach::create($validated);

            return response()->json([
                'status' => true,
                'message' => 'Create successful',
                'data' => $coach
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
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $coach = Coach::findOrFail($id);

            return response()->json([
                'status' => true,
                'message' => 'Get successful',
                'data' => $coach
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Coach not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $coach = Coach::findOrFail($id);

            // Validasi input
            $validated = $request->validate([
                'nama_coach' => 'required|string|max:255',
            ]);

            // Update coach
            $coach->update($validated);

            return response()->json([
                'status' => true,
                'message' => 'Update successful',
                'data' => $coach
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $coach = Coach::findOrFail($id);
            $coach->delete();

            return response()->json([
                'status' => true,
                'message' => 'Delete successful'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Coach not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }
}
