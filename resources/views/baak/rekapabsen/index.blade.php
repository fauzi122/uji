@extends('layouts.dosen.main')

@section('content')
<div class="content-wrapper">
    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Rekap Absen Mahasiswa</h4>
                </div>
                <div class="card-body">
                    <!-- Form untuk memilih Kd Lokal dan Kd MTK -->
                    <div class="form-group">
                        <label for="kd_lokal">Pilih Kelas (Kd Lokal)</label>
                        <select id="kd_lokal" class="form-control select2">
                            <option value="">Pilih Kd Lokal</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="kd_mtk">Pilih Mata Kuliah (Kd MTK)</label>
                        <select id="kd_mtk" class="form-control select2">
                            <option value="">Pilih Kd MTK</option>
                        </select>
                    </div>

                    <!-- Tabel Data Absensi Mahasiswa -->
                    <div class="table-container" style="display:none;">
                        <div class="table-responsive">
                            <table id="tbl_list" class="table custom-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Dosen</th>
                                        <th>Nama Dosen</th>
                                        <th>Kode Matakuliah</th>
                                        <th>Nama Matakuliah</th>
                                        <th>NIM</th>
                                        <th>Nama Mahasiswa</th>
                                        <th>Kelas</th>
                                        <th>Jumlah Hadir</th>
                                        <th>Jumlah Tidak Hadir</th>
                                        <th>Total Pertemuan</th>
                                        <th>Persentase Kehadiran</th>
                                        <th>No.Hp/Telp</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data akan dimuat oleh DataTables via AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        // Inisialisasi Select2 untuk dropdown
        $('.select2').select2();

        // Load Kd Lokal dari server
        $.ajax({
            url: "{{ url('rekap-absen/kd-lokal') }}",
            method: 'GET',
            success: function(data) {
                $('#kd_lokal').empty().append('<option value="">Pilih Kd Lokal</option>');
                data.forEach(function(item) {
                    $('#kd_lokal').append('<option value="' + item.kd_lokal + '">' + item.kd_lokal + '</option>');
                });
            },
            error: function(xhr, status, error) {
                console.log('Error loading kd_lokal:', error);
            }
        });

        // Load Kd MTK ketika Kd Lokal dipilih
        $('#kd_lokal').change(function() {
            var kd_lokal = $(this).val();

            if (kd_lokal) {
                $.ajax({
                    url: "{{ url('rekap-absen/kd-mtk-by-lokal') }}",
                    method: 'GET',
                    data: {
                        kd_lokal: kd_lokal
                    },
                    success: function(data) {
                        $('#kd_mtk').empty().append('<option value="">Pilih Kd MTK</option>');
                        data.forEach(function(item) {
                            $('#kd_mtk').append('<option value="' + item.kd_mtk + '">' + item.kd_mtk + ' - ' + item.nm_mtk + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.log('Error loading kd_mtk:', error);
                    }
                });
            } else {
                $('#kd_mtk').empty().append('<option value="">Pilih Kd MTK</option>');
            }
        });

        // Load DataTables saat Kd MTK dipilih
        $('#kd_mtk').change(function() {
            var kd_lokal = $('#kd_lokal').val();
            var kd_mtk = $('#kd_mtk').val();

            if (kd_lokal && kd_mtk) {
                $('.table-container').show();

                $('#tbl_list').DataTable({
                    processing: true,
                    serverSide: true,
                    destroy: true,
                    ajax: {
                        url: "{{ url('rekap-absen-mhs/json') }}",
                        data: {
                            kd_lokal: kd_lokal,
                            kd_mtk: kd_mtk
                        }
                    },
                    columns: [{
                            data: null,
                            name: 'no',
                            searchable: false,
                            orderable: false,
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {
                            data: 'kode_dosen',
                            name: 'kode_dosen'
                        },
                        {
                            data: 'nama_dosen',
                            name: 'nama_dosen'
                        },
                        {
                            data: 'kd_mtk',
                            name: 'kd_mtk'
                        },
                        {
                            data: 'nama_mtk',
                            name: 'nama_mtk'
                        },
                        {
                            data: 'nim',
                            name: 'nim'
                        },
                        {
                            data: 'nm_mhs',
                            name: 'nm_mhs'
                        },
                        {
                            data: 'kd_lokal',
                            name: 'kd_lokal'
                        },
                        {
                            data: 'jml_hadir',
                            name: 'jml_hadir'
                        },
                        {
                            data: 'jml_absen',
                            name: 'jml_absen'
                        },
                        {
                            data: 'totalpertemuan',
                            name: 'totalpertemuan'
                        },
                        {
                            data: 'prosentase',
                            name: 'prosentase',
                            render: function(data) {
                                return (data !== null && !isNaN(data)) ? parseFloat(data).toFixed(2) + '%' : 'N/A';
                            }
                        },
                        {
                            data: null, // Set null to indicate custom rendering
                            name: 'no_telp_hp_telpon', // Give a unique name, this is not used for SQL queries
                            render: function(data, type, row) {
                                // Combine 'no_telp_hp' and 'telp' with a '/'
                                return data.no_telp_hp + ' / ' + data.telp;
                            }
                        },
                        {
                            data: 'emailaddress',
                            name: 'emailaddress'
                        },
                    ],
                    dom: 'Blfrtip',
                    lengthMenu: [
                        [300],
                        ['Show All']
                    ],
                    buttons: [
                        'copy', 'csv', 'excel',
                        {
                            extend: 'pdfHtml5',
                            orientation: 'landscape', // Set PDF orientation to landscape
                            pageSize: 'A4',
                            title: 'Rekap Absen Mahasiswa',
                            customize: function(doc) {
                                doc.pageMargins = [10, 10, 10, 10]; // Adjust margins [top, left, bottom, right]
                                doc.defaultStyle.fontSize = 8; // Adjust the font size
                                doc.content[1].table.widths = [
                                    '5%', '10%', '15%', '10%', '15%', '10%', '15%', '10%', '10%', '10%', '10%', '10%'
                                ]; // Adjust column widths
                                doc.content[1].layout = 'lightHorizontalLines'; // Add grid lines to the table
                                doc.styles.tableHeader.fontSize = 10; // Adjust the font size of the table header
                            }
                        },
                        'print',
                    ],
                });


            }
        });
    });
</script>
@endpush