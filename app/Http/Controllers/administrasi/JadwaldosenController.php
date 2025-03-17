<?php

namespace App\Http\Controllers\administrasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use App\Exports\JadwalExport;
use Maatwebsite\Excel\Facades\Excel;


class JadwaldosenController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:jadwaldosen_adm.index']);
        if (!$this->middleware('auth:sanctum')) {
            return redirect('/login');
        }
    }
    public function index()
    {
        $kampus_list = DB::table('jadwal')->select('nm_kampus')->distinct()->get();
        $jumlahPertemuan = DB::table('jadwal')->count();
      
        // jadwal all
        $jadwal = DB::table('jadwal')
        ->when(request()->q, function ($jadwal) {
            $jadwal = $jadwal->where('kd_dosen', 'like', '%' . request()->q . '%');
        })->paginate(30);

        // jadwal per kampus
        $jadwal_kampus = DB::table('jadwal')->join('user_adm', 'jadwal.nm_kampus', '=', 'user_adm.kampus')
        ->select('jadwal.*', 'user_adm.nip as nip_adm')
        ->where('user_adm.nip', auth()->user()->username)
        ->when(request()->q, function ($jadwal) {
            $jadwal = $jadwal->where('jadwal.kd_dosen', 'like', '%' . request()->q . '%');
        });
    
        // Menghitung total baris sebelum pagination
        $totalperkampus = $jadwal_kampus->count();
        $jadwal_kampus = $jadwal_kampus->paginate(20);


        // Hari ini
        $hari_ini = hari_ini(date('Y-m-d'));
        
        // Buat query tanpa memanggil paginate terlebih dahulu
        $jadwal_query = DB::table('jadwal')
            ->join('user_adm', 'jadwal.nm_kampus', '=', 'user_adm.kampus')
            ->select('jadwal.*', 'user_adm.nip as nip_adm')
            ->where('user_adm.nip', auth()->user()->username)
            ->where('jadwal.hari_t', $hari_ini)
            ->when(request()->q, function ($query) {
                $query->where('jadwal.kd_dosen', 'like', '%' . request()->q . '%');
            });
        
        $totalCount = $jadwal_query->count();
        
        $jadwal_htoday = $jadwal_query->paginate(20);
        
    
        return view('administrasi.jadwal.index', compact('jadwal','jumlahPertemuan','jadwal_kampus',
        'jadwal_htoday','totalCount','totalperkampus','kampus_list'));
    }

    public function edit($id)
    {
        $decryptedString = Crypt::decryptString($id);
        $pecah = explode(',', $decryptedString);

        $tugas =  DB::table('jadwal')->where([
            'nip'              => $pecah[0],
            'kd_dosen'         => $pecah[1],
            'kd_lokal'         => $pecah[2],
            'kel_praktek'      => $pecah[3],
            'hari_t'           => $pecah[4],
            'jam_t'            => $pecah[5],
            'no_ruang'         => $pecah[6],
            'kd_mtk'           => $pecah[7],
            'sks'              => $pecah[8],
            'mulai'            => $pecah[9],
            'selesai'          => $pecah[10],
            'selesai_interval' => $pecah[11],
            'kd_gabung'        => $pecah[12],
        ])->first();

        if ($tugas) {
            // Record ditemukan, lakukan apa yang perlu dilakukan. Misalnya,
            return view('administrasi.jadwal.edit', compact('tugas'));
        } else {
            // Record tidak ditemukan, tampilkan pesan error atau lakukan redirect. Misalnya,
            return redirect('/lecturer/schedule')->with('error', 'Tugas tidak ditemukan');
        }
    }


    public function update(Request $request, $id)
    {
        try {
            // Validasi input sesuai kebutuhan Anda
            $request->validate([
                // 'field1' => 'required',
                // 'field2' => 'required',
                // Tambahkan validasi lainnya sesuai dengan kolom yang ada
            ]);
    
            // Decrypt ID untuk identifikasi dalam database
            $decryptedString = Crypt::decryptString($id);
            $pecah = explode(',', $decryptedString);
    
            // Pengecekan data setelah dekripsi
            if (count($pecah) != 13) {
                return redirect()->back()->with('error', 'Data tidak valid.');
            }
    
            // Update data jadwal dengan data baru
            $updated = DB::table('jadwal')
                ->where([
                    'nip'              => $pecah[0],
                    'kd_dosen'         => $pecah[1],
                    'kd_lokal'         => $pecah[2],
                    'kel_praktek'      => $pecah[3],
                    'hari_t'           => $pecah[4],
                    'jam_t'            => $pecah[5],
                    'no_ruang'         => $pecah[6],
                    'kd_mtk'           => $pecah[7],
                    'sks'              => $pecah[8],
                    'mulai'            => $pecah[9],
                    'selesai'          => $pecah[10],
                    'selesai_interval' => $pecah[11],
                    'kd_gabung'        => $pecah[12],
                ])
                ->update([
                    'nip'               => $request->input('nip'),
                    'kd_dosen'          => $request->input('kd_dosen'),
                    'kd_lokal'          => $request->input('kd_lokal'),
                    'kel_praktek'       => $request->input('kel_praktek'),
                    'hari_t'            => $request->input('hari_t'),
                    'jam_t'             => $request->input('jam_t'),
                    'no_ruang'          => $request->input('no_ruang'),
                    'nm_mtk'            => $request->input('nm_mtk'),
                    'kd_mtk'            => $request->input('kd_mtk'),
                    'sks'               => $request->input('sks'),
                    'mulai'             => $request->input('mulai'),
                    'selesai'           => $request->input('selesai'),
                    'selesai_interval'  => $request->input('selesai_interval'),
                    'nm_kampus'         => $request->input('nm_kampus'),
                    'nm_dosen'          => $request->input('nm_dosen')
                    // Update kolom lainnya sesuai dengan kebutuhan
                ]);
    
            if (!$updated) {
                return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui jadwal.');
            }
    
            return redirect('/lecturer/schedule')->with('success', 'Jadwal berhasil diperbarui.');
    
        } catch (DecryptException $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mendekripsi data.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan tidak terduga.');
        }
    }
    


    public function search(Request $request)
    {
        $kd_dosen = $request->input('kd_dosen');
        $kd_lokal = $request->input('kd_lokal');

        $query = DB::table('jadwal');
        if ($kd_dosen) {
            $query->where('kd_dosen', $kd_dosen);
        }
        if ($kd_lokal) {
            $query->where('kd_lokal', $kd_lokal);
        }
        $result = $query->get();

        return view('administrasi.jadwal.cari', compact('result', 'kd_lokal', 'kd_dosen'));
    }

    
    public function hari_ini($tanggal)
    {
        $hari = date("D", strtotime($tanggal));

        switch ($hari) {
            case 'Sun':
                return "Minggu";
            case 'Mon':
                return "Senin";
            case 'Tue':
                return "Selasa";
            case 'Wed':
                return "Rabu";
            case 'Thu':
                return "Kamis";
            case 'Fri':
                return "Jumat";
            case 'Sat':
                return "Sabtu";
            default:
                return "Tidak Diketahui";
        }
    }


    public function downloadJadwal(Request $request)
    {
        $kampus = $request->input('kampus');
    
        // Query jadwal berdasarkan kampus yang dipilih
        $jadwal = DB::table('jadwal')
            ->join('user_adm', 'jadwal.nm_kampus', '=', 'user_adm.kampus')
            ->select(
                'jadwal.no_j_klh',
                'jadwal.nip',
                'jadwal.kd_dosen',
                'jadwal.kd_dosen2',
                'jadwal.nip_aslab',
                'jadwal.nip_aslab2',
                'jadwal.kd_lokal',
                'jadwal.kel_praktek',
                'jadwal.nohari',
                'jadwal.hari_t',
                'jadwal.jam_t',
                'jadwal.no_ruang',
                'jadwal.nm_mtk',
                'jadwal.kd_mtk',
                'jadwal.sks',
                'jadwal.sksajar',
                'jadwal.status_ajar',
                'jadwal.cek',
                'jadwal.mulai',
                'jadwal.selesai',
                'jadwal.nm_kampus',
                'jadwal.kd_gabung',
                'jadwal.jml_pertemuan',
                'jadwal.nm_dosen'
            )
            ->when($kampus, function ($query, $kampus) {
                return $query->where('jadwal.nm_kampus', $kampus);
            })
            ->get();
    
        // Menggunakan Excel export untuk mendownload data dalam format Excel
        return Excel::download(new JadwalExport($jadwal), 'jadwal.xlsx');
    }
    

}
