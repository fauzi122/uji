function edit_ekpor(id,  produk, negara_tujuan) {
    // $('.editPenjualan').click(function () {
    //     let id = $(this).attr('data-id')
    // Kirim data melalui Ajax
    $.ajax({
      url: '/get-export/' + id,
      method: 'GET',
      data: {
        id: id
      },
      success: function (response) {
        // Tangkap pesan dari server dan tampilkan ke user
        $('#form_ekpor').attr('action', '/update_export/' + response.data.find.id)
        $('#id_ekpor').val(response.data.find.id)
        $('#bulan_ekpor').val(response.data.find.bulan_peb)
        $('#produk_ekpor').val(response.data.find.produk)
        $('#hs_code_ekpor').val(response.data.find.hs_code)
        $('#volume_peb_ekpor').val(response.data.find.volume_peb)
        $('#satuan_ekpor').val(response.data.find.satuan)
        $('#invoice_amount_nilai_pabean_ekpor').val(response.data.find.invoice_amount_nilai_pabean)
        $('#invoice_amount_final_ekpor').val(response.data.find.invoice_amount_final)
        $('#nama_konsumen_ekpor').val(response.data.find.nama_konsumen)
        $('#pelabuhan_muat_ekpor').val(response.data.find.pelabuhan_muat)
        $('#negara_tujuan_ekpor').val(response.data.find.negara_tujuan)
        $('#vessel_name_ekpor').val(response.data.find.vessel_name)
        $('#tanggal_bl_ekpor').val(response.data.find.tanggal_bl)
        $('#bl_no_ekpor').val(response.data.find.bl_no)
        $('#no_pendaf_peb_ekpor').val(response.data.find.no_pendaf_peb)
        $('#tanggal_pendaf_peb_ekpor').val(response.data.find.tanggal_pendaf_peb)
        $('#incoterms_ekpor').val(response.data.find.incoterms)

        let produkSelect = response.data.find.produk
        let satuanSelect = response.data.find.satuan
        let negaraSelect = response.data.find.negara_tujuan

        $('#produk_ekpor').empty()
        $('#produk_ekpor').append(` <option>Pilih Produk</option>`)
        $.each(response.data.produk, function (i, value) {
            let isSelected = produkSelect == value.name ? 'selected' : ''

            $('#produk_ekpor').append(
            `<option value="` + value.name + `"` + isSelected + `>` + value.name + `</option>`
            )
        });

        // alert(response.data.find.provinsi)

        $.ajax({
            url: '/get-satuan/' + produk,
            method: 'GET',
            data: {
            },
            success: function (response) {
            // console.log(response);
            // Loop melalui data dan tambahkan opsi ke dalam select
            $('#satuan_ekpor').empty()
            $('#satuan_ekpor').append(` <option>Pilih Satuan</option>`)
            $.each(response.data, function (i, value) {
                let isSelected = satuanSelect == value.satuan ? 'selected' : ''
                $('#satuan_ekpor').append(
                `<option value="` + value.satuan + `" `+ isSelected +`>` + value.satuan + `</option>`
                )
            });
            },
            error: function (xhr, status, error) {
            // Tangkap pesan error jika ada
            alert('Terjadi kesalahan saat mengirim data.');
            }
        });


        $('#negara_tujuan_ekpor').empty()
        $('#negara_tujuan_ekpor').append(` <option>Pilih Negara Tujuan</option>`)
        $.each(response.data.negara_tujuan, function (i, value) {
            let isSelected = negaraSelect == value.nm_negara ? 'selected' : ''

            $('#negara_tujuan_ekpor').append(
            `<option value="` + value.nm_negara + `"` + isSelected + `>` + value.nm_negara + `</option>`
            )
        });
  
      
  
        // Contoh: Lakukan tindakan selanjutnya setelah data berhasil dikirim
        // window.location.href = '/success-page';
  
      },
      error: function (xhr, status, error) {
        // Tangkap pesan error jika ada
        alert('Terjadi kesalahan saat mengirim data to.');
      }
    });
    //   })
}


