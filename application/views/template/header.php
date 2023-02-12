<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="Dinkes" content="Dinas Kesehatan Kabupaten Bangka" />
    <meta name="keywords" content="" />
    <meta name="author" content="pixelstrap" />
    <link rel="icon" href="<?= base_url() ?>assets/images/logo/logo-md.png" type="image/x-icon" />
    <link rel="shortcut icon" href="<?= base_url() ?>assets/images/logo/logo-md.png" type="image/x-icon" />
    <title>DINKES KAB.BANGKA | <?= !empty($title) ? $title : '' ?></title>
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/font-awesome.css" />
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/vendors/icofont.css" />
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/vendors/themify.css" />
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/vendors/flag-icon.css" />
    <!-- Feather icon-->
    <!-- <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/vendors/feather-icon.css" /> -->
    <!-- <script src="https://unpkg.com/feather-icons"></script> -->
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/vendors/scrollbar.css" />
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/vendors/animate.css" />
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/vendors/chartist.css" />
    <!-- <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/vendors/chartist.css" /> -->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/vendors/date-picker.css" />
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/vendors/bootstrap.css" />
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/style.css" />
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/custom.css" />
    <!-- galeri -->

    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/vendors/photoswipe.css" />
    <!-- end  galeri -->
    <link id="color" rel="stylesheet" href="<?= base_url() ?>assets/css/color-1.css" media="screen" />
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/responsive.css" />
    <!-- <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/vendors/datatables.css" /> -->
    <!-- <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/js/datatable/datatables/datatables.min.css" /> -->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/vendors/select2.css">
    <script src="<?= base_url() ?>assets/js/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.13.2/af-2.5.2/b-2.3.4/b-colvis-2.3.4/b-html5-2.3.4/b-print-2.3.4/cr-1.6.1/date-1.3.0/fc-4.2.1/fh-3.3.1/kt-2.8.1/r-2.4.0/rg-1.3.0/rr-1.3.2/sc-2.1.0/sb-1.4.0/sp-2.1.1/sl-1.6.0/sr-1.2.1/datatables.min.css" />

    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.13.2/af-2.5.2/b-2.3.4/b-colvis-2.3.4/b-html5-2.3.4/b-print-2.3.4/cr-1.6.1/date-1.3.0/fc-4.2.1/fh-3.3.1/kt-2.8.1/r-2.4.0/rg-1.3.0/rr-1.3.2/sc-2.1.0/sb-1.4.0/sp-2.1.1/sl-1.6.0/sr-1.2.1/datatables.min.js"></script>

    <!-- <script type="text/javascript" src="<?= base_url() ?>assets/js/datatable/datatables/datatables.min.js"></script> -->

    <!-- <script src="<?= base_url() ?>assets/js/datatable/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url() ?>assets/js/datatable/datatables/datatable.custom.js"></script> -->
    <!-- <script src="<?= base_url() ?>assets/js/datatable/datatables2/datatable.min.js"></script> -->
    <script src="<?= base_url('assets/') ?>js/FileUploader.js"></script>
    <script src="<?= base_url('assets/') ?>js/custom.js?v=0.0.5"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
</head>

<body>
    <!-- <body onload="startTime()"> -->
    <!-- loader starts-->
    <div class="loader-wrapper">
        <div class="loader-index"><span></span></div>
        <svg>
            <defs></defs>
            <filter id="goo">
                <fegaussianblur in="SourceGraphic" stddeviation="11" result="blur"></fegaussianblur>
                <fecolormatrix in="blur" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo"></fecolormatrix>
            </filter>
        </svg>
    </div>
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <div class="page-wrapper compact-wrapper" id="pageWrapper">