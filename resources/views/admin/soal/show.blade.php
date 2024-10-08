@extends('layouts.dosen.main')

@section('content')
<!-- Content wrapper start -->
				<div class="content-wrapper">
					<!-- Row start -->
					<div class="row gutters">
						<div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
							<div class="card">
								<div class="card-body p-0">
									<div class="invoice-container">
										<div class="invoice-header">
                    @php
                    $id=Crypt::encryptString($soal->id);                                    
                    @endphp
									<a href="/create-pilih/{{$id}}" class="btn btn-success">Input Soal Pilihan Ganda</a>
								
                  <button type="button" class="btn btn-info" data-toggle="modal" data-target="#basicModal">
										Import Excel Soal Pilihan Ganda
									</button>

                    <br>
                    <br>
                    @if (session('success'))
                            <div class="alert alert-info">
                                {{ session('success') }}
                            </div>
                            @endif
                
                            @if (session('error'))
                                <div class="alert alert-info">
                                    {{ session('error') }}
                                </div>
                            @endif

									<!-- Modal -->
									<div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModalLabel" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="basicModalLabel">Import Excel Soal Pilihan Ganda</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
                         <form action="/upload-soalpg" method="post" enctype="multipart/form-data">
                            @csrf
												  <label for="">File (.xls, .xlsx) <a href="{{ Storage::url('public/formatfile/soalpg.xlsx') }}"
                                        class="btn btn-info btn-sm">
                                        Unduh Format File<a></label>

                                         <div class="form-group">
                                
                                    <input type="number" hidden name="id_soal" value="{{ $soal->id }}">
                                      <br>
                                    <input type="text" hidden name="sesi" value="{{ md5(rand(0000000000, mt_getrandmax())) }}">
                           
                                <p class="text-danger">{{ $errors->first('file') }}</p>
                                <input type="file" class="btn btn-primary" name="file">                           
                              <button class="btn btn-info btn-lg">
                                    <i class="icon-upload"></i> Upload </button>
                                   
                            </div>
                        </form>

                            	<hr>
                           <label><h5>*Catatan :</h5> 
                           <br>
                          <h6> 1.Upload soal harus sesuai format excel yang tersedia.  

                           <br>
                           2.Soal yang di upload statusnya <span class='badge badge-pill badge-light'>TAMPIL</span></label> .
                          <br>
                           3.tidak dapat menyertakan  <span class='badge badge-pill badge-info'>Audio/Gambar</span> saat upload excel. </h6> 
												</div>
									
                    
											</div>
										</div>
									</div>
                            </div>
                            <div class="invoice-body">
                              <!-- Row start -->
                              <div class="row gutters">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                  <div class="table-responsive">                       
                                  <p>
                                  <h4>List Soal Pilihan Ganda</h4>	
                                  <hr>
                                  </p>
                                    <table id="myTable2" class="table custom-table">
                                      <thead>
                                        <tr>
                                          <th>NO</th>                               
                                          <th>Soal</th>                               
                                          
                                          <th style="text-align: center;">Score</th>
                                          
                                          <th style="text-align: center; width: 100px">Aksi</th>
                                        </tr>
                                       </thead>
                                      <tbody>
                                       
                                        @foreach ($soals  as $no => $soals)
                                            
                                       
                                     <tr>
                                     <td>{{ ++$no }}</td>
                                     <td>{{strip_tags($soals->soal) }}
                                     <p></p>
                                                   @if ($soals->file!=null)
                                                   <img src="{{ Storage::url('public/soal/'.$soals->file) }}" class="img-thumbnail" height="150" width="200"/>
                                                    @endif
                                              <br><B> Kunci : {{ $soals->kunci }}</B>
                                              <br> A. {{ $soals->pila }}
                                              <br> B. {{ $soals->pilb }}
                                              <br> C. {{ $soals->pilc }}
                                              <br> D. {{ $soals->pild }}
                                              <br> E. {{ $soals->pile }}
                                              <p></p> Status :
                                              @php
                                      $detail=Crypt::encryptString($soals->id);                                    
                                      @endphp
                                       @if ($soals->status == 'Y')
                                       <span class='badge badge-pill badge-light'>Tampil</span>
                                           
                                       @else
                                       <span class='badge badge-pill badge-secondary'>Tidak tampil</span>
                                           
                                       @endif
                                     
                                     
                                            </td>
                                     <td><center>{{ $soals->score }}</center></td>

                                     <td>
                                  
                                       <a href="/edit-detail/soal/{{$detail}}" class="btn btn-sm btn-success">edit</a>
                                       <a href="/detail/soal-show/{{$detail}}" class="btn btn-sm btn-info">show</a>
                                      

                                     </td>
                                     </tr>
                                  
                                     @endforeach     
                                          
                                      </tbody>
                                    </table>
                                </div>
												</div>
											</div>
											<!-- Row end -->

                      	<!-- Row start -->
                      
											<div class="row gutters">
												<div class="col-lg-12 col-md-12 col-sm-12">

                        @php
                        $id=Crypt::encryptString($soal->id);                                    
                        @endphp

                        	<a href="/create-essay/{{$id}}" class="btn btn-success">Input Soal Essay</a>
								  <button type="button" class="btn btn-info" data-toggle="modal" data-target="#basicModal1">
										Import Excel Soal Essay
									</button>

									<!-- Modal -->
									<div class="modal fade" id="basicModal1" tabindex="-1" role="dialog" aria-labelledby="basicModalLabel" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="basicModalLabel">Import Excel Soal Essay</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
                         <form action="/upload-soalessay" method="post" enctype="multipart/form-data">
                            @csrf
												  <label for="">File (.xls, .xlsx) <a href="{{ Storage::url('public/formatfile/soalessay.xlsx') }}"
                                        class="btn btn-info btn-sm">
                                        Unduh Format File<a></label>

                                         <div class="form-group">
                                
                                    <input type="number" hidden name="id_soal" value="{{ $soal->id }}">
                                      <br>
                                   
                           
                                <p class="text-danger">{{ $errors->first('file') }}</p>
                                <input type="file" class="btn btn-primary" name="file">                           
                              <button class="btn btn-info btn-lg">
                                    <i class="icon-upload"></i> Upload </button>
                                   
                            </div>
                        </form>

                            	<hr>
                           <label><h5>*Catatan :</h5> 
                           <br>
                          <h6> 1.Upload soal harus sesuai format excel yang tersedia.  

                           <br>
                           2.Soal yang di upload statusnya <span class='badge badge-pill badge-light'>TAMPIL</span></label> .
                          <br>
                           3.tidak dapat menyertakan  <span class='badge badge-pill badge-info'>Audio/Gambar</span> saat upload excel. </h6> 
												</div>
									
                    
											</div>
										</div>
									</div>
                         <p>
                          <h4>List Soal Pilihan Essay</h4>
                          <hr>
                          </p>
													<div class="table-responsive">
                                   <table id="copy-print-csv" class="table custom-table">
                                      <thead>
                                        <tr>
                                          <th>No</th>
                                          <th>Soal</th>
                                          <th style="text-align: center;">Status</th>
                                          <th>Aksi</th>
                                        </tr>
                                       </thead>
                                      <tbody>
                                        @foreach ($essay as $no => $essay)
                                     <tr>
                                     
                                     <td>{{ ++$no }}</td>
                                     <td>{{ strip_tags($essay->soal) }}</td>
                                     <td>
                                     
                                       @php
                                      $detail_essay=Crypt::encryptString($essay->id);                                    
                                      @endphp

                                      @if ($essay->status == 'Y')
                                      <center><span class='badge badge-pill badge-light'>Tampil</span></center>
                                         
                                     @else
                                      <center><span class='badge badge-pill badge-secondary'>Tidak tampil</span></center>
                                         
                                     @endif

                                      <p></p>
                                       @if ($essay->file == '')
                                        {{--  <center><span class='badge badge-pill badge-light'></span></center>  --}}
                                           
                                       @else
                                        <center>
                                        <a href="/essay/soal-show/{{$detail_essay}}"> <span class='badge badge-pill badge-info'>audio/img</span>
                                        </a>
                                        </center>
                                           
                                       @endif
                                     </td>
                                     <td>
                                    
                                  <div class="card-body">
                                    <div class="btn-group">
                                      <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        menu
                                      </button>
                                      <div class="dropdown-menu">
                                        <a class="dropdown-item" href="/edit-essay/soal/{{$detail_essay}}">Edit</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="/essay/soal-show/{{$detail_essay}}">Show</a>
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
											<!-- Row end -->
										</div>

										

									</div>
								</div>
							</div>
						</div>
            {{--  informasi  --}}
						<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">

							<div class="row gutters">
								<div class="col-xl-12 col-lg-12 col-md-12 col-sm-4">
								<div class="card-header badge-primary">
                        <h4 class="m-b-0 text-white">Informasi
                        <a href="/latihan" class="btn btn-sm btn-success">
                       <i class="icon-refresh"></i> Kembal</a>
                        </h4>
                    </div>
                    <div class="table-responsive">
                      <table class="table table-condensed table-bordered table-hover">
                      <tbody>
                        <tr>
                          <td width="100px">Nama Paket</td>
                          
                          <td>{{ $soal->paket }}</td>
                        </tr>
                        <tr>
                          <td width="100px">MTK</td>
                          
                          <td>{{ $soal->kd_mtk }}-{{ $soal->nm_mtk }}</td>
                        </tr>
                        <tr style="font-weight: 600; color: #e61111;">
                          <td>ID Soal</td>
                          
                          <td>{{ $soal->id }}</td>
                        </tr>
                        <tr>
                          <td>Deskripsi</td>
                          
                          <td>{{ $soal->deskripsi }}</td>
                        </tr>
                  
                        <tr>
                          <td>KKM</td>
                          
                          <td>{{ $soal->kkm }}</td>
                        </tr>
                        <tr>
                          <td>Waktu</td>
                          
                          <td><b>{{ $soal->waktu.' menit' }}</b>
                            <p></p>
                           tgl mulai  : {{ $soal->tgl_ujian }}
                            <p></p>
                           tgl selsai : {{ $soal->tgl_selsai_ujian }}
                          </td>
                        </tr>
                        
                        {{--  <tr>
                          <td>Aksi</td>
                          
                          <td><a href="" class="btn btn-sm btn-info">  edit Informasi </a> </td>
                        </tr>
                       --}}
                      </tbody>
                    </table>
									
								</div>
              </div>
            </div>
				{{--  and informasi  --}}

        {{--  start kls  --}}
       
          <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-4">
            <div class="card-header badge-primary">
                    <h4 class="m-b-0 text-white">Data Kelas Ajar</h4>
                </div>
                <div class="table-responsive">
                  <table class="table table-condensed table-bordered table-hover">
                    <thead>
                      <tr>
                        <th><center>Mtk</center></th>
                        <th>Kelas</th>
                        <th width="35">Status</th>
                      </tr>
                    </thead>
                    <tbody>
                     
                    @if($kelas->count())
                      @foreach($kelas as $no => $data_kelas)
                      {{--  <input type="hidden" id="id{{ $data_kelas->id }}" value="{{ $data_kelas->id }}">  --}}
                      <tr>
                        <td>
                        <center>{{ $data_kelas->kd_mtk}}</center>
                        <span class='badge badge-pill badge-light'>{{ $data_kelas->kd_gabung }}</span>
                        
                        </td>
                        <td>
                        {{ $data_kelas->kd_lokal }}
                       
                        
                        
                        </td>
                        
                        <td align="center">
                          <input data-id="{{$soal->id}}" data-nama="{{$data_kelas->kd_lokal}}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" 
                          {{ isset($distribusi[$data_kelas->kd_lokal]->id) ? 'checked' : '' }}> 
                        </td>
                      </tr>
                   
                      @endforeach
                      @endif
                    </tbody>
                </table>
              
            </div>
          </div>
      
     {{--  start kls  --}}

     {{--  info  --}}
     <div class="row gutters">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-4">
        <div class="alert-notify info">
          <div class="alert-notify-body">
            <span class="type">Info</span>
            <div class="alert-notify-title">info penerbitan soal<img src="img/notification-info.svg" alt=""></div>
            <div class="alert-notify-text"> Silahkan lakukan <b>Active </b> jika jadwal ujian akan terbit pada halaman <b> MAHASISWA</b>.
              <p></p>
              <br>
              Jika jadwal ujian ingin di hidden kembali, silahkan lakukan <b>InActive </b> pada status 
            </div>
          </div>
        </div>
      </div>
					<!-- Row end -->


				</div>
				<!-- Content wrapper end -->
@endsection

@push('scripts')
<script>
$(document).ready(function () {
     $('#myTable2').DataTable({
      dom: 'Blfrtip',
                  lengthMenu: [
                      [ 10, 25, 50, 10000 ],
                      [ '10', '25', '50', 'Show All' ]
                  ],
                  buttons: [
                      'copy', 'csv', 'excel', 'pdf', 'print'
                  ],
    responsive: true
      });

   });
   $(function() { 
          $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
           $('.toggle-class').change(function() { 
           var status = $(this).prop('checked') == true ? 1 : 0;
           var id_soal = $(this).data('id');  
           var nm_kelas = $(this).data('nama');  
           $.ajax({ 
    
               type: "POST", 
               dataType: "json", 
               url: '/terbit-soal', 
               data: {'status': status, 'id_soal': id_soal, 'nm_kelas': nm_kelas}, 
               success: function(data){ 
            } 
         }); 
      }) 
   }); 
</script>
@endpush