<?php

namespace App\Http\Controllers;

use App\Models\Barcode;
use App\Models\Presensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PresensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $data = Barcode::all();
        return view('presensi.index', compact('data', 'user'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $presensiData = Presensi::where('qr', $id)->get();
        $judul = Barcode::findOrFail($id);


        // Pisahkan data berdasarkan status 'masuk' dan 'pulang'
        $masuk = $presensiData->where('keterangan', 'masuk');
        $pulang = $presensiData->where('keterangan', 'pulang');

        return view('presensi.show', compact('masuk', 'pulang', 'judul'));
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
