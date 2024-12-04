<?php

namespace App\Http\Controllers;

use App\Models\Riwayat;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    /**
     * Display a listing of the history records.
     */
    public function index(Request $request)
    {
        try {
            $query = Riwayat::query();

            // Pencarian berdasarkan ID transaksi
            if ($request->has('search')) {
                $search = $request->search;
                $query->whereHas('detailTransaksi', function ($q) use ($search) {
                    $q->where('id_transaksi', 'like', "%{$search}%");
                });
            }

            $riwayat = $query->with(['detailTransaksi', 'layanan'])->get();

            return response()->json([
                'status' => true,
                'message' => 'Riwayat fetched successfully',
                'data' => $riwayat
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
     * Display the specified history record.
     */
    public function show($id)
    {
        try {
            $riwayat = Riwayat::with(['detailTransaksi', 'layanan'])->find($id);

            if ($riwayat) {
                return response()->json([
                    'status' => true,
                    'message' => 'Riwayat found',
                    'data' => $riwayat
                ], 200);
            }

            return response()->json([
                'status' => false,
                'message' => 'Riwayat not found'
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
     * Store a newly created history record.
     */
    public function store(Request $request)
    {
        try {
            // Validasi data input
            $validated = $request->validate([
                'id_detail_transaksi' => 'required|exists:detail_transaksis,id_detail_transaksi',
                'id_layanan' => 'required|exists:layanans,id_layanan',
                'tanggal_riwayat' => 'required|date',
                'jenis_layanan' => 'required|string',
            ]);

            // Membuat riwayat baru
            $riwayat = Riwayat::create($validated);

            return response()->json([
                'status' => true,
                'message' => 'Riwayat created successfully',
                'data' => $riwayat
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
     * Update the specified history record.
     */
    public function update(Request $request, $id)
    {
        try {
            $riwayat = Riwayat::find($id);

            if ($riwayat) {
                // Validasi data input
                $validated = $request->validate([
                    'id_detail_transaksi' => 'required|exists:detail_transaksis,id_detail_transaksi',
                    'id_layanan' => 'required|exists:layanans,id_layanan',
                    'tanggal_riwayat' => 'required|date',
                    'jenis_layanan' => 'required|string',
                ]);

                // Update riwayat
                $riwayat->update($validated);

                return response()->json([
                    'status' => true,
                    'message' => 'Riwayat updated successfully',
                    'data' => $riwayat
                ], 200);
            }

            return response()->json([
                'status' => false,
                'message' => 'Riwayat not found'
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
     * Remove the specified history record.
     */
    public function destroy($id)
    {
        try {
            $riwayat = Riwayat::find($id);

            if ($riwayat) {
                $riwayat->delete();

                return response()->json([
                    'status' => true,
                    'message' => 'Riwayat deleted successfully'
                ], 200);
            }

            return response()->json([
                'status' => false,
                'message' => 'Riwayat not found'
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
