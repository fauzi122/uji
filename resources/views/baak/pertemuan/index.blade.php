@extends('layouts.dosen.main')

@section('content')
<div class="row gutters">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <div class="card-body">
                <center>
                    <h4> Form Pertemuan Dosen</h4>
                </center>
                <div class="form-group">
                    1. Hapus Data Pertemuan <br>
                    @can('temu_baak.delete') 
                    <form action="/pertemuan/tran" method="POST">
                        @csrf
                        <button class="btn btn-secondary btn-lg" type="submit">
                            <i class="icon-delete"></i> Kosongkan Pertemuan </button>  
                    </form>
                    @endcan
                </div>
                2. Input Nomer Jadwal Kuliah Saat ini <br>
                <form action="/input-nojklh" method="POST">
                    @csrf
                    <div class="row gutters">
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                            <div class="form-group">
                                <label>No Jadwal Kuliah</label>
                                <input type="text" name="no_j_klh" class="form-control time" placeholder="No Jadwal Kuliah" value="{{$pertemuan->smt}}">
                                <code>Contoh : 1221</code>
                            </div>
                            <div class="form-group mb">
                                <button type="submit" class="btn btn-info">Save</button>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                <div class="form-group">
                3. Klik Tombol dibawah (*Izinkan Pop-up pada Browser) <br>
                    @php
                    for ($i= 1; $i <= $pertemuan->lastPage; $i++) {
                        if ( $bagi = $i % 10 == 0 ) {
                            echo "
                            <a href='".url("/send-jadwal/".Crypt::encryptString($i)) ."' type='button' class='btn btn-info'>Klik $i</a>
                            ";
                        }
                    }
                    if (substr($pertemuan->lastPage,1)!='0') {
                        echo "
                            <a href='".url("/send-jadwal/".Crypt::encryptString($pertemuan->lastPage)) ."' type='button' class='btn btn-info'>Klik $pertemuan->lastPage</a>
                            ";
                        }
                    @endphp
                </div>
                <div class="form-group">
                4. Proses Terakhir Klik Tombol Sinkronnya <br>

                @can('temu_baak.singkron')
                        <form action="/pertemuan/singkron" method="POST">
                            @csrf
                            <button class="btn btn-info btn-lg" type="submit">
                                <i class="icon-loader"></i> Singkron Jadwal </button>   
                       
                        </form>
                        @endcan 
            </div>
            </div>
        </div>
    </div>
</div>
                    <div class="card-body">
  <form action="/pertemuan1" method="post" enctype="multipart/form-data">
                            @csrf
                
                            @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                            @endif
                
                            @if (session('error'))
                                <div class="alert alert-success">
                                    {{ session('error') }}
                                </div>
                            @endif
                            @can('temu_baak.upload') 
                            <div class="form-group">
                                <label for="">File (.xls, .xlsx) <a href="{{ Storage::url('public/formatfile/pertemuan1.xlsx') }}"
                                    class="btn btn-info btn-sm">
                                    Unduh Format File<a></label>
                                <p class="text-danger">{{ $errors->first('file') }}</p>

                                <input type="file" class="btn btn-primary" name="file">
                           
                                <button class="btn btn-info btn-lg">
                                    <i class="icon-upload"></i> Upload </button>
                            </div>
                            @endcan 
                        </form>
                        <div class="table-responsive">
                            <table id="tbl_list" class="table custom-table">

                                <thead>
                                    <tr>
                                     
                                   
                                      <th>Kode Dosen</th>
                                      <th>Kode MTK</th>
                                      <th>Jam</th>
                                      <th>Hari</th>
                                      <th>Ruang</th>
                                      <th>Kelas</th>
                                      <th>SKS</th>
                                      <th>Kode Gabung</th>
                                   
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                        </table>
                        </div>
                    </div>
                </div>
           
 
    @endsection
    @push('scripts')
<script type="text/javascript">
 $(document).ready(function () {
    $('#tbl_list').DataTable({
     dom: 'Blfrtip',
                 lengthMenu: [
                     [ 10, 25, 50, 10000 ],
                     [ '10', '25', '50', 'Show All' ]
                 ],
                 buttons: [
                     'copy', 'csv', 'excel', 'pdf', 'print',
                   
                 ],    
         paging: true,
         processing: true,
         serverSide: true,
         ajax: '{{ url('/pertemuan/json') }}',
         columns: [
            { data: 'kd_dosen', name: 'kode_dosen' },
			{ data: 'kd_mtk', name: 'kd_mtk' },
			{ data: 'jam_t', name: 'jam_t' },
			{ data: 'hari_t', name: 'hari_t' },
			{ data: 'no_ruang', name: 'no_ruang' },
			{ data: 'kd_lokal', name: 'kd_lokal' },
			{ data: 'sksajar', name: 'sksajar' },
			{ data: 'kd_gabung', name: 'kd_gabung' }
         ]
     });
  });
</script>
@endpush