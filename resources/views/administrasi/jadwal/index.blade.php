@extends('layouts.dosen.main')

@section('content')

<div class="main-container">
    <div class="table-container">
        <div class="alert alert-success" role="alert">
            <h4 class="alert-heading">INFO PENTING</h4>
            <p><strong>(Khusus Mahasiswa Baru PASSWORD Default: Mhs-1945)</strong></p>
            <hr>
            <p><strong>(Khusus Dosen Baru PASSWORD Default: Dosen-1945)</strong></p>
        </div>
        <div class="t-header mb-3">
            <a href="#" class="btn btn-primary"><i class="icon-file"></i> Jadwal Mengajar Dosen</a>
        </div>

        <div class="card-body">
            <h5>*Catatan: Salah satu boleh dikosongkan</h5>
            <form action="/cari-lecturer/schedule" method="GET">
                <table class="table custom-table">
                    <tr>
                        <td><label for="kd_dosen">Kode Dosen</label></td>
                        <td><input type="text" name="kd_dosen" id="kd_dosen" placeholder="Masukkan Kode Dosen" class="form-control"></td>
                    </tr>
                    <tr>
                        <td><label for="kd_lokal">Kelas</label></td>
                        <td><input type="text" name="kd_lokal" id="kd_lokal" placeholder="Masukkan Kelas" class="form-control"></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-right">
                            <button type="submit" class="btn btn-info">Cari Data Jadwal</button>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-right">
                            <strong>Jumlah record di tabel Jadwal: {{ $jumlahPertemuan }}</strong>
                        </td>
                    </tr>
                </table>
            </form>
        </div>

        <div class="table-responsive mt-3">
            <table class="table table-striped table-bordered table-hover text-center">
                <thead>
                    <tr>
                        <th scope="col" style="width: 10%">NIP</th>
                        <th scope="col" style="width: 10%">AKRONIM</th>
                        <th scope="col" style="width: 10%">KELAS</th>
                        <th scope="col" style="width: 10%">HARI</th>
                        <th scope="col" style="width: 10%">JAM</th>
                        <th scope="col" style="width: 10%">RUANG</th>
                        <th scope="col" colspan="2" style="width: 20%">NAMA MTK</th>
                        <th scope="col" style="width: 5%">SKS</th>
                        <th scope="col" style="width: 10%">KD GABUNG</th>
                        <th scope="col" style="width: 10%">KEL PRAKTEK</th>
                        @can('jadwal_edit.adm') 
                            <th scope="col" style="width: 5%">AKSI</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jadwal as $role)
                    <tr>
                        <td>{{ $role->nip }}</td>
                        <td>{{ $role->kd_dosen }}</td>
                        <td>{{ $role->kd_lokal }}</td>
                        <td>{{ $role->hari_t }}</td>
                        <td>{{ $role->jam_t }}</td>
                        <td>{{ $role->no_ruang }}</td>
                        <td>{{ $role->nm_mtk }}</td>
                        <td><strong>{{ $role->kd_mtk }}</strong></td>
                        <td>{{ $role->sksajar }}</td>
                        <td>{{ $role->kd_gabung }}</td>
                        <td>{{ $role->kel_praktek }}</td>
            
                        @php
                            $idComponents = [
                                $role->nip,
                                $role->kd_dosen,
                                $role->kd_lokal,
                                $role->kel_praktek,
                                $role->hari_t,
                                $role->jam_t,
                                $role->no_ruang,
                                $role->kd_mtk,
                                $role->sks,
                                $role->mulai,
                                $role->selesai,
                                $role->selesai_interval,
                                $role->kd_gabung
                            ];
                            $idString = implode(',', $idComponents);
                            $id = Crypt::encryptString($idString);
                        @endphp
            
                        @can('jadwal_edit.adm') 
                            <td>
                                <a href="/lecturer/schedule/edit/{{ $id }}" class="btn btn-sm btn-info">Edit</a>
                            </td>
                        @endcan
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            <div class="d-flex justify-content-center mt-3">
                {{ $jadwal->links("vendor.pagination.bootstrap-4") }}
            </div>
        </div>
    </div>
</div>

@endsection
