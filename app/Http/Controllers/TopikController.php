<?php

namespace App\Http\Controllers;
use App\Models\Jawaban;
use App\Models\Pertanyaan;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class TopikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userTopik = Pertanyaan::with('kategori')->where('user_id', auth()->user()->id)->get();
        // Return the view with the user's "Topik" data
        return view('topik.viewTopik', compact('userTopik'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategori = Kategori::all();
        return view('topik.create', compact('kategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'tag' => 'required|string',
            'deskripsi' => 'required|string',
            'publik' => 'required|in:Ya,Tidak',
            'kategori_id' => 'required|exists:kategori,id',
            'user_id' => 'required|exists:users,id',
            'stat_publikasi' => 'required|in:Ya,Tidak',
        ]);
        $request->merge(['stat_selesai' => 'Tidak']);
        // Create the Topik if validation passes
        $topik = new Pertanyaan();
        $topik->judul = $request->judul;
        $topik->slug = Str::slug($request->judul);
        $topik->tag = $request->tag;
        $topik->deskripsi = $request->deskripsi;
        $topik->publik = $request->publik;
        $topik->kategori_id = $request->kategori_id;
        $topik->user_id = $request->user_id;
        $topik->stat_publikasi = $request->stat_publikasi;
        $topik->waktu_publikasi = date('Y-m-d H:i:s');
        $topik->stat_selesai = $request->stat_selesai;
        $topik->save();

        $this->uploadFile($request, $topik->id);

        return redirect('home');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Pertanyaan::with([
            'jawaban' => function ($q) {
                $q->join('users', 'users.id', '=', 'jawaban.user_id')
                    ->leftJoin('votejawaban', 'votejawaban.jawaban_id', '=', 'jawaban.id')
                    ->select([
                        'jawaban.id',
                        'jawaban.deskripsi',
                        'jawaban.main_id',
                        'jawaban.pertanyaan_id',
                        'jawaban.user_id',
                        'jawaban.created_at',
                        DB::raw('users.name as nama_user'),
                        DB::raw("SUM(CASE WHEN votejawaban.vote = 'Up' THEN 1 ELSE 0 END) AS vote_up"),
                        DB::raw("SUM(CASE WHEN votejawaban.vote = 'Down' THEN 1 ELSE 0 END) AS vote_down"),
                    ])
                    ->where('jawaban.main_id', '0')
                    ->groupBy([
                        'jawaban.id',
                        'jawaban.deskripsi',
                        'jawaban.main_id',
                        'jawaban.pertanyaan_id',
                        'jawaban.user_id',
                        'jawaban.created_at',
                        DB::raw('users.name')
                    ])
                    ->orderBy('created_at', 'desc');
            }, 'user'
        ])->find($id);
        if (!$data) {
            return redirect('home');
        }
        $tanggapan = Jawaban::with(['user', 'vote',])
            ->leftJoin('votejawaban', 'votejawaban.jawaban_id', '=', 'jawaban.id')
            ->select([
                'jawaban.id',
                'jawaban.deskripsi',
                'jawaban.main_id',
                'jawaban.pertanyaan_id',
                'jawaban.user_id',
                'jawaban.created_at',
                DB::raw("SUM(CASE WHEN votejawaban.vote = 'Up' THEN 1 ELSE 0 END) AS vote_up"),
                DB::raw("SUM(CASE WHEN votejawaban.vote = 'Down' THEN 1 ELSE 0 END) AS vote_down"),
            ])
            ->where('jawaban.main_id', '>', '0')
            ->groupBy([
                'jawaban.id',
                'jawaban.deskripsi',
                'jawaban.main_id',
                'jawaban.pertanyaan_id',
                'jawaban.user_id',
                'jawaban.created_at',
            ])
            ->orderBy('created_at', 'asc')
            ->get();
        return view('topik.index', [
            'data'      => $data,
            'tanggapan' => $tanggapan
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $kategori = Kategori::all();
        $data = Pertanyaan::find($id);
        return view('topik.edit', [
            'kategori' => $kategori,
            'data' => $data,
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'judul' => 'required|string|max:255',
            'tag' => 'required|string',
            'deskripsi' => 'required|string',
            'publik' => 'required|in:Ya,Tidak',
            'kategori_id' => 'required|exists:kategori,id',
            'user_id' => 'required|exists:users,id',
            'stat_publikasi' => 'required|in:Ya,Tidak',
        ]);

        Pertanyaan::where('id', $id)->update([
            'judul'         => $request->judul,
            'slug'          => Str::slug($request->judul) ,
            'tag'           => $request->tag,
            'deskripsi'     => $request->deskripsi,
            'gambar'        => $request->gambar,
            'publik'        => $request->publik,

            'kategori_id'    => $request->kategori_id,
            'user_id'        => $request->user_id,

            'stat_publikasi' => $request->stat_publikasi,
            'waktu_publikasi'   => date('Y-m-d H:i:s')
        ]);

        $this->uploadFile($request, $id);

        return redirect('topik');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //

        Pertanyaan::find($id)->delete();
        return redirect('topik');
    }

    private function uploadFile($request, $id){
        if ($request->hasFile('gambar')) {
            if ($request->file('gambar')->isValid()) {

                $avatar = public_path('image-topik');
                if (!File::exists($avatar)) File::makeDirectory($avatar, 0777, true);

                $file = $request->file('gambar');
                $image = 'image-topik-' . $id . '.' . $file->getClientOriginalExtension();

                array_map('unlink', glob($avatar . "/image-topik-$id*"));

                $file->move($avatar, $image);


                Pertanyaan::find($id)->update([
                    'gambar' => $image,
                ]);
            }
        }
    }
}
