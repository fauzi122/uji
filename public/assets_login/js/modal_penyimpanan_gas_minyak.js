function editPMB(id,kab_kota, produk) {
  // alert('test');
    // $('.editPenjualan').click(function () {
    //   let id = $(this).attr('data-id')
    // Kirim data melalui Ajax
    $('input:checkbox').removeAttr('checked');
    $.ajax({
      url: '/get-pmb/' + id,
      method: 'GET',
      data: {
        id: id
      },
      success: function (response) {
        // console.log(response);
        // Tangkap pesan dari server dan tampilkan ke user
        if ($.inArray('Minyak Bumi', response.data.find.jenis_komoditas) != -1) {
          // alert("DATA")
          $('#edit_minyak_bumi').attr("checked", "checked")
        }
        if ($.inArray('BBM', response.data.find.jenis_komoditas) != -1) {
          $('#edit_bbm').attr("checked", "checked")
        }
        if ($.inArray('Hasil Olahan', response.data.find.jenis_komoditas) != -1) {
          $('#edit_hasil_olahan').attr("checked", "checked")
        }
        let bulanx = response.data.find.bulan.substring(0, 7)
        $('#form_pmb').attr('action', '/update_pmb/' + response.data.find.id)
        $('#id_pmb').val(response.data.find.id)
        // $('#bulan_pmb').val(response.data.find.bulan)
        $('#bulan_pmb').val(bulanx)
        $('#jenis_fasilitas_pmb').val(response.data.find.jenis_fasilitas)
        $('#no_tangki_pmb').val(response.data.find.no_tangki)
        // $('#jenis_komoditas_pmb').val(response.data.find.jenis_komoditas)
        $('#produk_pmb').val(response.data.find.produk)
        $('#provinsi_pmb').val(response.data.find.provinsi)
        $('#kab_kota_pmb').val(response.data.find.kab_kota)
        $('#kategori_supplai_pmb').val(response.data.find.kategori_supplai)
        $('#volume_stok_awal_pmb').val(response.data.find.volume_stok_awal)
        $('#volume_supply_pmb').val(response.data.find.volume_supply)
        $('#volume_output_pmb').val(response.data.find.volume_output)
        $('#volume_stok_akhir_pmb').val(response.data.find.volume_stok_akhir)
        $('#satuan_pmb').val(response.data.find.satuan)
        $('#utilasi_tangki_pmb').val(response.data.find.utilasi_tangki)
        $('#pengguna_pmb').val(response.data.find.pengguna)
        $('#jangka_waktu_penggunaan_pmb').val(response.data.find.jangka_waktu_penggunaan)
        $('#tarif_penyimpanan_pmb').val(response.data.find.tarif_penyimpanan)
        $('#satuan_tarif_pmb').val(response.data.find.satuan_tarif)
        $('#keterangan_pmb').val(response.data.find.keterangan)
  
        let produkSelect = response.data.find.produk
        let satuanSelect = response.data.find.satuan
        let provinsiSelect = response.data.find.provinsi
        let kotaSelect = response.data.find.kab_kota
  
        $('#produk_pmb').empty()
        $('#produk_pmb').append(` <option>Pilih Produk</option>`)
        $.each(response.data.produk, function (i, value) {
          let isSelected = produkSelect == value.name ? 'selected' : ''
  
          $('#produk_pmb').append(
            `<option value="` + value.name + `"` + isSelected + `>` + value.name + `</option>`
          )
        });
  
        $.ajax({
          url: '/get-satuan/' + produk,
          method: 'GET',
          data: {},
          success: function (response) {
            // console.log(response);
            // Loop melalui data dan tambahkan opsi ke dalam select
            $('#satuan_pmb').empty()
            $('#satuan_pmb').append(` <option>Pilih Satuan</option>`)
            $.each(response.data, function (i, value) {
              let isSelected = satuanSelect == value.satuan ? 'selected' : ''
              $('#satuan_pmb').append(
                `<option value="` + value.satuan + `" ` + isSelected + `>` + value.satuan + `</option>`
              )
            });
          },
          error: function (xhr, status, error) {
            // Tangkap pesan error jika ada
            alert('Terjadi kesalahan saat mengirim data.');
          }
        });
        
        $('#provinsi_pmb').empty()
        $('#provinsi_pmb').append(` <option>Pilih Provinsi</option>`)
        $.each(response.data.provinsi, function (i, value) {
          let isSelected = provinsiSelect == value.name ? 'selected' : ''

          $('#provinsi_pmb').append(
            `<option value="` + value.name + `"` + isSelected + `>` + value.name + `</option>`
          )
        });
  
        // alert(kabupaten_kota)
        // console.log(response.data.provinsi);
  
        $.ajax({
          url: '/get-kab-kota/',
          method: 'GET',
          data: {},
          success: function (response) {
            // console.log(response.data);
            // Loop melalui data dan tambahkan opsi ke dalam select
            $('#kab_kota_pmb').empty()
            $('#kab_kota_pmb').append(` <option>Pilih Kab / Kota</option>`)
            $.each(response.data, function (i, value) {
              let isSelected = kotaSelect == value.nama_kota ? 'selected' : ''
      
              $('#kab_kota_pmb').append(
                `<option value="` + value.nama_kota + `"` + isSelected + `>` + value.nama_kota + `</option>`
              )
            });
          },
          error: function (xhr, status, error) {
            // Tangkap pesan error jika ada
            alert('Terjadi kesalahan saat mengirim data.');
          }
        });
  
        // Contoh: Lakukan tindakan selanjutnya setelah data berhasil dikirim
        // window.location.href = '/success-page';
      },
      error: function (xhr, status, error) {
        // Tangkap pesan error jika ada
        alert('Terjadi kesalahan saat mengirim data.');
      }
    });
    // })
}

  function lihat_pmb(id, produk, kabupaten_kota) {
    // $('.editPenjualan').click(function () {
    //   let id = $(this).attr('data-id')
    // Kirim data melalui Ajax
    $('input:checkbox').removeAttr('checked');
    $.ajax({
      url: '/get-pmb/' + id,
      method: 'GET',
      data: {
        id: id
      },
      success: function (response) {
        // Tangkap pesan dari server dan tampilkan ke user
        if ($.inArray('Minyak Bumi', response.data.find.jenis_komoditas) != -1) {
          // alert("DATA")
          $('#lihat_minyak_bumi').attr("checked", "checked")
        }
        if ($.inArray('BBM', response.data.find.jenis_komoditas) != -1) {
          $('#lihat_bbm').attr("checked", "checked")
        }
        if ($.inArray('Hasil Olahan', response.data.find.jenis_komoditas) != -1) {
          $('#lihat_hasil_olahan').attr("checked", "checked")
        }
        $('#id_pmb_lihat').val(response.data.find.id)
        $('#bulan_pmb_lihat').val(response.data.find.bulan)
        $('#jenis_fasilitas_pmb_lihat').val(response.data.find.jenis_fasilitas)
        $('#no_tangki_pmb_lihat').val(response.data.find.no_tangki)
        $('#jenis_komoditas_pmb_lihat').val(response.data.find.jenis_komoditas)
        $('#produk_pmb_lihat').val(response.data.find.produk)
        $('#provinsi_pmb_lihat').val(response.data.find.provinsi)
        $('#kab_kota_pmb_lihat').val(response.data.find.kab_kota)
        $('#kategori_supplai_pmb_lihat').val(response.data.find.kategori_supplai)
        $('#volume_stok_awal_pmb_lihat').val(response.data.find.volume_stok_awal)
        $('#volume_supply_pmb_lihat').val(response.data.find.volume_supply)
        $('#volume_output_pmb_lihat').val(response.data.find.volume_output)
        $('#volume_stok_akhir_pmb_lihat').val(response.data.find.volume_stok_akhir)
        $('#satuan_pmb_lihat').val(response.data.find.satuan)
        $('#utilasi_tangki_pmb_lihat').val(response.data.find.utilasi_tangki)
        $('#pengguna_pmb_lihat').val(response.data.find.pengguna)
        $('#jangka_waktu_penggunaan_pmb_lihat').val(response.data.find.jangka_waktu_penggunaan)
        $('#tarif_penyimpanan_pmb_lihat').val(response.data.find.tarif_penyimpanan)
        $('#satuan_tarif_pmb_lihat').val(response.data.find.satuan_tarif)
        $('#keterangan_pmb_lihat').val(response.data.find.keterangan)
  
  
        // Contoh: Lakukan tindakan selanjutnya setelah data berhasil dikirim
        // window.location.href = '/success-page';
      },
      error: function (xhr, status, error) {
        // Tangkap pesan error jika ada
        alert('Terjadi kesalahan saat mengirim data.');
      }
    });
    // })
  }


