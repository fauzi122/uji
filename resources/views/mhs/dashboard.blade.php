
@extends('layouts.mhs.main')

@section('content')
<div class="main-container">


    <!-- Page header start -->
   
    <!-- Page header end -->


    <!-- Content wrapper start -->
    <div class="content-wrapper">

        <div class="row gutters">
            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="account-settings">
                            <div class="user-profile">
                                <div class="">
              
                @if (Auth::user()->profile_photo_path!=null)
                <img src="{{ Storage::url('public/'.Auth::user()->profile_photo_path.'') }}" class="img-thumbnail" alt="{{ Auth::user()->name }}"/>
                @else

                <img src="{{ Storage::url('public/icon/profile.png') }}" class="img-thumbnail" >
                @endif
                               
                                </div>
                                <h5 class="user-name"></h5>
                                <h6 class="user-email"></h6>
                                <h6 class="user-email"></h6>
                            </div>
                            <div class="setting-links">
                               
                                {{-- <a href="tasks.html">
                                    <i class="icon-inbox"></i>
                                    Informasi
                                </a> --}}
                                <a href="{{ Storage::url('public/Panduan MyBest Mahasiswa.pdf') }}" target="_blank">
                                    <i class="icon-file-text"></i>
                                    Panduan Penggunaan 
                                </a>
                                {{--  <a href="https://www.youtube.com/watch?v=BbLEm3TUZnE&t=187s" target="_blank">
                                    <i class="icon-youtube"></i>
                                    Tutorial Penggunaan 
                                </a>  --}}

                                <a href="{{ Storage::url('public/PANDUAN_UJIAN_ONLINE_MHS_UBSI.pdf') }}" target="_blank">
                                    <i class="icon-file"></i>
                                    Panduan Ujian Online 
                                </a>
                                <a href="{{ Storage::url('public/Panduan Kuis MyBest Mahasiswa.pdf') }}" target="_blank">
                                    <i class="icon-file"></i>
                                    Panduan Kuis Online 
                                </a>

                              
                                {{-- <a href="faq.html">
                                    <i class="icon-info"></i>
                                    FAQ's
                                </a> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                <div class="card h-100">
                    <div class="card-header">
                        <div class="card-title">Profile Mahasiswa</div>
                    </div>
                    <div class="card-body">
                        <div class="row gutters">
                            <center><h3>
                                Yth. Bpk/Ibu Dosen,<br><br>

                <h3>Aturan Ujian Terbaru UTS/UAS/HER</h3>  
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Aturan Ujian</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><h4>1</h4></td>
                            <td><h4>Perangkat ujian hanya diperbolehkan menggunakan notebook/laptop.</h4></td>
                        </tr>
                        <tr>
                            <td><h4>2</h4></td>
                            <td><h4>Koneksi menggunakan wifi/paket data pribadi </h4></td>
                        </tr>
                        <tr>
                            <td><h4>3</h4></td>
                            <td><h4>KRS tidak perlu dicetak kembali saat ujian (cukup diabsen BAP oleh dosen dari kampusonline).</h4></td>
                        </tr>
                        <tr>
                            <td><h4>4</h4></td>
                            <td><h4>Saat ujian berlangsung, diatas meja hanya ada identitas pribadi & notebook/laptop (jika menggunakan kuota hp, hp ditaruh di dalam tas).</h4></td>
                        </tr>
                        <tr>
                            <td><h4>5</h4></td>
                            <td><h4>Mahasiswa yang selesai ujian lebih awal tidak di perkenankan keluar ruangan sebelum waktu ujian berakhir.</h4></td>
                        </tr>
                        <tr>
                            <td><h4>6</h4></td>
                            <td><h4>Pengawas disarankan lebih ketat dalam mengawas ujian untuk meminimalisir joki.</h4></td>
                        </tr>
                    </tbody>
                </table>
                </center>
							
                            {{--  buka  --}}
                            {{-- <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-12">
                                <div class="form-group">
                                    <label for="fullName">NIM</label>
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
                                    <label for="addRess">Kelas</label>
                                    <input type="text" class="form-control" id="addRess" 
                                    placeholder="{{ Auth::user()->kode }}"value="{{ Auth::user()->kode }}"
                                    readonly>
                                </div>
                              
                            </div> --}}
                           {{--  tutup  --}}

                            {{--  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">  --}}
                               
                                {{--  <div class="form-group">
                                    <label for="ciTy">Jurusan</label>
                                    <input type="name" class="form-control" id="ciTy" placeholder=""readonly>
                                </div>  --}}
                                {{--  <div class="form-group">
                                    <label for="sTate">Kampus</label>
                                    <input type="text" class="form-control" id="sTate" placeholder=""readonly>
                                </div>  --}}
                              
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                {{--w  <h1 class="btn btn-lg btn-info"> <b>*SEGERA LAKUKAN PERUBAHAN PASSWORD DEMI KEAMANAN AKUN ANDA. <a href="/user/profile">KLIK DI SINI</a></b></h1>  --}}
                                <div class="text-right">
                                  
                                    {{--  <button type="button" id="submit" name="submit" class="btn btn-dark">Edit</button>  --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        

    </div>
    <!-- Content wrapper end -->

   
</div>


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Informasi Penting</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><h5>
                    
                    {{-- Yth. Bapak/Ibu, Mohon bantuan Bapak/Ibu untuk menyampaikan informasi kepada para Mahasiswa. Terima kasih atas perhatian dan kerjasamanya.     --}}
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
