@extends('layouts.dosen.main')

@section('content')

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
  
            <div class="card">
   <div class="card-header bg-info">
           
       <h4 class="m-b-0 text-white">FORM EDIT JADWAL KUIS</h4>
   </div>
        <div class="modal-body">
            <form class="row" action="/toef-jadwal/update/{{ $editjadwal->id }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('patch')

                <!-- Matakuliah and Kategori -->
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label>Matakuliah</label>
                        <select name="kd_mtk" class="form-control">
                            <option value="0315">TOEFL PREPARATION</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label>Kategori</label>
                        <select name="nm_kategori" class="form-control" style="text-transform: uppercase;">
                            @foreach($kategori as $materi)
                                <option value="{{ $materi->nm_kategori }}" 
                                    {{ (isset($currentValue) && $currentValue == $materi->nm_kategori) ? 'selected' : '' }}>
                                    {{ strtoupper($materi->nm_kategori) }}
                                </option>
                            @endforeach
                        </select>
                        @error('nm_kategori')
                        <div class="invalid-feedback" style="display: block">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <!-- Paket and KKM -->
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label>Paket</label>
                        <input type="text" class="form-control" value="LATIHAN" name="paket" readonly>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label>KKM</label>
                        <input type="text" class="form-control @error('kkm') is-invalid @enderror" 
                            name="kkm" value="{{ $editjadwal->kkm }}" required>
                        @error('kkm')
                        <div class="invalid-feedback" style="display: block">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <!-- Waktu and Waktu Mulai -->
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label>Waktu</label>
                        <input type="text" class="form-control @error('waktu') is-invalid @enderror" 
                            name="waktu" value="{{ $editjadwal->waktu }}" required>
                        @error('waktu')
                        <div class="invalid-feedback" style="display: block">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label>Waktu Mulai</label>
                        <input type="text" class="form-control @error('tgl_ujian') is-invalid @enderror" 
                            name="tgl_ujian" value="{{ $editjadwal->tgl_ujian }}" required>
                        @error('tgl_ujian')
                        <div class="invalid-feedback" style="display: block">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <!-- Waktu Selesai and Jumlah Soal -->
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label>Waktu Selesai</label>
                        <input type="text" class="form-control @error('tgl_selsai_ujian') is-invalid @enderror" 
                            name="tgl_selsai_ujian" value="{{ $editjadwal->tgl_selsai_ujian }}" required>
                        @error('tgl_selsai_ujian')
                        <div class="invalid-feedback" style="display: block">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label>Jumlah Soal</label>
                        <input type="text" class="form-control @error('jml_soal') is-invalid @enderror" 
                            name="jml_soal" value="{{ $editjadwal->jml_soal }}" required>
                        @error('jml_soal')
                        <div class="invalid-feedback" style="display: block">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <!-- Deskripsi -->
                <div class="col-md-12 mb-3">
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                            name="deskripsi" rows="5" placeholder="Masukkan deskripsi">{{ old('deskripsi', $editjadwal->deskripsi) }}</textarea>
                        @error('deskripsi')
                        <div class="invalid-feedback" style="display: block">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <!-- Footer with Action Buttons -->
                <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-info">Update</button>
                    <button type="reset" class="btn btn-warning">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