function editpggb(id, kab_kota, produk) {
    // $('.editPenjualan').click(function () {
    //   let id = $(this).attr('data-id')
    // Kirim data melalui Ajax
    $.ajax({
      url: '/get-pggb/' + id,
      method: 'GET',
      data: {
        id: id
      },
      success: function (response) {
        // console.log(response);
        // Tangkap pesan dari server dan tampilkan ke user
        let bulanx = response.data.find.bulan.substring(0, 7)
        $('#form_pggb').attr('action', '/update_pggb/' + response.data.find.id)
        $('#id_pggb').val(response.data.find.id)
        // $('#bulan_pggb').val(response.data.find.bulan)
        $('#bulan_pggb').val(bulanx)
        $('#jenis_fasilitas_pggb').val(response.data.find.jenis_fasilitas)
        $('#no_tangki_pggb').val(response.data.find.no_tangki)
        $('#jenis_komoditas_pggb').val(response.data.find.jenis_komoditas)
        $('#produk_pggb').val(response.data.find.produk)
        $('#kab_kota_pggb').val(response.data.find.kab_kota)
        $('#kategori_supplai_pggb').val(response.data.find.kategori_supplai)
        $('#volume_stok_awal_pggb').val(response.data.find.volume_stok_awal)
        $('#volume_supply_pggb').val(response.data.find.volume_supply)
        $('#volume_output_pggb').val(response.data.find.volume_output)
        $('#volume_stok_akhir_pggb').val(response.data.find.volume_stok_akhir)
        $('#satuan_pggb').val(response.data.find.satuan)
        $('#utilasi_tangki_pggb').val(response.data.find.utilasi_tangki)
        $('#pengguna_pggb').val(response.data.find.pengguna)
        $('#jangka_waktu_penggunaan_pggb').val(response.data.find.jangka_waktu_penggunaan)
        $('#tarif_penyimpanan_pggb').val(response.data.find.tarif_penyimpanan)
        $('#satuan_tarif_pggb').val(response.data.find.satuan_tarif)
        $('#keterangan_pggb').val(response.data.find.keterangan)
  
        let produkSelect = response.data.find.produk
        let satuanSelect = response.data.find.satuan
        let kotaSelect = response.data.find.kab_kota
        // console.log(kotaSelect);
  
        $('#produk_pggb').empty()
        $('#produk_pggb').append(` <option>Pilih Produk</option>`)
        $.each(response.data.produk, function (i, value) {
          let isSelected = produkSelect == value.name ? 'selected' : ''
  
          $('#produk_pggb').append(
            `<option value="` + value.name + `"` + isSelected + `>` + value.name + `</option>`
          )
        });
  
        $.ajax({
          url: '/get-satuan/' + produk,
          method: 'GET',
          data: {},
          success: function (response) {
            // console.log(produk);
            // Loop melalui data dan tambahkan opsi ke dalam select
            $('#satuan_pggb').empty()
            $('#satuan_pggb').append(` <option>Pilih Satuan</option>`)
            $.each(response.data, function (i, value) {
              let isSelected = satuanSelect == value.satuan ? 'selected' : ''
              $('#satuan_pggb').append(
                `<option value="` + value.satuan + `" ` + isSelected + `>` + value.satuan + `</option>`
              )
            });
          },
          error: function (xhr, status, error) {
            // Tangkap pesan error jika ada
            alert('Terjadi kesalahan saat mengirim data.');
          }
        });

        $.ajax({
          url: '/get-kab-kota/',
          method: 'GET',
          data: {},
          success: function (response) {
            // console.log(response.data);
            // Loop melalui data dan tambahkan opsi ke dalam select
            $('#kab_kota_pggb').empty()
            $('#kab_kota_pggb').append(` <option>Pilih Kab / Kota</option>`)
            $.each(response.data, function (i, value) {
              let isSelected = kotaSelect == value.nama_kota ? 'selected' : ''
      
              $('#kab_kota_pggb').append(
                `<option value="` + value.nama_kota + `"` + isSelected + `>` + value.nama_kota + `</option>`
              )
            });
          },
          error: function (xhr, status, error) {
            // Tangkap pesan error jika ada
            alert('Terjadi kesalahan saat mengirim data.');
          }
        });
  
        // Contoh: Lakukan tindakan selanjutnya setelah data berhasil dikirim
        // window.location.href = '/success-page';
      },
      error: function (xhr, status, error) {
        // Tangkap pesan error jika ada
        alert('Terjadi kesalahan saat mengirim data!.');
      }
    });
    // })
}


