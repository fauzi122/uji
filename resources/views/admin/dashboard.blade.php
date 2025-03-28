@extends('layouts.dosen.main')

@section('content')
<div class="main-container">

    {{-- <p class="alert alert-warning" style="font-size: 1.5em;">
       <b>Info Penting: Selama UAS mulai tanggal 20 - 26 Januari 2025, menu rekap absen akan ditutup.</b>
    </p> --}}
    <!-- Content wrapper start -->
    <div class="content-wrapper">

        <div class="row gutters">
            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="account-settings">
                            <div class="user-profile">
                                <div>
                                    
                                 {{--  <img src="{{ Storage::url('public/icon/profile.png') }}" alt="..." class="img-thumbnail">  --}}
                                    
                {{-- <img src="http://api.bsi.ac.id/v2/index.php/manage/foto-dosen/{{ Auth::user()->username }}"> --}}

                  {{-- @if (Auth::user()->profile_photo_path!=null) --}}
                {{-- <img src="{{ Storage::url('public/'.Auth::user()->profile_photo_path.'') }}" class="img-thumbnail" alt="{{ Auth::user()->name }}"/> --}}
                {{-- <img src="{{ Storage::url('public/icon/profile.png') }}" class="circle"  alt="4215"/> --}}
                
                {{-- @else --}}

                <img src="{{ Storage::url('public/icon/profile.png') }}" class="img-thumbnail" >
                {{-- @endif --}}

                                </div>
                                <h5 class="user-name"></h5>
                                <h6 class="user-email"></h6>
                                <h6 class="user-email"></h6>
                            </div>
                            <div class="setting-links">

                                <a href="{{ Storage::url('public/Panduan MyBest Dosen.pdf') }}" target="_blank">
                                    <i class="icon-file-text"></i>
                                    Panduan Penggunaan 
                                </a>
                                <a href="https://www.youtube.com/watch?v=P7Dz5qzzMBo&feature=youtu.be" target="_blank">
                                    <i class="icon-youtube"></i>
                                    Tutorial Penggunaan 
                                </a>
                                <a href="{{ Storage::url('public/PANDUAN_UJIAN_ONLINE DOSEN UBSI.pdf') }}" target="_blank">
                                    <i class="icon-file-text"></i>
                                    Panduan Ujian Online 
                                </a>
                                <a href="{{ Storage::url('public/Panduan Kuis MyBest Dosen.pdf') }}" target="_blank">
                                    <i class="icon-file-text"></i>
                                    Panduan Kuis Online 
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                <div class="nav-tabs-container">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">
                            <i class="icon-new_releases" > Pengumuman</i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">
                                <i class="icon-user" > Profile</i></a>
                        </li>
                      
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <p>
                                <div class="table-responsive">
                                    {{-- <table id="copy-print-csv" class="table custom-table">
                                      <thead>
                                        <tr>
                                          <th>Judul</th>
                                          
                                        
                                        </tr>
                                       </thead>
                                       @foreach ($info as $no => $info)
                                      <tr>
                                        <td>
                                        
                                         @if (isset($info->file))
                                        <form action="/download-file-info" method="post">
                                         @csrf
                                        <h4 class="status text-info"> <i class="icon-file"></i>
                                        {{ $info->title }} </h4> {{ $info->created_at }}  <span class="badge badge-info badge-pill"></span>
                 
                                        <input type="hidden" name="id" value="{{$info->id}}">
                                        <input type="hidden" name="file" value="{{$info->file}}">
                                         <button type="submit" class="btn btn-info btn-rounded btn-sm"> Unduh</button>
                         
                                        </form>  
                                        @endif 
                                        
                                        </td>
                                     </tr>
                                        @endforeach
                                            
                                          
                                      </tbody>
                                    </table> --}}
                                     <center><h3>
                                    Yth. Bpk/Ibu Dosen,<br><br>

 <h1>Aturan Ujian Terbaru UTS/UAS/HER</h1>  
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Aturan Ujian</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Perangkat ujian hanya diperbolehkan menggunakan notebook/laptop.</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Koneksi menggunakan wifi/paket data pribadi</td>
            </tr>
            <tr>
                <td>3</td>
                <td>KRS tidak perlu dicetak kembali saat ujian (cukup diabsen BAP oleh dosen dari kampusonline).</td>
            </tr>
            <tr>
                <td>4</td>
                <td>Saat ujian berlangsung, diatas meja hanya ada identitas pribadi & notebook/laptop (jika menggunakan kuota hp, hp ditaruh di dalam tas).</td>
            </tr>
            <tr>
                <td>5</td>
                <td>Mahasiswa yang selesai ujian lebih awal tidak di perkenankan keluar ruangan sebelum waktu ujian berakhir.</td>
            </tr>
            <tr>
                <td>6</td>
                <td>Pengawas disarankan lebih ketat dalam mengawas ujian untuk meminimalisir joki.</td>
            </tr>
        </tbody>
    </table>

                                </div>
                            </p>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <p>
                                <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-12">
                                    <div class="form-group">
                                        <label for="fullName">NIP</label>
                                        <input type="text" class="form-control" id="fullName"
                                         placeholder="{{ Auth::user()->username }}" name="nim"
                                        value="{{ Auth::user()->username }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="eMail">Nama</label>
                                        <input type="email" class="form-control"
                                         id="eMail" placeholder="{{ Auth::user()->name }}" readonly 
                                         name="name" value="{{ Auth::user()->name }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Email</label>
                                        <input type="text" class="form-control"
                                         id="phone" placeholder="{{ Auth::user()->email }}"readonly 
                                         name="email" value="{{ Auth::user()->email }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="website">Kode Dosen</label>
                                        <input type="url" class="form-control" 
                                        id="website" placeholder="{{ Auth::user()->kode }}" readonly
                                        name="kd_dosen" value="{{ Auth::user()->kode }}">
                                    </div>
                                </div>
                               
                            </p>
                        </div>
                      
                    </div>
                </div>
            </div>
        </div>

        

    </div>
    <!-- Content wrapper end -->

<!-- Modal -->
{{-- <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pesan Penting</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><h5>
                    
                    Yth. Bapak/Ibu, Mohon bantuan Bapak/Ibu untuk menyampaikan informasi kepada para Mahasiswa. Terima kasih atas perhatian dan kerjasamanya.    
                </h5></p>
                <br>
                <a href="{{ Storage::url('public/info/v3E3TN8DtZ9YAcV9ebtvtIhxnCQAkWLk2Tmo9HRr.pdf') }}" target="_blank" class="btn btn-primary btn-block">
                    <h4>
                        <i class="icon-file-text"></i> Pengumuman Pembayaran Kuliah Smt. Genap 2024-2024 - UBSI (6 Des 24)
                    </h4>
                </a>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div> --}}

<script>
    $(document).ready(function() {
        $('#exampleModal').modal('show');
    });
</script>
</div>

@endsection
<!-- Bootstrap CSS -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
