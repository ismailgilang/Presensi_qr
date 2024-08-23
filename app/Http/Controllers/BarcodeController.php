<?php

namespace App\Http\Controllers;

use App\Models\Barcode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BarcodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user(); // Mendapatkan pengguna yang sedang login
        $data = Barcode::all(); // Mengambil semua data dari model Barcode
        return view('barcode.index', compact('data', 'user')); // Mengirim data ke view
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'keterangan' => 'required|string',
        ]);

        // Create a new Barcode record using all data from the request
        Barcode::create($validatedData);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $barcode = Barcode::find($id);
        $user = Auth::user();

        if (!$barcode) {
            abort(404, 'Barcode not found');
        }

        // Generate QR code URL using QR Code API
        $qrCodeUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($barcode->id);

        return view('barcode.show', compact('barcode', 'qrCodeUrl', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $barcode = Barcode::findOrFail($id);
        $user = Auth::user();
        return view('barcode.edit', compact('barcode', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        $barcode = Barcode::findOrFail($id);
        $barcode->update($request->only('judul', 'deskripsi', 'keterangan'));

        return redirect()->route('Barcode.index', $id)->with('success', 'Barcode updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $barcode = Barcode::find($id);

        // Check if the record exists
        if ($barcode) {
            // Delete the record
            $barcode->delete();
            // Redirect back with a success message
            return redirect()->back()->with('success', 'Data berhasil dihapus!');
        } else {
            // Redirect back with an error message if not found
            return redirect()->back()->with('error', 'Data tidak ditemukan!');
        }
    }
}
