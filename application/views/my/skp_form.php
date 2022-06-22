<div class="container-fluid">
    <div class="card">
        <form id="user_form" onsubmit="return false;" type="multipart" autocomplete="off">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_title">
                    Form Saran Kerja Pegawai
                </h5>
                <!-- <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>
            <div class="modal-body">
                <div class="row">

                    <input type="hidden" name="id_skp" value="<?= !empty($dataContent['return_data']['id_skp']) ? $dataContent['return_data']['id_skp'] : '' ?>">
                    <div class="hr-line-dashed"></div>
                    <div class="col-lg-6">
                        <div class="col-form-label">Periode Penilaian</div>
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
                    <div class="col-lg-3">
                        <div class="col-form-label">Tgl Pengajuan</div>
                        <div class="row">
                            <div class="col">
                                <input name="tgl_pengajuan" type="date" id="tgl_pengajuan" class="form-control" value="<?= !empty($dataContent['return_data']['tgl_pengajuan']) ? $dataContent['return_data']['tgl_pengajuan'] : date("Y-m-d") ?>">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="col-form-label">Penilai</div>
                        <select class="select2 col-sm-12" id="id_penilai" name="id_penilai">
                            <?php
                            if (!empty($dataContent['return_data']['id_penilai'])) {
                                echo '<option selected value="' . $dataContent['return_data']['id_penilai'] . '">' . $dataContent['return_data']['nama_penilai'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <br>
                <!-- <div class="card-body"> -->
                <ul class="nav nav-dark" id="pills-darktab" role="tablist">
                    <li class="nav-item"><a class="nav-link active" id="pills-darkhome-tab" data-bs-toggle="pill" href="#pills-darkhome" role="tab" aria-controls="pills-darkhome" aria-selected="true" data-bs-original-title="" title="">Kegiatan Utama</a></li>
                    <li class="nav-item"><a class="nav-link" id="pills-darkprofile-tab" data-bs-toggle="pill" href="#pills-darkprofile" role="tab" aria-controls="pills-darkprofile" aria-selected="false" data-bs-original-title="" title="">Kegiatan Tambahan</a></li>
                </ul>
                <div class="tab-content" id="pills-darktabContent">
                    <div class="tab-pane fade show active" id="pills-darkhome" role="tabpanel" aria-labelledby="pills-darkhome-tab">
                        <div class="col-lg-12" id="layout_ku"> </div>
                        <hr>
                        <a class="btn btn-light my-1" type="" id="add_ku" data-loading-text="Loading..."><strong>Tambah Kegiatan Utama</strong></a>
                    </div>
                    <div class="tab-pane fade" id="pills-darkprofile" role="tabpanel" aria-labelledby="pills-darkprofile-tab">
                        <div class="col-lg-12" id="layout_kt"> </div>
                        <hr>
                        <a class="btn btn-light my-1" type="" id="add_kt" data-loading-text="Loading..."><strong>Tambah Kegiatan Tambahan</strong></a>
                    </div>
                </div>
                <!-- </div> -->


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
        $('#sidebar_skp').addClass('active_c');
        // $('#opmenu_2').show();
        // $('#submenu_6').addClass('active');

        var UserModal = {
            'form': $('#user_form'),
            'addBtn': $('#add_btn'),
            'saveEditBtn': $('#save_edit_btn'),
            // 'add_dasar': $('#add_dasar'),
            'add_ku': $('#add_ku'),
            'add_kt': $('#add_kt'),
            // 'idUser': $('#id_user'),
            'periode_start': $('#periode_start'),
            'periode_end': $('#periode_end'),
            // 'nip': $('#nip'),
            // 'email': $('#email'),
            // 'no_hp': $('#no_hp'),
            // 'status': $('#status'),
            // 'password': $('#password'),
            // 'id_role': $('#id_role'),
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

        last_ku = 1;
        last_kt = 1;
        <?php
        if (!empty($dataContent['return_data']['child'])) {
            foreach ($dataContent['return_data']['child'] as $p) {
                // if ($p['jenis_keg'] == 'KU')
                echo 'addKU("' . $p['jenis_keg'] . '",' . $p['id_skp_child'] . ', ' . (!empty($p['id_skp_atasan']) ?  $p['id_skp_atasan'] : 'null')  . ', "' . $p['kegiatan_atasan'] . '", "' . $p['kegiatan'] . '" , "' . $p['iki_kuantitas'] . '" , "' . $p['min_kuantitas'] . '" , "' . $p['max_kuantitas'] . '" , "' . $p['ket_kuantitas'] . '" , "' . $p['iki_kualitas'] . '" , "' . $p['min_kualitas'] . '" , "' . $p['max_kualitas'] . '" , "' . $p['ket_kualitas'] .  '" , "' . $p['iki_waktu'] . '" , "' . $p['min_waktu'] . '" , "' . $p['max_waktu'] . '" , "' . $p['ket_waktu'] . '");  ';
                // else
                //     echo 'addKT(' . $p['id_skp_child'] . ', ' . (!empty($p['id_skp_atasan']) ?  $p['id_skp_atasan'] : 'null')  . ', "' . $p['kegiatan_atasan'] . '", "' . $p['kegiatan'] . '" , "' . $p['iki_kuantitas'] . '" , "' . $p['min_kuantitas'] . '" , "' . $p['max_kuantitas'] . '" , "' . $p['ket_kuantitas'] . '" , "' . $p['iki_kualitas'] . '" , "' . $p['min_kualitas'] . '" , "' . $p['max_kualitas'] . '" , "' . $p['ket_kualitas'] .  '" , "' . $p['iki_waktu'] . '" , "' . $p['min_waktu'] . '" , "' . $p['max_waktu'] . '" , "' . $p['ket_waktu'] . '");  ';
            }
        } else {
            echo 'addKU("KU");';
        }
        ?>

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
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });

        function addKU(jk, id = '', id_skp_atasan = null, skp_ats = "", keg = '', iki_1 = '', min_1 = '-', max_1 = '1', ket_1 = '', iki_2 = '', min_2 = '-', max_2 = '1', ket_2 = '', iki_3 = '', min_3 = '-', max_3 = '1', ket_3 = '', ) {
            if (id_skp_atasan != null) {
                opt = `<option value="${id_skp_atasan}">${skp_ats}</option>`
            } else {
                opt = `<option value="null">-</option>`
            }
            htmlTujuan = ` <hr>
            <div class="row">
            <div class="col-form-label"><b>No ${jk== 'KU' ? last_ku: last_kt}</b></div>
            <div class="col-lg-6">
            <div  class="col-form-label">Rencana Kinerja Atasan</div>
            <input  class="" id="jenis_keg[]" name="jenis_keg[]" type="hidden" value="${jk}">
            <input  class="" id="id_skp_child[]" name="id_skp_child[]" type="hidden" value="${id}">
              <select class="form-control select2 id_skp_atasan" id="id_skp_atasan[]" name="id_skp_atasan[]" required>${opt}</select>
            </div>
               <div class="col-lg-6">
            <div class="col-form-label">Rencana Kinerja</div>
            <textarea class="form-control" id="kegiatan[]" name="kegiatan[]" type="text" rows="3" placeholder="ex. Melakukan Laporan"/>${keg}</textarea>
            </div>
            <div class="col-lg-12 m-2">
                <table class="table table-bordered ">
                    <tr class="align-middle text-center">
                        <th rowspan="2" scope="col">Aspek</th>
                        <th rowspan="2">IKI</th>
                        <th colspan="2">Target</th>
                         <th rowspan="2">Keterangan</th>
                    </tr>
                      <tr class="align-middle text-center">
                        <th style="width : 130px">Min</th>
                        <th style="width : 130px">Max</th>
                    </tr>
                    <tr class="">
                        <td>Kuantitas</td>
                        <td>
                            <input class="form-control" id="iki_kuantitas[]" name="iki_kuantitas[]" type="text" value="${iki_1}" >
                        </td>
                         <td>
                            <input class="form-control" id="min_kuantitas[]" name="min_kuantitas[]" type="text" value="${min_1}" >
                        </td>
                        <td>
                            <input class="form-control" id="max_kuantitas[]" name="max_kuantitas[]" type="number" value="${max_1}" >
                        </td>
                        <td>
                            <input class="form-control" id="ket_kuantitas[]" name="ket_kuantitas[]" type="text" value="${ket_1}" >
                        </td>
                    </tr>
                    <tr class="">
                        <td>Kualitas</td>
                        <td>
                            <input class="form-control" id="iki_kualitas[]" name="iki_kualitas[]" type="text" value="${iki_2}" >
                        </td>
                         <td>
                            <input class="form-control" id="min_kualitas[]" name="min_kualitas[]" type="text" value="${min_2}" >
                        </td>
                        <td>
                            <input class="form-control" id="max_kualitas[]" name="max_kualitas[]" type="number" value="${max_2}" >
                        </td>
                        <td>
                            <input class="form-control" id="ket_kualitas[]" name="ket_kualitas[]" type="text" value="${ket_2}" >
                        </td>
                    </tr>
                    <tr class="">
                        <td>Waktu</td>
                        <td>
                            <input class="form-control" id="iki_waktu[]" name="iki_waktu[]" type="text" value="${iki_3}" >
                        </td>
                         <td>
                            <input class="form-control" id="min_waktu[]" name="min_waktu[]" type="text" value="${min_3}" >
                        </td>
                        <td>
                            <input class="form-control" id="max_waktu[]" name="max_waktu[]" type="number" value="${max_3}" >
                        </td>
                        <td>
                            <input class="form-control" id="ket_waktu[]" name="ket_waktu[]" type="text" value="${ket_3}" >
                        </td>
                    </tr>
                </table>
            </div>
           `;
            if (jk == 'KU') {

                $('#layout_ku').append(htmlTujuan)
                last_ku++;
            } else {

                $('#layout_kt').append(htmlTujuan)
                last_kt++;

            }
            render_search_skp()
        }

        UserModal.add_ku.on('click', (ev) => {
            addKU('KU');
        })
        UserModal.add_kt.on('click', (ev) => {
            addKU('KT');
        })


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

                            location.href = "<?= base_url('skp') ?>";
                        });
                    }
                });
            });
        });

        $("#id_penilai").select2({
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

        function render_search_skp() {

            $(".id_skp_atasan").select2({
                ajax: {
                    url: '<?= base_url() ?>Search/skp_atasan',
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            searchTerm: params.term,
                            // asd: '2'
                            periode_start: UserModal.periode_start.val(),
                            periode_end: UserModal.periode_end.val()
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

        }

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