function lihat_ekspor(id,  produk) {
    // $('.editPenjualan').click(function () {
    //     let id = $(this).attr('data-id')
    // Kirim data melalui Ajax
    $.ajax({
      url: '/get-export/' + id,
      method: 'GET',
      data: {
        id: id
      },
      success: function (response) {
        // Tangkap pesan dari server dan tampilkan ke user
        $('#form_ekpor').attr('action', '/update_export/' + response.data.find.id)
        $('#id_ekpor_lihat').val(response.data.find.id)
        $('#bulan_ekpor_lihat').val(response.data.find.bulan_peb)
        $('#produk_ekpor_lihat').val(response.data.find.produk)
        $('#hs_code_ekpor_lihat').val(response.data.find.hs_code)
        $('#volume_peb_ekpor_lihat').val(response.data.find.volume_peb)
        $('#satuan_ekpor_lihat').val(response.data.find.satuan)
        $('#invoice_amount_nilai_pabean_ekpor_lihat').val(response.data.find.invoice_amount_nilai_pabean)
        $('#invoice_amount_final_ekpor_lihat').val(response.data.find.invoice_amount_final)
        $('#nama_konsumen_ekpor_lihat').val(response.data.find.nama_konsumen)
        $('#pelabuhan_muat_ekpor_lihat').val(response.data.find.pelabuhan_muat)
        $('#negara_tujuan_ekpor_lihat').val(response.data.find.negara_tujuan)
        $('#vessel_name_ekpor_lihat').val(response.data.find.vessel_name)
        $('#tanggal_bl_ekpor_lihat').val(response.data.find.tanggal_bl)
        $('#bl_no_ekpor_lihat').val(response.data.find.bl_no)
        $('#no_pendaf_peb_ekpor_lihat').val(response.data.find.no_pendaf_peb)
        $('#tanggal_pendaf_peb_ekpor_lihat').val(response.data.find.tanggal_pendaf_peb)
        $('#incoterms_ekpor_lihat').val(response.data.find.incoterms)

        let produkSelect = response.data.find.produk
        let satuanSelect = response.data.find.satuan

        $('#produk_ekpor_lihat').empty()
        $('#produk_ekpor_lihat').append(` <option>Pilih Produk</option>`)
        $.each(response.data.produk, function (i, value) {
            let isSelected = produkSelect == value.name ? 'selected' : ''

            $('#produk_ekpor_lihat').append(
            `<option value="` + value.name + `"` + isSelected + `>` + value.name + `</option>`
            )
        });

        // alert(response.data.find.provinsi)

        $.ajax({
            url: '/get-satuan/' + produk,
            method: 'GET',
            data: {
            },
            success: function (response) {
            // console.log(response);
            // Loop melalui data dan tambahkan opsi ke dalam select
            $('#satuan_ekpor_lihat').empty()
            $('#satuan_ekpor_lihat').append(` <option>Pilih Satuan</option>`)
            $.each(response.data, function (i, value) {
                let isSelected = satuanSelect == value.satuan ? 'selected' : ''
                $('#satuan_ekpor_lihat').append(
                `<option value="` + value.satuan + `" `+ isSelected +`>` + value.satuan + `</option>`
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
        alert('Terjadi kesalahan saat mengirim data to.');
      }
    });
    //   })
}


function edit_impor(id,  produk , negara_tujuan) {
    // $('.editPenjualan').click(function () {
    //     let id = $(this).attr('data-id')
    // Kirim data melalui Ajax
    $.ajax({
      url: '/get-import/' + id,
      method: 'GET',
      data: {
        id: id
      },
      success: function (response) {
        // Tangkap pesan dari server dan tampilkan ke user
        $('#form_impor').attr('action', '/update_import/' + response.data.find.id)
        $('#id_impor').val(response.data.find.id)
        $('#bulan_impor').val(response.data.find.bulan_pib)
        $('#produk_impor').val(response.data.find.produk)
        $('#hs_code_impor').val(response.data.find.hs_code)
        $('#volume_pib_impor').val(response.data.find.volume_pib)
        $('#satuan_impor').val(response.data.find.satuan)
        $('#invoice_amount_nilai_pabean_impor').val(response.data.find.invoice_amount_nilai_pabean)
        $('#invoice_amount_final_impor').val(response.data.find.invoice_amount_final)
        $('#nama_supplier_impor').val(response.data.find.nama_supplier)
        $('#negara_asal_impor').val(response.data.find.negara_asal)
        $('#pelabuhan_muat_impor').val(response.data.find.pelabuhan_muat)
        $('#pelabuhan_bongkar_impor').val(response.data.find.pelabuhan_bongkar)
        $('#vessel_name_impor').val(response.data.find.vessel_name)
        $('#tanggal_bl_impor').val(response.data.find.tanggal_bl)
        $('#bl_no_impor').val(response.data.find.bl_no)
        $('#no_pendaf_pib_impor').val(response.data.find.no_pendaf_pib)
        $('#tanggal_pendaf_pib_impor').val(response.data.find.tanggal_pendaf_pib)
        $('#incoterms_impor').val(response.data.find.incoterms)

        let produkSelect = response.data.find.produk
        let satuanSelect = response.data.find.satuan
        let negaraSelect = response.data.find.negara_asal

        $('#produk_impor').empty()
        $('#produk_impor').append(` <option>Pilih Produk</option>`)
        $.each(response.data.produk, function (i, value) {
            let isSelected = produkSelect == value.name ? 'selected' : ''

            $('#produk_impor').append(
            `<option value="` + value.name + `"` + isSelected + `>` + value.name + `</option>`
            )
        });

        // alert(response.data.find.provinsi)

        $.ajax({
            url: '/get-satuan/' + produk,
            method: 'GET',
            data: {
            },
            success: function (response) {
            // console.log(response);
            // Loop melalui data dan tambahkan opsi ke dalam select
            $('#satuan_impor').empty()
            $('#satuan_impor').append(` <option>Pilih Satuan</option>`)
            $.each(response.data, function (i, value) {
                let isSelected = satuanSelect == value.satuan ? 'selected' : ''
                $('#satuan_impor').append(
                `<option value="` + value.satuan + `" `+ isSelected +`>` + value.satuan + `</option>`
                )
            });
            },
            error: function (xhr, status, error) {
            // Tangkap pesan error jika ada
            alert('Terjadi kesalahan saat mengirim data.');
            }
        });

        $('#negara_asal_impor').empty()
        $('#negara_asal_impor').append(` <option>Pilih Negara Asal</option>`)
        $.each(response.data.negara_asal, function (i, value) {
            let isSelected = negaraSelect == value.nm_negara ? 'selected' : ''

            $('#negara_asal_impor').append(
            `<option value="` + value.nm_negara + `"` + isSelected + `>` + value.nm_negara + `</option>`
            )
        });
  
      
  
        // Contoh: Lakukan tindakan selanjutnya setelah data berhasil dikirim
        // window.location.href = '/success-page';
  
      },
      error: function (xhr, status, error) {
        // Tangkap pesan error jika ada
        alert('Terjadi kesalahan saat mengirim data to.');
      }
    });
    //   })
}


function lihat_import(id,  produk) {
    // $('.editPenjualan').click(function () {
    //     let id = $(this).attr('data-id')
    // Kirim data melalui Ajax
    $.ajax({
      url: '/get-import/' + id,
      method: 'GET',
      data: {
        id: id
      },
      success: function (response) {
        // Tangkap pesan dari server dan tampilkan ke user
        $('#form_impor_lihat').attr('action', '/update_impor_lihat/' + response.data.find.id)
        $('#id_impor_lihat').val(response.data.find.id)
        $('#bulan_impor_lihat').val(response.data.find.bulan_pib)
        $('#produk_impor_lihat').val(response.data.find.produk)
        $('#hs_code_impor_lihat').val(response.data.find.hs_code)
        $('#volume_pib_impor_lihat').val(response.data.find.volume_pib)
        $('#satuan_impor_lihat').val(response.data.find.satuan)
        $('#invoice_amount_nilai_pabean_impor_lihat').val(response.data.find.invoice_amount_nilai_pabean)
        $('#invoice_amount_final_impor_lihat').val(response.data.find.invoice_amount_final)
        $('#nama_supplier_impor_lihat').val(response.data.find.nama_supplier)
        $('#negara_asal_impor_lihat').val(response.data.find.negara_asal)
        $('#pelabuhan_muat_impor_lihat').val(response.data.find.pelabuhan_muat)
        $('#pelabuhan_bongkar_impor_lihat').val(response.data.find.pelabuhan_bongkar)
        $('#vessel_name_impor_lihat').val(response.data.find.vessel_name)
        $('#tanggal_bl_impor_lihat').val(response.data.find.tanggal_bl)
        $('#bl_no_impor_lihat').val(response.data.find.bl_no)
        $('#no_pendaf_pib_impor_lihat').val(response.data.find.no_pendaf_pib)
        $('#tanggal_pendaf_pib_impor_lihat').val(response.data.find.tanggal_pendaf_pib)
        $('#incoterms_impor_lihat').val(response.data.find.incoterms)

        let produkSelect = response.data.find.produk
        let satuanSelect = response.data.find.satuan

        $('#produk_impor_lihat').empty()
        $('#produk_impor_lihat').append(` <option>Pilih Produk</option>`)
        $.each(response.data.produk, function (i, value) {
            let isSelected = produkSelect == value.name ? 'selected' : ''

            $('#produk_impor_lihat').append(
            `<option value="` + value.name + `"` + isSelected + `>` + value.name + `</option>`
            )
        });

        // alert(response.data.find.provinsi)

        $.ajax({
            url: '/get-satuan/' + produk,
            method: 'GET',
            data: {
            },
            success: function (response) {
            // console.log(response);
            // Loop melalui data dan tambahkan opsi ke dalam select
            $('#satuan_impor_lihat').empty()
            $('#satuan_impor_lihat').append(` <option>Pilih Satuan</option>`)
            $.each(response.data, function (i, value) {
                let isSelected = satuanSelect == value.satuan ? 'selected' : ''
                $('#satuan_impor_lihat').append(
                `<option value="` + value.satuan + `" `+ isSelected +`>` + value.satuan + `</option>`
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
        alert('Terjadi kesalahan saat mengirim data to.');
      }
    });
    //   })
  }

