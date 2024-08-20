<?php

namespace App\Http\Controllers\baak;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RekapabsenController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['permission:unit_layanan']);
        if (!$this->middleware('auth:sanctum')) {
            return redirect('/login');
        }
    }

    public function index()
    {
        return view('baak.rekapabsen.index');
    }

    // Endpoint untuk mendapatkan data kd_lokal
    public function getKdLokal(Request $request)
    {
        $kd_lokal = DB::table('jadwal')
            ->select('kd_lokal')
            ->groupBy('kd_lokal')
            ->get();

        return response()->json($kd_lokal);
    }

    // Endpoint untuk mendapatkan data kd_mtk
    public function getKdMtk(Request $request)
    {
        $kd_mtk = DB::table('mtk')
            ->select('kd_mtk', 'nm_mtk')
            ->get();

        return response()->json($kd_mtk);
    }

    // Endpoint untuk mendapatkan data kd_mtk berdasarkan kd_lokal
    public function getMtkByKdLokal(Request $request)
    {
        $kd_lokal = $request->input('kd_lokal');

        $mtks = DB::table('jadwal')
            ->select('kd_mtk', 'nm_mtk')
            ->where('kd_lokal', $kd_lokal)
            ->groupBy('kd_mtk', 'nm_mtk')
            ->get();

        return response()->json($mtks);
    }


    // Endpoint untuk mendapatkan data rekap absensi
    public function getRekapAbsenMhsJson(Request $request)
    {

        $kd_lokal = $request->input('kd_lokal');
        $kd_mtk = $request->input('kd_mtk');

        if (empty($kd_lokal) || empty($kd_mtk)) {
            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
            ]);
        }

        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $search = $request->input('search.value');
        $orderColumnIndex = $request->input('order.0.column');
        $orderColumn = $request->input('columns.' . $orderColumnIndex . '.data') ?: 'a.kd_mtk';
        $orderDirection = $request->input('order.0.dir', 'asc');

        $validColumns = ['k.kode_dosen', 'k.nama_dosen', 'a.kd_mtk', 'm.nama_mtk', 'a.nim', 'b.nm_mhs', 'a.kd_lokal', 'jml_hadir', 'jml_absen', 'totalpertemuan', 'prosentase', 'no_telp_hp', 'emailaddress', 'telp'];
        if (!in_array($orderColumn, $validColumns)) {
            $orderColumn = 'a.kd_mtk';
        }
        $query = DB::table('absen_mhs as a')
            ->select(
                'a.nip',
                'k.kd_dosen as kode_dosen',
                'k.nama as nama_dosen',
                'a.nim as nim',
                'b.nm_mhs as nm_mhs',
                'a.kd_mtk as kd_mtk',
                'm.nm_mtk as nama_mtk',
                'a.kd_lokal as kd_lokal',
                'a.kel_praktek as kel_praktek',
                'a.kd_gabung as kd_gabung',
                'b.no_telp_hp as no_telp_hp',
                'b.telp as telp',
                'b.emailaddress as emailaddress',
                DB::raw('SUM(IF(a.status_hadir = 1, 1, 0)) AS jml_hadir'),
                DB::raw('IF(MAX(a.pertemuan) >= 9, MAX(a.pertemuan) - 1, MAX(a.pertemuan)) AS totalpertemuan'),
                DB::raw('(IF(MAX(a.pertemuan) >= 9, MAX(a.pertemuan) - 1, MAX(a.pertemuan)) - SUM(IF(a.status_hadir = 1, 1, 0))) AS jml_absen'),
                DB::raw('SUM(IF(a.status_hadir = 1, 1, 0)) * 100 / IF(MAX(a.pertemuan) >= 9, MAX(a.pertemuan) - 1, MAX(a.pertemuan)) AS prosentase')
            )
            ->leftJoin('mhs as b', 'a.nim', '=', 'b.nim')
            ->leftJoin('karyawanbs1 as k', 'a.nip', '=', 'k.nip')
            ->leftJoin('mtk as m', 'a.kd_mtk', '=', 'm.kd_mtk')
            ->where('a.kd_lokal', $kd_lokal)
            ->where('a.kd_mtk', $kd_mtk)
            ->groupBy('a.nim', 'a.kd_mtk');


        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('k.nama', 'like', "%{$search}%")
                    ->orWhere('a.nim', 'like', "%{$search}%")
                    ->orWhere('b.nm_mhs', 'like', "%{$search}%")
                    ->orWhere('a.kd_mtk', 'like', "%{$search}%")
                    ->orWhere('m.nm_mtk', 'like', "%{$search}%");
            });
        }

        $query->orderBy($orderColumn, $orderDirection);

        $recordsTotal = $query->count();

        $data = $query->offset($start)->limit($length)->get();

        $response = [
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => $data,
        ];

        return response()->json($response);
    }
}
