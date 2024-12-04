<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use Illuminate\Http\Request;

class DetailTransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = DetailTransaksi::query();

            if ($request->has('search')) {
                $query->whereHas('transaksi', function ($q) use ($request) {
                    $q->where('id_transaksi', 'like', '%' . $request->search . '%');
                });
            }

            $detailTransaksi = $query->with(['transaksi', 'layanan'])->get();

            return response()->json([
                'status' => true,
                'message' => 'Detail Transaksi fetched successfully',
                'data' => $detailTransaksi
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
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $detailTransaksi = DetailTransaksi::with(['transaksi', 'layanan'])->findOrFail($id);

            return response()->json([
                'status' => true,
                'message' => 'Detail Transaksi fetched successfully',
                'data' => $detailTransaksi
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Detail Transaksi not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'id_transaksi' => 'required|exists:transaksis,id_transaksi',
                'id_layanan' => 'required|exists:layanans,id_layanan',
            ]);

            // Menyimpan detail transaksi
            $detailTransaksi = DetailTransaksi::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Detail Transaksi created successfully',
                'data' => $detailTransaksi
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            // Validasi input
            $request->validate([
                'id_transaksi' => 'required|exists:transaksis,id_transaksi',
                'id_layanan' => 'required|exists:layanans,id_layanan',
            ]);

            $detailTransaksi = DetailTransaksi::findOrFail($id);
            $detailTransaksi->update($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Detail Transaksi updated successfully',
                'data' => $detailTransaksi
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
                'message' => 'Detail Transaksi not found',
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
            $detailTransaksi = DetailTransaksi::findOrFail($id);
            $detailTransaksi->delete();

            return response()->json([
                'status' => true,
                'message' => 'Detail Transaksi deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Detail Transaksi not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }
}
