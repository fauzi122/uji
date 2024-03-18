<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\Models\Ujian_berita_acara;
use Illuminate\Http\Request;
use App\Models\Soal_ujian;
use App\Models\Absen_ujian;
use App\Models\Distribusisoal_ujian;

class MengawasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.mengawas.index');
    }

    public function m_uts()
    {
        $uts = Soal_ujian::where('kd_dosen', Auth::user()->kode)
        ->where('paket', 'UTS')
            ->get();
        return view('admin.mengawas.uts', compact('uts'));
    }

    public function m_uas()
    {
        $uas = DB::table('uts_soals')
            ->where('kd_dosen', Auth::user()->kode)
            ->where('paket', 'UAS')
            ->get();
        return view('admin.mengawas.uas', compact('uas'));
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
    public function store(Request $request)
    {
        $this->validate($request, [
            'kd_mtk'    => 'required', 
            'kel_ujian' => 'required',
            'hari'      => 'required',
            'paket'     => 'required',
            'isi'       => 'required',
        ]);
    
        // Define the unique keys for searching. Example: 'kd_mtk' and 'kel_ujian'
        $uniqueKeys = [
            'kd_mtk' => $request->input('kd_mtk'),
            'kel_ujian' => $request->input('kel_ujian'),
        ];
    
        // Data to be updated or created
        $data = [
            'kd_dosen' => Auth::user()->kode,
            'hari'     => $request->input('hari'),
            'paket'    => $request->input('paket'),
            'isi'      => $request->input('isi'),
        ];
    
        // Update or create
        $berita = Ujian_berita_acara::updateOrCreate($uniqueKeys, $data);
    
        if ($berita) {
            return back()->with(['status' => 'Berhasil Di Kirim!']);
        } else {
            return back()->with(['error' => 'Gagal Berhasil Di Kirim!']);
        }
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_uts($id)
    {
        $pecah = explode(',', Crypt::decryptString($id));

        $soal = Soal_ujian::where([
            'kd_dosen'    => $pecah[0],
            'kd_mtk'      => $pecah[1],
            'kel_ujian'   => $pecah[2],
            'paket'       => $pecah[3],
            'hari_t'      => $pecah[4]
            ])->first();
            
        $beritaAcara = Ujian_berita_acara::where([
            'kd_dosen'  => $pecah[0],
            'kd_mtk'    => $pecah[1],
            'kel_ujian' => $pecah[2],
            'paket'     => $pecah[3]
            ])->first(); 
            // dd($beritaAcara); 
        $mhsujian = Absen_ujian::where([    
            'kd_mtk'        => $pecah[1],
            'no_kel_ujn'    => $pecah[2],
            'paket'         => $pecah[3]
           
            ])->get(); 
            
            return view('admin.mengawas.show', compact('soal','id','beritaAcara','mhsujian'));
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

    public function UpdateAbsenUjian(Request $request)
    {
        $id = $request->input('id');
        $status = $request->input('status');

        try {
            $kutipan = Absen_ujian::find($id);
            $kutipan->status = $status;
            $kutipan->kd_dosen =Auth::user()->kode;
            $kutipan->save();

            return response()->json(['message' => 'Status updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error updating status'], 500);
        }
    }

    public function updateKeterangan(Request $request)
    {
        // dd($request->all()); // Ini akan menampilkan semua data request di browser
    
        // Sisa kode untuk memproses data
        $item = Absen_ujian::findOrFail($request->id);
        $item->ket = $request->ket;
        $item->save();
    
        return response()->json(['message' => 'Keterangan berhasil diperbarui']);
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
