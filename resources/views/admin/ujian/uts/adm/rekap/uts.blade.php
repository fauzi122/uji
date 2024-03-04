@extends('layouts.dosen.ujian.main')

@section('content')
    <div class="content-wrapper">
        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="alert-notify info">
                    <div class="alert-notify-body">
                        <span class="type">Info</span>
                        <span class="type">Info</span>
                        <div class="alert-notify-title">
                            <h4>Rekap Mengawas Ujian UTS</h4>
                        </div>
                       
                        
                    </div>
                </div>
                <div class="card">
                    <div class="card-body p-0">
                        <div class="invoice-container">
                            <div class="invoice-header">
                                <div class="row gutters">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="table-responsive">
                                            <table id="copy-print-csv" class="table custom-table">
                                                <thead>
                                                    <tr>
                                                        <th>NO</th>
                                                        <th>DOSEN</th>
                                                        <th>MTK</th>
                                                        <th>KEL-UJIAN</th>
                                                        <th>HARI </th>
                                                        <th>tgl berita acara</th>
                                                        <th>Aksi</th>

                                                       
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($uts as $no => $hasil)
                                                        <tr>
                                                            <td>{{ ++$no }}</td>
                                                            <td>
                                                                {{ $hasil->name }} - <b>{{ $hasil->kd_dosen }}</b>
                                                            </td>
                                                            <td>{{ $hasil->nm_mtk }} -
                                                               <b> {{ $hasil->kd_mtk }}<b>
                                                            </td>
                                                            
                                                            <td>{{ $hasil->kel_ujian }}</td>
                                                            <td>{{ $hasil->hari }}</td>
                                                            <td>{{ $hasil->created_at }}</td>
                                                            <td>
                                                                @php
                                                                    $id=Crypt::encryptString($hasil->kd_dosen.','.$hasil->kd_mtk.','.$hasil->kel_ujian.','.$hasil->paket);                                    
                                                                    @endphp
                                                                <a href="/adm/show-rekap-mengawas/{{ $id }}"  value="Delete" class="btn btn-xs btn-info">
                                                                    <i class="fa fa-check"></i> Detail </button>
                                                            </td>
                                                           
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
