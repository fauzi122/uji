<?php

namespace App\Http\Controllers\mhs;

use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Absen_ajar_praktek;
use App\Models\Absen_ajar;
use App\Models\Jadwal;
use App\Models\Absen_mhs;
use App\Models\Kuliah_pengganti;
use App\Models\Komentar_mhs;
// use App\Models\mhs\Jadwalmhs;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
class JadwalpenggantiController extends Controller
{
    public function __construct() {
        if(!$this->middleware('auth:sanctum')){
            return redirect('/login');
        } 
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       
        $schedule = app('App\Models\mhs\Jadwalmhs')->jadwal_pengganti($request->user()->kode,$request->user()->username);
        $praktek = app('App\Models\mhs\Jadwalmhs')->jadwal_praktek_pengganti($request->user()->kode,$request->user()->username);
        $gabung = app('App\Models\mhs\Jadwalmhs')->jadwal_gabung_pengganti($request->user()->kode,$request->user()->username);
        // $cek=$schedule->get();
        // dd($cek);
        // dump($ck->kd_mtk);
        // $cek_ajar = app('App\Models\mhs\Jadwalmhs')->absen_ajar($request->user()->kode,date('Y-m-d'));
        // $cek_ajar_praktek = app('App\Models\mhs\Jadwalmhs')->absen_ajar_praktek($request->user()->kode,date('Y-m-d'));
        // echo $cek_ajar['894']->pertemuan;
        // echo $cek_ajar['328']->pertemuan;
        // die;
        // dd($gabung->first());

        // $cek_ajar = app('App\Models\mhs\Jadwalmhs')->jadwal($request->user()->kode,$request->user()->username);
        return view('mhs.jadwal_pengganti.index',compact('schedule','praktek','gabung'));
    }

    public function show_absen($id)
    {
    // 0 => "894"
    // 1 => "DASAR PEMROGRAMAN "
    // 2 => "GNB"
    // 3 => "4"
    // 4 => "DPG.19.1A.12.A"
    // 5 => "Senin"
    // 6 => "11:40-15:00"
    // 7 => "201-G1"
    $tgl=date('Y-m-d');
            $exp = explode(",",Crypt::decryptString($id));
            $w_cek = ['kel_praktek'=>$exp[4],'kd_mtk'=>$exp[0]];
        $jam=date("H:i");
        $cek = Absen_ajar_praktek::where($w_cek)->count();

        if($cek>0){
            $absen      = Absen_ajar_praktek::where(['kel_praktek'=>$exp[4],'kd_mtk'=>$exp[0],'tgl_ajar_masuk'=>date('Y-m-d')]);
            $durasi     = kuliah_pengganti::where($w_cek)
                                ->where('selesai','>=', $jam)->count();
            $absen_mhs  = Absen_mhs::Where(['kel_praktek'=>$exp[4],'kd_mtk'=>$exp[0],'pertemuan'=>$absen->first()->pertemuan,'nim'=>Auth::user()->username])->count();
        }else{
           $cek_teori   = kuliah_pengganti::where(['kd_lokal'=>$exp[4],'kd_mtk'=>$exp[0]])->count();
           $absen      = Absen_ajar::where(['kd_lokal'=>$exp[4],'kd_mtk'=>$exp[0],'tgl_ajar_masuk'=>date('Y-m-d')]);
           if($cek_teori>0){
                $durasi     = kuliah_pengganti::where(['kd_lokal'=>$exp[4],'kd_mtk'=>$exp[0]])
                                    ->where('selesai','>=', $jam)->count();
                $absen_mhs  = Absen_mhs::Where(['kd_lokal'=>$exp[4],'kd_mtk'=>$exp[0],'pertemuan'=>$absen->first()->pertemuan,'nim'=>Auth::user()->username])->count();

            }else{
                $durasi     = kuliah_pengganti::where(['kd_gabung'=>$exp[4],'kd_mtk'=>$exp[0]])
                                    ->where('selesai','>=', $jam)->count();
                $absen_mhs  = Absen_mhs::Where(['kd_gabung'=>$exp[4],'kd_mtk'=>$exp[0],'pertemuan'=>$absen->first()->pertemuan,'nim'=>Auth::user()->username])->count();
                                    
            }
        }
        // dd($absen->first('pertemuan'));
        $komentar=DB::table('komentar_mhs')
            ->where(['user'=>Auth::user()->username,'kd_mtk'=>$exp[0],'kd_lokal'=>$exp[4]])
            ->where(DB::raw('LEFT(created_at,10)'),$tgl)
            ->count();
        return view('mhs.jadwal.absen_mhs',compact('id','absen','exp','durasi','absen_mhs','komentar'));
    }
   public function rekap_side($id)
   {
       $exp = explode(",",Crypt::decryptString($id));
       $where=['kel_praktek'=>$exp[4],'kd_mtk'=>$exp[0]];
       $cek = Absen_ajar_praktek::where($where)->count();
            if($cek>0){
                $ajar=DB::table('absen_ajar_prakteks')
            ->where($where)->get();
            }else{
                $ajar=DB::table('absen_ajars')
                ->where(['kd_lokal'=>$exp[4],'kd_mtk'=>$exp[0]])->get();
            }
            
    return Datatables::of($ajar)
    ->addColumn('status_hadir', function ($ajar) {
        $w_mhs=['pertemuan'=>$ajar->pertemuan,'kd_mtk'=>$ajar->kd_mtk,'nim'=>Auth::user()->username];
        $absen_mhs=DB::table('absen_mhs')
            ->where($w_mhs)->first();
             if (isset($absen_mhs->status_hadir)) {
                if($absen_mhs->status_hadir=='0'){
                    $aksi='<a href="javascript:void(0)" class="btn btn-danger">Tidak Hadir</a>';
                }else{
                    $aksi='<a href="javascript:void(0)" class="btn btn-primary">Hadir</a>';

                 }
            }else{
                    $aksi='<a href="javascript:void(0)" class="btn btn-danger">Tidak Hadir</a>';
             }
                    return $aksi;
            })
        ->rawColumns(['status_hadir'])
        // ->rawColumns(['nomer'])
    ->make(true);  
   }

