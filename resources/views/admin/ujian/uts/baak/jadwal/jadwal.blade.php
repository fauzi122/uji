@extends('layouts.dosen.ujian.main')

@section('content')
	<div class="main-container">
				<div class="content-wrapper">

					<!-- Row start -->
					<div class="row gutters">
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
							
							<div class="card-header badge-info">
							
								<h4 class="m-b-0 text-white">

									Jadwal Ujian</h4>
							</div>

							<div class="table-container">
								<b>*Catatan : Kelas/Kelompok Ujian boleh di kosongkan jika pencarian haya berdasarkan tanggal ataupun sebaliknya </b>
								<br>
								<form action="/baak/cari-peserta-ujian" method="GET">
									<table class="table custom-table">
										<tr>
											<td>Kelas</td>
											<td><input type="text" name="kd_lokal" placeholder="Masukkan Kelas Mahasiswa" class="nilai form-control"></td>
										</tr>
										<tr>
											<td>Kelompok Ujian</td>
											<td>
												<input type="text" name="kel_ujian" placeholder="Masukkan Kelompok Ujian Mahasiswa" class="nilai form-control">
											</td>
										</tr>
										<tr>
											<td>Tanggal Ujian</td>
											<td>
												<input type="date" name="tgl_ujian" placeholder="Masukkan Tanggal Ujian Mahasiswa" class="nilai form-control">
											</td>
										</tr>
										<tr>
											<td colspan="2" style="text-align: right;">
												<button type="submit" class="btn btn-info">Cari Data Jadwal </button><br>
											</td>
										</tr>
									</table>
								</form>
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
								<div class="table-responsive">
									<table id="copy-print-csv" class="table custom-table">
										<thead>
											<tr>
											  
												<th>NIP</th>
												<th>MTK</th>
												<th>Kelas</th>
												<th>Kel-Ujian</th>
												<th>Hari</th>
												<th>Mulai</th>
												<th>Selsai</th>
												<th>Ruang</th>
												<th>paket</th>
												<th>kampus</th>
												<th>Aksi</th>
												<th><span class="icon-edit1"></span></th>
												<th><span class="icon-edit1"></span></th>
											</tr>
										</thead>
										<tbody>
											@foreach ($jadwal as $no => $jadwal)
											<tr>
											
											 <td>
												{{ $jadwal->nip }}
												<br><b>{{ $jadwal->kd_dosen }}</b>
												
											 </td>
										
											 <td>{{ $jadwal->nm_mtk }}-<b>
												{{ $jadwal->kd_mtk }}</b></td>
											 <td>{{ $jadwal->kd_lokal }}</td>
											 <td>{{ $jadwal->kel_ujian }}</td>
											 <td><center>{{ $jadwal->hari_t }}<br>{{ $jadwal->tgl_ujian }}</center></td>
											 <td>{{ $jadwal->mulai }}</td>
											 <td>{{ $jadwal->selesai }}</td>
											
											 <td>{{ $jadwal->no_ruang }}</td>
											 <td>{{ $jadwal->paket }}</td>
											 <td>{{ $jadwal->nm_kampus }}</td>
											
											 <td>
						@php
						$id=Crypt::encryptString($jadwal->kd_dosen.','.$jadwal->kd_mtk.','.$jadwal->kel_ujian.','.$jadwal->paket.','.$jadwal->nm_kampus);                                    
						@endphp

												{{-- <a href="/show/jadwal-uji-baak/{{ $id }}" class="btn btn-xs btn-info">show</a> --}}
												@php
													$key = $jadwal->kd_dosen . '_' . $jadwal->kel_ujian . '_' . $jadwal->kd_mtk;
												@endphp

												@if(array_key_exists($key, $resultArray))
													<!-- Jika ada data yang cocok di resultArray, aktifkan tombol Show -->
													<a href="/show/jadwal-uji-baak/{{ $id }}" class="btn btn-sm btn-info">Show</a>
												@else
													<!-- Jika tidak, nonaktifkan tombol Show -->
													<button class="btn btn-sm btn-custom btn-info" disabled>Show</button>
												@endif
											</td>
											<td>

												<a href="/edit/jadwal-ujian/{{ $id }}" class="btn btn-sm btn-primary">Edit</a>
												

											</td>
											<td>
												<a href="/ganti-pengawas/{{ $id }}" class="btn btn-sm btn-secondary">Ganti Pengawas</a>

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
				<!-- Content wrapper end -->


			</div>
@endsection
