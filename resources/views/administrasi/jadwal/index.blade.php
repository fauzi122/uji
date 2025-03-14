@extends('layouts.dosen.main')

@section('content')
<div class="main-container">
    <div class="table-container">
        <div class="alert alert-success" role="alert">
            <h4 class="alert-heading">Jadwal Mengajar Dosen</h4>
            {{-- <p><strong>(Khusus Mahasiswa Baru PASSWORD Default: Mhs-1945)</strong></p> --}}
            <hr>
            <p><strong>( Dosen Baru PASSWORD Default: Dosen-1945) ( MHS Baru PASSWORD Default: Mhs-1945)</strong></p>
        </div>

        <!-- Tab Navigation -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            
            <li class="nav-item">
                <a class="nav-link active" id="today-tab" data-toggle="tab" href="#today" role="tab" aria-controls="today" aria-selected="true">Jadwal Hari Ini Perkampus <i>({{ $totalCount }})</i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="all-tab" data-toggle="tab" href="#all" role="tab" aria-controls="all" aria-selected="false">Jadwal Perkampus <i>({{ $totalperkampus }})</i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="campus-tab" data-toggle="tab" href="#campus" role="tab" aria-controls="campus" aria-selected="false">Semua Jadwal <i>({{ $jumlahPertemuan }})</i></a>
            </li>

        </ul>
        <div class="card-body">
            <h5><i>*Catatan: Salah satu boleh dikosongkan</i></h5>
            <form action="/cari-lecturer/schedule" method="GET" class="p-3 border rounded">
                <div class="form-row align-items-center">
                    <div class="col-auto">
                        <label for="kd_dosen" class="sr-only">Kode Dosen</label>
                        <input type="text" name="kd_dosen" id="kd_dosen" class="form-control mb-2" placeholder="Masukkan Kode Dosen">
                    </div>
                    <div class="col-auto">
                        <label for="kd_lokal" class="sr-only">Kelas</label>
                        <input type="text" name="kd_lokal" id="kd_lokal" class="form-control mb-2" placeholder="Masukkan Kelas">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-info mb-2">Cari Data Jadwal</button>
                    </div>
                </div>
            </form>
            

        </div>
        
        <!-- Tab Content -->
        <div class="tab-content" id="myTabContent">
            <!-- Today's Schedules Tab -->
            <div class="tab-pane fade show active" id="today" role="tabpanel" aria-labelledby="today-tab">
            <table class="table table-striped table-bordered table-hover text-center">
                <thead>
                <tr style="background-color: #d22375" class="text-white">
                    <th scope="col" style="width: 10%">NIP</th>
                    <th scope="col" style="width: 10%">kode</th>
                    <th scope="col" style="width: 10%">KELAS</th>
                    <th scope="col" style="width: 10%">HARI</th>
                    <th scope="col" style="width: 10%">JAM</th>
                    <th scope="col" style="width: 10%">RUANG</th>
                    <th scope="col" colspan="2" style="width: 20%">NAMA MTK</th>
                    <th scope="col" style="width: 5%">SKS</th>
                    <th scope="col" style="width: 10%">KD GABUNG</th>
                    <th scope="col" style="width: 10%">KEL PRAKTEK</th>
                    <th scope="col" style="width: 10%">kampus</th>
                    @can('jadwal_edit.adm') 
                    {{-- <th scope="col" style="width: 5%">AKSI</th> --}}
                    @endcan
                </tr>
                </thead>
                <tbody>
                @foreach ($jadwal_htoday as $role)
                <tr>
                    <td>{{ $role->nip }}
                        
                    </td>
              
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
                    <td>{{ $role->nm_kampus }}</td>
            
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
                    {{-- <td>
                        <a href="" class="btn btn-sm btn-info">i</a>
                    </td> --}}
                    @endcan
                </tr>
                @endforeach
                </tbody>
            </table>
            <div style="text-align: center">
                {{$jadwal_htoday->links("vendor.pagination.bootstrap-4")}}
            </div>
            </div>

            <!-- All Schedules Tab -->
            <div class="tab-pane fade" id="all" role="tabpanel" aria-labelledby="all-tab">
            <table class="table table-striped table-bordered table-hover text-center">
                <thead>
                <tr style="background-color: #1e7fe0" class="text-white">
                    <th scope="col" style="width: 10%">NIP</th>
                    <th scope="col" style="width: 10%">kode</th>
                    <th scope="col" style="width: 10%">KELAS</th>
                    <th scope="col" style="width: 10%">HARI</th>
                    <th scope="col" style="width: 10%">JAM</th>
                    <th scope="col" style="width: 10%">RUANG</th>
                    <th scope="col" colspan="2" style="width: 20%">NAMA MTK</th>
                    <th scope="col" style="width: 5%">SKS</th>
                    <th scope="col" style="width: 10%">KD GABUNG</th>
                    <th scope="col" style="width: 10%">KEL PRAKTEK</th>
                    <th scope="col" style="width: 10%">kampus</th>
                    @can('jadwal_edit.adm') 
                    {{-- <th scope="col" style="width: 5%">AKSI</th> --}}
                    @endcan
                </tr>
                </thead>
                <tbody>
                @foreach ($jadwal_kampus as $role)
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
                    <td>{{ $role->nm_kampus }}</td>
            
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
                    {{-- <td>
                        <a href="/lecturer/schedule/edit/{{ $id }}" class="btn btn-sm btn-info">Edit</a>
                    </td> --}}
                    @endcan
                </tr>
                @endforeach
                </tbody>
            </table>
            <div style="text-align: center">
                {{$jadwal_kampus->links("vendor.pagination.bootstrap-4")}}
            </div>
            </div>

            <!-- Campus Schedules Tab -->
            <div class="tab-pane fade" id="campus" role="tabpanel" aria-labelledby="campus-tab">
                <table class="table table-striped table-bordered table-hover text-center">
                    <thead>
                    <tr style="background-color: #6b2121" class="text-white">
                        <th scope="col" style="width: 10%">NIP</th>
                        <th scope="col" style="width: 10%">kode</th>
                        <th scope="col" style="width: 10%">KELAS</th>
                        <th scope="col" style="width: 10%">HARI</th>
                        <th scope="col" style="width: 10%">JAM</th>
                        <th scope="col" style="width: 10%">RUANG</th>
                        <th scope="col" colspan="2" style="width: 20%">NAMA MTK</th>
                        <th scope="col" style="width: 5%">SKS</th>
                        <th scope="col" style="width: 10%">KD GABUNG</th>
                        <th scope="col" style="width: 10%">KEL PRAKTEK</th>
                        <th scope="col" style="width: 10%">kampus</th>
                        @can('jadwal_edit.adm') 
                        {{-- <th scope="col" style="width: 5%">AKSI</th> --}}
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
                        <td>{{ $role->nm_kampus }}</td>
                
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
                        {{-- <td>
                            <a href="/lecturer/schedule/edit/{{ $id }}" class="btn btn-sm btn-info">Edit</a>
                        </td> --}}
                        @endcan
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                <div style="text-align: center">
                    {{$jadwal->links("vendor.pagination.bootstrap-4")}}
                </div>
    </div>
</div>
@endsection
