@extends('layouts.dosen.main')

@section('content')
<div class="main-container">
    <div class="table-container">
        <div class="alert alert-info" role="alert">
            <h4 class="alert-heading">Rekap Ajar Per Kampus Per Hari</h4>
        </div>
        <a href="/rekap/day" class="btn btn-primary float-right">Kembali</a>

        <div class="card-body">
            <div class="table-responsive">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="rekap-kampus-tab" data-toggle="tab" href="#rekap-kampus" role="tab" aria-controls="rekap-kampus" aria-selected="true">Rekap Ajar Per Kampus Per Hari</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="rekap-teori-tab" data-toggle="tab" href="#rekap-teori" role="tab" aria-controls="rekap-teori" aria-selected="false">Rekap Ajar Teori Per Hari</a>
                    </li>
                </ul>

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="rekap-kampus" role="tabpanel" aria-labelledby="rekap-kampus-tab">
                        <!-- Konten untuk Rekap Ajar Per Kampus Per Hari -->
                        <table id="myTable5" class="table custom-table">
                            <thead>
                                <tr style="background-color: #a16983" class="text-white">
                                
                                <th scope="col" style="width: 10%">NIP</th>
                                <th scope="col">kd</th>
                                <th scope="col">KELAS</th>
                                <th scope="col">SKS</th>
                                <th scope="col">Kode MTK</th>
                              
                                <th scope="col">TANGGAL</th>
                                <th scope="col">JAM MASUK</th>
                                <th scope="col">JAM KELUAR</th>
                                <th scope="col">NO RUANG</th>
                                <th scope="col">temu</th>
                                <th scope="col">sts_ajar</th>
                          
                                
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($rekaperkampus as $no => $role)
                                <tr>
                                    
                                    <td>{{ $role->nip }}</td>
                                    <td>{{ $role->kd_dosen }}</td>
                                    <td>{{ $role->kd_lokal }}</td>
                                    <td>{{ $role->sks }}</td>
                                    <td>{{ $role->nm_mtk }} - <b>{{ $role->kd_mtk }}
                                         </b></td>
                                    
                                    <td>{{ $role->tgl_ajar_masuk }}</td>
                                    <td><b>{{ $role->jam_masuk }}</b></td>
                                    <td><b>{{ $role->jam_keluar }}</b></td>
                                    <td>{{ $role->no_ruang }}</td>
                                    <td>{{ $role->pertemuan }}</td>
                                    <td>{{ $role->sts_ajar }}</td>
                                  
                                       
                                    
                                   
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="rekap-teori" role="tabpanel" aria-labelledby="rekap-teori-tab">
                        <!-- Konten untuk Rekap Ajar Teori Per Hari -->
                        <table id="copy-print-csv" class="table custom-table">
                            <thead>
                                <tr style="background-color: #a16983" class="text-white">
                                
                                <th scope="col" style="width: 10%">NIP</th>
                                <th scope="col">kd</th>
                                <th scope="col">KELAS</th>
                                <th scope="col"style="width: 2%">SKS</th>
                                <th scope="col">Kode MTK</th>
                              
                                <th scope="col">TANGGAL</th>
                                <th scope="col">JAM MASUK</th>
                                <th scope="col">JAM KELUAR</th>
                                <th scope="col">NO RUANG</th>
                                <th scope="col">temu</th>
                                <th scope="col">sts_ajar</th>
                          
                                
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($rekapajarhari as $no => $role)
                                <tr>
                                    
                                    <td>{{ $role->nip }}</td>
                                    <td>{{ $role->kd_dosen }}</td>
                                    <td>{{ $role->kd_lokal }}</td>
                                    <td style="width: 2%">{{ $role->sks }}</td>
                                    <td>{{ $role->nm_mtk }} - <b>{{ $role->kd_mtk }}
                                         </b></td>
                                    
                                    <td>{{ $role->tgl_ajar_masuk }}</td>
                                    <td><b>{{ $role->jam_masuk }}</b></td>
                                    <td><b>{{ $role->jam_keluar }}</b></td>
                                    <td>{{ $role->no_ruang }}</td>
                                    <td>{{ $role->pertemuan }}</td>
                                    <td>{{ $role->sts_ajar }}</td>
                                  
                                       
                                    
                                   
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div style="text-align: center">
                            {{--  {{$rekapajarhari->links("vendor.pagination.bootstrap-4")}}  --}}
                        </div>
                    
                    </div>
                </div>
            </div>
            {{-- <div class="note-section mt-4">
                <h3>Catatan</h3>
                <p><strong>Status Ajar (STS AJAR):</strong></p>
                <ul class="list-unstyled">
                    <li><strong>KP:</strong> Kelas Pengganti</li>
                    <li><strong>M:</strong> Input Manual</li>
                </ul>
            </div> --}}
        </div>
    </div>
</div>
@endsection
