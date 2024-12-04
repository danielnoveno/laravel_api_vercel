<?php

namespace App\Http\Controllers;

use App\Models\KelasOlahraga;
use App\Models\Coach;
use Illuminate\Http\Request;

class KelasOlahragaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = KelasOlahraga::query();

            // Pencarian berdasarkan nama_olahraga dan deskripsi (optional)
            if ($request->has('search')) {
                $search = $request->input('search');
                $query->where('nama_olahraga', 'like', "%$search%")
                    ->orWhere('deskripsi', 'like', "%$search%");
            }

            $kelasOlahraga = $query->with(['coach', 'ruangan', 'jadwal'])->get();

            return response()->json([
                'status' => true,
                'message' => 'Get successful',
                'data' => $kelasOlahraga
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
                'nama_olahraga' => 'required|string|max:255',
                'kapasitas' => 'required|integer',
                'id_jadwal' => 'required|exists:jadwals,id_jadwal',
                'id_ruangan' => 'required|exists:ruangans,id_ruangan',
                'id_coach' => 'required|exists:coaches,id_coach',
                'deskripsi' => 'nullable|string',
            ]);

            // Menyimpan kelas olahraga
            $kelasOlahraga = KelasOlahraga::create($validated);

            return response()->json([
                'status' => true,
                'message' => 'Create successful',
                'data' => $kelasOlahraga
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
            $kelasOlahraga = KelasOlahraga::findOrFail($id);

            return response()->json([
                'status' => true,
                'message' => 'Get successful',
                'data' => $kelasOlahraga
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Kelas olahraga not found',
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
            $kelasOlahraga = KelasOlahraga::findOrFail($id);

            // Validasi input
            $validated = $request->validate([
                'nama_olahraga' => 'required|string|max:255',
                'kapasitas' => 'required|integer',
                'id_jadwal' => 'required|exists:jadwals,id_jadwal',
                'id_ruangan' => 'required|exists:ruangans,id_ruangan',
                'id_coach' => 'required|exists:coaches,id_coach',
                'deskripsi' => 'nullable|string',
            ]);

            // Update kelas olahraga
            $kelasOlahraga->update($validated);

            return response()->json([
                'status' => true,
                'message' => 'Update successful',
                'data' => $kelasOlahraga
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
            $kelasOlahraga = KelasOlahraga::findOrFail($id);
            $kelasOlahraga->delete();

            return response()->json([
                'status' => true,
                'message' => 'Delete successful'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Kelas olahraga not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }
}
