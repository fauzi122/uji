@extends('layouts.dosen.main')

@section('content')
<div class="main-container">

    <div class="table-container"> 
        <div class="t-header">
            <a href="#">
                <i class="icon-documents"></i> Rekap Pengajaran Dosen
            </a>
        </div>

        <div class="card-body">
            <h2 class="section-title">Rekapitulasi Per Hari</h2>
            <div class="row gutters">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="exam-tile">
                        <i class="icon-activity exam-icon"></i>
                        <h3><a href="/rekap/teori-day" class="exam-link">Rekap Ajar Teori & Kelas Gabungan</a></h3>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="exam-tile">
                        <i class="icon-activity exam-icon"></i>
                        <h3><a href="/rekap/praktek-day" class="exam-link">Rekap Ajar Praktek</a></h3>
                    </div>
                </div>
            </div>
            <br><br>
            <h2 class="section-title">Rekapitulasi Keseluruhan</h2>
            <div class="row gutters">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="exam-tile">
                        <i class="icon-filter_frames exam-icon"></i>
                        <h3><a href="/rekap/teori-all" class="exam-link">Rekap Ajar Teori & Kelas Gabungan</a></h3>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="exam-tile">
                        <i class="icon-filter_frames exam-icon"></i>
                        <h3><a href="/rekap/praktek-all" class="exam-link">Rekap Ajar Praktek</a></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f4f5f7;
        color: #333;
    }
    /* .main-container {
        padding: 20px;
        background: #ffffff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    } */

    .card-body {
        padding: 24px;
        text-align: left;
    }
    .section-title {
        font-size: 1.75rem;
        color: #07328C;
        margin-bottom: 24px;
    }
    .row.gutters {
        display: flex;
        flex-wrap: wrap;
        margin-right: -15px;
        margin-left: -15px;
    }
    .col-xl-6, .col-lg-6, .col-md-6, .col-sm-6, .col-12 {
        padding-right: 15px;
        padding-left: 15px;
        margin-bottom: 20px;
    }
    .exam-tile {
        background-color: #e9ecef;
        border-radius: 8px;
        padding: 20px;
        display: flex;
        align-items: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .exam-tile:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.15);
    }
    .exam-icon {
        font-size: 24px;
        margin-right: 15px;
        color: #007bff;
    }
    .exam-link {
        font-size: 1.1rem;
        color: #495057;
        text-decoration: none;
    }
    .exam-link:hover {
        color: #007bff;
        text-decoration: underline;
    }
</style>
@endsection
