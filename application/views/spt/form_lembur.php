<div class="container-fluid">
    <div class="card">
        <form id="user_form" onsubmit="return false;" type="multipart" autocomplete="off">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_title">
                    Form Lembur
                </h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" name="id_spt" value="<?= !empty($dataContent['return_data']['id_spt']) ? $dataContent['return_data']['id_spt'] : '' ?>">
                    <input type="hidden" name="sppd" value="2">
                    <input type="hidden" name="jenis" value="3">

                    <label class="col-sm-2 col-form-label" hidden=""><strong>No SPT</strong></label>

                    <div class="col-sm-4" hidden="">
                        <input type="text" class="form-control" name="no_spt" required="" value="<?= !empty($dataContent['return_data']['no_spt']) ? $dataContent['return_data']['no_spt'] : '' ?>" readonly="">
                    </div>
                    <div class="hr-line-dashed"></div>

                    <label class="col-sm-2 col-form-label" hidden=""><strong>Kadinkes*</strong></label>
                    <div class="col-sm-4" hidden="">

                        <input type="text" class="form-control" name="id_kad" value="<?= !empty($dataContent['return_data']['id_kad']) ? $dataContent['return_data']['id_kad'] : '' ?>" required="" readonly="">
                    </div>
                    <div class="hr-line-dashed"></div>

                    <label class="col-sm-2 col-form-label" hidden=""><strong>No SPPD</strong></label>
                    <div class="col-sm-4" hidden="">
                        <input type="text" class="form-control" name="no_sppd" required="" readonly="" value="<?= !empty($dataContent['return_data']['no_sppd']) ? $dataContent['return_data']['no_sppd'] : '' ?>">
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="col-lg-12">
                        <div class="col-form-label">Dasar</div>
                        <select class="select2 col-sm-12" id="id_dasar" name="id_dasar">
                            <?php
                            if (!empty($dataContent['return_data']['id_dasar'])) {
                                echo '<option selected value="' . $dataContent['return_data']['id_dasar'] . '">' . $dataContent['return_data']['nama_dasar'] . '</option>';
                            }
                            ?>
                        </select>
                        <a class="btn btn-light my-1" type="" id="add_dasar" data-loading-text="Loading..."><strong>Tambah Dasar</strong></a>
                        <div class="col-lg-12" id="layout_dasar_tambahan">
                            <?php
                            $last_dasar = 1;
                            if (!empty($dataContent['return_data']['dasar_tambahan'])) {
                                foreach ($dataContent['return_data']['dasar_tambahan'] as $dt) {
                                    $last_dasar++;
                                    echo "<div class='mb-3 row' id='row_dasar_" . $dt['id_dasar_tambahan'] . "'>
                                    <label class='col-sm-1 col-form-label'>" . $last_dasar . " </label>
                                    <div class='col-sm-10'>
                                    <input name='id_dasar_tambahan[]' value='" . $dt['id_dasar_tambahan'] . "' type=''>
                                    <textarea name='dasar_tambahan[]' class='form-control' rows='2'>" . $dt['dasar_tambahan'] . "</textarea>
                                    </div>
                                    <a class='delete_dasar_tambahan_lama col-sm-1 col-form-label' data-id='" . $dt['id_dasar_tambahan'] . "' data-newrow='false' ><i class='fa fa-trash'></i> </a>
                                    </div>";
                                }
                                // echo '<option selected value="' . $dataContent['return_data']['id_dasar'] . '">' . $dataContent['return_data']['nama_dasar'] . '</option>';
                            }
                            ?>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="col-form-label">Maksud Lembur</div>
                        <textarea name="maksud" id="maksud" class="form-control" rows="3"><?= !empty($dataContent['return_data']['maksud']) ? $dataContent['return_data']['maksud'] : '' ?></textarea>
                    </div>


                    <div class="col-lg-6">
                        <div class="col-form-label">Pegawai Pelaksana</div>
                        <select class="select2 col-sm-12" id="id_pegawai" name="id_pegawai">
                            <?php
                            if (!empty($dataContent['return_data']['id_pegawai'])) {
                                echo '<option selected value="' . $dataContent['return_data']['id_pegawai'] . '">' . $dataContent['return_data']['pel_nama'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-lg-6">
                        <div class="col-form-label">Pengikut</div>
                        <select class="col-sm-12" multiple="multiple" name="pengikut[]" id="pengikut">
                            <?php
                            if (!empty($dataContent['return_data']['pengikut'])) {
                                foreach ($dataContent['return_data']['pengikut'] as $p) {
                                    echo '<option selected value="' . $p['id_pegawai'] . '">' . $p['p_nama'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-12" id="layout_tujuan">
                </div>
                <hr>
                <a class="btn btn-light my-1" type="" id="add_tujuan" data-loading-text="Loading..."><strong>Tambah Tempat</strong></a>

                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit" id="save_edit_btn" data-loading-text="Loading..."><strong>Simpan Perubahan</strong></button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#menu_2').addClass('active');
        $('#opmenu_2').show();
        $('#submenu_9').addClass('active');

        var UserModal = {
            'form': $('#user_form'),
            'addBtn': $('#add_btn'),
            'saveEditBtn': $('#save_edit_btn'),
            'add_dasar': $('#add_dasar'),
            'add_tujuan': $('#add_tujuan'),
            'idUser': $('#id_user'),
            'username': $('#username'),
            'nama': $('#nama'),
            'nip': $('#nip'),
            'email': $('#email'),
            'no_hp': $('#no_hp'),
            'status': $('#status'),
            'password': $('#password'),
            'id_role': $('#id_role'),
            // 'transport': $('#transport'),
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
        last_dasar = 2;
        UserModal.add_dasar.on('click', (ev) => {
            // console.log('render')

            htmlDasarTambahan = `<div class="mb-3 row" id='new_row_dasar_${last_dasar}'>
                                <label class="col-sm-1 col-form-label">${last_dasar}. </label>
                                <div class="col-sm-10">
                                    <input type='hidden' name='id_dasar_tambahan[]' value='' type=''>

                                    <textarea name="dasar_tambahan[]" class="form-control" rows="2"></textarea>
                                </div>
                                <a class="delete_dasar_tambahan col-sm-1 col-form-label" data-id='${last_dasar}' data-newrow='true' ><i class="fa fa-trash"></i> </a>
                            </div>`;
            $('#layout_dasar_tambahan').append(htmlDasarTambahan)
            last_dasar++;

            $('.delete_dasar_tambahan').on('click', function(event) {
                event.preventDefault();
                Swal.fire({
                    title: "Hapus Dasar Tambahan?",
                    icon: "warning",
                    allowOutsideClick: false,
                    showCancelButton: true,
                    buttons: {
                        cancel: 'Batal !!',
                        catch: {
                            text: "Ya, Hapus !!",
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
                    var currentData = $(this).data('id');
                    var newrow = $(this).data('newrow');
                    if (!newrow) {

                        $.ajax({
                            url: '<?= base_url('spt/delete_dasar') ?>',
                            'type': 'get',
                            data: {
                                'id_dasar_tambahan': currentData
                            },
                            success: function(data) {
                                var json = JSON.parse(data);
                                if (json['error']) {
                                    Swal.fire("Hapus Gagal", json['message'], "error");
                                    return;
                                }
                                Swal.close();
                                Swal.fire({
                                    title: "Berhasil !!",
                                    text: "Dasar telah dihapus.",
                                    icon: "success",
                                    allowOutsideClick: true,
                                    buttons: {
                                        catch: {
                                            text: "OK",
                                            value: true,
                                        },
                                    },
                                }).then((result) => {
                                    $('#row_dasar_' + currentData).remove()
                                });
                            }
                        });
                    } else {
                        Swal.close();
                        Swal.fire({
                            title: "Berhasil !!",
                            text: "Dasar telah dihapus.",
                            icon: "success",
                            allowOutsideClick: true,
                            buttons: {
                                catch: {
                                    text: "OK",
                                    value: true,
                                },
                            },
                        }).then((result) => {
                            $('#new_row_dasar_' + currentData).remove()
                        });
                    }
                });
            });

        })

        $('.delete_dasar_tambahan_lama').on('click', function(event) {
            event.preventDefault();
            Swal.fire({
                title: "Hapus Dasar Tambahan?",
                text: "Dasar ini sebelumnya sudah disimpan, selanjutkan akan dihapus ?",
                icon: "warning",
                allowOutsideClick: false,
                showCancelButton: true,
                buttons: {
                    cancel: 'Batal !!',
                    catch: {
                        text: "Ya, Hapus !!",
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
                var currentData = $(this).data('id');
                $.ajax({
                    url: '<?= base_url('spt/delete_dasar_tambahan') ?>',
                    'type': 'get',
                    data: {
                        'id_dasar_tambahan': currentData
                    },
                    success: function(data) {
                        var json = JSON.parse(data);
                        if (json['error']) {
                            Swal.fire("Hapus Gagal", json['message'], "error");
                            return;
                        }
                        Swal.close();
                        Swal.fire({
                            title: "Berhasil !!",
                            text: "Dasar telah dihapus.",
                            icon: "success",
                            allowOutsideClick: true,
                            buttons: {
                                catch: {
                                    text: "OK",
                                    value: true,
                                },
                            },
                        }).then((result) => {
                            $('#row_dasar_' + currentData).remove()
                        });
                    }
                });

            });
        });

        last_tujuan = 1;
        <?php
        if (!empty($dataContent['return_data']['tujuan'])) {
            foreach ($dataContent['return_data']['tujuan'] as $p) {
                echo 'addTujuan(' . $p['id_tujuan'] . ', "' . $p['tempat_tujuan'] . '" , "' . $p['date_berangkat'] . '" , "' . $p['dari'] . '" , "' . $p['sampai'] . '");  ';
            }
        } else {
            echo 'addTujuan();';
        }
        ?>

        function addTujuan(id = '', tj = '', dj = '', tk = '', dk = '') {
            htmlTujuan = ` <hr>
            <div class="row">
            <div class="col-lg-5">
            <div class="col-form-label"><b>Ke ${last_tujuan}</b></div>
            <input type="hidden" id="id_tujuan[]" name="id_tujuan[]" type="text" value="${id}">
            <input class="form-control" id="tempat_tujuan[]" name="tempat_tujuan[]" type="text" value="${tj}" placeholder="ex. Puskesmas Bakam">
            </div>
            <div class="col-lg-3">
            <div class="col-form-label">Tanggal </div>
            <input class="form-control" id="date_berangkat[]" name="date_berangkat[]" type="date" value="${dj}">
            </div>
            <div class="col-lg-2">
            <div class="col-form-label">Dari </div>
            <input class="form-control" id="dari[]" name="dari[]" type="time" value="${tk}">
            </div>
            <div class="col-lg-2">
            <div class="col-form-label">Sampai </div>
            <input class="form-control" id="sampai[]" name="sampai[]" type="time" value="${dk}">
            </div>
            </div>`;

            $('#layout_tujuan').append(htmlTujuan)
            last_tujuan++;
        }

        UserModal.add_tujuan.on('click', (ev) => {
            addTujuan();
        })

        // function getAllTransport() {
        //     Swal.fire({
        //         title: 'Loading',
        //         allowOutsideClick: false,
        //     });
        //     Swal.showLoading()
        //     return $.ajax({
        //         url: `<?php echo site_url('Search/transport') ?>`,
        //         'type': 'get',
        //         data: {},
        //         success: function(data) {
        //             Swal.close();
        //             var json = JSON.parse(data);
        //             if (json['error']) {
        //                 return;
        //             }
        //             dataTransport = json['data'];
        //             renderTransport(dataTransport);
        //         },
        //         error: function(e) {}
        //     });
        // }

        // function renderTransport(data) {
        //     UserModal.transport.empty();
        //     UserModal.transport.append($('<option>', {
        //         value: "",
        //         text: "--"
        //     }));
        //     Object.values(data).forEach((d) => {
        //         console.log(d)
        //         UserModal.transport.append($('<option>', {
        //             value: d['transport'],
        //             text: d['nama_tr'],
        //         }));
        //     });

        //     <?php if (!empty($dataContent['return_data']['transport'])) { ?>
        //         UserModal.transport.val("<?= $dataContent['return_data']['transport'] ?>");
        //     <?php } ?>
        // }
        UserModal.form.submit(function(event) {
            event.preventDefault();
            var url = "<?= base_url() . $dataContent['form_url'] ?>";

            Swal.fire({
                title: "Apakah anda Yakin?",
                text: "Data akan disimpan !",
                icon: "warning",
                allowOutsideClick: false,
                showCancelButton: true,
                buttons: {
                    cancel: 'Batal !!',
                    catch: {
                        text: "Ya, Saya Yakin !!",
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
                    // allowOutsideClick: false,
                    buttons: false,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                })
                $.ajax({
                    url: url,
                    'type': 'POST',
                    data: UserModal.form.serialize(),
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
                            text: "",
                            icon: "success",
                            allowOutsideClick: true,
                            buttons: {
                                catch: {
                                    text: "OK",
                                    value: true,
                                },
                            },
                        }).then((result) => {

                            location.href = "<?= base_url('spt/detail/') ?>" + json['data'];
                        });
                    }
                });
            });
        });


        $("#id_dasar").select2({
            minimumInputLength: 6,
            ajax: {
                url: '<?= base_url() ?>Search/dasar',
                type: "get",
                dataType: 'json',
                delay: 1500,
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

        $("#id_pegawai").select2({
            minimumInputLength: 4,
            ajax: {
                url: '<?= base_url() ?>Search/pegawai',
                type: "get",
                dataType: 'json',
                delay: 1500,
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

        $("#pengikut").select2({
            minimumInputLength: 6,
            ajax: {
                url: '<?= base_url() ?>Search/pegawai',
                type: "get",
                dataType: 'json',
                delay: 1500,
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
    });
</script>