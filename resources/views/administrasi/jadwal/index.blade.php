@extends('layouts.dosen.main')

@section('content')
<div class="main-container">
    <div class="table-container">
        <div class="alert alert-success text-center" role="alert">
            <h4 class="alert-heading">Jadwal Mengajar Dosen</h4>
            <hr>
            <p><strong>(Dosen Baru PASSWORD Default: Dosen-1945) (MHS Baru PASSWORD Default: Mhs-1945)</strong></p>
        </div>

        <!-- Tab Navigation -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="today-tab" data-toggle="tab" href="#today" role="tab" aria-controls="today" aria-selected="true">
                    Jadwal Hari Ini Perkampus <i>({{ $totalCount ?? 0 }})</i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="all-tab" data-toggle="tab" href="#all" role="tab" aria-controls="all" aria-selected="false">
                    Jadwal Perkampus <i>({{ $totalperkampus ?? 0 }})</i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="campus-tab" data-toggle="tab" href="#campus" role="tab" aria-controls="campus" aria-selected="false">
                    Semua Jadwal <i>({{ $jumlahPertemuan ?? 0 }})</i>
                </a>
            </li>
        </ul>

        <!-- Form Pencarian -->
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
            {{-- <form action="{{ route('jadwal.download') }}" method="GET">
                <label for="kampus">Pilih Kampus:</label>
                <select name="kampus" id="kampus" class="form-control">
                    <option value="">Semua Kampus</option>
                    @foreach($kampus_list as $kampus)
                        <option value="{{ $kampus->nm_kampus }}">{{ $kampus->nm_kampus }}</option>
                    @endforeach
                </select>
                
                <button type="submit" class="btn btn-info mt-2">Download Jadwal</button>
            </form> --}}
        </div>

        <!-- Tab Content -->
        <div class="tab-content" id="myTabContent">
            @foreach (['today' => $jadwal_htoday, 'all' => $jadwal_kampus, 'campus' => $jadwal] as $tabId => $scheduleData)
            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $tabId }}" role="tabpanel" aria-labelledby="{{ $tabId }}-tab">
                <div class="table-responsive">
                    <table id="jadwalTable" class="table table-striped table-bordered table-hover text-center">
                        <thead>
                            <tr style="background-color: {{ $tabId == 'today' ? '#d22375' : ($tabId == 'all' ? '#1e7fe0' : '#6b2121') }}" class="text-white">
                                <th scope="col" style="min-width: 100px;">NIP</th>
                                <th scope="col" style="min-width: 80px;">Kode</th>
                                <th scope="col" style="min-width: 100px;">Kelas</th>
                                <th scope="col" style="min-width: 80px;">Hari</th>
                                <th scope="col" style="min-width: 120px;">Jam</th>
                                <th scope="col" style="min-width: 100px;">Ruang</th>
                                <th scope="col" style="min-width: 200px;">Nama MTK</th>
                                <th scope="col" style="min-width: 60px;">SKS</th>
                                <th scope="col" style="min-width: 120px;">KD Gabung</th>
                                <th scope="col" style="min-width: 120px;">Kel Praktek</th>
                                <th scope="col" style="min-width: 150px;">Kampus</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($scheduleData as $role)
                            <tr>
                                <td>{{ $role->nip ?? '-' }}</td>
                                <td>{{ $role->kd_dosen ?? '-' }}</td>
                                <td>{{ $role->kd_lokal ?? '-' }}</td>
                                <td>{{ $role->hari_t ?? '-' }}</td>
                                <td>{{ $role->jam_t ?? '-' }}</td>
                                <td>{{ $role->no_ruang ?? '-' }}</td>
                                <td>{{ $role->nm_mtk ?? '-' }}</td>
                                <td>{{ $role->sksajar ?? '-' }}</td>
                                <td>{{ $role->kd_gabung ?? '-' }}</td>
                                <td>{{ $role->kel_praktek ?? '-' }}</td>
                                <td>{{ $role->nm_kampus ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="11" class="text-center">Tidak ada data jadwal tersedia</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div style="text-align: center">
                    {{ $scheduleData->links("vendor.pagination.bootstrap-4") }}
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Tambahkan CSS -->
<style>
.table th, .table td {
    white-space: nowrap; /* Menghindari teks terpotong */
    vertical-align: middle; /* Agar isi sejajar */
    text-align: center;
}

.table th {
    background-color: #6b2121 !important;
    color: white !important;
}

.table td {
    padding: 8px 12px;
    border: 1px solid #ddd;
}
</style>
<script>
    $(document).ready(function() {
        $('#jadwalTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'excel', 'csv', 'pdf', 'print'
            ]
        });
    });
    </script>
@endsection
