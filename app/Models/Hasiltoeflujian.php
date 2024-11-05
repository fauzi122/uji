<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\JawabEsay;
use App\Traits\LogTrait;

class Hasiltoeflujian extends Model
{
    use LogTrait;

    protected $guarded = [];
    protected $table = 'hasilujians';

    public function mhs($kd_lokal)
    {
        // Mengambil nim dan nama mahasiswa secara langsung menggunakan pluck
        return DB::table('toef_mhs')
            ->where('kd_lokal', $kd_lokal)
            ->pluck('nama', 'nim')
            ->toArray(); // Mengembalikan array dengan key 'nim' dan value 'nama'
    }

    public function readMateri()
    {
        // Mengambil id_soal berdasarkan nim
        return DB::table('read_materis')
            ->where('nim', auth()->user()->username)
            ->pluck('nim', 'id_soal')
            ->toArray();
    }

    public function nilai($id_soal, $kd_lokal)
    {
        // Mengambil data hasil ujian berdasarkan id_user
        $nilai = DB::table('hasilujians')
            ->where('id_soal', $id_soal)
            ->where('kd_lokal', $kd_lokal)
            ->get()
            ->keyBy('id_user')
            ->toArray();

        return !empty($nilai) ? $nilai : null;
    }

    public function nilai_essay($id_soal, $kd_lokal)
    {
        // Mengambil skor esai berdasarkan id_user
        return DB::table('jawab_esays')
            ->where('id_soal', $id_soal)
            ->where('id_kelas', $kd_lokal)
            ->select('id_user', DB::raw('SUM(score) as total_score'))
            ->groupBy('id_user')
            ->pluck('total_score', 'id_user')
            ->toArray();
    }

    public function nilai_pg($id_soal, $kd_lokal)
    {
        // Mengambil skor pilihan ganda berdasarkan id_user
        return DB::table('jawabs')
            ->where('id_soal', $id_soal)
            ->where('id_kelas', $kd_lokal)
            ->select('id_user', DB::raw('SUM(score) as total_score'))
            ->groupBy('id_user')
            ->pluck('total_score', 'id_user')
            ->toArray();
    }

    public function soals()
    {
        // Mengambil informasi soal untuk latihan berdasarkan nim
        return DB::table('distribusisoals')
            ->join('soals', 'distribusisoals.id_soal', '=', 'soals.id')
            ->join('mtk', 'soals.kd_mtk', '=', 'mtk.kd_mtk')
            ->join('toef_mhs', 'distribusisoals.id_kelas', '=', 'toef_mhs.kd_lokal')
            ->join('toef_materi', 'soals.id', '=', 'toef_materi.id_soal')
            ->where('toef_mhs.nim', auth()->user()->username)
            ->where('paket', 'LATIHAN')
            ->get()
            ->keyBy('id_soal')
            ->toArray();
    }

    public function hasil_ujian()
    {
        // Mengambil data hasil ujian berdasarkan id_user
        return DB::table('hasilujians')
            ->where('id_user', auth()->user()->username)
            ->get()
            ->keyBy('id_soal')
            ->toArray();
    }
}
