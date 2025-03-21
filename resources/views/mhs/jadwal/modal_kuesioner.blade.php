<div class="modal fade" id="exampleModalLarge" tabindex="-1" role="dialog" aria-labelledby="exampleModalLargeLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <!-- Perhatikan kelas 'modal-lg' di sini -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLargeLabel">FORM PERSEPSI MAHASISWA MENGENAI DOSEN</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="/store/kuisoner-mpd" enctype="multipart/form-data">
                    @csrf
                    <p><b>FORM PERSEPSI MAHASISWA MENGENAI DOSEN </b> (Diisi sebanyak Jumlah Dosen)</p>
                    <!-- /.col-->
                    <hr>
                    <div class="tab-content rounded-bottom">
                        <div><label class="form-label"><b> F1 PROFIL RESPONDEN </b></label> </div>
                        <div class="tab-pane p-3 active preview" role="tabpanel" id="preview-1004">
                            <div class="mb-8 row">
                                <label class="col-sm-4 col-form-label" for="staticEmail"> <b> F1-1 </b> NIM</label>
                                <div class="col-sm-6">
                                    <input class="form-control" id="staticEmail" type="text" name="nim" readonly=""
                                        value="{{ Auth::user()->username }}">
                                </div>
                            </div>
                            <div class="mb-8 row">
                                <label class="col-sm-4 col-form-label" for="staticEmail"> <b> F1-2 </b> Nama</label>
                                <div class="col-sm-6">
                                    <input class="form-control" id="staticEmail" type="text" name="name" readonly=""
                                        value="{{ Auth::user()->name }}">
                                </div>
                            </div>
                            <div class="mb-8 row">
                                <label class="col-sm-4 col-form-label" for="staticEmail"> <b> F1-3 </b> Kelas</label>
                                <div class="col-sm-6">
                                    <input class="form-control" id="staticEmail" type="text" name="kelas" readonly=""
                                        value="{{ Auth::user()->kode }}">
                                </div>
                            </div>
                            <div class="mb-8 row">
                                <label class="col-sm-4 col-form-label" for="inputPassword"><b> F1-4 </b>Program
                                    Studi</label>
                                <div class="col-sm-6">
                                    <input class="form-control" id="staticEmail" type="text" name="prodi" readonly=""
                                        value="{{ $result->nm_jrs }}">
                                </div>
                            </div>
                            <div class="mb-8 row">
                                <label class="col-sm-4 col-form-label" for="inputPassword"><b> F1-5 </b>UPPS</label>
                                <div class="col-sm-6">
                                    <input class="form-control" id="staticEmail" type="text" name="upps" readonly=""
                                        value="{{ $result->upps }}">
                                </div>
                            </div>
                            <div class="mb-8 row">
                                <label class="col-sm-4 col-form-label" for="inputPassword"><b> F2-1 </b>Dosen</label>
                                <div class="col-sm-6">
                                    <input class="form-control" id="staticEmail" type="text" name="nip_dosen"
                                        readonly="" value="{{$exp[2]}}">
                                    <input class="form-control" id="staticEmail" type="text" name="mtk" readonly=""
                                        value="{{$exp[0]}}">
                                </div>
                            </div>

                            <div class="mb-8 row">
                                <label class="col-sm-4 col-form-label" for="inputPassword"><b> F2-2 </b>Periode</label>
                                <div class="col-sm-6">
                                    <input class="form-control" id="staticEmail" type="text" name="periode" readonly=""
                                        value="Ganjil 2023/2024">
                                </div>
                            </div>
                            <hr>
                        </div>

                        <label class="col-md-12 control-label">Jawablah dengan cara memilih salah satu jawaban yang
                            tersedia, sesuai dengan persepsi anda terhadap dosen tersebut.</label>
                        <section class="panel">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped mb-none">
                                        <thead>
                                            <tr>
                                                <th width='40%'>Pernyataan Mengenai Dosen</th>
                                                <th width='20%' align='center'>Sangat Setuju<br></th>
                                                <th width='10%' align='center'> Setuju<br></th>
                                                <th width='15%' align='center'>Cukup Setuju<br></th>
                                                <th width='15%' align='center'>Tidak Setuju<br></th>
                                                <th width='20%' align='center'>Sangat Tidak Setuju<br></th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="6"> <strong>(F3) Kemampuan Mengajar Dosen </strong></td>
                                            </tr>
                                            <tr>
                                                <td>Menguasai Materi yang Diajarkan (F3-1)</td>
                                                <td><input type="radio" value='5' name='cf31' required></td>
                                                <td><input type="radio" value='4' name='cf31'></td>
                                                <td><input type="radio" value='3' name='cf31'></td>
                                                <td><input type="radio" value='2' name='cf31'></td>
                                                <td><input type="radio" value='1' name='cf31'></td>
                                            </tr>
                                            <tr>
                                                <td>Menyampaikan Materi dengan Jelas (F3-2)</td>
                                                <td><input type="radio" value='5' name='cf32' required></td>
                                                <td><input type="radio" value='4' name='cf32'></td>
                                                <td><input type="radio" value='3' name='cf32'></td>
                                                <td><input type="radio" value='2' name='cf32'></td>
                                                <td><input type="radio" value='1' name='cf32'></td>
                                            </tr>
                                            <tr>
                                                <td>Materi yang diajarkan sesuai dengan RPS (F3-3)</td>
                                                <td><input type="radio" value='5' name='cf33' required></td>
                                                <td><input type="radio" value='4' name='cf33'></td>
                                                <td><input type="radio" value='3' name='cf33'></td>
                                                <td><input type="radio" value='2' name='cf33'></td>
                                                <td><input type="radio" value='1' name='cf33'></td>
                                            </tr>
                                            <tr>
                                                <td>Cara Mengajar tidak Membosankan (F3-4)</td>
                                                <td><input type="radio" value='5' name='cf34' required></td>
                                                <td><input type="radio" value='4' name='cf34'></td>
                                                <td><input type="radio" value='3' name='cf34'></td>
                                                <td><input type="radio" value='2' name='cf34'></td>
                                                <td><input type="radio" value='1' name='cf34'></td>
                                            </tr>

                                            <tr>
                                                <td colspan="6"><b>F4 Kemampuan Berkomunikasi Dosen dengan Mahasiswa
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Melakukan diskusi dengan mahasiswa (F4-1)</td>
                                                <td><input type="radio" value='5' name='cf41' required></td>
                                                <td><input type="radio" value='4' name='cf41'></td>
                                                <td><input type="radio" value='3' name='cf41'></td>
                                                <td><input type="radio" value='2' name='cf41'></td>
                                                <td><input type="radio" value='1' name='cf41'></td>
                                            </tr>
                                            <tr>
                                                <td>Mampu memotivasi mahasiswa (F4-2)</td>
                                                <td><input type="radio" value='5' name='cf42' required></td>
                                                <td><input type="radio" value='4' name='cf42'></td>
                                                <td><input type="radio" value='3' name='cf42'></td>
                                                <td><input type="radio" value='2' name='cf42'></td>
                                                <td><input type="radio" value='1' name='cf42'></td>
                                            </tr>
                                            <tr>
                                                <td>Memberikan informasi akademik dengan tepat (F4-3)</td>
                                                <td><input type="radio" value='5' name='cf43' required></td>
                                                <td><input type="radio" value='4' name='cf43'></td>
                                                <td><input type="radio" value='3' name='cf43'></td>
                                                <td><input type="radio" value='2' name='cf43'></td>
                                                <td><input type="radio" value='1' name='cf43'></td>
                                            </tr>
                                            <tr>
                                                <td>Tanggap terhadap permasalahan akademik Mahasiswa (F4-4)</td>
                                                <td><input type="radio" value='5' name='cf44' required></td>
                                                <td><input type="radio" value='4' name='cf44'></td>
                                                <td><input type="radio" value='3' name='cf44'></td>
                                                <td><input type="radio" value='2' name='cf44'></td>
                                                <td><input type="radio" value='1' name='cf44'></td>
                                            </tr>
                                            <tr>
                                                <td colspan="6"><b>F5 Perilaku dan Sikap Dosen</td>

                                            </tr>
                                            <tr>
                                                <td>Disiplin dalam waktu (memulai dan mengakhiri) perkuliahan (F5-1)
                                                </td>
                                                <td><input type="radio" value='5' name='cf51' required></td>
                                                <td><input type="radio" value='4' name='cf51'></td>
                                                <td><input type="radio" value='3' name='cf51'></td>
                                                <td><input type="radio" value='2' name='cf51'></td>
                                                <td><input type="radio" value='1' name='cf51'></td>
                                            </tr>
                                            <tr>
                                                <td>Mengenakan pakaian dengan rapi (F5-2)</td>
                                                <td><input type="radio" value='5' name='cf52' required></td>
                                                <td><input type="radio" value='4' name='cf52'></td>
                                                <td><input type="radio" value='3' name='cf52'></td>
                                                <td><input type="radio" value='2' name='cf52'></td>
                                                <td><input type="radio" value='1' name='cf52'></td>
                                            </tr>
                                            <tr>
                                                <td>Jarang mengosongkan perkuliahan (F5-3)</td>
                                                <td><input type="radio" value='5' name='cf53' required></td>
                                                <td><input type="radio" value='4' name='cf53'></td>
                                                <td><input type="radio" value='3' name='cf53'></td>
                                                <td><input type="radio" value='2' name='cf53'></td>
                                                <td><input type="radio" value='1' name='cf53'></td>
                                            </tr>
                                            <tr>
                                                <td>Memberikan contoh sikap yang baik kepada Mahasiswa (F5-4)</td>
                                                <td><input type="radio" value='5' name='cf54' required></td>
                                                <td><input type="radio" value='4' name='cf54'></td>
                                                <td><input type="radio" value='3' name='cf54'></td>
                                                <td><input type="radio" value='2' name='cf54'></td>
                                                <td><input type="radio" value='1' name='cf54'></td>
                                            </tr>

                                        </tbody>

                                    </table>
                                    F6. Berikan Masukan Anda Untuk Program Studi Mengenai Matakuliah dan Dosen <br>
                                    <textarea name="cf6" rows="5" cols="40" class="form-control"></textarea> <br>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-info">Kirim</button>
                    </div>
            </div>
            </section>
        </div>
        </form>
    </div>

</div>