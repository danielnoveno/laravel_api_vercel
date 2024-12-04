<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = Layanan::query();

            // Pencarian berdasarkan nama_layanan (optional)
            if ($request->has('search')) {
                $search = $request->search;
                $query->where('nama_layanan', 'like', "%{$search}%");
            }

            $data = $query->get();

            return response()->json([
                'status' => true,
                'message' => 'Get successful',
                'data' => $data
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
                'nama_layanan' => 'required|string'
            ]);

            // Menyimpan data layanan
            $layanan = Layanan::create($validated);

            return response()->json([
                'status' => true,
                'message' => 'Create successful',
                'data' => $layanan
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
            $layanan = Layanan::findOrFail($id);

            return response()->json([
                'status' => true,
                'message' => 'Get successful',
                'data' => $layanan
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Layanan not found',
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
            $layanan = Layanan::findOrFail($id);

            // Validasi input
            $validated = $request->validate([
                'nama_layanan' => 'sometimes|required|string'
            ]);

            $layanan->update($validated);

            return response()->json([
                'status' => true,
                'message' => 'Update successful',
                'data' => $layanan
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
            $layanan = Layanan::findOrFail($id);
            $layanan->delete();

            return response()->json([
                'status' => true,
                'message' => 'Delete successful'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Layanan not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }
}
