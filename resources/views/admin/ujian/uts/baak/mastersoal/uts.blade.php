
@extends('layouts.dosen.ujian.main')

@section('content')
	<div class="main-container">


				<!-- Page header start -->
				
				<!-- Page header end -->


				<!-- Content wrapper start -->
				<div class="content-wrapper">

					<!-- Row start -->
					<div class="row gutters">
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
<div class="main-container">
 
  <!-- Row start -->
  <div class="row gutte">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
  
      <div class="card-header badge-info">
							
        <h4 class="m-b-0 text-white">Master Matakuliah Ujian</h4>
    </div>
    
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
      <div class="table-container " >
       <div class="" > 
        <h4> 
		  <form action="/baak/singkron-mtkuji" method="POST">
         @csrf
          <button class="btn btn-info btn-lg" type="submit">
          <i class="icon-loader"></i>  Singkron Matakuliah Ujian </button>
          </form> 
      </h4>
      <hr>
      </div>
      
        <div class="table-responsive">
          <table id="copy-print-csv" class="table custom-table">
            <thead>
              <tr>
                <th><center>No</center></th>                
                <th>Matakuliah</th>
                <th>Paket</th>       
                <th>Soal PG</th>
                <th>Soal ESSAY</th>
                <th>Jml PG</th>
                <th>Jml ESSAY</th>       
                <th><center>Status</center></th>        
                 <th><center> Aksi </center></th>
              </tr>
            </thead>
            <tbody>
              
              @php $no = 0; @endphp
              @foreach ($soals as $soal)
                  @php
                  $id = Crypt::encryptString($soal->kd_mtk . ',' . $soal->paket);
                  @endphp
                  <tr>
                      <td><center>{{ ++$no }}</center></td>
                      <td><b>{{ $soal->kd_mtk }}</b> - {{ $soal->nm_mtk }}</td>
                      <td>{{ $soal->paket }}</td>
                      <td>{{ $detailsoal[$soal->kd_mtk] ?? '0' }} SOAL PG</td>
                                  <td>{{ $detailsoal_essay[$soal->kd_mtk] ?? '0' }} SOAL ESSAY</td>
                                  <td>{{ $soal->jml_soal }} soal</td>
                                  <td>{{ $soal->jml_essay }} soal</td>
                      <td></td>
                      <td><center>
                          <a href="/baak/uts-soal-show/{{ $id }}" class="btn btn-xs btn-info">SOAL</a>
                          </center>
                      </td>
                  </tr>
              @endforeach
              
          
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>
  <!-- Row end -->

						</div>

					</div>
					<!-- Row end -->

				</div>
				<!-- Content wrapper end -->


			</div>

</div>

@endsection