   public function mhs_absen(Request $request)
   {
    // 0 => "894"
    // 1 => "DASAR PEMROGRAMAN "
    // 2 => "GNB"
    // 3 => "4"
    // 4 => "DPG.19.1A.12.A"
    // 5 => "Senin"
    // 6 => "11:40-15:00"
    // 7 => "201-G1"
    $exp = explode(",",Crypt::decryptString($request->id));
    $w_cek = ['kel_praktek'=>$exp[4],'kd_mtk'=>$exp[0]];
    $cek = Absen_ajar_praktek::where($w_cek)->count();
    if($cek>0){
        DB::table('absen_mhs')->insert([
            'nip' => $request->nip,
            'nim' => Auth::user()->username,
            'kd_lokal' => Auth::user()->kode,
            'kd_mtk' => $exp[0],
            'kel_praktek' => $exp[4],
            'tgl_hadir' => date('Y-m-d'),
            'jam_hadir' => date('H:i:s'),
            'pertemuan' => $request->pertemuan,
            'status_hadir' => $request->status
        ]);
            
    }else{
        $cek_teori   = kuliah_pengganti::where(['kd_lokal'=>$exp[4],'kd_mtk'=>$exp[0]])->count();
        if($cek_teori>0){
            DB::table('absen_mhs')->insert([
                'nip' => $request->nip,
                'nim' => Auth::user()->username,
                'kd_lokal' => Auth::user()->kode,
                'kd_mtk' => $exp[0],
                'tgl_hadir' => date('Y-m-d'),
                'jam_hadir' => date('H:i:s'),
                'pertemuan' => $request->pertemuan,
                'status_hadir' => $request->status
            ]);
            
        }else{
            DB::table('absen_mhs')->insert([
                'nip' => $request->nip,
                'nim' => Auth::user()->username,
                'kd_lokal' => Auth::user()->kode,
                'kd_mtk' => $exp[0],
                'tgl_hadir' => date('Y-m-d'),
                'jam_hadir' => date('H:i:s'),
                'pertemuan' => $request->pertemuan,
                'status_hadir' => $request->status,
                'kd_gabung' => $exp[4]
            ]);
            
        }
    }
    return redirect('/absen-mhs/'.$request->id);
   }
   public function komentar_mhs(Request $request)
   {
    $request->validate([
        'komentar' => 'required|min:10',
        'nilai' => 'required',
        ]);
        $exp = explode(",",Crypt::decryptString($request->id));
    Komentar_mhs::updateOrCreate(
        ['kd_mtk' => $exp[0],
        'kd_lokal' => $exp[4],
        'user' => Auth::user()->username,
        'pertemuan' => $request->pertemuan],
        [
        'kd_mtk' => $exp[0],
        'kd_lokal' => $exp[4],
        'pertemuan' => $request->pertemuan,
        'user' => Auth::user()->username,
        'penilai' => $request->nilai,
        'komentar' => $request->komentar
        ]);
        return redirect('/absen-mhs/'.$request->id);
   }
}
