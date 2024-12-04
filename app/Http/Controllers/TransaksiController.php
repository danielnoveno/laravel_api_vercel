<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the transactions.
     */
    public function index(Request $request)
    {
        try {
            $query = Transaksi::query();

            // Pencarian berdasarkan metode pembayaran atau status pembayaran
            if ($request->has('search')) {
                $search = $request->search;
                $query->where('metode_pembayaran', 'like', '%' . $search . '%')
                    ->orWhere('status_pembayaran', 'like', '%' . $search . '%');
            }

            $transaksis = $query->get();

            return response()->json([
                'status' => true,
                'message' => 'Transactions fetched successfully',
                'data' => $transaksis
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error fetching transactions',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created transaction.
     */
    public function store(Request $request)
    {
        try {
            // Validasi data input
            $validated = $request->validate([
                'tanggal_transaksi' => 'required|date',
                'jumlah_transaksi' => 'required|numeric',
                'metode_pembayaran' => 'required|string',
                'status_pembayaran' => 'required|string',
                'id_layanan' => 'required|exists:layanans,id_layanan',
                'id_pelanggan' => 'required|exists:pelanggans,id_pelanggan',
            ]);

            // Membuat transaksi baru
            $transaksi = Transaksi::create($validated);

            return response()->json([
                'status' => true,
                'message' => 'Transaction created successfully',
                'data' => $transaksi
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
                'message' => 'Error storing transaction',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified transaction.
     */
    public function show($id)
    {
        try {
            $transaksi = Transaksi::find($id);

            if ($transaksi) {
                return response()->json([
                    'status' => true,
                    'message' => 'Transaction found',
                    'data' => $transaksi
                ], 200);
            }

            return response()->json([
                'status' => false,
                'message' => 'Transaction not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error fetching transaction',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified transaction.
     */
    public function update(Request $request, $id)
    {
        try {
            $transaksi = Transaksi::find($id);

            if (!$transaksi) {
                return response()->json([
                    'status' => false,
                    'message' => 'Transaction not found'
                ], 404);
            }

            // Validasi data input
            $validated = $request->validate([
                'tanggal_transaksi' => 'required|date',
                'jumlah_transaksi' => 'required|numeric',
                'metode_pembayaran' => 'required|string',
                'status_pembayaran' => 'required|string',
            ]);

            // Update transaksi
            $transaksi->update($validated);

            return response()->json([
                'status' => true,
                'message' => 'Transaction updated successfully',
                'data' => $transaksi
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
                'message' => 'Error updating transaction',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified transaction.
     */
    public function destroy($id)
    {
        try {
            $transaksi = Transaksi::find($id);

            if (!$transaksi) {
                return response()->json([
                    'status' => false,
                    'message' => 'Transaction not found'
                ], 404);
            }

            $transaksi->delete();

            return response()->json([
                'status' => true,
                'message' => 'Transaction deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error deleting transaction',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
