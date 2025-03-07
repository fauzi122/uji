@extends('layouts.dosen.main')

@section('content')
<div class="main-container">
    <div class="table-container"> 
        <div class="t-header" style="background-color: rgb(77, 77, 184); color: white;">
            <a href="#" class="header-link" style="color: white;">
            <i class="icon-documents"></i> Rekap Pengajaran Dosen
            </a>
        </div>
        <div class="card-body">
            <h2 class="section-title">Rekapitulasi Per Hari</h2>
            <div class="row gutters">
                <div class="col-xl-6 col-lg-4 col-md-4 col-sm-4 col-12">
                    <div class="info-tiles">
                        <div class="info-icon">
                            <i class="icon-activity"></i>
                        </div>
                        <div class="stats-detail">
                            <h3><a href="/rekap/teori-day">Rekap Ajar Teori & Kelas Gabungan</a></h3>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-4 col-md-4 col-sm-4 col-12">
                    <div class="info-tiles">
                        <div class="info-icon">
                            <i class="icon-filter_frames"></i>
                        </div>
                        <div class="stats-detail">
                            <h3><a href="/rekap/praktek-day">Rekap Ajar Praktek</a></h3>
                        </div>
                    </div>
                </div>
            </div>
            <br><br>
            <h2 class="section-title">Rekapitulasi Keseluruhan</h2>
            <div class="row gutters">
                <div class="col-xl-6 col-lg-4 col-md-4 col-sm-4 col-12">
                    <div class="info-tiles">
                        <div class="info-icon">
                            <i class="icon-check_circle"></i>
                        </div>
                        <div class="stats-detail">
                            <h3><a href="/rekap/teori-all">Rekap Ajar Teori & Kelas Gabungan</a></h3>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-4 col-md-4 col-sm-4 col-12">
                    <div class="info-tiles">
                        <div class="info-icon">
                            <i class="icon-filter_frames"></i>
                        </div>
                        <div class="stats-detail">
                            <h3><a href="/rekap/praktek-all">Rekap Ajar Praktek</a></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
