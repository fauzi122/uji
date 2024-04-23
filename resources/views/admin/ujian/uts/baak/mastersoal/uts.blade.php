
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
		  {{-- <form action="/baak/singkron-mtkuji" method="POST">
         @csrf
          <button class="btn btn-info btn-lg" type="submit">
          <i class="icon-loader"></i>  Singkron Matakuliah Ujian </button>
          </form>  --}}
      </h4>
      <hr>
      </div>
      
        <div class="table-responsive">
          <table id="myTable1" class="table custom-table">
            <thead>
              <tr>
                <th>No</th>                
                <th>Matakuliah</th>
                <th>Paket</th>       
                <th>Soal PG</th>
                <th>Soal ESSAY</th>
                <th>Jml PG</th>
                <th>Jml ESSAY</th>       
                <th>Perakit</th>        
                <th>Kaprodi</th>        
                <th>Baak</th>        
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @php $no = 0; @endphp
              @foreach ($soals as $soal)
                  @php
                  $id = Crypt::encryptString($soal->kd_mtk . ',' . $soal->paket);
                  @endphp
                  <tr>
                      <td>{{ ++$no }}</td>
                      <td><b>{{ $soal->kd_mtk }}</b> - {{ $soal->nm_mtk }}</td>
                      <td>{{ $soal->paket }}</td>
                      <td>{{ $detailsoal[$soal->kd_mtk] ?? '0' }} </td>
                      <td>{{ $detailsoal_essay[$soal->kd_mtk] ?? '0' }} </td>
                      <td>{{ $soal->jml_soal }} soal</td>
                      <td>{{ $soal->jml_essay }} soal</td>

                      <td class="status-cell {{ isset($aprov[$soal->kd_mtk]) && $aprov[$soal->kd_mtk]->perakit_kirim == 1 ? 'ok' : 'none' }}">
                        <b>
                            @if(isset($aprov[$soal->kd_mtk]) && $aprov[$soal->kd_mtk]->perakit_kirim == 1)
                                <span class="check-green">✔️</span>
                            @elseif (isset($aprov[$soal->kd_mtk]) && $aprov[$soal->kd_mtk]->perakit_kirim_essay == 1)
                                <span class="check-green">✔️</span>
                            @else
                                <span class="check-transparent"></span>
                            @endif
                        </b>
                    </td>
                    <td class="status-cell {{ isset($aprov[$soal->kd_mtk]) && $aprov[$soal->kd_mtk]->acc_kaprodi == 1 ? 'ok' : 'none' }}">
                      <b>
                          @if(isset($aprov[$soal->kd_mtk]) && $aprov[$soal->kd_mtk]->acc_kaprodi == 1)
                              <span class="check-green">✔️</span>
                          @elseif (isset($aprov[$soal->kd_mtk]) && $aprov[$soal->kd_mtk]->acc_kaprodi_essay == 1)
                              <span class="check-green">✔️</span>
                          @else
                              <span class="check-transparent"></span>
                          @endif
                      </b>
                  </td>
                  <td class="status-cell {{ isset($aprov[$soal->kd_mtk]) && $aprov[$soal->kd_mtk]->acc_baak == 1 ? 'ok' : 'none' }}">
                    <b>
                        @if(isset($aprov[$soal->kd_mtk]) && $aprov[$soal->kd_mtk]->acc_baak == 1)
                            <span class="check-green">✔️</span>
                        @elseif (isset($aprov[$soal->kd_mtk]) && $aprov[$soal->kd_mtk]->acc_baak_essay == 1)
                            <span class="check-green">✔️</span>
                        @else
                            <span class="check-transparent"></span>
                        @endif
                    </b>
                </td> 
                      <td><a href="/baak/uts-soal-show/{{ $id }}" class="btn btn-info">SOAL</a></td>
                  </tr>
              @endforeach
          </tbody>
          
          </table>
          
        </div>
      </div>

    </div>
  </div>
  <div class="alert-notify info">
    <div class="alert-notify-body">
      <span class="type">Info</span>
      <div class="alert-notify-title">info penerbitan soal<img src="img/notification-info.svg" alt=""></div>

        <div class="alert-notify-text"></i>
        <H6>
            <li>1.Perakit ✔️ = Perakit Soal Sudah Menyerahkan Hasil Rakitan Soal</li>
            <li>2.Kaprodi ✔️ = Kaprodi Sudah Menyetujui Soal Akan di Tayangkan</li>
            <li>2.BAAK    ✔️ = BAAK Sudah Menyetujui Soal Akan di Tayangkan</li>
          </H4>
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
<script>
  $(document).ready(function() {
    $('#myTable1').DataTable({
      dom: 'Blfrtip',
      lengthMenu: [
        [10, 25, 50, -1],
        ['10', '25', '50', 'Show All']
      ],
      buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
      ],
      responsive: true
    });
  });
  </script>
@endsection
<style>
  .custom-table {
    width: 100%;
    border-collapse: collapse;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    overflow: hidden;
  }
  
  .custom-table th, .custom-table td {
    padding: 10px;
    text-align: left;
  }
  
  .custom-table th {
    background-color: #007bff;
    color: white;
  }
  
  .custom-table tr:nth-child(even) {
    background-color: #f2f2f2;
  }
  
  .custom-table tr:hover {
    background-color: #e8f4fd;
  }
  
  .custom-table td {
    border-bottom: 1px solid #dddddd;
  }
  
  .btn-info {
    background-color: #17a2b8;
    color: white;
    padding: 5px 10px;
    border: none;
    border-radius: 5px;
    text-decoration: none;
  }
  
  .btn-info:hover {
    background-color: #1391b5;
    cursor: pointer;
  }
  
  .status-cell {
    text-align: center;
  }
  
  .status-cell.ok {
    background-color: #dff0d8; /* light green for positive status */
  }
  
  .status-cell.none {
    background-color: #f2f2f2; /* light grey for neutral or no status */
  }
  </style>
  