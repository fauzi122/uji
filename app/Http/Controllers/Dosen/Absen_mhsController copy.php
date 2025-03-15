<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Absen_mhs;
use App\Models\Absen_ajar;
use App\Models\Absen_ajar_praktek;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use App\Library\APIBap;


class Absen_mhsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $api;
    public function __construct()
    {
        if (!$this->middleware('auth:sanctum')) {
            return redirect('/login');
        }
        $this->api = new APIBap();
    }
    public function index()
    {
        //
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
    public function store_praktek(Request $request)
    {
        for ($i = 1; $i <= count($request->no_urut); $i++) {
            DB::table('absen_mhs')
                ->updateOrInsert(
                    [
                        'nim' => $request->no_urut[$i],
                        'kd_mtk' => $request->kd_mtk,
                        'kel_praktek' => $request->kel_praktek,
                        'pertemuan' => $request->temuke
                    ],
                    [
                        'nip' => Auth::user()->username,
                        'nim' => $request->no_urut[$i],
                        'kd_lokal' => $request->kd_lokal,
                        'kd_mtk' => $request->kd_mtk,
                        'kel_praktek' => $request->kel_praktek,
                        'tgl_hadir' => $request->tgl_hadir[$i],
                        'jam_hadir' => $request->jam_t[$i],
                        'pertemuan' => $request->temuke,
                        'ip_address' => ambilIP(),
                        'status_hadir' => $request->nama_radio[$i]
                    ]
                );
        }
        if ($request->id == '1') {
            return redirect('/rekap-absen');
        } elseif ($request->id_ke == '2') {
            return redirect('/ajar-praktek-pengganti/' . $request->id);
        } else {
            return redirect('/ajar-praktek/' . $request->id);
        }
        //    return redirect('/jadwal');

    }

    public function store_teori(Request $request)
    {

        for ($i = 1; $i <= count($request->no_urut); $i++) {
            DB::table('absen_mhs')
                ->updateOrInsert(
                    [
                        'nim' => $request->no_urut[$i],
                        'kd_mtk' => $request->kd_mtk,
                        'kd_lokal' => $request->kd_lokal,
                        'pertemuan' => $request->temuke
                    ],
                    [
                        'nip' => Auth::user()->username,
                        'nim' => $request->no_urut[$i],
                        'kd_lokal' => $request->kd_lokal,
                        'kd_mtk' => $request->kd_mtk,
                        'tgl_hadir' => $request->tgl_hadir[$i],
                        'jam_hadir' => $request->jam_t[$i],
                        'pertemuan' => $request->temuke,
                        'ip_address' => ambilIP(),
                        'status_hadir' => $request->nama_radio[$i]
                    ]
                );
        }
        if ($request->id == '1') {
            return redirect('/rekap-absen');
        } else {
            if ($request->id_ke == '1') {
                return redirect('/ajar-teori-pengganti/' . $request->id);
            } else {
                return redirect('/ajar-teori/' . $request->id);
            }
        }
    }

    public function store_gabung(Request $request)
    {
        // dd($exp[0]);
        // dd($request->kd_gabung.'-'.$request->temuke.'-'.$request->kd_mtk.'-'.count($request->no_urut));
        for ($i = 1; $i <= count($request->no_urut); $i++) {
            $exp = explode(",", $request->no_urut[$i]);
            // dump($exp[0].'-'.$exp[1].'-'.$exp[2].'-'.$exp[3]);
            DB::table('absen_mhs')
                ->updateOrInsert(
                    [
                        'nim' => $exp[0],
                        'kd_mtk' => $request->kd_mtk,
                        'kd_gabung' => $request->kd_gabung,
                        'pertemuan' => $request->temuke
                    ],
                    [
                        'nip' => Auth::user()->username,
                        'nim' => $exp[0],
                        'kd_lokal' => $exp[1],
                        'kd_mtk' => $request->kd_mtk,
                        'kel_praktek' => $request->kel_praktek,
                        'tgl_hadir' => $exp[2],
                        'jam_hadir' => $exp[3],
                        'pertemuan' => $request->temuke,
                        'status_hadir' => $request->nama_radio[$i],
                        'ip_address' => ambilIP(),
                        'kd_gabung' => $request->kd_gabung
                    ]
                );
        }
        //    die;
        if ($request->id == '1') {
            return redirect('/rekap-absen');
        } else {
            if ($request->id_ke == '1') {
                return redirect('/ajar-gabung-pengganti/' . $request->id);
            } else {
                return redirect('/ajar-gabung/' . $request->id);
            }
        }
    }

    public function bap_gabung(Request $request)
    {
        $request->validate([
            'rangkuman' => 'required',
            'bap' => 'required',
            'file' => 'required|file|mimes:pdf,jpeg,jpg,doc,docx|max:2000',
        ]);

        // Dekripsi ID dan ekstrak informasi
        $exp = explode(",", Crypt::decryptString($request->id));

        $w_bap = [
            'nip' => Auth::user()->username,
            'kd_lokal' => $request->kd_lokal,
            'kd_mtk' => $exp[0],
            'tgl_ajar_masuk' => date('Y-m-d'),
            'jam_t' => $exp[6]
        ];

        // Ambil data file lama dari database
        $bap = Absen_ajar::select('file_ajar', 'created_at')->where($w_bap)->first();
        $fileLama = $bap ? $bap->file_ajar : null;
        $tahun = $bap ? date('Y', strtotime($bap->created_at)) : date('Y'); // Ambil tahun dari created_at

        // Ambil file baru dari request
        $file = $request->file('file');

        // Jika file lama ada, gunakan API updateFile, jika tidak ada gunakan API uploadFile
        if ($fileLama) {
            $url = '/update'; // Endpoint update
            $uploadResponse = $this->api->put($url, [
                'file' => $file,
                'filename_lama' => $fileLama,
                'tahun' => $tahun
            ]);
        } else {
            $url = '/'; // Endpoint upload baru
            $uploadResponse = $this->api->post($url, [
                'file' => $file
            ]);
        }

        // Cek apakah upload/update berhasil
        if (!isset($uploadResponse['status']) || $uploadResponse['status'] !== 'success') {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengunggah file ke API BAP'
            ], 503);
        }

        // Ambil nama file dari API
        $filenameDariApi = $uploadResponse['data']['filename'] ?? null;
        if (!$filenameDariApi) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mendapatkan nama file dari API'
            ], 504);
        }

        $destinationPath = storage_path('app/public/ajar');

        // Hapus file lama jika ada
        if ($fileLama && file_exists($destinationPath . '/' . $fileLama)) {
            unlink($destinationPath . '/' . $fileLama);
        }

        // Buat folder jika belum ada
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        // Simpan file baru
        if (!$file->move($destinationPath, $filenameDariApi)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menyimpan file ke server Laravel'
            ], 500);
        }

        // Simpan ke database dengan nama file dari API
        $simpan = Absen_ajar::where($w_bap)->update([
            'rangkuman' => $request->rangkuman,
            'berita_acara' => $request->bap,
            'file_ajar' => $filenameDariApi
        ]);

        // Redirect dengan flash message
        $redirectUrl = ($request->pengganti == '1') ? "/ajar-gabung-pengganti/" : "/ajar-gabung/";
        if ($simpan) {
            session()->flash('status', 'Ditambahkan');
        } else {
            session()->flash('error', 'Gagal Ditambahkan');
        }

        return redirect($redirectUrl . $request->id);
    }


    public function bap_teori(Request $request)
    {
        $request->validate([
            'rangkuman' => 'required',
            'bap' => 'required',
            'file' => 'required|file|mimes:pdf,jpeg,jpg,doc,docx|max:2000',
        ]);

        // Dekripsi ID dan ekstrak informasi
        $exp = explode(",", Crypt::decryptString($request->id));
        $w_bap = [
            'nip' => Auth::user()->username,
            'kd_lokal' => $request->kd_lokal,
            'kd_mtk' => $exp[0],
            'tgl_ajar_masuk' => date('Y-m-d'),
            'jam_t' => $exp[6]
        ];

        // Ambil data file lama dari database
        $bap = Absen_ajar::select('file_ajar', 'created_at')->where($w_bap)->first();
        $fileLama = $bap ? $bap->file_ajar : null;
        $tahun = $bap ? date('Y', strtotime($bap->created_at)) : date('Y'); // Ambil tahun dari created_at

        // Ambil file baru dari request
        $file = $request->file('file');

        // Jika file lama ada, gunakan API updateFile, jika tidak ada gunakan API uploadFile
        if ($fileLama) {
            $url = '/update'; // Endpoint update
            $uploadResponse = $this->api->put($url, [
                'file' => $file,
                'filename_lama' => $fileLama,
                'tahun' => $tahun
            ]);
        } else {
            $url = '/'; // Endpoint upload baru
            $uploadResponse = $this->api->post($url, [
                'file' => $file
            ]);
        }

        // Cek apakah upload/update berhasil
        if (!isset($uploadResponse['status']) || $uploadResponse['status'] !== 'success') {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengunggah file ke API BAP'
            ], 503);
        }

        // Ambil nama file dari API
        $filenameDariApi = $uploadResponse['data']['filename'] ?? null;
        if (!$filenameDariApi) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mendapatkan nama file dari API'
            ], 504);
        }

        $destinationPath = storage_path('app/public/ajar');

        // Hapus file lama jika ada
        if ($fileLama && file_exists($destinationPath . '/' . $fileLama)) {
            unlink($destinationPath . '/' . $fileLama);
        }

        // Buat folder jika belum ada
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        // Simpan file baru
        if (!$file->move($destinationPath, $filenameDariApi)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menyimpan file ke server Laravel'
            ], 500);
        }

        // Simpan ke database dengan nama file dari API
        $simpan = Absen_ajar::where($w_bap)->update([
            'rangkuman' => $request->rangkuman,
            'berita_acara' => $request->bap,
            'file_ajar' => $filenameDariApi
        ]);

        // Redirect dengan flash message
        $redirectUrl = ($request->pengganti == '1') ? "/ajar-teori-pengganti/" : "/ajar-teori/";
        if ($simpan) {
            session()->flash('status', 'Ditambahkan');
        } else {
            session()->flash('error', 'Gagal Ditambahkan');
        }

        return redirect($redirectUrl . $request->id);
    }

    public function bap_praktek(Request $request)
    {
        // 0 => "0008"
        // 1 => "WEB PROGRAMMING III"
        // 2 => "HMT"
        // 3 => "4"
        // 4 => "WP3.12.4A.11.A"
        // 5 => "Rabu"
        // 6 => "14:10-17:30"
        // 7 => "305-F1"
        // 8 => "3"
        // Validasi input
        $request->validate([
            'rangkuman' => 'required',
            'bap' => 'required',
            'file' => 'required|file|mimes:pdf,jpeg,jpg,doc,docx|max:2000',
        ]);

        // Dekripsi ID dan ekstrak informasi
        $exp = explode(",", Crypt::decryptString($request->id));
        $w_pert = [
            'nip' => Auth::user()->username,
            'kel_praktek' => $exp[4],
            'kd_mtk' => $exp[0],
            'tgl_ajar_masuk' => date('Y-m-d'),
            'jam_t' => $exp[6]
        ];

        // Ambil data file lama dari database (termasuk tahun dari created_at)
        $bap = Absen_ajar_praktek::select('file_ajar', 'created_at')->where($w_pert)->first();
        $fileLama = $bap ? $bap->file_ajar : null;
        $tahun = $bap ? date('Y', strtotime($bap->created_at)) : date('Y'); // Ambil tahun dari created_at

        // Ambil file dari request
        $file = $request->file('file');

        // Jika file lama ada, gunakan API updateFile, jika tidak ada gunakan API uploadFile
        if ($fileLama) {

            $url = '/update'; // Endpoint untuk update
            $uploadResponse = $this->api->put($url, [
                'file' => $file,
                'filename_lama' => $fileLama,
                'tahun' => $tahun
            ]);
            // dd($uploadResponse);
        } else {
            $url = '/'; // Endpoint untuk upload baru
            $uploadResponse = $this->api->post($url, [
                'file' => $file
            ]);
        }

        // Cek apakah upload/update ke API berhasil
        if (!isset($uploadResponse['status']) || $uploadResponse['status'] !== 'success') {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengunggah file ke API BAP'
            ], 503);
        }

        // **Ambil nama file dari API**
        $filenameDariApi = $uploadResponse['data']['filename'] ?? null;
        if (!$filenameDariApi) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mendapatkan nama file dari API'
            ], 504);
        }
        $destinationPath = storage_path('app/public/ajar');

        // Hapus file lama jika ada
        if ($fileLama && file_exists($destinationPath . '/' . $fileLama)) {
            unlink($destinationPath . '/' . $fileLama);
        }

        // Buat folder jika belum ada
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        // Simpan file baru
        if (!$file->move($destinationPath, $filenameDariApi)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menyimpan file ke server Laravel'
            ], 500);
        }

        // Simpan ke database dengan nama file dari API
        $simpan = Absen_ajar_praktek::where($w_pert)->update([
            'rangkuman' => $request->rangkuman,
            'berita_acara' => $request->bap,
            'file_ajar' => $filenameDariApi
        ]);

        // Redirect dengan flash message
        $redirectUrl = ($request->id_ke == '1') ? "/ajar-praktek-pengganti/" : "/ajar-praktek/";
        if ($simpan) {
            session()->flash('status', 'Ditambahkan');
        } else {
            session()->flash('error', 'Gagal Ditambahkan');
        }

        return redirect($redirectUrl . $request->id);
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
    public function destroy($id)
    {
        //
    }
}
