<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = Ruangan::query();

            // Pencarian berdasarkan kapasitas
            if ($request->has('search')) {
                $search = $request->input('search');
                $query->where('kapasitas', 'like', "%$search%");
            }

            $ruangans = $query->get();

            return response()->json([
                'status' => true,
                'message' => 'Get successful',
                'data' => $ruangans
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
                'kapasitas' => 'required|integer',
            ]);

            // Menyimpan ruangan
            $ruangan = Ruangan::create($validated);

            return response()->json([
                'status' => true,
                'message' => 'Create successful',
                'data' => $ruangan
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
            $ruangan = Ruangan::findOrFail($id);

            return response()->json([
                'status' => true,
                'message' => 'Get successful',
                'data' => $ruangan
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Ruangan not found',
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
            // Validasi input
            $validated = $request->validate([
                'kapasitas' => 'required|integer',
            ]);

            $ruangan = Ruangan::findOrFail($id);

            // Update ruangan
            $ruangan->update($validated);

            return response()->json([
                'status' => true,
                'message' => 'Update successful',
                'data' => $ruangan
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
                'message' => 'Ruangan not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $ruangan = Ruangan::findOrFail($id);
            $ruangan->delete();

            return response()->json([
                'status' => true,
                'message' => 'Delete successful'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Ruangan not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }
}
