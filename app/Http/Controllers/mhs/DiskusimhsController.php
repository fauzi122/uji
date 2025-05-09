<?php

namespace App\Http\Controllers\mhs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Diskusi;
use App\Models\Komentar;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class DiskusimhsController extends Controller
{
    public function __construct()
    {
        if (!$this->middleware('auth:sanctum')) {
            return redirect('/login');
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        // 0 => "21.1A.12"
        // 1 => "064"
        // 2 => "202007129"
        $request = explode(",", Crypt::decryptString($id));
        $where = ['a.kd_lokal' => $request[0], 'a.kd_mtk' => $request[1]];
        $chat = app('App\Models\Diskusi')->chat($where);
        return view('mhs.forum.form_diskusimhs', ['id' => $id, 'request' => $request, 'chat' => $chat]);
    }

    public function komentar($kombinasi)
    {
        // dd($request->id_chat);
        $exp = explode(",", Crypt::decryptString($kombinasi));
        $cek = app('App\Models\Diskusi')->komentar($exp[0]);
        $komentar = app('App\Models\Diskusi')->komentar($exp[0]);
        // $explod = explode(",",Crypt::decryptString($request->id));
        $where = ['a.id_chat' => $exp[0]];
        $chat = app('App\Models\Diskusi')->chat($where);
        return view('mhs.forum.form_komentarmhs', ['id' => $exp[1], 'komentar' => $komentar->get(), 'chat' => $chat, 'kombinasi' => $kombinasi]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_diskusi(Request $request)
    {
        $file = $request->file('file');
        if (isset($file)) {
            $file->storeAs('public/diskusi', $file->hashName());
            $request->validate([
                'chat' => 'required',
                'judul' => 'required',
                'file' => 'file|mimes:pdf|max:2000',
            ]);
            $simpan = Diskusi::create([
                'kd_mtk' => $request->kd_mtk,
                'kd_lokal' => $request->kd_lokal,
                'user' => Auth::user()->username,
                'judul' => $request->judul,
                'chat' => $request->chat,
                'file' => $file->hashName()
            ]);
        } else {
            $request->validate([
                'chat' => 'required',
                'judul' => 'required',
            ]);
            $simpan = Diskusi::create([
                'kd_mtk' => $request->kd_mtk,
                'kd_lokal' => $request->kd_lokal,
                'user' => Auth::user()->username,
                'judul' => $request->judul,
                'chat' => $request->chat
            ]);
        }



        $id = Crypt::encryptString($request->kd_lokal . ',' . $request->kd_mtk . ',' . Auth::user()->username);
        if ($simpan) {
            return redirect('/form-diskusimhs/' . $id)->with('status', 'Ditambahkan');
        } else {
            return redirect('/form-diskusimhs/' . $id)->with('eror', 'Gagal Ditambahkan');
        }
    }
    public function store_komen(Request $request)
    {
        $simpan = Komentar::create([
            'id_chat' => $request->id_chat,
            'user_komentar' => Auth::user()->username,
            'komentar' => $request->komentar
        ]);
        if ($simpan) {
            return redirect('/form-komentarmhs/' . $request->id)->with('status', 'Ditambahkan');
        } else {
            return redirect('/form-komentarmhs/' . $request->id)->with('eror', 'Gagal Ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy_diskusi(Request $request, $id)
    {
        // dd($id);
        // Diskusi::destroy(['id_chat'=>$request->id_chat]);
        Komentar::where(['id_chat' => $request->id_chat])->delete();
        $diskusi = Diskusi::select('file')
            ->where(['id_chat' => $request->id_chat])->first();
        if ($diskusi->file <> '' || $diskusi->file <> null) {
            Storage::delete('public/diskusi/' . $request->file);
        }
        Diskusi::where(['id_chat' => $request->id_chat])->delete();
        return redirect('/form-diskusimhs/' . $request->id)->with('status', 'Data Diskusi Dihapus');
    }

    public function download_file_diskusi(Request $request)
    {
        $files = public_path() . '/storage/diskusi/' . $request->file; //Mencari file dari model yang sudah dicari
        if (file_exists($files)) {
            return response()->download($files, $request->file);
        } else {
            echo "kosong";
        }

        // dd($file);
        // $model_file = Absen_ajar::findOrFail($id); //Mencari model atau objek yang dicari
    }
}
