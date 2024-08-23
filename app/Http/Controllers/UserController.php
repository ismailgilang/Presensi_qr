<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $data = User::all();
        return view('user.index', compact('data', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string',
            'password' => 'required|string',
            'role' => 'required|string'
        ]);

        // Create a new User record using all data from the request
        User::create($validatedData);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
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
        $user = Auth::user();
        $data = User::findOrFail($id);
        return view('user.edit', compact('data', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string',
            'password' => 'required|string',
            'role' => 'required|string'
        ]);

        $user = User::findOrFail($id);
        $user->update($request->only('name', 'email', 'password', 'role'));

        return redirect()->route('User.index', $id)->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        // Check if the record exists
        if ($user) {
            // Delete the record
            $user->delete();
            // Redirect back with a success message
            return redirect()->back()->with('success', 'Data berhasil dihapus!');
        } else {
            // Redirect back with an error message if not found
            return redirect()->back()->with('error', 'Data tidak ditemukan!');
        }
    }
}
