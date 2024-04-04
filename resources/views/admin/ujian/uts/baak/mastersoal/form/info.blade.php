<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">

							<div class="row gutters">
								<div class="col-xl-12 col-lg-12 col-md-12 col-sm-4">
								<div class="card-header badge-primary">
                        <h4 class="m-b-0 text-white">Informasi
                          <a href="/soal/master-baak" class="btn btn-sm btn-success">
                            <i class="icon-refresh"></i> Kembali.
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