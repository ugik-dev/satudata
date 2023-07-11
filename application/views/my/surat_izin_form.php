<div class="container-fluid">
    <div class="card">
        <form id="user_form" onsubmit="return false;" type="multipart" autocomplete="off">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_title">
                    Form Cuti
                </h5>
                <!-- <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" name="id_skp" value="<?= !empty($dataContent['return_data']['id_skp']) ? $dataContent['return_data']['id_skp'] : '' ?>">
                    <div class="hr-line-dashed"></div>
                    <div class="col-lg-8">
                        <div class="col-form-label">Tanggal Izin</div>
                        <div class="row">
                            <div class="col">

                                <input name="periode_start" type="date" id="periode_start" class="form-control" value="<?= !empty($dataContent['return_data']['periode_start']) ? $dataContent['return_data']['periode_start'] : date("Y-m-d") ?>">
                            </div>
                            <div class="col-1 d-flex align-items-center">
                                s.d.
                            </div>
                            <div class="col">
                                <input name="periode_end" type="date" id="periode_end" class="form-control" value="<?= !empty($dataContent['return_data']['periode_end']) ? $dataContent['return_data']['periode_end'] : date("Y-m-d") ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="col-form-label">Lama Izin (hari)</div>
                        <div class="row">
                            <div class="col">
                                <input type="number" name="lama_izin" id="lama_izin" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-12">

                                <div class="col-form-label">Jenis Perizinan</div>
                                <select name="jenis_izin" id="jenis_izin" class="form-control" required="required">
                                    <option value="">Pilih Jenis Izin</option>
                                    <?php
                                    foreach ($dataContent['jenis_izin'] as $ji) {
                                        echo "<option value='{$ji['id_ref_jen_izin']}'>{$ji['nama_izin']}</option>";
                                    } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-12">

                                <div class="col-form-label">Kategori</div>
                                <select name="kategori" id="kategori" class="form-control" required="required">
                                    <option value="1">Non Urgent</option>
                                    <option value="2">Urgent</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="col-form-label">Pelimpahan Wewenang</div>
                        <select class="select2 col-sm-12" id="id_pengganti" name="id_pengganti">
                            <?php
                            if (!empty($dataContent['laporan']['id_pengganti'])) {
                                echo '<option selected value="' . $dataContent['laporan']['id_pengganti'] . '">' . $dataContent['laporan']['nama_bendahara'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="col-form-label">Alasan</div>
                    <div class="row">
                        <div class="col">
                            <textarea type="text" name="alasan" id="alasan" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="col-form-label">Alamat Selama Menjalankan Izin / Cuti</div>
                    <div class="row">
                        <div class="col">
                            <textarea type="text" name="alamat_izin" id="alamat_izin" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="col-form-label">Dokumen Lampiran</div>
                    <div class="row">
                        <div class="col">
                            <!-- <input type="file" class="form-control" id="file_foto" name="file_foto"> -->
                            <input type="file" name="file_lampiran" id="file_foto" class="form-control">
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
        // $('#sidebar_wrapper_func').addClass('close_icon');
        $('#sidebar_surat_izin').addClass('active_c');

        var UserModal = {
            'form': $('#user_form'),
            'addBtn': $('#add_btn'),
            'saveEditBtn': $('#save_edit_btn'),
            'add_ku': $('#add_ku'),
            'add_kt': $('#add_kt'),
            'periode_start': $('#periode_start'),
            'periode_end': $('#periode_end'),
            'jenis_izin': $('#jenis_izin'),
            'c_n': $('#c_n'),
            'c_n1': $('#c_n1'),
            'c_n2': $('#c_n2'),
            'alamat_izin': $('#alamat_izin'),
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
                Swal.fire({
                    title: 'Loading ..',
                    html: 'Harap Tunggu !!',
                    allowOutsideClick: false,
                    buttons: false,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                })
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
                            location.href = "<?= base_url('surat-izin') ?>";
                        });
                    }
                });
            });
        });


    });
</script>