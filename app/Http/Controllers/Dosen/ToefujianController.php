<?php

namespace App\Http\Controllers\Dosen;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Imports\LatihanSoalpgImport;
use App\Imports\LatihanSoalEssayImport;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


use App\Models\DetailSoalEssay;
use App\Models\Distribusisoal;
use App\Models\Detailsoal;
use App\Models\Jadwal;
use App\Models\MateriToef;
use App\Models\Soal;
use App\Models\Kelas;

class ToefujianController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:toef.jadwal']);
        if (!$this->middleware('auth:sanctum')) {
            return redirect('/login');
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userKode = Auth::user()->kode;
    
        // Get list of codes from `toef_dosen` table
        $userKodeList = DB::table('toef_dosen')->pluck('kd_dosen'); 
    
        if ($userKodeList->contains($userKode)) {
            // If user code is in the list, get all soals with the specified joins
            $soals = Soal::leftJoin('mtk', 'soals.kd_mtk', '=', 'mtk.kd_mtk')
                ->leftJoin('toef_materi', 'soals.id', '=', 'toef_materi.id_soal')
                ->select(
                    'soals.*',
                    'mtk.nm_mtk',
                    'toef_materi.id as id_materi',
                    'toef_materi.file_path'
                )
                ->where('soals.toef', 1)
                ->orderBy('soals.id', 'asc')
                ->get();
        } else {
            // If user code is not in the list, filter `soals` by `kd_dosen`
            $soals = Soal::leftJoin('mtk', 'soals.kd_mtk', '=', 'mtk.kd_mtk')
                ->leftJoin('toef_materi', 'soals.id', '=', 'toef_materi.id_soal')
                ->select(
                    'soals.*',
                    'mtk.nm_mtk',
                    'toef_materi.id as id_materi',
                    'toef_materi.file_path'
                )
                ->where('soals.kd_dosen', $userKode)
                ->where('soals.toef', 1)
                ->get();
        }
    
        // Fetch detail soal information
        $detailsoal = app('App\Models\Soal')->jml_soal();
    
        // Return view with `soals` and `detailsoal` data
        return view('admin.latihanujian.toef.index', compact('soals', 'detailsoal'));
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kategori = DB::table('toef_kategori')->get();
        // $materis = Jadwal::where('kd_dosen', Auth::user()->kode)
        //     ->groupBy('kd_mtk')
        //     ->get();
        return view('admin.latihanujian.toef.create',compact('kategori'));
    }
    public function create_pilih($id)
    {
        
        $pecah = explode(',', Crypt::decryptString($id));
        $soal = Soal::where([
            'soals.id'      => $pecah[0]
        ])->first();
        return view('admin.soal.toef.createpilih', compact('id', 'soal'));
    }

    public function create_essay($id)
    {
        $pecah = explode(',', Crypt::decryptString($id));
        $soal = Soal::where([
            'soals.id'      => $pecah[0]
        ])->first();
        return view('admin.soal.createessay', compact('id', 'soal'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [

            'kd_mtk'            => 'required',
            'paket'             => 'required',
            'deskripsi'         => 'required',
            'kkm'               => 'required',
            'waktu'             => 'required',
            'jml_soal'          => 'required',
            'tgl_ujian'         => 'required',
            'jam_mulai_ujian'   => 'required',
            'tgl_selsai_ujian'  => 'required',
            'jam_selsai_ujian'  => 'required',

        ]);

        $soal = Soal::create([
            'id_user'           => Auth::user()->id,
            'jenis'             => 1,
            'kd_dosen'          => Auth::user()->kode,
            'kd_mtk'            => $request->input('kd_mtk'),
            'paket'             => $request->input('paket'),
            'deskripsi'         => $request->input('deskripsi'),
            'kkm'               => $request->input('kkm'),
            'waktu'             => $request->input('waktu'),
            'jml_soal'          => $request->input('jml_soal'),
            'toef'              => 1,
            'tgl_ujian'         => $request->input('tgl_ujian') . ' ' . $request->input('jam_mulai_ujian'),
            'tgl_selsai_ujian'  => $request->input('tgl_selsai_ujian') . ' ' . $request->input('jam_selsai_ujian'),
            'toef_kategori'       => $request->input('nm_kategori'),

        ]);

        if ($soal) {
            return redirect('/toef')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            return redirect('/toef')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    public function store_materi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_soal'   => 'required',
            'judul'     => 'required|max:255',
            'file'      => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $idSoal = $request->input('id_soal');
        $file = $request->file('file');
        $fileName = $file->hashName();
        $file->storeAs('public/materitoef', $fileName);

        // Mendapatkan email petugas yang sedang login
        $email = Auth::user()->email;

        // Cek apakah materi sudah pernah diunggah sebelumnya
        $materi = MateriToef::where('id_soal', $idSoal)->first();

        if ($materi) {
            // Materi sudah ada, lakukan operasi update
            $materi->update([
                'judul'     => $request->input('judul'),
                'petugas'   => $email,
                'file_path' => $fileName,
            ]);
        } else {
            // Materi belum ada, lakukan operasi create
            $materi = MateriToef::create([
                'id_soal'   => $idSoal,
                'judul'     => $request->input('judul'),
                'petugas'   => $email,
                'file_path' => $fileName,
            ]);
        }

        return redirect()->back()->with('status', 'Materi berhasil diunggah.');
    }


    public function store_pilihan(Request $request)
    {
        $this->validate($request, [
            'soal'      => 'required',
            'pila'      => 'required',
            'pilb'      => 'required',
            'pilc'      => 'required',
            'pild'      => 'required',
            'pile'      => 'required',
            'kunci'     => 'required',
            'score'     => 'required',
            'status'    => 'required',
        ]);

        $file = $request->file('file');

        if (isset($file)) {
            $this->validate($request, [
                'file'      => 'file|mimes:jpg,jpeg,png,mp3|max:2500',
            ]);

            $file->storeAs('public/soal', $file->hashName());

            $detailsoal = Detailsoal::create([
                'id_soal'       => $request->input('id_soal'),
                'jenis'         => 1,
                'soal'          => $request->input('soal'),
                'url'           => $request->input('url'),
                'file'          => $file->hashName(),
                'pila'          => $request->input('pila'),
                'pilb'          => $request->input('pilb'),
                'pilc'          => $request->input('pilc'),
                'pild'          => $request->input('pild'),
                'pile'          => $request->input('pile'),
                'kunci'         => $request->input('kunci'),
                'score'         => $request->input('score'),
                'id_user'       => $request->input('id_user'),
                'status'        => $request->input('status'),
                'sesi'          => $request->input('sesi')
            ]);
        } else {
            $detailsoal = Detailsoal::create([
                'id_soal'       => $request->input('id_soal'),
                'jenis'         => 1,
                'soal'          => $request->input('soal'),
                'url'           => $request->input('url'),
                'pila'          => $request->input('pila'),
                'pilb'          => $request->input('pilb'),
                'pilc'          => $request->input('pilc'),
                'pild'          => $request->input('pild'),
                'pile'          => $request->input('pile'),
                'kunci'         => $request->input('kunci'),
                'score'         => $request->input('score'),
                'id_user'       => $request->input('id_user'),
                'status'        => $request->input('status'),
                'sesi'          => $request->input('sesi')
            ]);
        }

        $gabung = Crypt::encryptString($request->input('id_soal'));

        if ($detailsoal) {
            return redirect('/toef-soal-show/' . $gabung)->with('status', 'Data Ditambah');
        } else {
            return redirect('/toef-soal-show/' . $gabung)->with('error', 'Data Gagal Disimpan!');
        }
    }

    public function storeData_SoalPg(Request $request)
    {
        //VALIDASI
        $this->validate($request, [
            'file' => 'required|mimes:xls,xlsx'
        ]);

        if ($request->hasFile('file')) {
            $set = [

                'id_soal'       => $request->input('id_soal'),
                'jenis'         => 1,
                'id_user'       => Auth::user()->id,
                'status'        => 'Y',
                'sesi'          => $request->input('sesi')

            ];
            $file = $request->file('file'); //GET FILE

            Excel::import(new LatihanSoalpgImport($set), $file); //IMPORT FILE 
            return redirect()->back()->with(['success' => 'Upload Soal Pilihan Ganda Berhasil']);
        }
        return redirect()->back()->with(['error' => 'Please choose file before']);
    }

    public function storeData_SoalEssay(Request $request)
    {
        //VALIDASI
        $this->validate($request, [
            'file' => 'required|mimes:xls,xlsx'
        ]);

        if ($request->hasFile('file')) {
            $set = [

                'id_soal'       => $request->input('id_soal'),
                'id_user'       => Auth::user()->id,
                'status'        => 'Y'

            ];

            $file = $request->file('file'); //GET FILE

            Excel::import(new LatihanSoalEssayImport($set), $file); //IMPORT FILE 
            return redirect()->back()->with(['success' => 'Upload Soal Essay Berhasil']);
        }
        return redirect()->back()->with(['error' => 'Please choose file before']);
    }

    public function store_essay(Request $request)
    {
        $file = $request->file('file');
        if (isset($file)) {
            $this->validate($request, [

                'soal'      => 'required',
                'status'    => 'required',
                'file'      => 'file|mimes:jpg,jepg,png,mp3|max:2500'
            ]);

            $file = $request->file('file');
            $file->storeAs('public/soalessay', $file->hashName());
            $essaysoal = DetailSoalEssay::create([

                'id_soal'       => $request->input('id_soal'),
                'soal'          => $request->input('soal'),
                'status'        => $request->input('status'),
                'id_user'       => $request->input('id_user'),
                'file'          => $file->hashName()


            ]);
        } else {
            $this->validate($request, [

                'soal'      => 'required',
                'status'    => 'required'

            ]);
            $essaysoal = DetailSoalEssay::create([

                'id_soal'       => $request->input('id_soal'),
                'soal'          => $request->input('soal'),
                'status'        => $request->input('status')

            ]);
        }
        $gabung = Crypt::encryptString($request->input('id_soal'));

        if ($essaysoal) {
            return redirect('/toef-soal-show/' . $gabung)->with('status', 'Data Ditambah');
        } else {
            return redirect('/toef-soal-show/' . $gabung)->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $userKode = Auth::user()->kode;
        $userKodeList = DB::table('toef_dosen')->pluck('kd_dosen'); 

        $pecah = explode(',', Crypt::decryptString($id));
        if (Auth::user()->utype == 'ADM') {

            $soals = Detailsoal::where([
                'id_soal'        => $pecah[0]
            ])
                ->orderBy('created_at', 'DESC')
                ->get();

            $essay = DetailSoalEssay::where([
                'id_soal'        => $pecah[0]
            ])
                ->orderBy('created_at', 'DESC')
                ->get();

            $soal = Soal::join('mtk', 'soals.kd_mtk', '=', 'mtk.kd_mtk')
                ->select('mtk.*', 'soals.*')
                ->where([
                    'soals.id'      => $pecah[0]
                ])->first();

                if ($userKodeList->contains($userKode)) {
                $kelas = DB::table('toef_mhs')
                    ->select(
                        'toef_mhs.kd_lokal',
                        'toef_mhs.kd_dosen',
                        'toef_mhs.kd_mtk'
                    )
                    ->groupBy('kd_lokal')
                    // ->where('toef_mhs.kd_dosen', Auth::user()->kode)
                    ->get();
            } else {
                $kelas = DB::table('toef_mhs')
                    ->select(
                        'toef_mhs.kd_lokal',
                        'toef_mhs.kd_dosen',
                        'toef_mhs.kd_mtk'
                    )
                    ->groupBy('kd_lokal')
                    ->where('toef_mhs.kd_dosen', Auth::user()->kode)
                    ->get();
            }

            $distribusi = app('App\Models\Soal')->distribusi(['id_soal' => $pecah[0]]);

            return view('admin.soal.toef.show', compact('soal', 'kelas', 'soals', 'essay', 'distribusi'));
        } else {
            return redirect('/dashboard');
        }
    }

    public function show_detailsoal($id)
    {
        $pecah = explode(',', Crypt::decryptString($id));
        $detailsoal = Detailsoal::where([
            'id'   => $pecah[0]
        ])->first();
        return view('admin.soal.toef.detailsoal', compact('detailsoal', 'id'));
    }
    public function show_detalessay($id)
    {
        $pecah = explode(',', Crypt::decryptString($id));
        $detailsoal = DetailSoalEssay::where([
            'id'   => $pecah[0]
        ])->first();
        return view('admin.soal.toef.detailsoal_essay', compact('detailsoal', 'id'));
    }

    public function terbitSoal(Request $request)
    {
        if ($request->status == '1') {
            $terbit = Distribusisoal::create([
                'id_soal'       => $request->id_soal,
                'id_kelas'      => $request->nm_kelas
            ]);
        } else {
            $cek = Distribusisoal::where('id_soal', $request->id_soal)
                ->where('id_kelas', $request->nm_kelas)->delete();
        }
        return response()->json(['success' => 'Berhasil Cuy']);


        // if ($terbit) {
        //     return back();
        // } else {
        //     return back();
        // }
        //   Distribusisoal::where('id_soal', $request->id_soal)->where('id_kelas', $request->id_kelas)->delete();

    }
    public function terbitSoalNetral(Request $request)
    {
        Distribusisoal::where('id_soal', $request->id_soal)
            ->where('id_kelas', $request->id_kelas)->delete();
        return back();
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kategori = DB::table('toef_kategori')->get();
        $pecah = explode(',', Crypt::decryptString($id));

        $materis = Jadwal::where('kd_dosen', Auth::user()->kode)
            ->groupBy('kd_mtk')
            ->get();

        $editjadwal = Soal::where([
            'id'   => $pecah[0]
        ])->first();
        return view('admin.latihanujian.toef.editjadwal', compact('editjadwal', 'id', 'materis','kategori'));
    }

    public function edit_detalsoal($id)
    {
        $pecah = explode(',', Crypt::decryptString($id));
        $editsoal = Detailsoal::where([
            'id'   => $pecah[0]
        ])->first();
        return view('admin.soal.toef.form.editsoal', compact('editsoal', 'id'));
    }

    public function edit_detalessay($id)
    {
        $pecah = explode(',', Crypt::decryptString($id));
        $editsoal = DetailSoalEssay::where([
            'id'   => $pecah[0]
        ])->first();
        return view('admin.soal.toef.form.editsoal_essay', compact('editsoal', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Soal $soal)
    {

        $this->validate($request, [
            'kd_mtk'            => 'required',
            'paket'             => 'required',
            'deskripsi'         => 'required',
            'kkm'               => 'required',
            'waktu'             => 'required',
            'jml_soal'          => 'required',
            'tgl_selsai_ujian'  => 'required',
        ]);

        $soal = Soal::findOrFail($soal->id);
        $soal->update([
            'id_user'           => Auth::user()->id,
            'jenis'             => 1,
            'kd_dosen'          => Auth::user()->kode,
            'kd_mtk'            => $request->input('kd_mtk'),
            'paket'             => $request->input('paket'),
            'deskripsi'         => $request->input('deskripsi'),
            'kkm'               => $request->input('kkm'),
            'waktu'             => $request->input('waktu'),
            'jml_soal'          => $request->input('jml_soal'),
            'tgl_ujian'         => $request->input('tgl_ujian'),
            'tgl_selsai_ujian'  => $request->input('tgl_selsai_ujian'),
            'toef_kategori'       => $request->input('nm_kategori'),
        ]);

        if ($soal) {
            //redirect dengan pesan sukses
            return redirect('/toef')->with('status', 'Data Diupdate');
        } else {
            return redirect('/toef')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }

    public function update_soalpilih(Request $request, Detailsoal $detailsoal)
    {
        $this->validate($request, [
            'soal'      => 'required',
            'pila'      => 'required',
            'pilb'      => 'required',
            'pilc'      => 'required',
            'pild'      => 'required',
            'pile'      => 'required',
            'kunci'     => 'required',
            'score'     => 'required'
        ]);

        if ($request->file('file') == "") {

            $detailsoal = Detailsoal::findOrFail($detailsoal->id);
            $detailsoal->update([
                'id_soal'       => $request->input('id_soal'),
                'jenis'         => 1,
                'soal'          => $request->input('soal'),
                'url'           => $request->input('url'),
                'pila'          => $request->input('pila'),
                'pilb'          => $request->input('pilb'),
                'pilc'          => $request->input('pilc'),
                'pild'          => $request->input('pild'),
                'pile'          => $request->input('pile'),
                'kunci'         => $request->input('kunci'),
                'score'         => $request->input('score'),
                'id_user'       => $request->input('id_user'),
                'status'        => $request->input('status'),
                'sesi'          => $request->input('sesi')

            ]);
        } else {

            //remove old image
            Storage::disk('local')->delete('public/soal/' . $detailsoal->file);

            //upload new image
            $image = $request->file('file');
            $image->storeAs('public/soal', $image->hashName());

            $detailsoal = Detailsoal::findOrFail($detailsoal->id);
            $detailsoal->update([
                'id_soal'       => $request->input('id_soal'),
                'jenis'         => 1,
                'soal'          => $request->input('soal'),
                'url'           => $request->input('url'),
                'file'          => $image->hashName(),
                'pila'          => $request->input('pila'),
                'pilb'          => $request->input('pilb'),
                'pilc'          => $request->input('pilc'),
                'pild'          => $request->input('pild'),
                'pile'          => $request->input('pile'),
                'kunci'         => $request->input('kunci'),
                'score'         => $request->input('score'),
                'id_user'       => $request->input('id_user'),
                'status'        => $request->input('status'),
                'sesi'          => $request->input('sesi')

            ]);
        }

        $gabung = Crypt::encryptString($request->input('id_soal'));

        if ($detailsoal) {
            //redirect dengan pesan sukses
            return redirect('/toef-soal-show/' . $gabung)->with('status', 'Data Diupdate');
        } else {
            return redirect('/toef-soal-show/' . $gabung)->with(['error' => 'Data Gagal Diupdate!']);
        }
    }

    public function update_essay(Request $request, DetailSoalEssay $detailSoalEssay)
    {
        $this->validate($request, [
            'soal'      => 'required',
            'status'    => 'required'
            // 'file'      => 'file|mimes:jpg,jepg,png|max:2500'
        ]);
        if ($request->file('file') == "") {

            $detailSoalEssay = DetailSoalEssay::findOrFail($detailSoalEssay->id);
            $detailSoalEssay->update([
                'id_soal'       => $request->input('id_soal'),
                'soal'          => $request->input('soal'),
                'status'        => $request->input('status'),
                'id_user'       => $request->input('id_user')
            ]);
        } else {

            //remove old image
            Storage::disk('local')->delete('public/soalessay/' . $detailSoalEssay->file);

            //upload new image
            $image = $request->file('file');
            $image->storeAs('public/soalessay', $image->hashName());

            $detailSoalEssay = DetailSoalEssay::findOrFail($detailSoalEssay->id);
            $detailSoalEssay->update([
                'id_soal'       => $request->input('id_soal'),
                'soal'          => $request->input('soal'),
                'status'        => $request->input('status'),
                'id_user'       => $request->input('id_user'),
                'file'          => $image->hashName()
            ]);
        }
        $gabung = Crypt::encryptString($request->input('id_soal'));

        if ($detailSoalEssay) {
            //redirect dengan pesan sukses
            return redirect('/toef-soal-show/' . $gabung)->with('status', 'Data Ditambah');
        } else {
            return redirect('/toef-soal-show/' . $gabung)->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function download_materi_toef(Request $request)
    {
        if ($request->file <> '') {
            $files = public_path() . '/storage/materitoef/' . $request->file; //Mencari file dari model yang sudah dicari
            return response()->download($files, $request->file);
        } else {
            return redirect('/materitoef/' . $request->id)->with('error', 'File Kosong');
            echo "kosong";
        }
    }
}
