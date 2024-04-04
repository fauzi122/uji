<br>
<br>
    <a href="/baak/uts-create-essay/{{$id}}" class="btn btn-success">Input Soal Essay</a>
  <button type="button" class="btn btn-info" data-toggle="modal" data-target="#basicModal1">
    Import Excel Soal Essay
  </button>
  <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#basicModal">
    Persetujuan Kaprodi
  </button>
<br>
<br>
 
  <h4>List Soal Pilihan Essay</h4>
  <hr>
  </p>
                            
    <table id="myTable2" class="table custom-table">
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