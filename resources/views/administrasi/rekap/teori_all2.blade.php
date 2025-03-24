@extends('layouts.dosen.main')

@section('content')

<div class="container-fluid mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0 text-center">Rekap Ajar Teori ALL</h4>
        </div>
        <div class="card-body">
            <h5 class="text-muted">
                *Catatan: kode dosen dapat dikosongkan jika pencarian hanya ingin berdasarkan kampus atau tanggal saja
            </h5>

            <!-- Form Pencarian -->
            <form action="/cari-rekap-teori" method="GET" class="mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <label for="kd_dosen"><b>Kode Dosen</b></label>
                        <input type="text" name="kd_dosen" placeholder="Masukkan Kode Dosen" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label for="tgl_awal"><b>Tanggal Awal</b></label>
                        <input type="date" required name="tgl_awal" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label for="tgl_akhir"><b>Tanggal Akhir</b></label>
                        <input type="date" required name="tgl_akhir" class="form-control">
                    </div>
                </div>
                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-info"><i class="fa fa-search"></i> Cari Data Rekap</button>
                </div>
            </form>

            <!-- Form Pencarian Cepat -->
            <form action="/rekap/teori-all" method="GET" class="mb-4">
                <div class="input-group">
                    <input type="text" class="form-control" name="q" placeholder="Cari berdasarkan kode dosen">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> CARI</button>
                </div>
            </form>

            <!-- Tabel Rekap -->
            <div class="table-responsive">
                <table class="table custom-table table-bordered table-hover">
                    <thead class="bg-dark text-white text-center">
                        <tr>
                            <th scope="col" style="width: 10%">NIP</th>
                            <th scope="col">KD Dosen</th>
                            <th scope="col">Kelas</th>
                            <th scope="col">SKS</th>
                            <th scope="col">Kode MTK</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Hari</th>
                            <th scope="col" class="text-center">Jam Masuk</th>
                            <th scope="col" class="text-center">Jam Keluar</th>
                            <th scope="col">No Ruang</th>
                            <th scope="col">Pertemuan</th>
                            <th scope="col">Status Ajar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rekapajarall as $role)
                        <tr class="text-center">
                            <td>{{ $role->nip }}</td>
                            <td>{{ $role->kd_dosen }}</td>
                            <td>{{ $role->kd_lokal }}</td>
                            <td>{{ $role->sks }}</td>
                            <td>{{ $role->nm_mtk }} - <b>{{ $role->kd_mtk }}</b></td>
                            <td>{{ $role->tgl_ajar_masuk }}</td>
                            <td>{{ $role->hari_ajar_masuk }}</td>
                            <td class="text-center">
                                <span class="badge bg-success p-1 fs-2 fw-bold text-white shadow">
                                   <h5> {{ $role->jam_masuk }}</h5>
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-success p-1 fs-2 fw-bold text-white shadow">
                                    <h5>{{ $role->jam_keluar }}</h5>
                                </span>
                            </td>
                            <td>{{ $role->no_ruang }}</td>
                            <td>{{ $role->pertemuan }}</td>
                            <td>
                                <span class="badge bg-secondary">{{ $role->sts_ajar }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="text-center">
                    {{$rekapajarall->links("vendor.pagination.bootstrap-4")}}
                </div>
            </div>

            <!-- Catatan Status Ajar -->
            <div class="mt-4">
                <h5>Catatan (STS AJAR):</h5>
                <ul class="list-group">
                    <li class="list-group-item">KP = Kelas Pengganti</li>
                    <li class="list-group-item">M = Input Manual</li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection
