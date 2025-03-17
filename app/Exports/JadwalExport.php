<?php

namespace App\Exports;

use App\Models\Jadwal;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class JadwalExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Jadwal::select(
            'no_j_klh', 'nip', 'kd_dosen', 'kd_dosen2', 'nip_aslab', 'nip_aslab2', 'kd_lokal',
            'kel_praktek', 'nohari', 'hari_t', 'jam_t', 'no_ruang', 'nm_mtk', 'kd_mtk',
            'sks', 'sksajar', 'status_ajar', 'cek', 'mulai', 'selesai', 'nm_kampus',
            'kd_gabung', 'jml_pertemuan', 'nm_dosen'
        )->get();
    }

    public function headings(): array
    {
        return [
            'No Jadwal', 'NIP', 'Kode Dosen', 'Kode Dosen 2', 'NIP Aslab', 'NIP Aslab 2',
            'Kode Lokal', 'Kelompok Praktek', 'No Hari', 'Hari', 'Jam', 'No Ruang', 'Nama Matkul',
            'Kode Matkul', 'SKS', 'SKS Ajar', 'Status Ajar', 'Cek', 'Mulai', 'Selesai',
            'Nama Kampus', 'Kode Gabung', 'Jumlah Pertemuan', 'Nama Dosen'
        ];
    }
}

