@extends('layouts.dosen.main')

@section('content')
<div class="main-container">
  <div class="flash-tambah" data-flashdata="{{ session('status') }}"></div>
  <div class="flash-error" data-flasherror="{{ session('error') }}"></div>
  <!-- Row start -->
  <div class="row gutte">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

      <div class="card-header badge-primary">

        <h4 class="m-b-0 text-white">List Pembelajaran dan Tes TOEFL</h4>
      </div>
      <div class="table-container ">
        <div class="">
          <h4>
          @can('toef.jadwal') 
            <a href="/toef-create"><button class="btn btn-primary btn-lg"><i class="icon-add"> </i> Jadwal Pembelajaran dan Tes </button></a>
           @endcan
            <a href="{{ Storage::url('public/Panduan Kuis MyBest Dosen.pdf') }}" target="_blank" class="btn btn-info btn-lg">
              <i class="icon-file-text"></i>
              Panduan
            </a>
          </h4>
          <hr>
        </div>

        <div class="table-responsive">
          <div class="table-responsive">
            <table id="myTable2" class="table custom-table">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th>Kode Mtk</th>
                        <th>Paket</th>
                        <th>Kategori</th>
                        <th>KKM</th>
                        <th>Waktu</th>
                        <th class="text-center">Soal</th>
                        <th class="text-center">Jml</th>
                        <th>Tgl Mulai</th>
                        <th>Tgl Selesai</th>
                        <th>Created</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($soals as $no => $soal)
                        @php
                            $id = Crypt::encryptString($soal->id . ',' . $soal->kd_mtk);
                        @endphp
                        <tr>
                            <td class="text-center">{{ ++$no }}</td>
                            <td><strong>{{ $soal->kd_mtk }}</strong> - {{ $soal->nm_mtk }}</td>
                            <td>{{ $soal->paket }}</td>
                            <td><b>{{ strtoupper($soal->toef_kategori) }}</b></td>
                            <td>{{ $soal->kkm }}</td>
                            <td>{{ $soal->waktu }} menit</td>
                            <td class="text-center">
                                <span class="badge badge-pill badge-light">{{ $detailsoal[$soal->id] ?? '0' }} soal</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-pill badge-light">{{ $soal->jml_soal }} soal</span>
                            </td>
                            <td> <center>
                              <div>{{ \Carbon\Carbon::parse($soal->tgl_ujian)->format('Y-m-d') }}</div>
                              <div>{{ \Carbon\Carbon::parse($soal->tgl_ujian)->format('H:i:s') }}</div>
                            </center>
                          </td>
                          <td><center>
                              <div>{{ \Carbon\Carbon::parse($soal->tgl_selsai_ujian)->format('Y-m-d') }}</div>
                              <div>{{ \Carbon\Carbon::parse($soal->tgl_selsai_ujian)->format('H:i:s') }}</div>
                          </center>

                          </td>
                            <td>{{ $soal->kd_dosen }}</td>
                            <td>
                                <!-- Dropdown Menu for Actions -->
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Menu
                                    </button>
                                    <div class="dropdown-menu">
                                        @can('toef.jadwal.edit')
                                            <a class="dropdown-item" href="/edit-jadwal/toef/{{ $id }}">Edit Jadwal</a>
                                        @endcan
                                        @can('toef.jadwal.show')
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="/toef-soal-show/{{ $id }}">Master Soal</a>
                                        @endcan
                                        @if (isset($soal->file_path))
                                            <div class="dropdown-divider"></div>
                                            <form action="/download-materi-toef" method="post" class="text-center">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $soal->id_materi }}">
                                                <input type="hidden" name="file" value="{{ $soal->file_path }}">
                                                <button type="submit" class="btn btn-info btn-rounded btn-sm">Unduh Materi</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
        
                                <!-- Button to trigger the modal for uploading materi -->
                                <button class="btn btn-primary btn-sm mt-1" data-toggle="modal" data-target="#uploadModal{{ $soal->id }}">Upload Materi</button>
        
                                <!-- Modal for uploading materi -->
                                <div class="modal fade" id="uploadModal{{ $soal->id }}" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="uploadModalLabel">Upload Materi</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('toef.materi.store') }}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="id_soal" value="{{ $soal->id }}">
                                                    <div class="form-group">
                                                        <label for="judul">Judul Materi</label>
                                                        <input type="text" class="form-control" id="judul" name="judul" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="file">Pilih File</label>
                                                        <input type="file" class="form-control-file" id="file" name="file" required accept=".pdf,.doc,.docx">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                        <button type="submit" class="btn btn-primary">Upload</button>
                                                    </div>
                                                </form>
                                                <p class="text-muted"><small>Catatan: File yang diunggah harus berformat PDF, DOC, atau DOCX dengan ukuran maksimal 2MB.</small></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
  <!-- Row end -->
</div>

@endsection
@push('scripts')
<script type="text/javascript">

    // DataTables init
    $(document).ready(function() {
        $('#myTable2').DataTable({
            dom: 'Blfrtip',
            lengthMenu: [
                [10, 25, 50, 10000],
                ['10', '25', '50', 'Show All']
            ],
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            responsive: true
        });
    });
</script>
@endpush