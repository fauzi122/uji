@extends('layouts.mhs.main')
@section('content')

<div class="row gutters">
    <div class="col-xl-2 col-lg-3 col-md-3 col-sm-3 col-4">
        <div class="info-tiles">
            <div class="info-icon">
                <i class="icon-account_circle"></i>
            </div>
            <div class="stats-detail">
                <h5>{{$exp[2]}}</h5>
                <p>Dosen</p>
            </div>
        </div>
        <div class="info-tiles">
            <div class="info-icon">
                <i class="icon-home2"></i>
            </div>
            <div class="stats-detail">
                <h5>{{$exp[7]}}</h5>
                <p>Ruang</p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-6">
        <div class="info-tiles">
            <div class="info-icon">
                <i class="icon-documents"></i>
            </div>
            <div class="stats-detail">
                <h5>{{$exp[1]}}</h5>
                <p>Matakuliah</p>
            </div>
        </div>
        <div class="info-tiles">
            <div class="info-icon">
                <i class="icon-layers"></i>
            </div>
            <div class="stats-detail">
                <h5>{{$exp[4]}}</h5>
                <p>Kelas</p>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-4">
        <div class="info-tiles">
            <div class="info-icon">
                <i class="icon-watch_later"></i>
            </div>
            <div class="stats-detail">
                <h5>{{substr($exp[6],0,5)}}</h5>
                <p>Jam Masuk</p>
            </div>
        </div>
        <div class="info-tiles">
            <div class="info-icon">
                <i class="icon-date_range"></i>
            </div>
            <div class="stats-detail">
                <h5>{{$exp[5]}}</h5>
                <p>Hari</p>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-4">
        <div class="info-tiles">
            <div class="info-icon">
                <i class="icon-clock1"></i>
            </div>
            <div class="stats-detail">
                <h5>{{substr($exp[6],6,11)}}</h5>
                <p>Jam Keluar</p>

            </div>
        </div>
        <div class="info-tiles">
            <div class="info-icon">
                <i class="icon-dribbble-with-circle"></i>
            </div>
            <div class="stats-detail">
                <h5>{{$exp[0]}}</h5>
                <p>Kode MTK</p>

            </div>
        </div>
    </div>

    {{-- @if ($komentar < 1) --}} <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="info-tiles">
            {{-- {{$absen->first()->pertemuan}} --}}

            @if ($absen->count() > 0)
            {{-- Cek apakah ada data absen --}}
            @if ($durasi > 0)
            {{-- Cek apakah durasi masih berlangsung ini nanti buka aja --}}
            {{-- @if ($kuisionerExists) --}}
            {{-- Cek apakah mahasiswa sudah mengisi kuesioner --}}
            @if ($absen_mhs > 0)
            {{-- Cek apakah mahasiswa sudah melakukan absensi --}}
            @if ($komentar < 1) {{-- Cek apakah mahasiswa sudah memberikan komentar --}} @php
                $cryp_pertemuan=Crypt::encryptString($absen->
                first()->pertemuan.',1,'.$absen->first()->nip.','.$pengganti.',');
                @endphp
                <form action="/komentar-mhs" method="post">
                    @csrf
                    <center>
                        <textarea class="form-control @error('komentar') is-invalid @enderror" rows="3" name="komentar"
                            placeholder="Berikan Komentar Anda Terhadap Pengajar Dosen">{{ old('komentar') }}</textarea>
                        @error('komentar')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="radio1" name="nilai" class="custom-control-input" value="1"
                                checked="checked"><label class="custom-control-label" for="radio1">Pengajaran
                                Sesuai</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="radio2" name="nilai" class="custom-control-input" value="0"><label
                                class="custom-control-label" for="radio2">Pengajaran Tidak Sesuai</label>
                        </div>
                        {{-- <input type="radio" name="nilai" value="1" checked="checked"><label for="hadir1">Pengajaran
                            Sesuai</label><br>
                        <input type="radio" name="nilai" value="0"><label for="hadir1">Pengajaran Tidak
                            Sesuai</label><br> --}}

                        <input type="hidden" name="pertemuan" value="{{$cryp_pertemuan}}">
                        {{-- <input type="hidden" name="status" value="1">
                        <input type="hidden" name="nip" value="{{$absen->first()->nip}}"> --}}
                        <input type="hidden" name="id" value="{{$id}}">
                        <button type="submit" class="btn btn-primary btn-rounded left mt-4"><i class="icon-send1"></i>
                            Kirim</button>
                    </center>
                    </center>
                </form>
                @endif
                @else
                {{-- Jika mahasiswa belum melakukan absensi, tampilkan form absensi --}}
                @php
                $cryp_pertemuan =
                Crypt::encryptString($absen->first()->pertemuan.',1,'.$absen->first()->nip.','.$pengganti.',');
                @endphp
                <form action="/mhs-absen" method="post">
                    @csrf
                    <center>
                        <input type="hidden" name="pertemuan" value="{{$cryp_pertemuan}}">
                        <input type="hidden" name="id" value="{{$id}}">
                        <button type="submit" class="btn btn-primary btn-rounded left">Absen Masuk</button>
                    </center>
                </form>
                @endif

                {{-- nanti buka ini aja --}}
                {{-- @else
                Jika kuesioner belum diisi, tampilkan link untuk mengisi kuesioner
                <p>Anda harus mengisi kuisioner terlebih dahulu.sebelum melakukan absen</p>
                <br>
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModalLarge">
                    isi kuisioner
                </button>
                @endif --}}
                @else
                {{-- Jika durasi sudah habis, tampilkan tombol sudah selesai --}}
                <center><button type="submit" class="btn btn-warning btn-rounded left mt-4">Sudah Selesai</button>
                </center>
                @endif
                @else
                {{-- Jika tidak ada data absen, tampilkan tombol belum mulai --}}
                <center><button type="button" class="btn btn-danger btn-rounded left mt-4">Belum Mulai</button></center>
                @endif

        </div>
