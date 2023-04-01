<!DOCTYPE html>
<html lang="en">

<style>
    .public-card {

        background: url('<?= base_url() ?>assets/img/bg-dinkes.jpg');
        background-repeat: no-repeat;
        background-position: center;
        background-size: cover;

    }

    .public-card::before {
        content: '';
        position: absolute;
        top: 0px;
        right: 0px;
        bottom: 0px;
        left: 0px;
        background-color: rgba(227, 226, 225, 0.25);
    }

    .login-card .qrcode-result {
        width: 100%;
        padding: 40px;
        border-radius: 10px;
        -webkit-box-shadow: 0 0 37px rgba(8, 21, 66, 0.95);
        box-shadow: 0 0 37px rgba(8, 21, 66, 0.6);
        margin: 0 auto;
        background-color: rgba(228, 228, 228, 0.9);
    }
</style>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Cuba admin is super flexible, powerful, clean &amp; modern responsive bootstrap 5 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Cuba admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="<?= base_url() ?>assets/img/kab_bangka.png" type="image/x-icon">
    <link rel="shortcut icon" href="<?= base_url() ?>assets/img/kab_bangka.png" type="image/x-icon">
    <title>DINKES KAB.BANGKA | Login</title>
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/font-awesome.css">
    <!-- ico-font-->

    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/vendors/icofont.css">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/vendors/themify.css">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/vendors/flag-icon.css">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/vendors/feather-icon.css">
    <!-- Plugins css start-->
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/vendors/sweetalert2.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.13.2/af-2.5.2/b-2.3.4/b-colvis-2.3.4/b-html5-2.3.4/b-print-2.3.4/cr-1.6.1/date-1.3.0/fc-4.2.1/fh-3.3.1/kt-2.8.1/r-2.4.0/rg-1.3.0/rr-1.3.2/sc-2.1.0/sb-1.4.0/sp-2.1.1/sl-1.6.0/sr-1.2.1/datatables.min.css" />


    <!-- <script src="<?= base_url() ?>sweetalert2/dist"></script> -->
    <!-- <script src="<?= base_url() ?>sweetalert2/dist/sweetalert2.min.js"></script>
  <link rel="stylesheet" href="<?= base_url() ?>sweetalert2/dist/sweetalert2.min.css"> -->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/vendors/bootstrap.css">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/style.css">
    <link id="color" rel="stylesheet" href="<?= base_url() ?>assets/css/color-1.css" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/responsive.css">
    <script src="<?= base_url() ?>assets/js/jquery-3.5.1.min.js"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <!-- login page start-->
    <div class="container-fluid p-0">
        <div class="row m-0">
            <div class="col-12 p-0">
                <div class="public-card">
                    <div>
                        <div>
                            <div class="row">

                                <div class="col-lg-2">
                                    <a class="logo" href="">

                                        <img style="max-width: 100%; !important" class="img-fluid for-light" src="<?= base_url() ?>assets/img/kab_bangka.png" alt="looginpage">
                                        <img style="max-width: 40%;" class="img-fluid for-dark" src="<?= base_url() ?>assets/img/kab_bangka.png" alt="looginpage">
                                    </a>
                                </div>
                                <div class="col-lg-10">
                                    <center>
                                        <h4 style="margin-bottom : 0 ; margin-top: 1rem">SISTEM INFORMASI ADMINISTRASI DAN UMUM</h4>
                                        <h2 style="margin-bottom : 0">DINAS KESEHATAN</h2>
                                        <h2 style="margin-bottom : 0">KABUPATEN BANGKA</h2>
                                    </center>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="container">

                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="row">
                                <label class="col-sm-2 col-form-label"><strong>No SPT</strong></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="no_spt" required="" value="<?= !empty($dataContent['return_data']['no_spt']) ? $dataContent['return_data']['no_spt'] : '' ?>" readonly="">
                                </div>
                            </div>
                        </div>
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
                            <div class="row">

                                <div class="col-lg-6">
                                    <div class="col-form-label"><strong>PPK</strong></div>
                                    <?= $dataContent['return_data']['nama_ppk'] ?>
                                </div>
                                <div class="col-lg-6">
                                    <div class="col-form-label"><strong>PPTK</strong></div>
                                    <?= $dataContent['return_data']['nama_pptk'] ?>
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
                            </div>
                        <?php } ?>



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
                                <div class="col-lg-2"><strong>Pengikut</strong></div>
                                <div class="col-lg-4" style="">
                                    <table class="table table-sm table-dashboard data-table no-wrap mb-0 fs--1 w-100" id="tb-pengikut">
                                        <thead>
                                            <tr>
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
                                                        <td><?= $p['nama'] ?></td>
                                                        <td><?= $p['nip'] ?></td>
                                                        <td><?= $p['jabatan'] ?></td>
                                                        <td><?= $p['pangkat_gol'] ?></td>
                                                    </tr>
                                            <?php
                                                }
                                            } ?>
                                        </tbody>
                                    </table>


                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                    <div class="col-lg-12" id="layout_tujuan">
                        <?php if ($dataContent['return_data']['jenis'] == 3) { ?>
                            <div class="col-sm-2"><strong>Tempat & Waktu</strong></div>
                        <?php } else { ?>
                            <div class="col-sm-2"><strong>Tujuan</strong></div>
                        <?php } ?>
                        <table class="table" id="tb-tujuan">
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
                    </div>

                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                $('#tb-pengikut').DataTable({
                    responsive: true,
                    // ordering: false
                });
                $('#tb-tujuan').DataTable({
                    responsive: true,
                    // ordering: false
                });
            });
        </script>
        <script src="<?= base_url() ?>assets/js/jquery-3.5.1.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.13.2/af-2.5.2/b-2.3.4/b-colvis-2.3.4/b-html5-2.3.4/b-print-2.3.4/cr-1.6.1/date-1.3.0/fc-4.2.1/fh-3.3.1/kt-2.8.1/r-2.4.0/rg-1.3.0/rr-1.3.2/sc-2.1.0/sb-1.4.0/sp-2.1.1/sl-1.6.0/sr-1.2.1/datatables.min.js"></script>

        <script src="<?= base_url() ?>assets/js/bootstrap/bootstrap.bundle.min.js"></script>
        <script src="<?= base_url() ?>assets/js/icons/feather-icon/feather.min.js"></script>
        <script src="<?= base_url() ?>assets/js/icons/feather-icon/feather-icon.js"></script>
        <script src="<?= base_url() ?>assets/js/config.js"></script>
        <script src="<?= base_url() ?>assets/js/script.js"></script>
    </div>
</body>

</html>