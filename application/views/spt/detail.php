<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/vendors/photoswipe.css" />

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
                            <div class="col-lg-12" id="layout_aksi_btn">
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
                                            echo $dataContent['return_data']['nama_dasar'] . ' | Kode Rekening ' .
                                                $dataContent['return_data']['kode_rekening'];
                                        } else  if (!empty($dataContent['return_data']['dasar'])) {
                                            echo $dataContent['return_data']['dasar'];
                                        }
                                        ?>
                                        <?php if (!empty($dataContent['return_data']['id_dasar'])) { ?>
                                            <div class="row mb-2">
                                                <div class="col-lg-6">
                                                    <div class="col-form-label"><strong>PPK</strong></div>
                                                    <?= $dataContent['return_data']['nama_ppk'] ?>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="col-form-label"><strong>PPTK</strong></div>
                                                    <?= $dataContent['return_data']['nama_pptk'] ?>
                                                </div>
                                            </div>
                                        <?php } ?>
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
                            <?php if ($dataContent['return_data']['jenis'] == 3) { ?>
                            <?php } else { ?>
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

                                    </div>
                                    <hr>
                                </div> <?php } ?>


                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-sm-2"><strong>Pegawai</strong></div>
                                    <div class="col-sm-9">
                                        <div class="row">
                                            <div class="col-sm-3">Nama : </div>
                                            <div class="col-sm-9">
                                                <?= $dataContent['return_data']['pel_nama'] ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3">NIP : </div>
                                            <div class="col-sm-9">
                                                <?= $dataContent['return_data']['pel_nip'] ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3">Jabatan : </div>
                                            <div class="col-sm-9">
                                                <?= $dataContent['return_data']['pel_jabatan'] ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3">Pangkat / Golongan : </div>
                                            <div class="col-sm-9">
                                                <?= $dataContent['return_data']['pel_pangkat_gol'] ?>
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
                                                            <td><?= $p['p_nama'] ?></td>
                                                            <td><?= $p['p_nip'] ?></td>
                                                            <td><?= $p['p_jabatan'] ?></td>
                                                            <td><?= $p['p_pangkat_gol'] ?></td>
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
                            <?php if ($dataContent['return_data']['jenis'] == 3) { ?>
                                <div class="col-sm-2"><strong>Tempat & Waktu</strong></div>
                            <?php } else { ?>
                                <div class="col-sm-2"><strong>Tujuan</strong></div>
                            <?php } ?>
                            <!-- <div class="card-body"> -->
                            <!-- <div class="table-responsive mb-0"> -->
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <?php if ($dataContent['return_data']['jenis'] == 3) { ?>
                                            <th>Tempat</th>
                                            <th>Tanggal Lembur</th>
                                            <th>Dari</th>
                                            <th>Sampai</th>
                                            <th>Total Jam</th>
                                        <?php } else { ?>
                                            <th>Tempat Tujuan</th>
                                            <th>Tanggal Berangkat</th>
                                            <th>Temmpat Kembali</th>
                                            <th>Tanggal Kembali</th>
                                        <?php } ?>


                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($dataContent['return_data']['tujuan'])) {
                                        $i = 1;
                                        foreach ($dataContent['return_data']['tujuan'] as $t) {
                                            if ($dataContent['return_data']['jenis'] == 3) {
                                                $first  = new DateTime($t['dari']);
                                                $second = new DateTime($t['sampai']);
                                                $diff = $first->diff($second);
                                                $cur_jam =  $diff->format('%h');
                                    ?>
                                                <tr>
                                                    <td><?= to_romawi($i) ?></td>
                                                    <td><?= $t['tempat_tujuan'] ?></td>
                                                    <td><?= $t['date_berangkat'] ?></td>
                                                    <td><?= substr($t['dari'], 0, 5) ?></td>
                                                    <td><?= substr($t['sampai'], 0, 5)  ?></td>
                                                    <td><?= $cur_jam ?> jam</td>
                                                </tr>
                                            <?php

                                            } else { ?>
                                                <tr>
                                                    <td><?= to_romawi($i) ?></td>
                                                    <td><?= $t['tempat_tujuan'] ?></td>
                                                    <td><?= $t['date_berangkat'] ?></td>
                                                    <td><?= $t['tempat_kembali'] ?></td>
                                                    <td><?= $t['date_kembali'] ?></td>
                                                </tr>
                                            <?php } ?>


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
                            <?php
                            foreach ($dataContent['return_data']['logs'] as $log) {
                                echo "<tr>
                                    <td> {$log['deskripsi']}</td>
                                    <td> {$log['nama']}</td>
                                    <td> {$log['time_logs']}</td>
                                </tr>";
                            }
                            ?>

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
                                        <!-- <tr>
                                            <td>Surat Perintah Tugas dengan QR Code</td>
                                            <td><a href="<?= base_url('spt/print/' . $dataContent['return_data']['id_spt'] . '/1/2') ?>" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i></a></td>
                                        </tr> -->
                                        <?php if ($dataContent['return_data']['jenis'] == 2) {
                                        ?>
                                            <tr>
                                                <td>Surat Perintah Perjalanan Dinas</td>
                                                <td><a href="<?= base_url('spt/print/' . $dataContent['return_data']['id_spt'] . '/2') ?>" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i></a></td>
                                            </tr>
                                            <!-- <tr>
                                                <td>Surat Perintah Perjalanan Dinas dengan QR Code</td>
                                                <td><a href="<?= base_url('spt/print/' . $dataContent['return_data']['id_spt'] . '/2/2') ?>" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i></a></td>
                                            </tr> -->
                                        <?php } else if ($dataContent['return_data']['jenis'] == 3) {
                                        ?>
                                            <tr>
                                                <td>Draft Absensi</td>
                                                <td><a href="<?= base_url('download/absensi_lembur/' . $dataContent['return_data']['id_spt']) ?>" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i></a></td>
                                            </tr>
                                        <?php
                                        } ?>
                                        <tr>
                                            <td>Laporan </td>
                                            <td><a href="<?= base_url('spt/print/' . $dataContent['return_data']['id_spt'] . '/3') ?>" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i></a></td>
                                        </tr>
                                        <?php if ($dataContent['return_data']['jenis'] != 1) {
                                        ?>
                                            <tr>
                                                <td>Tanda Bukti Pembayaran</td>
                                                <td><a href="<?= base_url('spt/print/' . $dataContent['return_data']['id_spt'] . '/4') ?>" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i></a></td>
                                            </tr>
                                        <?php } ?>


                                    </tbody>
                                </table>


                            </div>
                            <!-- <hr> -->
                        </div>
                        <hr>
                    </div>
                </div>
                <div class="tab-pane fade" id="tap-laporan" role="tabpanel" aria-labelledby="contact-top-tab">
                    <?php
                    $team = [];
                    $team[] = $dataContent['return_data']['user_input'];
                    $team[] = $dataContent['return_data']['id_pegawai'];
                    foreach ($dataContent['return_data']['pengikut'] as $d) {
                        $team[]  = $d['id_pegawai'];
                    }
                    if (in_array($this->session->userdata('id'), $team)) {
                    ?>
                        <a class="btn btn-primary mb-2" href="<?= base_url() . 'spt/laporan/' . $dataContent['return_data']['id_spt'] ?>"><strong><i class="fa fa-pencil"></i> Form Laporan </strong></a>
                        <a class="btn btn-primary mb-2" id="addFoto"><strong><i class="fa fa-plus"></i> Foto </strong></a>
                        <a class="btn btn-primary mb-2" id="addPdf"><strong><i class="fa fa-plus"></i> File PDF </strong></a>
                    <?php } ?> <div class="col-lg-12">
                        <h5>Laporan</h5>
                        <?php if (!empty($dataContent['laporan']['text_laporan'])) {
                            echo $dataContent['laporan']['text_laporan'];
                        }
                        ?>
                    </div>


                    <hr>
                    <h5>Foto</h5>
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
                    <br><br>
                    <hr>
                    <div class="col-lg-12">
                        <h5>
                            File PDF
                        </h5>
                        <table id="FileDataTable" class="table  cell-border row-border display " style="padding-bottom: 100px">
                            <thead>
                                <tr>
                                    <th>Nama File</th>
                                    <th>Oleh</th>
                                    <th>Tanggal</th>
                                    <th style="width: 1%; text-align:center!important">Lihat</th>
                                    <th style="width: 1%; text-align:center!important">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
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
                    <input type="hidden" id="id_spt" name="id_spt" value="<?= $dataContent['return_data']['id_spt'] ?>">
                    <input type="hidden" id="id_foto" name="id_foto">
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
        var FileDataTable = $('#FileDataTable').DataTable({
            'columnDefs': [{
                    "targets": 0,
                    "className": "text-left",
                    "width": "4%"
                },
                {
                    "targets": [3, 4],
                    "className": "text-center",
                    "width": "2%"

                }
            ],
            deferRender: true,
            "order": [
                [0, "desc"]
            ]
        });

        $('#addFoto').on('click', (ev) => {
            FotoModal.self.modal('show');
            FotoModal.file_foto.prop('required', true);
            FotoModal.addBtn.show();
            FotoModal.saveEditBtn.hide();
            FotoModal.form.trigger('reset');

        })

        dataFoto = [];
        dataFile = [];
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
                    dataFoto = json['data']['image'];
                    dataFile = json['data']['file'];
                    renderFoto(dataFoto);
                    renderFile(dataFile);
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
                                 <div class="col"><i class="fa fa-trash delete_foto pl-2 pr-2" data-id="${d['id_foto']}" data-img="Y"></i>  <i class="fa fa-pencil edit_foto mr-2" data-img="Y" data-id="${d['id_foto']}"></i></div>
                        
                       
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
                FotoModal.file_foto.prop('required', false);
                console.log(currentData);
                FotoModal.id_foto.val(currentData['id_foto']);
                FotoModal.deskripsi.val(currentData['deskripsi']);
            });




            $('.delete_foto').on('click', function(event) {
                var currentData = dataFoto[$(this).data('id')];
                delete_foto(currentData);
            });


        }
        FileDataTable.on('click', '.delete_foto2', function() {
            var currentData = dataFile[$(this).data('id')];
            delete_foto(currentData);
        })

        FileDataTable.on('click', '.edit_foto2', function() {
            FotoModal.self.modal('show');
            FotoModal.addBtn.hide();
            FotoModal.saveEditBtn.show();
            FotoModal.form.trigger('reset');

            FotoModal.file_foto.prop('required', false);
            var currentData = dataFile[$(this).data('id')];
            FotoModal.id_foto.val(currentData['id_foto']);
            FotoModal.deskripsi.val(currentData['deskripsi']);
        });

        function delete_foto(currentData) {
            event.preventDefault();
            console.log(currentData);
            var url = "<?= base_url('Spt/deleteFoto') ?>";
            Swal.fire({
                title: "Konfirmasi?",
                text: "Foto akan dihapus?",
                icon: "warning",
                allowOutsideClick: false,
                showCancelButton: true,
                buttons: {
                    cancel: 'Batal !!',
                    catch: {
                        text: "Ya, Saya Hapus !!",
                        value: true,
                    },
                },
            }).then((result) => {
                if (!result.isConfirmed) {
                    return;
                }
                swalLoading();
                $.ajax({
                    url: url,
                    'type': 'get',
                    data: {
                        'id_foto': currentData['id_foto'],
                        'id_spt': currentData['id_spt'],
                    },
                    success: function(data) {
                        // buttonIdle(button);
                        var json = JSON.parse(data);
                        if (json['error']) {
                            Swal.fire("Simpan Gagal", json['message'], "error");
                            return;
                        }
                        var res = json['data']
                        if (currentData['is_image'] == 'Y') {
                            delete dataFoto[currentData['id_foto']];
                            renderFoto(dataFoto);
                        } else {
                            delete dataFile[currentData['id_foto']];
                            renderFile(dataFile);
                        }
                        Swal.fire("Simpan Berhasil", "", "success");
                        // location.reload();
                        // renderUser(dataUser);
                        // formProfile.self.modal('hide');
                    },
                    error: function(e) {}
                });
            });
        }

        function renderFile(data) {
            if (data == null || typeof data != "object") {
                console.log("Data::UNKNOWN DATA");
                return;
            }
            var i = 0;

            var renderData = [];
            Object.values(data).forEach((d) => {

                var button = `
                    <div class="btn-group mr-2" role="group" aria-label="First group">
                        <button class="btn btn-danger delete_foto2 pl-2 pr-2" data-img="N" data-id="${d['id_foto']}">
                            <i class="fa fa-trash " " ></i> 
                        </button>
                        <button class="btn btn-warning edit_foto2 pl-2 pr-2" data-img="N" data-id="${d['id_foto']}">
                         <i class="fa fa-pencil  mr-2" ></i>
                        </button>
                    </div>
                        `;
                renderData.push([d['deskripsi'], d['pel_nama'], d['waktu'], `<a class="btn btn-primary" target="_blank" href='<?= base_url() ?>uploads/foto_sppd/${d['file_foto']}'><i class="fa fa-eye"></i></a>`, button]);
            });
            FileDataTable.clear().rows.add(renderData).draw('full-hold');
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
                if (!result.isConfirmed) {
                    return;
                }
                swalLoading();
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
                        if (res['is_image'] == 'Y') {
                            dataFoto[res['id_foto']] = res;
                            renderFoto(dataFoto);
                        } else {
                            dataFile[res['id_foto']] = res;
                            renderFile(dataFile);
                        }
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
        PdfModal.form.submit(function(event) {
            console.log('submit');
            event.preventDefault();
            var url = "<?= base_url('Spt/addPdf') ?>";
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
                if (!result.isConfirmed) {
                    return;
                }
                swalLoading();
                $.ajax({
                    url: url,
                    'type': 'POST',
                    data:
                        // formProfile.form.serialize(),
                        new FormData(PdfModal.form[0]),
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
        console.log('ss');
        renderButtonSPT()

        function renderButtonSPT() {
            spt = <?= json_encode($dataContent['return_data']) ?>;
            currentUser = <?= json_encode($this->session->userdata()) ?>;
            console.log(spt);
            var aksiBtn = '';
            <?php if ($this->session->userdata()['level'] == 3 or $this->session->userdata()['level'] == 4) { ?>
                console.log('ini level 3 KASUBAG / KABID');
                if (spt['status'] == 2) {
                    var aksiBtn = `
                    <a class="approv dropdown-item"  data-jenis='spt' data-id='${spt['id_spt']}' ><i class='fa fa-check'></i> Approv</a>
                    <a class="deapprov dropdown-item " data-jenis='spt' data-id='${spt['id_spt']}' ><i class='fa fa-times'></i> Tolak Approv</a>
                    `;
                } else if (spt['status'] == 10) {
                    var aksiBtn = `
                    <a class="batal_aksi dropdown-item"  data-jenis='spt'  data-id='${spt['id_spt']}' ><i class='fa fa-check'></i> Batal Aksi</a>
                    `;
                }
            <?php } else if ($this->session->userdata()['level'] == 2) { ?>
                if (spt['status'] == 11) {
                    var aksiBtn = `
                    <a class="approv dropdown-item"  data-jenis='spt' data-id='${spt['id_spt']}' ><i class='fa fa-check'></i> Approv</a>
                    <a class="deapprov dropdown-item " data-jenis='spt' data-id='${spt['id_spt']}' ><i class='fa fa-times'></i> Tolak Approv</a>
                    `;
                } else if (spt['status'] == 12 || spt['unapprove_oleh'] == '<?= $this->session->userdata()['id'] ?>') {
                    var aksiBtn = `
                        <a class="batal_aksi dropdown-item"  data-jenis='spt'  data-id='${spt['id_spt']}' ><i class='fa fa-check'></i> Batal Aksi</a>
                        `;
                }
            <?php  } else if ($this->session->userdata()['level'] == 1) { ?>
                if (spt['status'] == 12) {
                    var aksiBtn = `
                    <a class="approv dropdown-item"  data-jenis='spt' data-id='${spt['id_spt']}' ><i class='fa fa-check'></i> Approv</a>
                    <a class="deapprov dropdown-item " data-jenis='spt' data-id='${spt['id_spt']}' ><i class='fa fa-times'></i> Tolak Approv</a>
                    `;
                } else if (spt['status'] == 99 || spt['unapprove_oleh'] == '<?= $this->session->userdata()['id'] ?>') {
                    var aksiBtn = `
                        <a class="batal_aksi dropdown-item"  data-jenis='spt'  data-id='${spt['id_spt']}' ><i class='fa fa-check'></i> Batal Aksi</a>
                        `;
                }
            <?php  } else if ($this->session->userdata()['level'] == 5) { ?>
                console.log(spt['status'])
                if (spt['status'] == 1 && spt['id_seksi'] == currentUser['id_seksi']) {
                    var aksiBtn = `
                    <a class="approv dropdown-item"  data-jenis='spt' data-id='${spt['id_spt']}' ><i class='fa fa-check'></i> Approv</a>
                    <a class="deapprov dropdown-item " data-jenis='spt' data-id='${spt['id_spt']}' ><i class='fa fa-times'></i> Tolak Approv</a>
                    `;
                } else if ((spt['status'] == 2 || spt['unapprove_oleh'] == currentUser['id']) && spt['id_seksi'] == currentUser['id_seksi']) {
                    var aksiBtn = `
                        <a class="batal_aksi dropdown-item"  data-jenis='spt'  data-id='${spt['id_spt']}' ><i class='fa fa-check'></i> Batal Aksi</a>
                        `;
                }
            <?php  } else if ($this->session->userdata()['level'] == 8) { ?>
                console.log(spt['id_satuan'])
                if (spt['status'] == 50 && spt['id_satuan'] == currentUser['id_satuan']) {
                    console.log("hereess23")
                    var aksiBtn = `
                    <a class="approv dropdown-item"  data-jenis='spt' data-id='${spt['id_spt']}' ><i class='fa fa-check'></i> Approv</a>
                    <a class="deapprov dropdown-item " data-jenis='spt' data-id='${spt['id_spt']}' ><i class='fa fa-times'></i> Tolak Approv</a>
                    `;
                } else if ((spt['status'] == 51 || spt['unapprove_oleh'] == currentUser['id']) && spt['id_satuan'] == currentUser['id_satuan']) {
                    var aksiBtn = `
                        <a class="batal_aksi dropdown-item"  data-jenis='spt'  data-id='${spt['id_spt']}' ><i class='fa fa-check'></i> Batal Aksi</a>
                        `;
                }
            <?php  } else if ($this->session->userdata()['level'] == 7) { ?>
                console.log(spt['id_satuan'])
                if (spt['status'] == 59 && spt['id_satuan'] == currentUser['id_satuan']) {
                    console.log("hereess23")
                    var aksiBtn = `
                    <a class="approv dropdown-item"  data-jenis='spt' data-id='${spt['id_spt']}' ><i class='fa fa-check'></i> Approv</a>
                    <a class="deapprov dropdown-item " data-jenis='spt' data-id='${spt['id_spt']}' ><i class='fa fa-times'></i> Tolak Approv</a>
                    `;
                } else if ((spt['status'] == 51 || spt['unapprove_oleh'] == currentUser['id']) && spt['id_satuan'] == currentUser['id_satuan']) {
                    var aksiBtn = `
                        <a class="batal_aksi dropdown-item"  data-jenis='spt'  data-id='${spt['id_spt']}' ><i class='fa fa-check'></i> Batal Aksi</a>
                        `;
                }
            <?php  } else if ($this->session->userdata()['penomoran'] == 1) { ?>
                console.log('here')
                if (spt['status'] == 99) {
                    var aksiBtn = `
                    <a class="approv dropdown-item"  data-jenis='spt' data-id='${spt['id_spt']}' ><i class='fa fa-check'></i> Approv</a>
                    <a class="deapprov dropdown-item " data-jenis='spt' data-id='${spt['id_spt']}' ><i class='fa fa-times'></i> Tolak Approv</a>
                    `;
                }
                // } else if (spt['status'] == 99 || spt['unapprove_oleh'] == '<?= $this->session->userdata()['id'] ?>') {
                //     var aksiBtn = `
                //     <a class="batal_aksi dropdown-item"  data-jenis='spt'  data-id='${spt['id_spt']}' ><i class='fa fa-check'></i> Batal Aksi</a>
                //     `;
            <?php  } ?>
            if (spt['status'] == 6 && spt['id_ppk2'] == '<?= $this->session->userdata()['id'] ?>' && spt['id_ppk2'] != '') {
                var aksiBtn = `
                    <a class="approv dropdown-item"  data-jenis='spt' data-id='${spt['id_spt']}' ><i class='fa fa-check'></i> Approv</a>
                    <a class="deapprov dropdown-item " data-jenis='spt' data-id='${spt['id_spt']}' ><i class='fa fa-times'></i> Tolak Approv</a>
                    `;
            } else if ((spt['status'] == 11 || spt['unapprove_oleh'] == '<?= $this->session->userdata()['id'] ?>') && spt['id_ppk'] == '<?= $this->session->userdata()['id'] ?>' && spt['id_ppk'] != '') {
                var aksiBtn = `
                        <a class="batal_aksi dropdown-item"  data-jenis='spt'  data-id='${spt['id_spt']}' ><i class='fa fa-check'></i> Batal Aksi</a>
                        `;
            } else if (
                (spt['status'] == 51 && spt['id_pptk'] == '<?= $this->session->userdata()['id'] ?>' && spt['id_pptk'] != '') ||
                (spt['status'] == 52 && spt['id_ppk2'] == '<?= $this->session->userdata()['id'] ?>' && spt['id_ppk'] != '')
            ) {
                var aksiBtn = `
                    <a class="approv dropdown-item"  data-jenis='spt' data-id='${spt['id_spt']}' ><i class='fa fa-check'></i> Approv</a>
                    <a class="deapprov dropdown-item " data-jenis='spt' data-id='${spt['id_spt']}' ><i class='fa fa-times'></i> Tolak Approv</a>
                    `;
            };
            if ((spt['unapprove_oleh'] == '<?= $this->session->userdata()['id'] ?>')) {
                var aksiBtn = `
                        <a class="batal_aksi dropdown-item"  data-jenis='spt'  data-id='${spt['id_spt']}' ><i class='fa fa-check'></i> Batal Aksi</a>
                        `;
            }
            var lihatButton = `
          
                      <a class="dropdown-item" target="_blank" style="width: 110px" href='<?= base_url() ?>spt/print/${spt['id_spt']}/1/2'><i class='fa fa-eye'></i> PDF SPT  </a>
                     <a class="dropdown-item" target="_blank" style="width: 110px" href='<?= base_url() ?>spt/print/${spt['id_spt']}/1'><i class='fa fa-eye'></i> PDF SPT  </a>
                     <a class="dropdown-item" target="_blank" style="width: 110px" href='<?= base_url() ?>spt/print/${spt['id_spt']}/2'><i class='fa fa-eye'></i> PDF SPPD </a>
                     <a class="dropdown-item" target="_blank" style="width: 110px" href='<?= base_url() ?>spt/print/${spt['id_spt']}/3'><i class='fa fa-eye'></i> PDF SPT Barcode </a>
                     <a class="dropdown-item" target="_blank" style="width: 110px" href='<?= base_url() ?>spt/print/${spt['id_spt']}/barcode'><i class='fa fa-eye'></i> PDF Barcode </a>
                      <a class="dropdown-item" style="width: 110px" href='<?= base_url() ?>spt/detail/${spt['id_spt']}'><i class='fa fa-eye'></i> Lihat </a>
                 `;

            var aprvButton = `
                                `;
            var deaprvButton = `
                                `;
            var button = `
                           <div class="dropdown-basic mb-2">
                            <div class="dropdown">
                                <div class="btn-group mb-1">
                                    <button class="dropbtn btn-square btn-sm btn-primary" style="width : 120px"  type="button">
                                        Aksi
                                        <span><i class="icofont icofont-arrow-down"> </i></span>
                                    </button>
                                    <div class="dropdown-content">
                                        ${aksiBtn}
                                        ${lihatButton}
                                    </div>
                                </div>
                            </div>
                        </div>`;
            // $('#layout_aksi_btn').append(button);
            console.log('sad');
            // console.log(button)
        }


    })
</script>