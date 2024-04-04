<a href="/baak/uts-create-pilih/{{$id}}" class="btn btn-success">Input Soal Pilihan Ganda</a>
									
                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#basicModal">
                                      Import Excel Soal Pilihan Ganda
                                    </button>                       
                                  <p>
                                    <br>
                                  <h4>List Soal Pilihan Ganda</h4>	
                                  <hr>
                                  </p>
                                  
                                  <form action="{{ url('/prodi/aprov-soal') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary" id="persetujuanKaprodiBtn">Persetujuan Kaprodi</button>
                                    <table id="copy-print-csv" class="table custom-table">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" id="checkAll"></th>                               
                                                <th>Soal</th>                               
                                                <th style="text-align: center;">Kunci</th>
                                                <th style="text-align: center;">Status</th>
                                                <th style="text-align: center;">Updated</th>
                                                <th style="text-align: center;">Dosen</th>
                                                <th style="text-align: center; width: 100px">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($soals as $no => $soals)
                                            <tr>
                                                <td>
                                               
                                            <input type="checkbox" class="soal-checkbox" name="soal_ids[]" value="{{ $soal->id }}">
                                                   
                                                </td>
                                                <td>{{ strip_tags($soals->soal) }}</td>
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
                                
                                                    @if ($soals->file != '')
                                                        <center>
                                                            <a href="/baak/detail/soal-show-uts/{{$detail}}"><span class='badge badge-pill badge-info'>cek gambar</span></a>
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
                                </form>
                                
                                <script>
                                    document.getElementById('checkAll').onclick = function() {
                                        var checkboxes = document.querySelectorAll('.soal-checkbox');
                                        for (var checkbox of checkboxes) {
                                            checkbox.checked = this.checked;
                                        }
                                    };
                                
                                    document.getElementById('persetujuanKaprodiBtn').onclick = function(event) {
                                        var selectedCheckboxes = document.querySelectorAll('.soal-checkbox:checked');
                                        if (selectedCheckboxes.length === 0) {
                                            event.preventDefault();
                                            alert('Silahkan pilih minimal satu soal sebelum memberikan persetujuan.');
                                        }
                                    };
                                </script>
                                    
                                