</div>

{{-- @endif --}}
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-4">
    <!-- Row start -->
    <div class="row gutters mt-3 mb-5">

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            @if($sapaan ?? ''==true)
            <div class="jumbotron">
                <h1 class="display-4 text-primary">Sekapur Sirih</h1>
                <center>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                        <figure class="user-card">
                            <center>
                                <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <figure class="effect-3">
                                        <img src="{{ Storage::url('public/'.$sapaan->profile_photo_path.'') }}"
                                            class="img-fluid" alt="Mybast" hight="200" width="150">
                                    </figure>
                                </div>
                                <figcaption>
                            </center>
                            <h5>{{$sapaan->name}}</h5>
                            <ul class="list-group">
                                <li class="list-group-item">{{$sapaan->email}}</li>
                            </ul>
                            <div class="justify-content-between">{{$sapaan->judul}}</div>
                            </figcaption>
                        </figure>
                    </div>
                </center>
                <p class="lead">{{$sapaan->deskripsi}}</p>
                <div class="mb-3"></div>

            </div>

        </div>
        @endif
        <!-- Modal Lebar -->
        @include('mhs.jadwal.modal_kuesioner')
    </div>
</div>
</div>

<!-- Row end -->
<div class="table-container">
    <div class="t-header">Rekap Absen</div>
    <div class="table-responsive">
        {{-- <table id="copy-print-csv" class="table custom-table"> --}}
            <table id="myTable" class="table custom-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Status Absen</th>
                        <th>Tanggal</th>
                        <th>Matakuliah</th>
                        <th>Pertemuan</th>
                        <th>Rangkuman</th>
                        <th>Berita Acara</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
    </div>
</div>

@endsection
@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $('#myTable').DataTable({
            dom: 'Blfrtip',
            lengthMenu: [
                [10, 25, 50, 10000],
                ['10', '25', '50', 'Show All']
            ],
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            paging: true,
            processing: true,
            serverSide: true,
            ajax: '{{ url("rekap-side/".$id) }}',
            columns: [{
                    name: 'nomer',
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'status_hadir',
                    name: 'status_hadir'
                },
                {
                    data: 'tgl_ajar_masuk',
                    name: 'tgl_ajar_masuk'
                },
                {
                    data: 'nm_mtk',
                    name: 'nm_mtk'
                },
                {
                    data: 'pertemuan',
                    name: 'pertemuan'
                },
                {
                    data: 'berita_acara',
                    name: 'berita_acara'
                },
                {
                    data: 'rangkuman',
                    name: 'rangkuman'
                }
            ]
        });
    });
</script>
@endpush