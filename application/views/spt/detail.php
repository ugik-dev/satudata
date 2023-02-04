<div class="container-fluid">
    <div class="card">
        <!-- <ul class="nav nav-tabs border-tab" id="top-tab" role="tablist"> -->
        <!-- <ul class="nav nav-tabs" id="icon-tab" role="tablist"> -->
        <ul class="nav nav-tabs nav-primary" id="pills-warningtab" role="tablist">
            <li class="nav-item"><a class="nav-link active" id="top-home-tab" data-bs-toggle="tab" href="#top-home" role="tab" aria-controls="top-home" aria-selected="true"><i class="icofont icofont-ui-note"></i>Home</a></li>
            <li class="nav-item"><a class="nav-link" id="profile-top-tab" data-bs-toggle="tab" href="#top-profile" role="tab" aria-controls="top-profile" aria-selected="false"><i class="icofont icofont-man-in-glasses"></i>Approval</a></li>
            <li class="nav-item"><a class="nav-link" id="contact-top-tab" data-bs-toggle="tab" href="#tap-dokumen" role="tab" aria-controls="tap-dokumen" aria-selected="false"><i class="icofont icofont-file-document"></i>Dokument</a></li>
            <li class="nav-item"><a class="nav-link" id="contact-top-tab" data-bs-toggle="tab" href="#tap-laporan" role="tab" aria-controls="tap-laporan" aria-selected="false"><i class="icofont icofont-notepad"></i>Laporan Perjalanan Dinas</a></li>
        </ul>
        <div class="card-body">
            <div class="tab-content" id="top-tabContent">
                <div class="tab-pane fade show active" id="top-home" role="tabpanel" aria-labelledby="top-home-tab">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- <div class="modal-footer"> -->
                                <?php
                                $cur_user = $this->session->userdata();
                                // echo $dataContent['return_data']['id_bagian'];
                                // var_dump($cur_user);
                                if ($cur_user['id'] == $dataContent['return_data']['user_input'] && $dataContent['return_data']['status'] == 0) {
                                    echo ' <a class="btn btn-info" id="ajukan_btn"><i class="fa fa-check"></i><strong>Ajukan Approv </strong></a>';
                                }

                                // NEW
                                if ($cur_user['level'] == 2 && $dataContent['return_data']['id_bagian_pegawai'] == $cur_user['id_bagian']) {
                                    if ($dataContent['return_data']['status'] == 0) {
                                        echo ' <a class="btn btn-info" id="approv_btn"><i class="fa fa-check"></i><strong>Approv </strong></a>';
                                        echo ' <a class="btn btn-danger" id="deapprov_btn"><i class="fa fa-times"></i><strong>Unapprov </strong></a>';
                                    } else if ($dataContent['return_data']['status'] == 1 || $dataContent['return_data']['id_unapproval'] == $cur_user['id'])
                                        echo ' <a class="btn btn-warning" id="batal_aksi" ><i class="fa fa-undo"></i><strong>Batalkan Tindakan </strong></a>';
                                } else if ($cur_user['level'] == 3 && $dataContent['return_data']['id_bagian_pegawai'] == $cur_user['id_bagian']) {
                                    if ($dataContent['return_data']['status'] == 1) {
                                        echo ' <a class="btn btn-info" id="approv_btn"><i class="fa fa-check"></i><strong>Approv </strong></a>';
                                        echo ' <a class="btn btn-danger" id="deapprov_btn"><i class="fa fa-times"></i><strong>Unapprov </strong></a>';
                                    } else if ($dataContent['return_data']['status'] == 2 || $dataContent['return_data']['id_unapproval'] == $cur_user['id'])
                                        echo ' <a class="btn btn-warning" id="batal_aksi" ><i class="fa fa-undo"></i><strong>Batalkan Tindakan </strong></a>';
                                }
                                ?>


                                <?php
                                ?>
                                <!-- <a class="btn btn-primary" href="<?= base_url('sppd/edit/' . $dataContent['return_data']['id_spt']) ?>"><strong>Edit </strong></a> -->
                                <!-- </div> -->
                            </div>
                            <div class="col-lg-6">
                                <div class="row">

                                    <label class="col-sm-2 col-form-label"><strong>No SPT</strong></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="no_spt" required="" value="<?= !empty($dataContent['return_data']['no_spt']) ? $dataContent['return_data']['no_spt'] : '' ?>" readonly="">
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="hr-line-dashed"></div> -->
                            <div class="col-lg-6">

                                <div class="row">

                                    <label class="col-sm-3 col-form-label"><strong>No SPPD</strong></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="no_sppd" required="" readonly="" value="<?= !empty($dataContent['return_data']['no_sppd']) ? $dataContent['return_data']['no_sppd'] : '' ?>">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <br>
                            <br>
                            <hr>
                            <!-- <div class="hr-line-dashed"></div> -->
                            <div class="col-lg-12">
                                <div class="col-form-label"><strong>Dasar</strong></div>
                                <div class="row">
                                    <div class="col-sm-1">1. </div>
                                    <div class="col-sm-11">

                                        <?php
                                        if (!empty($dataContent['return_data']['id_dasar'])) {
                                            echo $dataContent['return_data']['nama_dasar'];
                                        }
                                        ?>
                                    </div>
                                </div>
                                <?php
                                $last_dasar = 1;
                                if (!empty($dataContent['return_data']['dasar_tambahan'])) {
                                    foreach ($dataContent['return_data']['dasar_tambahan'] as $dt) {
                                        $last_dasar++;
                                        echo '<div class="row">
                                    <div class="col-sm-1">' . $last_dasar . '. </div>
                                    <div class="col-sm-11">' . $dt['dasar_tambahan'] . '</div></div>';
                                    }
                                    // echo '<option selected value="' . $dataContent['return_data']['id_dasar'] . '">' . $dataContent['return_data']['nama_dasar'] . '</option>';
                                }
                                ?>
                                <hr>
                            </div>

                            <div class="col-lg-12">
                                <div class="col-form-label"><strong> Maksud</strong></div>
                                <?= $dataContent['return_data']['maksud'] ?>
                                <hr>
                            </div>
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="col-form-label"><strong>Lama Perjalanan</strong></div>
                                        <?= $dataContent['return_data']['lama_dinas'] ?> hari
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="col-form-label"><strong>Transportasi</strong></div>
                                        <?= $dataContent['return_data']['nama_transport'] ?>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="col-form-label"><strong>PPK</strong></div>
                                        <?= $dataContent['return_data']['nama_ppk'] ?>
                                    </div>
                                </div>
                                <hr>
                            </div>
                            <!-- <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-sm-2"><strong>PPK</strong></div>
                                    <div class="col-sm-9">
                                        <?= $dataContent['return_data']['nama_ppk'] ?>
                                    </div>
                                </div>
                                <hr>
                            </div> -->
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-sm-2"><strong>Pegawai</strong></div>
                                    <div class="col-sm-9">
                                        <div class="row">
                                            <div class="col-sm-3">Nama : </div>
                                            <div class="col-sm-9">
                                                <?= $dataContent['return_data']['nama_pegawai'] ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3">NIP : </div>
                                            <div class="col-sm-9">
                                                <?= $dataContent['return_data']['nip_pegawai'] ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3">Jabatan : </div>
                                            <div class="col-sm-9">
                                                <?= $dataContent['return_data']['jabatan_pegawai'] ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3">Pangkat / Golongan : </div>
                                            <div class="col-sm-9">
                                                <?= $dataContent['return_data']['pangkat_gol_pegawai'] ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-sm-2"><strong>Pengikut</strong></div>
                                    <div class="col-sm-12">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <!-- <th></th> -->
                                                    <th>Nama</th>
                                                    <th>NIP</th>
                                                    <th>Jabatan</th>
                                                    <th>Pangkat / Gol</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (!empty($dataContent['return_data']['pengikut'])) {
                                                    foreach ($dataContent['return_data']['pengikut'] as $p) {
                                                ?>
                                                        <tr>
                                                            <td><?= $p['nama_pengikut'] ?></td>
                                                            <td><?= $p['nip_pengikut'] ?></td>
                                                            <td><?= $p['jabatan_pengikut'] ?></td>
                                                            <td><?= $p['pangkat_gol_pengikut'] ?></td>
                                                        </tr>
                                                <?php
                                                    }
                                                } ?>
                                            </tbody>
                                        </table>


                                    </div>
                                    <!-- <hr> -->
                                </div>
                                <hr>
                            </div>



                        </div>
                        <div class="col-lg-12" id="layout_tujuan">
                            <!-- <div class="card"> -->
                            <div class="col-sm-2"><strong>Tujuan</strong></div>

                            <!-- <div class="card-body"> -->
                            <!-- <div class="table-responsive mb-0"> -->
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Tempat Tujuan</th>
                                        <th>Tanggal Berangkat</th>
                                        <th>Temmpat Kembali</th>
                                        <th>Tanggal Kembali</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($dataContent['return_data']['tujuan'])) {
                                        $i = 1;
                                        foreach ($dataContent['return_data']['tujuan'] as $t) { ?>
                                            <tr>
                                                <td><?= to_romawi($i) ?></td>
                                                <td><?= $t['tempat_tujuan'] ?></td>
                                                <td><?= $t['date_berangkat'] ?></td>
                                                <td><?= $t['tempat_kembali'] ?></td>
                                                <td><?= $t['date_kembali'] ?></td>
                                            </tr>
                                    <?php
                                            $i++;
                                        }
                                    } ?>
                                </tbody>
                            </table>
                            <!-- </div> -->
                            <!-- </div> -->
                            <!-- </div> -->
                        </div>
                        <!-- <hr> -->

                    </div>
                </div>
                <div class="tab-pane fade" id="top-profile" role="tabpanel" aria-labelledby="profile-top-tab">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Aksi</th>
                                <th>Nama</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Mengajukan</td>
                                <td><?= $dataContent['return_data']['nama_input'] ?></td>
                                <td><?= $dataContent['return_data']['tgl_pengajuan'] ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="tap-dokumen" role="tabpanel" aria-labelledby="contact-top-tab">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <!-- <th></th> -->
                                            <th>Nama Dokumen</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Surat Perintah Tugas</td>
                                            <td><a href="<?= base_url('spt/print/' . $dataContent['return_data']['id_spt'] . '/1') ?>" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i></a></td>
                                        </tr>
                                        <tr>
                                            <td>Surat Perintah Perjalanan Dinas</td>
                                            <td><a href="<?= base_url('spt/print/' . $dataContent['return_data']['id_spt'] . '/2') ?>" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i></a></td>
                                        </tr>
                                        <tr>
                                            <td>Laporan Perjalanan Dinas</td>
                                            <td><a href="<?= base_url('spt/print/' . $dataContent['return_data']['id_spt'] . '/3') ?>" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i></a></td>
                                        </tr>
                                        <tr>
                                            <td>Tanda Bukti Pembayaran</td>
                                            <td><a href="<?= base_url('spt/print/' . $dataContent['return_data']['id_spt'] . '/4') ?>" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i></a></td>
                                        </tr>
                                    </tbody>
                                </table>


                            </div>
                            <!-- <hr> -->
                        </div>
                        <hr>
                    </div>
                </div>
                <div class="tab-pane fade" id="tap-laporan" role="tabpanel" aria-labelledby="contact-top-tab">

                    <div class="col-lg-12">
                        <h5>Laporan</h5>
                        <?php if (!empty($dataContent['laporan']['text_laporan'])) {
                            echo $dataContent['laporan']['text_laporan'];
                        }
                        ?>
                    </div>
                    <h5>Foto</h5>
                    <?php if ($dataContent['return_data']['user_input'] == $this->session->userdata('id')) {
                    ?>
                        <a class="btn btn-primary mb-2" href="<?= base_url() . 'spt/laporan/' . $dataContent['return_data']['id_spt'] ?>"><strong><i class="fa fa-pencil"></i> Form Laporan </strong></a>
                        <a class="btn btn-primary mb-2" id="addFoto"><strong><i class="fa fa-plus"></i> Tambah Foto </strong></a>
                    <?php } ?>
                    <div class="gallery my-gallery row" id="layout_foto" itemscope="">



                    </div>
                    <!-- Root element of PhotoSwipe. Must have class pswp.-->
                    <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="pswp__bg"></div>
                        <div class="pswp__scroll-wrap">
                            <div class="pswp__container">
                                <div class="pswp__item"></div>
                                <div class="pswp__item"></div>
                                <div class="pswp__item"></div>
                            </div>
                            <div class="pswp__ui pswp__ui--hidden">
                                <div class="pswp__top-bar">
                                    <div class="pswp__counter"></div>
                                    <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
                                    <button class="pswp__button pswp__button--share" title="Share"></button>
                                    <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
                                    <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
                                    <div class="pswp__preloader">
                                        <div class="pswp__preloader__icn">
                                            <div class="pswp__preloader__cut">
                                                <div class="pswp__preloader__donut"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                                    <div class="pswp__share-tooltip"></div>
                                </div>
                                <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)"></button>
                                <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)"></button>
                                <div class="pswp__caption">
                                    <div class="pswp__caption__center"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- </div>
                </div> -->
                <!-- </div> -->
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="foto_modal" aria-labelledby="exampleModalLongTitle">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form opd="form" id="foto_form" onsubmit="return false;" type="multipart" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_title">
                        Form Foto
                    </h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="" id="id_spt" name="id_spt" value="<?= $dataContent['return_data']['id_spt'] ?>">
                    <input type="" id="id_foto" name="id_foto">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="nama">File</label>
                                <!-- <p class="no-margins"><span id="file_foto">-</span></p> -->
                                <input type="file" placeholder="" class="form-control" id="file_foto" name="file_foto">
                            </div>
                            <div class="form-group">
                                <label for="nama">Deskripsi</label>
                                <textarea type="text" placeholder="" class="form-control" id="deskripsi" name="deskripsi"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit" id="add_btn" data-loading-text="Loading..."><strong>Tambah</strong></button>
                        <button class="btn btn-primary" type="submit" id="save_edit_btn" data-loading-text="Loading..."><strong>Simpan Perubahan</strong></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#menu_2').addClass('active');
        $('#opmenu_2').show();
        $('#submenu_5').addClass('active');
        $('#ajukan_btn').on('click', (ev) => {
            event.preventDefault();
            Swal.fire({
                title: "Data ini akan di  Ajukan?",
                icon: "warning",
                allowOutsideClick: false,
                showCancelButton: true,
                buttons: {
                    cancel: 'Batal !!',
                    catch: {
                        text: "Ya, Ajukan !!",
                        value: true,
                    },
                },
            }).then((result) => {
                if (!result.isConfirmed) {
                    return;
                }
                swalLoading();

                $.ajax({
                    url: '<?= base_url('spt/action/ajukan/' . $dataContent['return_data']['id_spt']) ?>',
                    'type': 'get',
                    data: {

                    },
                    success: function(data) {
                        var json = JSON.parse(data);
                        if (json['error']) {
                            Swal.fire(" <?= ($cur_user['id'] == $dataContent['return_data']['user_input'] && $dataContent['return_data']['status'] == 0) ? ' Pengajuan' : 'Approv' ?> Gagal", json['message'], "error");
                            return;
                        }
                        Swal.close();
                        Swal.fire({
                            title: "Berhasil !!",
                            text: "Data telah <?= ($cur_user['id'] == $dataContent['return_data']['user_input'] && $dataContent['return_data']['status'] == 0) ? ' diajukan' : 'diapprov' ?>",
                            icon: "success",
                            allowOutsideClick: true,
                            buttons: {
                                catch: {
                                    text: "OK",
                                    value: true,
                                },
                            },
                        }).then((result) => {
                            location.reload();
                        });
                    }
                });

            });
        })
        $('#approv_btn').on('click', (ev) => {
            event.preventDefault();
            Swal.fire({
                title: "Data ini akan di  <?= ($cur_user['id'] == $dataContent['return_data']['user_input'] && $dataContent['return_data']['status'] == 0) ? ' diajukan' : 'diapprov' ?>?",
                // text: "Data Role akan dirubah dan hak aksess user terkait akan berubah juga!",
                icon: "warning",
                allowOutsideClick: false,
                showCancelButton: true,
                buttons: {
                    cancel: 'Batal !!',
                    catch: {
                        text: "Ya, Approv !!",
                        value: true,
                    },
                },
            }).then((result) => {
                if (!result.isConfirmed) {
                    return;
                }
                swalLoading();

                $.ajax({
                    url: '<?= base_url('spt/action/approv/' . $dataContent['return_data']['id_spt']) ?>',
                    'type': 'get',
                    data: {

                    },
                    success: function(data) {
                        var json = JSON.parse(data);
                        if (json['error']) {
                            Swal.fire(" <?= ($cur_user['id'] == $dataContent['return_data']['user_input'] && $dataContent['return_data']['status'] == 0) ? ' Pengajuan' : 'Approv' ?> Gagal", json['message'], "error");
                            return;
                        }
                        Swal.close();
                        Swal.fire({
                            title: "Berhasil !!",
                            text: "Data telah <?= ($cur_user['id'] == $dataContent['return_data']['user_input'] && $dataContent['return_data']['status'] == 0) ? ' diajukan' : 'diapprov' ?>",
                            icon: "success",
                            allowOutsideClick: true,
                            buttons: {
                                catch: {
                                    text: "OK",
                                    value: true,
                                },
                            },
                        }).then((result) => {
                            location.reload();
                        });
                    }
                });

            });
        })
        var FotoModal = {
            'self': $('#foto_modal'),
            'info': $('#foto_modal').find('.info'),
            'form': $('#foto_modal').find('#foto_form'),
            'deskripsi': $('#foto_modal').find('#deskripsi'),
            'addBtn': $('#foto_modal').find('#add_btn'),
            'id_foto': $('#foto_modal').find('#id_foto'),
            'saveEditBtn': $('#foto_modal').find('#save_edit_btn'),
            'file_foto': $('#foto_modal').find('#file_foto'),

        };
        $('#addFoto').on('click', (ev) => {
            FotoModal.self.modal('show');
            FotoModal.file_foto.prop('required', true);
            FotoModal.addBtn.show();
            FotoModal.saveEditBtn.hide();
            FotoModal.form.trigger('reset');

        })

        dataFoto = [];
        getFotoSppd();


        function getFotoSppd() {
            Swal.fire({
                title: 'Loading Pegawai!',
                allowOutsideClick: false,
            });
            Swal.showLoading()
            return $.ajax({
                url: `<?php echo site_url('Spt/getFoto/') ?>`,
                'type': 'get',
                data: {
                    'id_spt': '<?= $dataContent['return_data']['id_spt'] ?>'
                },
                success: function(data) {
                    Swal.close();
                    var json = JSON.parse(data);
                    if (json['error']) {
                        return;
                    }
                    dataFoto = json['data'];
                    renderFoto(dataFoto);
                },
                error: function(e) {}
            });
        }

        function renderFoto(data) {
            if (data == null || typeof data != "object") {
                console.log("User::UNKNOWN DATA");
                return;
            }
            var i = 0;

            $('#layout_foto').html('');
            var renderData = [];
            Object.values(data).forEach((d) => {
                template_foto = `
                <div class="col-xl-3 col-md-4 col-6 mb-2">
                <div class="mb-0">
                <figure class="col-12 mb-0" itemprop="associatedMedia" itemscope="">
                    <a href="<?= base_url() ?>uploads/foto_sppd/${d['file_foto']}" itemprop="contentUrl" data-size="1600x950">
                     <img class="img-thumbnail" style="height : 12rem !important" src="<?= base_url() ?>uploads/foto_sppd/${d['file_foto']}" itemprop="thumbnail" alt="Image description"></a>
                            <figcaption itemprop="caption description">${d['deskripsi']}</figcaption>
                            </figure>
                            </div>
                            <div class="row col-12 icon-lists">
                                 <div class="col"><i class="fa fa-trash delete_foto pl-2 pr-2" data-id="${d['id_foto']}"></i>  <i class="fa fa-pencil edit_foto mr-2" data-id="${d['id_foto']}"></i></div>
                        
                       
                    </div>
                            </div>
                        `
                $('#layout_foto').append(template_foto);
            })

            $('.edit_foto').on('click', function(event) {
                console.log('sad')
                // resetUserModal();
                FotoModal.self.modal('show');
                FotoModal.addBtn.hide();
                FotoModal.saveEditBtn.show();
                FotoModal.form.trigger('reset');

                var currentData = dataFoto[$(this).data('id')];
                console.log(currentData);
                FotoModal.id_foto.val(currentData['id_foto']);
                FotoModal.deskripsi.val(currentData['deskripsi']);
            });
        }

        FotoModal.form.submit(function(event) {
            console.log('submit');
            event.preventDefault();
            var url = "<?= base_url('Spt/addFoto') ?>";
            Swal.fire({
                title: "Apakah anda Yakin?",
                text: "Data Disimpan!",
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
                swalLoading();
                if (!result.isConfirmed) {
                    return;
                }
                $.ajax({
                    url: url,
                    'type': 'POST',
                    data:
                        // formProfile.form.serialize(),
                        new FormData(FotoModal.form[0]),
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        // buttonIdle(button);
                        var json = JSON.parse(data);
                        if (json['error']) {
                            Swal.fire("Simpan Gagal", json['message'], "error");
                            return;
                        }
                        var res = json['data']
                        dataFoto[res['id_foto']] = res;
                        renderFoto(dataFoto);
                        Swal.fire("Simpan Berhasil", "", "success");
                        FotoModal.self.modal('hide')
                        // location.reload();
                        // renderUser(dataUser);
                        // formProfile.self.modal('hide');
                    },
                    error: function(e) {}
                });
            });
        });

        $('#deapprov_btn').on('click', (ev) => {
            console.log('de')
            event.preventDefault();
            Swal.fire({
                title: "Data ini akan di tolak?",
                // text: "Data Role akan dirubah dan hak aksess user terkait akan berubah juga!",
                icon: "danger",
                allowOutsideClick: false,
                showCancelButton: true,
                buttons: {
                    cancel: 'Batal !!',
                    catch: {
                        text: "Ya, Tolak !!",
                        value: true,
                    },
                },
            }).then((result) => {
                if (!result.isConfirmed) {
                    return;
                }
                swalLoading();

                $.ajax({
                    url: '<?= base_url('spt/action/unapprov/' . $dataContent['return_data']['id_spt']) ?>',
                    'type': 'get',
                    data: {

                    },
                    success: function(data) {
                        var json = JSON.parse(data);
                        if (json['error']) {
                            Swal.fire("Gagal", json['message'], "error");
                            return;
                        }
                        Swal.close();
                        Swal.fire({
                            title: "Berhasil !!",
                            text: "Data telah ditolak.",
                            icon: "success",
                            allowOutsideClick: true,
                            buttons: {
                                catch: {
                                    text: "OK",
                                    value: true,
                                },
                            },
                        }).then((result) => {
                            location.reload();
                        });
                    }
                });

            });
        })

        $('#batal_aksi').on('click', (ev) => {
            event.preventDefault();
            Swal.fire({
                title: "Batalkan Approval data?",
                // text: "Data Role akan dirubah dan hak aksess user terkait akan berubah juga!",
                icon: "warning",
                allowOutsideClick: false,
                showCancelButton: true,
                buttons: {
                    cancel: 'Batal !!',
                    catch: {
                        text: "Ya, Batalkan !!",
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
                    url: '<?= base_url('spt/action/undo/' . $dataContent['return_data']['id_spt']) ?>',
                    'type': 'get',
                    data: {

                    },
                    success: function(data) {
                        var json = JSON.parse(data);
                        if (json['error']) {
                            Swal.fire("Gagal", json['message'], "error");
                            return;
                        }
                        Swal.close();
                        Swal.fire({
                            title: "Berhasil !!",
                            text: "Aksi telah dibatalkan.",
                            icon: "success",
                            allowOutsideClick: true,
                            buttons: {
                                catch: {
                                    text: "OK",
                                    value: true,
                                },
                            },
                        }).then((result) => {
                            location.reload();
                        });
                    }
                });

            });
        })
    })
</script>