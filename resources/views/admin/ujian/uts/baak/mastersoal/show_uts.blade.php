@extends('layouts.dosen.ujian.main')

@section('content')
	<div class="main-container">
<!-- Content wrapper start -->
				<div class="content-wrapper">
					<!-- Row start -->
					<div class="row gutters">
						<div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
              <div class="card-header badge-info">
							
								<h4 class="m-b-0 text-white">Master Soal </h4>
							</div>
							<div class="card">
								<div class="card-body p-0">
									<div class="invoice-container">
										<div class="invoice-header">
                    @php
                    $id=Crypt::encryptString($soal->kd_mtk);                                    
                    @endphp
									<a href="/baak/uts-create-pilih/{{$id}}" class="btn btn-success">Input Soal Pilihan Ganda</a>
									<a href="" class="btn btn-info">Import Excel Soal Pilihan Ganda</a>
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
                                          <th style="text-align: center;">Kunci</th>
                                         
                                          <th style="text-align: center;">Status</th>
                                          <th style="text-align: center;">Updated</th>
                                          <th style="text-align: center;">Dosen</th>
                                          <th style="text-align: center; width: 100px">Aksi</th>
                                        </tr>
                                       </thead>
                                      <tbody>
                                       
                                        @foreach ($soals  as $no => $soals)
                                            
                                       
                                     <tr>
                                     <td>{{ ++$no }}</td>
                                     <td>{{strip_tags($soals->soal) }}</td>
                                     <td><center>{{ $soals->kunci }}</center></td>
                                    
                                     <td>
                                         @php
                                      $detail=Crypt::encryptString($soals->id);                                    
                                      @endphp
                                       @if ($soals->status == 'Y')
                                        <center><span class='badge badge-pill badge-light'>Tampil</span></center>
                                           
                                       @else
                                        <center><span class='badge badge-pill badge-secondary'>Tidak tampil</span></center>
                                           
                                       @endif
                                     
                                     <p></p>
                                       @if ($soals->file == '')
                                        {{--  <center><span class='badge badge-pill badge-light'></span></center>  --}}
                                           
                                       @else
                                        <center>
                                        <a href="/baak/detail/soal-show-uts/{{$detail}}"> <span class='badge badge-pill badge-info'>cek gambar</span>
                                        </a>
                                        </center>
                                           
                                       @endif
                                     </td>
                                     <td><center>{{ $soals->updated_at }}</center></td>
                                     <td><center>{{ $soals->id_user }}</center></td>

                                     <td>
                                  <center>
                                  <div class="btn-group" role="group">
											<button id="btnGroupDrop1" type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											menu
											</button>
											<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
												<a class="dropdown-item" href="/baak/edit-detail/soal-uts/{{$detail}}">Edit Data Soal</a>
												<a class="dropdown-item" href="/baak/detail/soal-show-uts/{{$detail}}">Show Data Soal</a>
											</div>
									</div>
                                     
                                      </center>

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
                        $id=Crypt::encryptString($soal->kd_mtk);                                    
                        @endphp

                        <br>
                        <br>
                        	<a href="/baak/uts-create-essay/{{$id}}" class="btn btn-success">Input Soal Essay</a>
									<a href="" class="btn btn-info">Import Excel Soal Essay</a>
                        <br>
                        <br>
                         
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
                                          <th style="text-align: center;">Updated</th>
                                          <th style="text-align: center;">dosen</th>
                                          <th  style="text-align: center;">Aksi </th>
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
                                        <a href="/baak/essay/soal-show-uts/{{$detail_essay}}"> <span class='badge badge-pill badge-info'>cek gambar</span>
                                        </a>
                                        </center>
                                           
                                       @endif
                                     </td>
                                     <td  style="text-align: center;">{{$essay->updated_at}}</td>
                                     <td  style="text-align: center;">{{$essay->id_user}}</td>
                                     <td>
                                      <center>

                                       <div class="btn-group" role="group">
											<button id="btnGroupDrop1" type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											menu
											</button>
											<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
												<a class="dropdown-item" href="/baak/edit-essay/soal-uts/{{$detail_essay}}">Edit Data Soal</a>
												<a class="dropdown-item" href="/baak/essay/soal-show-uts/{{$detail_essay}}">Show Data Soal</a>
											</div>
									</div>
                                     </center>
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
                          <a href="/soal/master-baak" class="btn btn-sm btn-success">
                            <i class="icon-refresh"></i> Kembali
                        </a>
                        
                        </h4>
                    </div>
                    <div class="table-responsive">
                      <table class="table table-condensed table-bordered table-hover">
                      <tbody>
                        <tr>
                          <td width="100px"> Paket Ujian</td>
                          
                          <td>{{$soal->paket}}</td>
                        </tr>
                        <tr>
                          <td width="100px">Nama MTK</td>
                          
                          <td>{{$soal->nm_mtk}}</td>
                        </tr>
                        <tr style="font-weight: 600; color: #e61111;">
                          <td>Kode MTK</td>
                          
                          <td>{{$soal->kd_mtk}}</td>
                        </tr>
                       
                      </tbody>
                    </table>
									
								</div>
              </div>
            </div>
				{{--  and informasi  --}}

        {{--  start kls  --}}
       
         
     {{--  start kls  --}}

     {{--  info  --}}
     <div class="row gutters">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-4">
        <div class="alert-notify info">
          <div class="alert-notify-body">
            <span class="type">Info</span>
            <div class="alert-notify-title">info penerbitan soal<img src="img/notification-info.svg" alt=""></div>
            <div class="alert-notify-text">Jadwal ujian akan terbit pada halaman mahasiswa, 
              <p></p>
              Sesuai dengan KRS Ujian yang telah di cetak
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
               console.log(data.success) 
            } 
         }); 
      }) 
   }); 
</script>
@endpush