<?php

namespace App\Http\Controllers;

use App\Models\Jawaban;
use App\Models\VoteJawaban;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KomentarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $request->validate([
            'pertanyaan_id' => ['required', 'numeric'],
            'deskripsi'     => ['required'],
        ]);

        Jawaban::create([
            "deskripsi"     => $request->deskripsi,
            "main_id"       => ($request->main_id) ? $request->main_id : 0,
            "pertanyaan_id" => $request->pertanyaan_id,
            "user_id"       => Auth::user()->id,
        ]);
        $request->session()->flash('info', "Komentar berhasil ditambahkan!");

        return redirect()->back();
    }

    public function vote(Request $request)
    {
        $exist = VoteJawaban::where('user_id', Auth::user()->id)
            ->where('jawaban_id', $request->id)
            ->first();
        if ($exist && $exist->vote == $request->vote) {
            VoteJawaban::where('user_id', Auth::user()->id)
                ->where('jawaban_id', $request->id)
                ->delete();
        } else {
            VoteJawaban::updateOrCreate(
                [
                    'user_id'       => Auth::user()->id,
                    'jawaban_id'    => $request->id,
                ],
                [
                    'user_id'       => Auth::user()->id,
                    'jawaban_id'    => $request->id,
                    'vote'          => $request->vote,
                ]
            );
        }
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
        $request->validate([
            'id'            => ['required', 'numeric'],
            'pertanyaan_id' => ['required', 'numeric'],
            'deskripsi'     => ['required'],
        ]);

        $res = Jawaban::where('id', $request->id)->update([
            "deskripsi"     => $request->deskripsi,
            "main_id"       => ($request->main_id) ? $request->main_id : 0,
            "pertanyaan_id" => $request->pertanyaan_id,
            "user_id"       => Auth::user()->id,
        ]);
        $request->session()->flash('info', "Komentar berhasil ditambahkan!");

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        // Delete jawaban with main id
        Jawaban::where('user_id', Auth::user()->id)
            ->where('main_id', $id)
            ->delete();

        // Delete jawaban by ID 
        Jawaban::where('id', $id)
            ->where('user_id', Auth::user()->id)
            ->delete();
    }
}
