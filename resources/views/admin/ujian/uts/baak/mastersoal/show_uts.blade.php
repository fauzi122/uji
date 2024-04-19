@extends('layouts.dosen.ujian.main')

@section('content')
<div class="main-container">
    <div class="content-wrapper">
        <div class="row gutters">
            <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
                <div class="card-header badge-info">
                    <h4 class="m-b-0 text-white">Master Soal</h4>
                </div>
                <div class="card">
                    <div class="card-body p-0">
                        <div class="invoice-container">
                            <div class="invoice-header">
                                
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

                                @php
                                  $kirim =Crypt::encryptString ($soal->kd_mtk.','.$soal->paket.','.Auth::user()->kode); 
                                    $id = Crypt::encryptString($soal->kd_mtk.','.$soal->paket.','.Auth::user()->kode);
                                @endphp
                            </div>
                            <div class="body">
                                <div class="row gutters">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="table-responsive">
                                          @if($soal->jenis_mtk=='PG ONLINE')
                                            @include('admin.ujian.uts.baak.mastersoal.form.table_soalpg')
                                          @endif

                                            @if($soal->jenis_mtk=='ESSAY ONLINE')
                                            @include('admin.ujian.uts.baak.mastersoal.form.table_essay')
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('admin.ujian.uts.baak.mastersoal.form.info')
        </div>
        @include('admin.ujian.uts.baak.mastersoal.form.modal_soal')
    </div>
</div>
@endsection

{{-- @push('scripts')
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


@endpush --}}