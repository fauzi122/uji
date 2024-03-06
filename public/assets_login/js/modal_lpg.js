function edit_harga(id, produk, kabupaten_kota) {
  // $('.editPenjualan').click(function () {
  //     let id = $(this).attr('data-id')
  // Kirim data melalui Ajax
  $.ajax({
    url: '/get-penjualan-lpg/' + id,
    method: 'GET',
    data: {
      id: id
    },
    success: function (response) {
      // Tangkap pesan dari server dan tampilkan ke user
      let bulanx = response.data.find.bulan.substring(0, 7)

      $('#form_lpg').attr('action', '/update_lpg/' + response.data.find.id)
      $('#id_penjualan').val(response.data.find.id)
      // $('#bulan_penjualan').val(response.data.find.bulan)
      $('#bulan_penjualan').val(bulanx)
      $('#provinsi_penjualan').val(response.data.find.provinsi)
      $('#kab_penjualan').val(response.data.find.kabupaten_kota)
      $('#produk_penjualan').val(response.data.find.produk)
      $('#satuan_penjualan').val(response.data.find.satuan)
      $('#konsumen_penjualan').val(response.data.find.konsumen)
      $('#sektor_penjualan').val(response.data.find.sektor)
      $('#kemasan_penjualan').val(response.data.find.kemasan)
      $('#volume_penjualan').val(response.data.find.volume)
      $('#biaya_kompresi_penjualan').val(response.data.find.biaya_kompresi)
      $('#biaya_penyimpanan_penjualan').val(response.data.find.biaya_penyimpanan)
      $('#biaya_pengangkutan_penjualan').val(response.data.find.biaya_pengangkutan)
      $('#biaya_niaga_penjualan').val(response.data.find.biaya_niaga)
      $('#harga_jual_penjualan').val(response.data.find.biaya_niaga)

      let produkSelect = response.data.find.produk
      let satuanSelect = response.data.find.satuan
      let provinsiSelect = response.data.find.provinsi
      let kotaSelect = response.data.find.kabupaten_kota

      $('#produk_penjualan').empty()
      $('#produk_penjualan').append(` <option>Pilih Produk</option>`)
      $.each(response.data.produk, function (i, value) {
        let isSelected = produkSelect == value.name ? 'selected' : ''

        $('#produk_penjualan').append(
          `<option value="` + value.name + `"` + isSelected + `>` + value.name + `</option>`
        )
      });

      // alert(response.data.find.provinsi)

      $.ajax({
        url: '/get-satuan/' + produk,
        method: 'GET',
        data: {},
        success: function (response) {
          // console.log(response);
          // Loop melalui data dan tambahkan opsi ke dalam select
          $('#satuan_penjualan').empty()
          $('#satuan_penjualan').append(` <option>Pilih Satuan</option>`)
          $.each(response.data, function (i, value) {
            let isSelected = satuanSelect == value.satuan ? 'selected' : ''
            $('#satuan_penjualan').append(
              `<option value="` + value.satuan + `" ` + isSelected + `>` + value.satuan + `</option>`
            )
          });
        },
        error: function (xhr, status, error) {
          // Tangkap pesan error jika ada
          alert('Terjadi kesalahan saat mengirim data ID Penjualan.');
        }
      });

      // console.log(response);
      $('#provinsi_penjualan').empty()
      $('#provinsi_penjualan').append(` <option>Pilih Provinsi</option>`)
      $.each(response.data.provinsi, function (i, value) {
        let isSelected = provinsiSelect == value.name ? 'selected' : ''

        $('#provinsi_penjualan').append(
          `<option data-id="` + value.id + `" value="` + value.name + `"` + isSelected + `>` + value.name + `</option>`
        )
      });


      $.ajax({
        url: '/get_kota_lpg/' + kabupaten_kota,
        method: 'GET',
        data: {},
        success: function (response) {
          // console.log(response);
          // console.log(kabupaten_kota);
          // Loop melalui data dan tambahkan opsi ke dalam select
          $('#kab_penjualan').empty()
          $('#kab_penjualan').append(` <option>Pilih Kab / Kota</option>`)
          $.each(response.data, function (i, value) {
            let isSelected = kotaSelect == value.nama_kota ? 'selected' : ''
            $('#kab_penjualan').append(
              `<option value="` + value.nama_kota + `" ` + isSelected + `>` + value.nama_kota + `</option>`
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
  //   })
}

function lihatPenjualanLPG(id, produk, kabupaten_kota) {
  $.ajax({
    url: '/get-penjualan-lpg/' + id,
    method: 'GET',
    data: {
      id: id
    },
    success: function (response) {
      // Tangkap pesan dari server dan tampilkan ke user
      let bulanx = response.data.find.bulan.substring(0, 7)

      $('#lihat_bulan_penjualan').val(bulanx)
      $('#lihat_provinsi_penjualan').val(response.data.find.provinsi)
      $('#lihat_kab_penjualan').val(response.data.find.kabupaten_kota)
      $('#lihat_produk_penjualan').val(response.data.find.produk)
      $('#lihat_satuan_penjualan').val(response.data.find.satuan)
      $('#lihat_sektor_penjualan').val(response.data.find.sektor)
      $('#lihat_kemasan_penjualan').val(response.data.find.kemasan)
      $('#lihat_volume_penjualan').val(response.data.find.volume)
    },
    error: function (xhr, status, error) {
      // Tangkap pesan error jika ada
      alert('Terjadi kesalahan saat mengirim data ID Penjualan.');
    }
  });
  //   })
}

function lihat_lng(id) {
  // $('.editPenjualan').click(function () {
  //     let id = $(this).attr('data-id')
  // Kirim data melalui Ajax
  $.ajax({
    url: '/get-penjualan-lng/' + id,
    method: 'GET',
    data: {
      id: id
    },
    success: function (response) {
      // Tangkap pesan dari server dan tampilkan ke user
      let bulanx = response.data.find.bulan.substring(0, 7)

      $('#form_lng').attr('action', '/update_lng/' + response.data.find.id)
      $('#lihat_id_penjualan').val(response.data.find.id)
      // $('#lihat_bulan_penjualan').val(response.data.find.bulan)
      $('#lihat_bulan_penjualan').val(bulanx)
      $('#lihat_provinsi_penjualan').val(response.data.find.provinsi)
      $('#lihat_kab_penjualan').val(response.data.find.kabupaten_kota)
      $('#lihat_produk_penjualan').val(response.data.find.produk)
      $('#lihat_satuan_penjualan').val(response.data.find.satuan)
      $('#lihat_konsumen_penjualan').val(response.data.find.konsumen)
      $('#lihat_sektor_penjualan').val(response.data.find.sektor)
      $('#lihat_volume_penjualan').val(response.data.find.volume)
      $('#lihat_biaya_kompresi_penjualan').val(response.data.find.biaya_kompresi)
      $('#lihat_biaya_penyimpanan_penjualan').val(response.data.find.biaya_penyimpanan)
      $('#lihat_biaya_pengangkutan_penjualan').val(response.data.find.biaya_pengangkutan)
      $('#lihat_biaya_niaga_penjualan').val(response.data.find.biaya_niaga)
      $('#lihat_harga_jual_penjualan').val(response.data.find.biaya_niaga)

      // Contoh: Lakukan tindakan selanjutnya setelah data berhasil dikirim
      // window.location.href = '/success-page';

    },
    error: function (xhr, status, error) {
      // Tangkap pesan error jika ada
      alert('Terjadi kesalahan saat mengirim data.');
    }
  });
  //   })
}

function edit_pasokan_lng(id, produk) {
  // $('.editPasok').click(function () {
  //     alert('test');
  //     let id = $(this).attr('data-id')
  // Kirim data melalui Ajax
  $.ajax({
    url: '/get-pasok-lng/' + id,
    method: 'GET',
    data: {
      id: id
    },
    success: function (response) {
      // Tangkap pesan dari server dan tampilkan ke user
      $('#form_pasok').attr('action', '/update_pasok_lng/' + response.data.find.id)
      $('#bulan_pasok').val(response.data.find.bulan)
      $('#produk_pasok').val(response.data.find.produk)
      $('#satuan_pasok').val(response.data.find.satuan)
      $('#nama_pemasok_pasok').val(response.data.find.nama_pemasok)
      $('#kategori_pemasok_pasok').val(response.data.find.kategori_pemasok)
      $('#volume_pasok').val(response.data.find.volume)
      $('#satuan_pasok').val(response.data.find.satuan)
      $('#harga_gas_pasok').val(response.data.find.harga_gas)

      let produkSelect = response.data.find.produk
      let satuanSelect = response.data.find.satuan
      let kategori_pemasokSelect = response.data.find.kategori_pemasok

      $('#produk_pasok').empty()
      $('#produk_pasok').append(` <option>Pilih Produk</option>`)
      $.each(response.data.produk, function (i, value) {
        let isSelected = produkSelect == value.name ? 'selected' : ''

        $('#produk_pasok').append(
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
          $('#satuan_pasok').empty()
          $('#satuan_pasok').append(` <option>Pilih Satuan</option>`)
          $.each(response.data, function (i, value) {
            let isSelected = satuanSelect == value.satuan ? 'selected' : ''
            $('#satuan_pasok').append(
              `<option value="` + value.satuan + `" ` + isSelected + `>` + value.satuan + `</option>`
            )
          });
        },
        error: function (xhr, status, error) {
          // Tangkap pesan error jika ada
          alert('Terjadi kesalahan saat mengirim data.');
        }
      });

      $('#kategori_pemasok_pasok').empty()
      $('#kategori_pemasok_pasok').append(` <option>Pilih Kategori Pemasok</option>`)
      $.each(response.data.kategori_pemasok, function (i, value) {
        let isSelected = kategori_pemasokSelect == value.name ? 'selected' : ''

        $('#kategori_pemasok_pasok').append(
          `<option value="` + value.name + `"` + isSelected + `>` + value.name + `</option>`
        )
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

function lihat_pasok_lng(id) {
  // $('.editPasok').click(function () {
  //     alert('test');
  //     let id = $(this).attr('data-id')
  // Kirim data melalui Ajax
  $.ajax({
    url: '/get-pasok-lng/' + id,
    method: 'GET',
    data: {
      id: id
    },
    success: function (response) {
      // Tangkap pesan dari server dan tampilkan ke user
      $('#form_pasok').attr('action', '/update_pasok_lng/' + response.data.find.id)
      $('#lihat_bulan_pasok').val(response.data.find.bulan)
      $('#lihat_produk_pasok').val(response.data.find.produk)
      $('#lihat_satuan_pasok').val(response.data.find.satuan)
      $('#lihat_nama_pemasok_pasok').val(response.data.find.nama_pemasok)
      $('#lihat_kategori_pemasok_pasok').val(response.data.find.kategori_pemasok)
      $('#lihat_volume_pasok').val(response.data.find.volume)
      $('#lihat_satuan_pasok').val(response.data.find.satuan)
      $('#lihat_harga_gas_pasok').val(response.data.find.harga_gas)


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

$('#produk_pasok').change(function () {
  let elemen = $(this).find('option:selected')
  let value = elemen.val()

  $.ajax({
    url: '/get-satuan/' + value,
    method: 'GET',
    data: {},
    success: function (response) {
      // console.log(response);
      // Loop melalui data dan tambahkan opsi ke dalam select
      $('.satuan').empty()
      $('.satuan').append(` <option>Pilih Satuan</option>`)
      $.each(response.data, function (i, value) {
        $('.satuan').append(
          `<option value="` + value.satuan + `">` + value.satuan + `</option>`
        )
      });
    },
    error: function (xhr, status, error) {
      // Tangkap pesan error jika ada
      alert('Terjadi kesalahan saat mengirim data.');
    }
  });
  // alert(value)
})

function editPasokanLPG(id) {
  // $('.editPenjualan').click(function () {
  //     let id = $(this).attr('data-id')
  // Kirim data melalui Ajax
  $.ajax({
    // url: '/get-penjualan-lpg/' + id,
    url: '/getPasokanLPG/' + id,
    method: 'GET',
    data: {
      id: id
    },
    success: function (response) {
      // Tangkap pesan dari server dan tampilkan ke user
      let bulanx = response.data.find.bulan.substring(0, 7)

      $('#form_pasokan').attr('action', '/update_pasokanLPG/' + response.data.find.id)
      // $('#bulan_pasokan').val(response.data.find.bulan)    
      $('#bulan_pasokan').val(bulanx)    
      $('#nama_pemasok').val(response.data.find.nama_pemasok)
      $('#kategori_pemasok').val(response.data.find.kategori_pemasok)
      $('#volume_pasokan').val(response.data.find.volume)
      $('#satuan_pasokan').val(response.data.find.satuan)

      // Contoh: Lakukan tindakan selanjutnya setelah data berhasil dikirim
      // window.location.href = '/success-page';

    },
    error: function (xhr, status, error) {
      // Tangkap pesan error jika ada
      alert('Terjadi kesalahan saat mengirim data ID Penjualan.');
    }
  });
  //   })
}

function lihatPasokanLPG(id) {
  // $('.editPenjualan').click(function () {
  //     let id = $(this).attr('data-id')
  // Kirim data melalui Ajax
  $.ajax({
    // url: '/get-penjualan-lpg/' + id,
    url: '/getPasokanLPG/' + id,
    method: 'GET',
    data: {
      id: id
    },
    success: function (response) {
      // Tangkap pesan dari server dan tampilkan ke user
      let bulanx = response.data.find.bulan.substring(0, 7)

      $('#lihat_bulan_pasokan').val(bulanx)    
      $('#lihat_nama_pemasok').val(response.data.find.nama_pemasok)
      $('#lihat_kategori_pemasok').val(response.data.find.kategori_pemasok)
      $('#lihat_volume_pasokan').val(response.data.find.volume)
      $('#lihat_satuan_pasokan').val(response.data.find.satuan)
    },
    error: function (xhr, status, error) {
      // Tangkap pesan error jika ada
      alert('Terjadi kesalahan saat mengirim data ID Pasokan.');
    }
  });
  //   })
}