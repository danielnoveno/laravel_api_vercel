<?php

namespace App\Http\Controllers;

use App\Models\JenisMembership;
use Illuminate\Http\Request;

class JenisMembershipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = JenisMembership::query();

            if ($request->has('search')) {
                $query->where('nama_jenis_membership', 'like', '%' . $request->search . '%');
            }

            $jenisMemberships = $query->get();

            return response()->json([
                'status' => true,
                'message' => 'Jenis Membership fetched successfully',
                'data' => $jenisMemberships
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
            // Validasi input
            $validated = $request->validate([
                'nama_jenis_membership' => 'required|string|max:255',
                'harga_membership' => 'required|numeric',
                'jadwal' => 'required|string|max:255',
                'durasi' => 'required|integer',
                'deskripsi' => 'required|string',
            ]);

            // Membuat data jenis membership baru
            $jenisMembership = JenisMembership::create($validated);

            return response()->json([
                'status' => true,
                'message' => 'Jenis Membership created successfully',
                'data' => $jenisMembership
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
            $jenisMembership = JenisMembership::findOrFail($id);

            return response()->json([
                'status' => true,
                'message' => 'Jenis Membership fetched successfully',
                'data' => $jenisMembership
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Jenis Membership not found',
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
                'nama_jenis_membership' => 'required|string|max:255',
                'harga_membership' => 'required|numeric',
                'jadwal' => 'required|string|max:255',
                'durasi' => 'required|integer',
                'deskripsi' => 'required|string',
            ]);

            $jenisMembership = JenisMembership::findOrFail($id);
            $jenisMembership->update($validated);

            return response()->json([
                'status' => true,
                'message' => 'Jenis Membership updated successfully',
                'data' => $jenisMembership
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
                'message' => 'Jenis Membership not found',
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
            $jenisMembership = JenisMembership::findOrFail($id);
            $jenisMembership->delete();

            return response()->json([
                'status' => true,
                'message' => 'Jenis Membership deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Jenis Membership not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }
}
