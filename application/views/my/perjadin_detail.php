<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-tabs border-tab" id="top-tab" role="tablist">
                <li class="nav-item"><a class="nav-link active" id="top-home-tab" data-bs-toggle="tab" href="#top-home" role="tab" aria-controls="top-home" aria-selected="true"><i class="icofont icofont-ui-note"></i>Home</a></li>
                <li class="nav-item"><a class="nav-link" id="profile-top-tab" data-bs-toggle="tab" href="#top-profile" role="tab" aria-controls="top-profile" aria-selected="false"><i class="icofont icofont-man-in-glasses"></i>Approval</a></li>
                <li class="nav-item"><a class="nav-link" id="contact-top-tab" data-bs-toggle="tab" href="#top-contact" role="tab" aria-controls="top-contact" aria-selected="false"><i class="icofont icofont-file-document"></i>Dokument</a></li>
                <li class="nav-item"><a class="nav-link" id="contact-top-tab" data-bs-toggle="tab" href="#top-contact" role="tab" aria-controls="top-contact" aria-selected="false"><i class="icofont icofont-notepad"></i>Laporan Perjalanan Dinas</a></li>
            </ul>
            <div class="tab-content" id="top-tabContent">
                <div class="tab-pane fade show active" id="top-home" role="tabpanel" aria-labelledby="top-home-tab">
                    <div class="modal-body">
                        <div class="row">
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
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#menu_2').addClass('active');
        $('#opmenu_2').show();
        $('#submenu_5').addClass('active');
    })
</script>