<?php

namespace App\Http\Controllers;

use App\Models\PersonalTrainer;
use Illuminate\Http\Request;

class PersonalTrainerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = PersonalTrainer::query();

            // Menambahkan pencarian
            if ($request->has('search')) {
                $query->where('nama_paket', 'like', '%' . $request->search . '%');
            }

            $personalTrainers = $query->get();

            return response()->json([
                'status' => true,
                'message' => 'Personal Trainers fetched successfully',
                'data' => $personalTrainers
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validasi data input
            $validated = $request->validate([
                'nama_paket' => 'required|string|max:255',
                'harga' => 'required|numeric',
                'deskripsi' => 'nullable|string|max:255',
            ]);

            // Membuat data personal trainer baru
            $personalTrainer = PersonalTrainer::create($validated);

            return response()->json([
                'status' => true,
                'message' => 'Personal Trainer created successfully',
                'data' => $personalTrainer
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
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $personalTrainer = PersonalTrainer::find($id);

            if ($personalTrainer) {
                return response()->json([
                    'status' => true,
                    'message' => 'Personal Trainer found',
                    'data' => $personalTrainer
                ], 200);
            }

            return response()->json([
                'status' => false,
                'message' => 'Personal Trainer not found'
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $personalTrainer = PersonalTrainer::find($id);

            if ($personalTrainer) {
                // Validasi data input
                $validated = $request->validate([
                    'nama_paket' => 'required|string|max:255',
                    'harga' => 'required|numeric',
                    'deskripsi' => 'nullable|string|max:255',
                ]);

                // Update data personal trainer
                $personalTrainer->update($validated);

                return response()->json([
                    'status' => true,
                    'message' => 'Personal Trainer updated successfully',
                    'data' => $personalTrainer
                ], 200);
            }

            return response()->json([
                'status' => false,
                'message' => 'Personal Trainer not found'
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
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $personalTrainer = PersonalTrainer::find($id);

            if ($personalTrainer) {
                $personalTrainer->delete();

                return response()->json([
                    'status' => true,
                    'message' => 'Personal Trainer deleted successfully'
                ], 200);
            }

            return response()->json([
                'status' => false,
                'message' => 'Personal Trainer not found'
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
