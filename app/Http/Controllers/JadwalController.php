<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Ruangan;
use App\Models\Trainer;
use App\Models\KelasOlahraga;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $jadwals = Jadwal::with(['ruangan', 'trainer', 'kelasOlahraga'])->get();

            return response()->json([
                'status' => true,
                'message' => 'Get successful',
                'data' => $jadwals
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $ruangans = Ruangan::all();
            $trainers = Trainer::all();
            $kelasOlahragas = KelasOlahraga::all();

            return response()->json([
                'status' => true,
                'message' => 'Create form data fetched successfully',
                'data' => compact('ruangans', 'trainers', 'kelasOlahragas')
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error fetching form data',
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
                'tanggal' => 'required|date',
                'bulan' => 'required|integer',
                'tahun' => 'required|integer',
                'waktu' => 'required|date_format:H:i',
                'id_ruangan' => 'required|exists:ruangans,id_ruangan',
                'id_trainer' => 'required|exists:trainers,id_trainer',
            ]);

            // Menyimpan jadwal
            $jadwal = Jadwal::create($validated);

            // Menyinkronkan kelas olahraga jika ada
            if ($request->has('kelas_olahragas')) {
                $jadwal->kelasOlahraga()->sync($request->kelas_olahragas);
            }

            return response()->json([
                'status' => true,
                'message' => 'Jadwal created successfully',
                'data' => $jadwal
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
            $jadwal = Jadwal::with(['ruangan', 'trainer', 'kelasOlahraga'])->findOrFail($id);

            return response()->json([
                'status' => true,
                'message' => 'Jadwal fetched successfully',
                'data' => $jadwal
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Jadwal not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $jadwal = Jadwal::findOrFail($id);
            $ruangans = Ruangan::all();
            $trainers = Trainer::all();
            $kelasOlahragas = KelasOlahraga::all();

            return response()->json([
                'status' => true,
                'message' => 'Edit form data fetched successfully',
                'data' => compact('jadwal', 'ruangans', 'trainers', 'kelasOlahragas')
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error fetching edit form data',
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
            // Validasi input
            $validated = $request->validate([
                'tanggal' => 'required|date',
                'bulan' => 'required|integer',
                'tahun' => 'required|integer',
                'waktu' => 'required|date_format:H:i',
                'id_ruangan' => 'required|exists:ruangans,id_ruangan',
                'id_trainer' => 'required|exists:trainers,id_trainer',
            ]);

            $jadwal = Jadwal::findOrFail($id);
            $jadwal->update($validated);

            // Menyinkronkan kelas olahraga jika ada
            if ($request->has('kelas_olahragas')) {
                $jadwal->kelasOlahraga()->sync($request->kelas_olahragas);
            }

            return response()->json([
                'status' => true,
                'message' => 'Jadwal updated successfully',
                'data' => $jadwal
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
                'message' => 'Jadwal not found',
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
            $jadwal = Jadwal::findOrFail($id);
            $jadwal->delete();

            return response()->json([
                'status' => true,
                'message' => 'Jadwal deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Jadwal not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Search for jadwal based on parameters.
     */
    public function search(Request $request)
    {
        try {
            $query = Jadwal::query();

            // Filter berdasarkan tanggal, bulan, tahun
            if ($request->has('tanggal')) {
                $query->whereDate('tanggal', $request->tanggal);
            }

            if ($request->has('bulan')) {
                $query->where('bulan', $request->bulan);
            }

            if ($request->has('tahun')) {
                $query->where('tahun', $request->tahun);
            }

            $jadwals = $query->with(['ruangan', 'trainer', 'kelasOlahraga'])->get();

            return response()->json([
                'status' => true,
                'message' => 'Search results fetched successfully',
                'data' => $jadwals
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error performing search',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
