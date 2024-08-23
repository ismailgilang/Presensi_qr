<?php

namespace App\Http\Controllers;

use App\Models\Barcode;
use App\Models\Presensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PresensiUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $presensiData = Presensi::where('nip', $user->nip)->get();

        // Get QR codes from Presensi and fetch titles from Barcode
        $qrCodes = $presensiData->pluck('qr');
        $barcodeTitles = Barcode::whereIn('id', $qrCodes)->pluck('judul', 'id')->toArray();

        return view('presensi.data', compact('presensiData', 'user', 'barcodeTitles'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        return view('presensi.presensi', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|string',
            'nip' => 'required|string',
            'role' => 'required|string',
            'qr' => 'required|string',
            'keterangan' => 'required|string',
        ]);

        // Periksa apakah QR code ada di tabel barcode
        $qrExists = Barcode::where('id', $request->qr)->exists();

        if (!$qrExists) {
            // QR code tidak ada di tabel barcode
            return response()->json(['success' => false, 'errors' => ['qr' => 'QR code tidak ditemukan.']]);
        }

        // Simpan data ke tabel presensi
        Presensi::create($validatedData);

        return response()->json(['success' => true]);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
