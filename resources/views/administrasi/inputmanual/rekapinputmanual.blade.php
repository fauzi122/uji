@extends('layouts.dosen.main')
@section('content')
<div class="flash-tambah" data-flashdata="{{ session('status') }}"></div>
<div class="flash-error" data-flasherror="{{ session('error') }}"></div>

<div class="content-wrapper">
	<div class="row gutters">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="card">
				<div class="card-header">
					<div class="card-title">Rekap Jadwal Pengajaran</div>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table id="myTable2" class="table custom-table">
							<thead>
								<tr>
									<th>#</th>
									<th>Nip</th>
									<th>Matkul</th>
									<th>Kd MTK</th>
									<th>Hari</th>
									<th>Kelas</th>
									<th>Waktu</th>
									<th>No Ruang</th>
									<!-- <th>Kampus</th> -->
									<th>Tgl Ajar</th>
									<th>Dosen Pengganti</th>
									<th class="text-center">Pilih</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($jadwal as $jd)
								<tr>
									<td>{{$loop->iteration}}</td>
									<td>{{$jd->nip}}</td>
									<td>{{$jd->nm_mtk}}</td>
									<td>{{$jd->kd_mtk}}</td>
									<td>{{$jd->hari_t}}</td>
									<td>
										@if ($jd->kd_gabung != '')
										{{$jd->kd_gabung}} <!-- Kelas Gabungan -->
										@elseif($jd->kel_praktek != '')
										{{$jd->kel_praktek}} <!-- Kelas Praktek -->
										@else
										{{$jd->kd_lokal}} <!-- Kelas Teori -->
										@endif
									</td>
									<td>{{$jd->jam_t}}</td>
									<td>{{$jd->no_ruang}}</td>
									<!-- <td>{{$jd->nm_kampus}}</td> -->
									<form action="@if($jd->kd_gabung != '') /rekap-manual-gabung @elseif($jd->kel_praktek != '') /rekap-manual-praktek @else /rekap-manual-teori @endif" method="post">
										@csrf
										<td><input class="form-control" id="tgl_pengganti" type="date" name="tgl_ajar" required style="width: 130px"></td>

										<!-- Kolom Dosen Pengganti (Combobox) -->
										<td>
											<!-- Combobox Dosen Pengganti -->
											<select class="form-control" name="kd_dp" id="dosen_pengganti_{{$loop->iteration}}" onchange="updateDosen(this, {{$loop->iteration}})">
												<!-- Default option untuk tidak pakai dosen pengganti -->
												<option value="" data-nip="{{$jd->nip}}" data-kd_dosen="{{$jd->kd_dosen}}">
													Tidak Pakai Dosen Pengganti
												</option>
												<!-- Loop untuk menampilkan dosen pengganti -->
												@foreach($dosenPenggantiList as $dosenPengganti)
												<option value="{{ $dosenPengganti->kd_dp }}" data-nip="{{ $dosenPengganti->nip }}" data-kd_dosen="{{ $dosenPengganti->kd_dp }}">
													{{ $dosenPengganti->nip }} ({{ $dosenPengganti->kd_dp }})
												</option>
												@endforeach
											</select>
										</td>

										<td>
											<!-- Hidden Inputs for Nip and Kd_dosen -->
											<input type="hidden" id="nip_{{$loop->iteration}}" name="nip" value="{{$jd->nip}}">
											<input type="hidden" id="kd_dosen_{{$loop->iteration}}" name="kd_dosen" value="{{$jd->kd_dosen}}">

											<input type="hidden" name="kd_mtk" value="{{$jd->kd_mtk}}">
											<input type="hidden" name="nm_mtk" value="{{$jd->nm_mtk}}">
											<input type="hidden" name="sks" value="{{$jd->sksajar}}">
											@if($jd->kd_gabung != '')
											<input type="hidden" name="kd_lokal" value="{{$jd->kd_gabung}}">
											@elseif($jd->kel_praktek != '')
											<input type="hidden" name="kel_praktek" value="{{$jd->kel_praktek}}">
											@else
											<input type="hidden" name="kd_lokal" value="{{$jd->kd_lokal}}">
											@endif
											<input type="hidden" name="hari_t" value="{{$jd->hari_t}}">
											<input type="hidden" name="jam_t" value="{{$jd->jam_t}}">
											<input type="hidden" name="no_ruang" value="{{$jd->no_ruang}}">
											<input type="hidden" name="id" value="{{$id}}">

											@if(isset($absen->pertemuan))
											<input type="hidden" name="pertemuan" value="{{$absen->pertemuan == '7' ? $absen->pertemuan + 2 : $absen->pertemuan + 1}}">
											@else
											<input type="hidden" name="pertemuan" value="1">
											@endif

											<button class="btn btn-outline-primary btn-rounded btn-sm" type="submit">
												Temu ke @if (isset($absen->pertemuan))
												{{$absen->pertemuan + 1}}
												@else
												1
												@endif
											</button>
									</form>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>


		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="card">
					<div class="card-header">
						<div class="card-title">
							<div class="col-sm-5 col-md-5">
								Rekapan Pengajaran
							</div>
						</div>
					</div>
					<div class="card-body">
						<div class="custom-btn-group">
							<!-- Buttons -->
							<div class="table-responsive">
								<table id="myTable3" class="table custom-table">
									<thead>
										<tr>
											<th>#</th>
											<th>Nip</th>
											<th>Matkul</th>
											<th>Kd MTK</th>
											<th>Hari</th>
											<th>Kelas</th>
											<th>Waktu</th>
											<th>No Ruang</th>
											<th>Tgl Ajar</th>
											<th>Pertemuan</th>
										</tr>
									</thead>
									{{-- @foreach ($jadwal as $jd)
													<tr>
														<td>{{$loop->iteration}}</td>
									<td>{{$jd->nip}}</td>
									<td>{{$jd->nm_mtk}}</td>
									<td>{{$jd->kd_mtk}}</td>
									<td>{{$jd->hari_t}}</td>
									<td>
										@if ($jd->kd_gabung<>'')
											{{$jd->kd_gabung}}
											@elseif($jd->kel_praktek<>'')
												{{$jd->kel_praktek}}
												@else
												{{$jd->kd_lokal}}
												@endif</td>
									<td>{{$jd->jam_t}}</td>
									<td>{{$jd->no_ruang}}</td>
									<td>{{$jd->nm_kampus}}</td>
									<td><input class="form-control" id="tgl_pengganti" type="date" name="tgl_ajar" required style="width: 130px"></td>
									<td>
										<form action="{{secure_url('/simpan-manual')}}" action="post">
											@csrf
											@if(isset($absen->pertemuan))
											<input type="hidden" name="pertemuan" value="{{$absen->pertemuan+1}}">
											@else
											<input type="hidden" name="pertemuan" value="1">
											@endif
											<button class="btn btn-outline-primary btn-rounded btn-sm" type="submit">
												Temu ke @if (isset($absen->pertemuan))
												{{$absen->pertemuan + 1}}
												@else
												1
												@endif

											</button>
										</form>
									</td>
									</tr>
									@endforeach --}}
									<tbody>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
		@php
		if ($jd->kd_gabung<>null) {
			$id=Crypt::encryptString($jd->kd_mtk.','.$jd->kd_gabung.','.$jd->jam_t);
			} elseif($jd->kel_praktek<>null) {
				$id=Crypt::encryptString($jd->kd_mtk.','.$jd->kel_praktek.','.$jd->jam_t);
				}else{
				$id=Crypt::encryptString($jd->kd_mtk.','.$jd->kd_lokal.','.$jd->jam_t);
				}
				@endphp
				{{-- {{Crypt::decryptString($id)}} --}}
				@endsection
				@push('scripts')
				<script>
					function updateDosen(selectElement, rowIndex) {
						const selectedOption = selectElement.options[selectElement.selectedIndex];
						const nip = selectedOption.getAttribute('data-nip');
						const kdDosen = selectedOption.getAttribute('data-kd_dosen');

						// Update the hidden input fields for nip and kd_dosen
						document.getElementById('nip_' + rowIndex).value = nip;
						document.getElementById('kd_dosen_' + rowIndex).value = kdDosen;
					}
				</script>
				<script>
					$(document).ready(function() {
						$('#myTable2').DataTable({
							dom: 'Blfrtip',
							lengthMenu: [
								[10, 25, 50, 10000],
								['10', '25', '50', 'Show All']
							],
							buttons: [
								'copy', 'csv', 'excel', 'pdf', 'print'
							]

						});
						$('#myTable3').DataTable({
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
							ajax: '{{ url("/rekap-manual/".$id) }}',

							columns: [{
									name: 'nomer',
									render: function(data, type, row, meta) {
										return meta.row + meta.settings._iDisplayStart + 1;
									}
								},
								{
									data: 'nip',
									name: 'nip'
								},
								{
									data: 'nm_mtk',
									name: 'nm_mtk'
								},
								{
									data: 'kd_mtk',
									name: 'kd_mtk'
								},
								{
									data: 'hari_ajar_masuk',
									name: 'hari_ajar_masuk'
								},
								{
									data: 'kelas',
									name: 'kelas'
								},
								{
									data: 'jam_t',
									name: 'jam_t'
								},
								{
									data: 'no_ruang',
									name: 'no_ruang'
								},
								{
									data: 'tgl_ajar_masuk',
									name: 'tgl_ajar_masuk'
								},
								{
									data: 'pertemuan',
									name: 'pertemuan'
								}
							]
						});
					});
				</script>
				@endpush