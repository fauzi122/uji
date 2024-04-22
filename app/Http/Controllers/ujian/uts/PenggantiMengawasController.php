<?php

namespace App\Http\Controllers\ujian\uts;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Soal_ujian;

class PenggantiMengawasController extends Controller
{
    public function __construct()
    {
        if (!$this->middleware('auth:sanctum')) {
            return redirect('/login');
        }
    }
    public function index()
    {
        $jadwal = Soal_ujian::get();
        $result = Soal_ujian::join('ujian_berita_acaras', function ($join) {
                    $join->on('uts_soals.kel_ujian', '=', 'ujian_berita_acaras.kel_ujian')
                         ->on('uts_soals.kd_mtk', '=', 'ujian_berita_acaras.kd_mtk');
                })
                ->select('ujian_berita_acaras.*', 'uts_soals.kd_dosen', 'uts_soals.kel_ujian', 'uts_soals.kd_mtk')
                ->get();
    
        return view('admin.ujian.uts.baak.pengganti.index', compact('jadwal', 'result'));
    }

    public function edit($id)
    {
        $pecah = explode(',', Crypt::decryptString($id));
        $jadwal = Soal_ujian::where([
            'kd_dosen'    => $pecah[0],
            'kd_mtk'      => $pecah[1],
            'kel_ujian'   => $pecah[2],
            'paket'       => $pecah[3],       
            'nm_kampus'   => $pecah[4]        
            ])->first();

        $dosens = DB::table('jadwal')->select('jadwal.kd_dosen','jadwal.nm_dosen')
        ->groupby('kd_dosen') ->get();
        
        return view('admin.ujian.uts.baak.pengganti.edit',compact('jadwal','dosens'));
    }
    
}
