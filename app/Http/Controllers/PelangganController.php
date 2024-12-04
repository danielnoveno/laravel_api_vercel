<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PelangganController extends Controller
{
    /**
     * Display a listing of Pelanggans.
     */
    public function index()
    {
        $pelanggans = Pelanggan::all();
        return response()->json($pelanggans);
    }

    /**
     * Store a newly created Pelanggan in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'umur' => 'required|integer',
            'alamat' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:pelanggans',
            'password' => 'required|string|min:8',
            'tanggal_daftar' => 'required|date',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        $pelanggan = Pelanggan::create($validatedData);

        return response()->json(['message' => 'Pelanggan created successfully', 'data' => $pelanggan], 201);
    }

    /**
     * Display the specified Pelanggan.
     */
    public function show($id)
    {
        $pelanggan = Pelanggan::find($id);

        if (!$pelanggan) {
            return response()->json(['message' => 'Pelanggan not found'], 404);
        }

        return response()->json($pelanggan);
    }

    /**
     * Update the specified Pelanggan in storage.
     */
    public function update(Request $request, $id)
    {
        $pelanggan = Pelanggan::find($id);

        if (!$pelanggan) {
            return response()->json(['message' => 'Pelanggan not found'], 404);
        }

        $validatedData = $request->validate([
            'nama' => 'sometimes|string|max:255',
            'umur' => 'sometimes|integer',
            'alamat' => 'sometimes|string|max:255',
            'no_telepon' => 'sometimes|string|max:15',
            'email' => 'sometimes|string|email|max:255|unique:pelanggans,email,' . $id . ',id_pelanggan',
            'password' => 'sometimes|string|min:8',
            'tanggal_daftar' => 'sometimes|date',
        ]);

        if ($request->has('password')) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        $pelanggan->update($validatedData);

        return response()->json(['message' => 'Pelanggan updated successfully', 'data' => $pelanggan]);
    }

    /**
     * Remove the specified Pelanggan from storage.
     */
    public function destroy($id)
    {
        $pelanggan = Pelanggan::find($id);

        if (!$pelanggan) {
            return response()->json(['message' => 'Pelanggan not found'], 404);
        }

        $pelanggan->delete();

        return response()->json(['message' => 'Pelanggan deleted successfully']);
    }


    /**
     * Register a new pelanggan.
     */
    public function register(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'umur' => 'required|integer',
                'alamat' => 'required|string|max:255',
                'no_telepon' => 'required|string|max:15',
                'email' => 'required|email|unique:pelanggans,email',
                'password' => 'required|string|min:8',
            ]);

            // Hash the password
            $validated['password'] = bcrypt($validated['password']);

            $pelanggan = Pelanggan::create($validated);

            return response()->json([
                'status' => true,
                'message' => 'Registration successful',
                'data' => $pelanggan,
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error during registration',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Login pelanggan.
     */
    public function login(Request $request)
{
    try {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $pelanggan = Pelanggan::where('email', $validated['email'])->first();

        if ($pelanggan && Hash::check($validated['password'], $pelanggan->password)) {
            $token = $pelanggan->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status' => true,
                'message' => 'Login successful',
                'data' => [
                    'pelanggan' => $pelanggan,
                    'token' => $token,
                ],
            ], 200);
        }

        return response()->json(['status' => false, 'message' => 'Invalid email or password'], 401);
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'status' => false,
            'message' => 'Validation failed',
            'errors' => $e->errors(),
        ], 422);
    } catch (\Exception $e) {
        return response()->json(['status' => false, 'message' => 'Error during login', 'error' => $e->getMessage()], 500);
    }
}

}
