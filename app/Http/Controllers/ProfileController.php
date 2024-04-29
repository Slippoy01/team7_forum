<?php

namespace App\Http\Controllers;

use App\Models\Pertanyaan;
use App\Models\Profil;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $topik = Pertanyaan::with([
            'kategori',
            'user',
            'jawaban',
            'countjawaban' => function ($q) {
                $q->leftJoin('pertanyaan', 'pertanyaan.id', '=', 'jawaban.pertanyaan_id')
                    ->select([
                        'jawaban.pertanyaan_id',
                        DB::raw("count(jawaban.id) AS jml"),
                    ])
                    ->groupBy([
                        'jawaban.pertanyaan_id',
                    ]);
            }
        ])
            ->where('user_id', Auth::user()->id)
            ->select(['pertanyaan.*',])
            ->orderBy('waktu_publikasi', 'desc')
            ->get();

        return view('profile.index', [
            'topik' => $topik,
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
        $this->validate($request, [
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore(Auth::user()->id, 'id')],
            'umur'      => ['required', 'numeric'],
            'biodata'   => ['required', 'string', 'max:255'],
            'alamat'    => ['required', 'string'],
        ]);

        User::where('id', Auth::user()->id)->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        if ($request->password) {
            User::where('id', Auth::user()->id)->update([
                'password' => Hash::make($request->password),
            ]);
        }

        Profil::where('user_id', Auth::user()->id)->update([
            'umur'      => $request->umur,
            'biodata'   => $request->biodata,
            'alamat'    => $request->alamat,
            'email'     => $request->email,
        ]);

        return redirect('/profile');
    }
}
