<!DOCTYPE html>
<html lang="en">

<style>
    .login-card .qrcode-result {
        width: 100%;
        /* padding: 40px; */
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
                <div class="login-card">
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
                        <div class="qrcode-result" style="">
                            <form class="theme-form" id="loginForm">
                                <div class="modal-body">
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
                                        </div>
                                        <!-- <br>
                                        <br>
                                        <br>
                                    -->
                                        <hr>
                                        <div class="col-lg-12">
                                            <div class="col-form-label"><strong>Dasar</strong></div>
                                            <div class="row">
                                                <div class=" col-sm-1 col-lg-1">1. </div>
                                                <div class=" col-sm-11 col-lg-11">
                                                    <p>
                                                        <?php
                                                        if (!empty($dataContent['return_data']['id_dasar'])) {
                                                            echo $dataContent['return_data']['nama_dasar'];
                                                        }
                                                        ?>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="col-form-label"><strong>Disetujui Oleh</strong></div>
                                                    <?= $dataContent['return_data']['sign']['sign_title'] . '<br>' .
                                                        $dataContent['return_data']['sign']['sign_name'] . '<br> NIP. ' .
                                                        $dataContent['return_data']['sign']['sign_nip']
                                                    ?>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="col-form-label"><strong>PPK</strong></div>
                                                    <?= $dataContent['return_data']['nama_ppk'] ?>
                                                </div>
                                                <div class="col-lg-4">
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
                                        <?php if (!empty($dataContent['return_data']['pengikut'])) {
                                        ?>
                                            <div class="col-lg-12">
                                                <div class="col-lg-2"><strong>Tujuan</strong></div>
                                                <!-- <div class="row"> -->
                                                <?php
                                                $i = 0;
                                                foreach ($dataContent['return_data']['tujuan'] as $t) {
                                                    $i++;
                                                ?>
                                                    <div class="col-lg-12">
                                                        <div class="row">

                                                            <div class="col-sm-1"><?= $i ?>. </div>
                                                            <div class="col-sm-12">Tempat Tujuan : <?= $t['tempat_tujuan'] ?> </div>
                                                            <div class="col-sm-12">Tanggal Berangkat : <?= $t['date_berangkat'] ?></div>
                                                            <div class="col-sm-12">Tanggal Kembali : <?= $t['date_kembali'] ?></div>
                                                        </div>
                                                    </div>
                                                <?php } ?>

                                                <hr>
                                            </div>
                                        <?php } ?>


                                        <div class="col-lg-12">
                                            <div class="col-lg-2"><strong>Pegawai</strong></div>
                                            <div class="col-sm-12">Nama &nbsp: <?= $dataContent['return_data']['nama_pegawai'] ?></div>
                                            <div class="col-sm-12">NIP &nbsp&nbsp&nbsp&nbsp: <?= $dataContent['return_data']['nip_pegawai']  ?> </div>
                                            <div class="col-sm-12">Jabatan : <?= $dataContent['return_data']['jabatan_pegawai'] ?></div>
                                            <div class="col-sm-12">Pangkat / Golongan : <?= $dataContent['return_data']['pangkat_gol_pegawai'] ?> </div>
                                        </div>
                                        <?php if (!empty($dataContent['return_data']['pengikut'])) {
                                        ?>
                                            <div class="col-lg-12">
                                                <hr>
                                                <div class="col-lg-2"><strong>Pengikut</strong></div>
                                                <!-- <div class="row"> -->
                                                <?php
                                                $i = 0;
                                                foreach ($dataContent['return_data']['pengikut'] as $p) {
                                                    $i++;
                                                ?>
                                                    <div class="col-lg-12">
                                                        <div class="col-sm-3"><?= $i ?>. </div>
                                                        <div class="col-sm-12">Nama &nbsp: <?= $p['nama'] ?></div>
                                                        <div class="col-sm-12">NIP &nbsp&nbsp&nbsp&nbsp: <?= $p['nip'] ?> </div>
                                                        <div class="col-sm-12">Jabatan : <?= $p['jabatan'] ?></div>
                                                        <div class="col-sm-12">Pangkat / Golongan : <?= $p['pangkat_gol'] ?> </div>
                                                    </div>
                                                    <br>
                                                    <!-- <br> -->
                                                <?php } ?>

                                                <!-- </div> -->
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </form>
                        </div>
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