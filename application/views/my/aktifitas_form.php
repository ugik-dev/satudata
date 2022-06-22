<div class="container-fluid">
    <div class="card">
        <form id="user_form" onsubmit="return false;" type="multipart" autocomplete="off">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_title">
                    Form Aktifitas Harian
                </h5>
                <!-- <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>
            <div class="modal-body">
                <div class="row">

                    <input type="hidden" name="id_aktifitas" value="<?= !empty($dataContent['return_data']['id_aktifitas']) ? $dataContent['return_data']['id_aktifitas'] : '' ?>">
                    <div class="hr-line-dashed"></div>
                    <div class="col-lg-12">
                        <div class="col-form-label">Tanggal</div>
                        <input name="date" type="date" id="date" class="form-control" value="<?= !empty($dataContent['return_data']['date']) ? $dataContent['return_data']['date'] : date("Y-m-d") ?>">

                    </div>


                </div>
                <div class="col-lg-12" id="layout_aktifitas">

                </div>
                <hr>
                <a class="btn btn-light my-1" type="" id="add_aktifitas" data-loading-text="Loading..."><strong>Tambah Aktifitas</strong></a>


                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit" id="save_edit_btn" data-loading-text="Loading..."><strong>Simpan</strong></button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#sidebar_wrapper_func').addClass('close_icon');

        $('#sidebar_aktifitas').addClass('active_c');

        var UserModal = {
            'form': $('#user_form'),
            'addBtn': $('#add_btn'),
            'saveEditBtn': $('#save_edit_btn'),
            'add_dasar': $('#add_dasar'),
            'add_aktifitas': $('#add_aktifitas'),
            'idUser': $('#id_user'),
            'username': $('#username'),
            'nama': $('#nama'),
            'nip': $('#nip'),
            'email': $('#email'),
            'no_hp': $('#no_hp'),
            'status': $('#status'),
            'password': $('#password'),
            'id_role': $('#id_role'),
            'transport': $('#transport'),
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

        $.when(getAllTransport()).then((e) => {}).fail((e) => {
            // console.log(e)
        });
        last_dasar = 2;

        last_aktifitas = 1;
        <?php
        if (!empty($dataContent['return_data']['child'])) {
            foreach ($dataContent['return_data']['child'] as $p) {
                echo 'addAktifitas(' . $p['id_aktifitas_child'] . ', "' . $p['id_skp_child'] . '" , "' . $p['kegiatan_skp'] . '" , "' . $p['kegiatan_aktifitas'] . '" , "' . $p['vol'] . '" , "' . $p['satuan'] . '");  ';
            }
        } else {
            echo 'addAktifitas();';
        }
        ?> dataResponseSKP = [];

        function render_search_skp() {
            $(".skp_search").select2({
                ajax: {
                    url: '<?= base_url() ?>Search/skp',
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            searchTerm: params.term // search term
                        };
                    },
                    processResults: function(response) {
                        console.log('s');
                        return {
                            results: response
                        };
                    },
                    cache: true
                }
            });
        }

        function addAktifitas(id = '', id_skp = '', skp_keg = '', ka = '', vl = '', st = '') {
            if (id_skp != '') {
                opt = `<option value="${id_skp}" selected>${skp_keg}</option>`
                // } else if (id_skp == null) {
                //     opt = `<option value="non_skp" selected>NON SKP</option>`
            } else {
                opt = `<option value="non_skp" selected>NON SKP</option>`
            }

            // <input class="form-control" id="date_berangkat[]" name="date_berangkat[]" type="date" value="${dj}">
            // <input class="form-control" id="jn_skp[]" name="jn_skp[]" type="text" value="${tj}" placeholder="ex. Input Data SPPD">
            htmlAktifitas = ` <hr>
            <div class="row">
            <div class="col-form-label"><b>Ke ${last_aktifitas}</b></div>
            <div class="col-lg-5">
            <div class="col-form-label">Rencana Kerja / Jenis Kegiatan</div>
            <input class="" id="id_aktifitas_child[]" name="id_aktifitas_child[]" type="hidden" value="${id}">
            <select class="form-control select2 skp_search" id="jn_skp[]" name="jn_skp[]" >${opt} </select>
            </div>
            <div class="col-lg-3">
            <div class="col-form-label">Kegiatan</div>
                <input class="form-control" id="kegiatan_aktifitas[]" name="kegiatan_aktifitas[]" value="${ka}"/>  
            </div>
            <div class="col-lg-1">
            <div class="col-form-label">Vol</div>
            <input class="form-control" id="vol[]" name="vol[]" type="number" value="${vl}" placeholder="ex. Sungailiat">
            </div>
            <div class="col-lg-2">
            <div class="col-form-label">Satuan </div>
            <input class="form-control" id="satuan[]" name="satuan[]" type="text" value="${st}">
            </div>
            </div>`;

            $('#layout_aktifitas').append(htmlAktifitas)
            last_aktifitas++;
            render_search_skp()
        }

        UserModal.add_aktifitas.on('click', (ev) => {
            addAktifitas();
        })

        function getAllTransport() {
            Swal.fire({
                title: 'Loading',
                allowOutsideClick: false,
            });
            Swal.showLoading()
            return $.ajax({
                url: `<?php echo site_url('Search/transport') ?>`,
                'type': 'get',
                data: {},
                success: function(data) {
                    Swal.close();
                    var json = JSON.parse(data);
                    if (json['error']) {
                        return;
                    }
                    dataTransport = json['data'];
                    renderTransport(dataTransport);
                },
                error: function(e) {}
            });
        }

        function renderTransport(data) {
            UserModal.transport.empty();
            UserModal.transport.append($('<option>', {
                value: "",
                text: "--"
            }));
            Object.values(data).forEach((d) => {
                console.log(d)
                UserModal.transport.append($('<option>', {
                    value: d['transport'],
                    text: d['nama_tr'],
                }));
            });

            <?php if (!empty($dataContent['return_data']['transport'])) { ?>
                UserModal.transport.val("<?= $dataContent['return_data']['transport'] ?>");
            <?php } ?>
        }

        UserModal.form.submit(function(event) {
            event.preventDefault();
            var url = "<?= base_url() . $dataContent['form_url'] ?>";

            Swal.fire({
                title: "Apakah anda Yakin?",
                text: "Data Role akan dirubah dan hak aksess user terkait akan berubah juga!",
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
                            text: "Hak Aksess Berhasil Diperbaharui",
                            icon: "success",
                            allowOutsideClick: true,
                            buttons: {
                                catch: {
                                    text: "OK",
                                    value: true,
                                },
                            },
                        }).then((result) => {

                            // location.href = "<?= base_url('aktifitas/detail/') ?>" + json['data'];
                        });
                    }
                });
            });
        });



        $("#id_ppk").select2({
            ajax: {
                url: '<?= base_url() ?>Search/ppk',
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

        $("#id_dasar").select2({
            ajax: {
                url: '<?= base_url() ?>Search/dasar',
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

        $("#id_pegawai").select2({
            ajax: {
                url: '<?= base_url() ?>Search/pegawai',
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

        $("#pengikut").select2({
            ajax: {
                url: '<?= base_url() ?>Search/pegawai',
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
    });
</script>