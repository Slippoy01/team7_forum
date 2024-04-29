<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_kategori = Kategori::all();
        return view('kategori.index', compact('data_kategori'));
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
        $this->validate($request, [
            'nama' => 'unique:kategori|required'
        ]);

        Kategori::create([
            'nama' => $request->nama
        ]);
        $data_kategori = Kategori::all();
        return view('kategori.index', compact('data_kategori'));
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
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'unique:kategori|required'
        ]);

        // Update the Kategori if validation passes
        $kategori = Kategori::find($id);
        $kategori->nama = $request->nama;
        $kategori->update();

        return redirect('kategori');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kategori = Kategori::find($id);
        $kategori->delete();
        return redirect('kategori');
    }
}
