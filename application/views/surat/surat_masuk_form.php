<div class="container-fluid">
    <div class="card">
        <form id="user_form" onsubmit="return false;" type="multipart" autocomplete="off">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_title">
                    Form Surat Masuk
                </h5>
                <!-- <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" name="id_surat_masuk" value="<?= !empty($dataContent['return_data']['id_surat_masuk']) ? $dataContent['return_data']['id_surat_masuk'] : '' ?>">
                    <div class="hr-line-dashed"></div>
                    <div class="col-lg-4">
                        <div class="col-form-label">Tanggal Izin</div>
                        <div class="row">
                            <div class="col">
                                <input name="tanggal_surat" type="date" id="tanggal_surat" class="form-control" value="<?= !empty($dataContent['return_data']['tanggal_surat']) ? $dataContent['return_data']['tanggal_surat'] : date("Y-m-d") ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="col-form-label">Nomor Surat</div>
                        <div class="row">
                            <div class="col">
                                <input type="text" name="nomor_surat" id="nomor_surat" class="form-control" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="current_dispo">Disposisikan Kepada</label>
                        <select class="select2 col-sm-12" id="current_dispo" name="current_dispo"></select>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="col-form-label">Dari</div>
                        <div class="row">
                            <div class="col">
                                <textarea type="text" name="dari" id="dari" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="col-form-label">Tujuan / Kepada </div>
                        <div class="row">
                            <div class="col">
                                <textarea type="text" name="kepada" id="kepada" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="col-form-label">File Surat (pdf)</div>
                    <div class="row">
                        <div class="col">
                            <input type="file" name="file_lampiran" id="file_lampiran" accept="application/pdf" class=" form-control">
                        </div>
                    </div>
                </div>
                <br>


                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit" id="save_edit_btn" data-loading-text="Loading..."><strong>Simpan</strong></button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#menu_8').addClass('active');
        $('#opmenu_8').show();
        $('#submenu_18').addClass('active');

        var UserModal = {
            'form': $('#user_form'),
            'addBtn': $('#add_btn'),
            'saveEditBtn': $('#save_edit_btn'),
            'add_ku': $('#add_ku'),
            'add_kt': $('#add_kt'),
            'tanggal_surat': $('#tanggal_surat'),
            'periode_end': $('#periode_end'),
            'jenis_izin': $('#jenis_izin'),
            'c_n': $('#c_n'),
            'c_n1': $('#c_n1'),
            'c_n2': $('#c_n2'),
            'kepada': $('#kepada'),
        }

        var swalSaveConfigure = {
            title: "Konfirmasi simpan",
            text: "Yakin akan menyimpan data ini?",
            type: "info",
            showCancelButton: true,
            confirmButtonColor: "#18a689",
            confirmButtonText: "Ya, Simpan!",
        };

        var swalDeleteConfigure = {
            title: "Konfirmasi hapus",
            text: "Yakin akan menghapus data ini?",
            type: "warning",
            showCancelButton: true,
        };

        $.when().then((e) => {}).fail((e) => {
            // console.log(e)
        });

        // UserModal.jenis_izin.on('change', function() {
        //     if (UserModal.jenis_izin.val() == '11') {
        //         $('.layout_c_tahunan').show();
        //         UserModal.c_n.prop('disabled', false);
        //         UserModal.c_n1.prop('disabled', false);
        //         UserModal.c_n2.prop('disabled', false);
        //     } else {
        //         $('.layout_c_tahunan').hide();
        //         UserModal.c_n.prop('disabled', true);
        //         UserModal.c_n1.prop('disabled', true);
        //         UserModal.c_n2.prop('disabled', true);

        //     }
        // })
        UserModal.jenis_izin.trigger('change');
        $("#id_pengganti").select2({
            ajax: {
                url: '<?= base_url() ?>Search/pegawai',
                type: "get",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        'id_satuan': <?= $this->session->userdata('id_satuan') ?>,
                        'bagian_show': 1,
                        searchTerm: params.term // search term
                    };
                },
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });

        $("#current_dispo").select2({
            ajax: {
                url: '<?= base_url() ?>Search/Pegawai',
                type: "get",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term // search term
                    };
                },
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });

        UserModal.form.submit(function(event) {
            event.preventDefault();
            var url = "<?= base_url() . $dataContent['form_url'] ?>";
            Swal.fire({
                title: "Konfirmasi",
                text: "Data akan disimpan!",
                icon: "warning",
                allowOutsideClick: false,
                showCancelButton: true,
                buttons: {
                    cancel: 'Batal !!',
                    catch: {
                        text: "Ya, Saya Simpan !!",
                        value: true,
                    },
                },
            }).then((result) => {
                if (!result.isConfirmed) {
                    return;
                }
                // Swal.fire({
                //     title: 'Loading ..',
                //     html: 'Harap Tunggu !!',
                //     allowOutsideClick: false,
                //     buttons: false,
                //     didOpen: () => {
                //         Swal.showLoading()
                //     }
                // })
                $.ajax({
                    url: url,
                    'type': 'POST',
                    data: new FormData(UserModal.form[0]),
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        // buttonIdle(button);
                        var json = JSON.parse(data);
                        if (json['error']) {
                            Swal.fire("Simpan Gagal", json['message'], "error");
                            return;
                        }
                        Swal.close();
                        Swal.fire({
                            title: "Berhasil !!",
                            text: "Surat Permohonan berhasil diajukan",
                            icon: "success",
                            allowOutsideClick: true,
                            buttons: {
                                catch: {
                                    text: "OK",
                                    value: true,
                                },
                            },
                        }).then((result) => {

                            // location.href = "<?= base_url('Surat/masuk') ?>";
                        });
                    }
                });
            });
        });


    });
</script>