function lihat_pggb(id, produk, kabupaten_kota) {
  // $('.editPenjualan').click(function () {
  //   let id = $(this).attr('data-id')
  // Kirim data melalui Ajax
  $.ajax({
    url: '/get-pggb/' + id,
    method: 'GET',
    data: {
      id: id
    },
    success: function (response) {
      // Tangkap pesan dari server dan tampilkan ke user
      $('#form_pggb').attr('action', '/update_pggb/' + response.data.find.id)
      $('#id_pggb_lihat').val(response.data.find.id)
      $('#bulan_pggb_lihat').val(response.data.find.bulan)
      $('#jenis_fasilitas_pggb_lihat').val(response.data.find.jenis_fasilitas)
      $('#no_tangki_pggb_lihat').val(response.data.find.no_tangki)
      $('#jenis_komoditas_pggb_lihat').val(response.data.find.jenis_komoditas)
      $('#produk_pggb_lihat').val(response.data.find.produk)
      $('#kab_kota_pggb_lihat').val(response.data.find.kab_kota)
      $('#kategori_supplai_pggb_lihat').val(response.data.find.kategori_supplai)
      $('#volume_stok_awal_pggb_lihat').val(response.data.find.volume_stok_awal)
      $('#volume_supply_pggb_lihat').val(response.data.find.volume_supply)
      $('#volume_output_pggb_lihat').val(response.data.find.volume_output)
      $('#volume_stok_akhir_pggb_lihat').val(response.data.find.volume_stok_akhir)
      $('#satuan_pggb_lihat').val(response.data.find.satuan)
      $('#utilasi_tangki_pggb_lihat').val(response.data.find.utilasi_tangki)
      $('#pengguna_pggb_lihat').val(response.data.find.pengguna)
      $('#jangka_waktu_penggunaan_pggb_lihat').val(response.data.find.jangka_waktu_penggunaan)
      $('#tarif_penyimpanan_pggb_lihat').val(response.data.find.tarif_penyimpanan)
      $('#satuan_tarif_pggb_lihat').val(response.data.find.satuan_tarif)
      $('#keterangan_pggb_lihat').val(response.data.find.keterangan)

      // Contoh: Lakukan tindakan selanjutnya setelah data berhasil dikirim
      // window.location.href = '/success-page';
    },
    error: function (xhr, status, error) {
      // Tangkap pesan error jika ada
      alert('Terjadi kesalahan saat mengirim data!.');
    }
  });
  // })
}


function tambahPMB(bulan) {
  // Mendapatkan elemen dengan ID 'bulanx'
  var elemen = document.getElementById('bulanx');
  var elemen_import = document.getElementById('bulan_import');

  // Mengatur ID elemen 'bulanx' dengan nilai bulan yang diterima dari parameter
  // elemen.id = bulan;
  // console.log(bulan);
  $('#bulanx').val(bulan)
  elemen.readOnly = true;

  $('#bulanxx').val(bulan)
  elemen.readOnly = true;
  
  $('#bulan_import').val(bulan)
  elemen_import.readOnly = true;

  $('#bulan_importx').val(bulan)
  elemen_import.readOnly = true;

  $('#bulan_importxx').val(bulan)
  elemen_import.readOnly = true;

  // Anda dapat melakukan operasi lain dengan elemen atau nilai bulan
}
