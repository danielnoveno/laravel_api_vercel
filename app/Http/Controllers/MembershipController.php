<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MembershipController extends Controller
{
    /**
     * Menampilkan daftar semua memberships.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $memberships = Membership::all();
        return response()->json($memberships);
    }

    /**
     * Menampilkan detail membership berdasarkan ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $membership = Membership::find($id);

        if (!$membership) {
            return response()->json(['message' => 'Membership not found'], 404);
        }

        return response()->json($membership);
    }

    /**
     * Membuat membership baru.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|string|max:255',
            'duration' => 'required|string|max:255',  // duration sebagai string
        ]);

        // Membuat data membership baru
        $membership = Membership::create([
            'title' => $request->title,
            'image' => $request->image,
            'duration' => $request->duration, // Menyimpan duration dalam string
        ]);

        // Mengembalikan response berupa data membership yang baru
        return response()->json($membership, 201);
    }

    /**
     * Mengupdate data membership yang sudah ada.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $membership = Membership::find($id);

        if (!$membership) {
            return response()->json(['message' => 'Membership not found'], 404);
        }

        // Validasi input
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|string|max:255',
            'duration' => 'required|string|max:255',  // duration sebagai string
        ]);

        // Mengupdate data membership
        $membership->update([
            'title' => $request->title,
            'image' => $request->image,
            'duration' => $request->duration,  // Mengupdate duration sebagai string
        ]);

        // Mengembalikan response berupa data membership yang sudah diupdate
        return response()->json($membership);
    }

    /**
     * Menghapus membership berdasarkan ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $membership = Membership::find($id);

        if (!$membership) {
            return response()->json(['message' => 'Membership not found'], 404);
        }

        // Menghapus membership
        $membership->delete();

        // Mengembalikan response sukses
        return response()->json(['message' => 'Membership deleted successfully']);
    }

    /**
     * Mengambil URL gambar menggunakan Storage::url
     *
     * @param string $imageName
     * @return \Illuminate\Http\JsonResponse
     */
    public function getImageUrl($imageName)
    {
        $imagePath = 'storage/images/' . $imageName;
        if (Storage::exists($imagePath)) {
            $url = asset(Storage::url($imagePath));
            return response()->json(['url' => $url]);
        }
        return response()->json(['message' => 'Image not found'], 404);
    }
}
