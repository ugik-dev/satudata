<div id='sidebar_wrapper_func' class="sidebar-wrapper">
    <div>
        <div class="logo-wrapper">
            <a href="<?= base_url() ?>">
                <!-- <h3>DINKES</h3> -->
                <img class="img-fluid for-light" src="<?= base_url() ?>assets/images/logo/logo.png" alt="" />
                <img class="img-fluid for-dark" src="<?= base_url() ?>assets/images/logo/logo.png" alt="" />
            </a>
            <div class="back-btn"><i class="fa fa-angle-left"></i></div>
            <div class="toggle-sidebar">
                <i class="status_toggle middle sidebar-toggle" data-feather="grid">
                </i>
            </div>
        </div>
        <div class="logo-icon-wrapper">
            <a href="<?= base_url() ?>"><img class="img-fluid" src="<?= base_url() ?>assets/images/logo/logo-icon.png" alt="" /></a>
        </div>
        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow">
                <i data-feather="arrow-left"></i>
            </div>

            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                    <li class="back-btn">
                        <a href="index.html"><img class="img-fluid" src="<?= base_url() ?>assets/images/logo/logo-icon.png" alt="" /></a>
                        <div class="mobile-back text-end">
                            <span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i>
                        </div>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav" href="<?= base_url() ?>dashboard"><i data-feather="home"> </i><span>DASHBOARD</span></a>
                    </li>
                    <li class="sidebar-list">
                        <!-- <a style="" class="sidebar-link sidebar-title link-nav" id="sidebar_absensi" href="<?= base_url() ?>absensi"><i data-feather="calendar"> </i><span>Absensi</span></a> -->
                    </li>
                    <li class="sidebar-list">
                        <a style="" class="sidebar-link sidebar-title link-nav" id="sidebar_surat_izin" href="<?= base_url() ?>surat-izin"><i data-feather="calendar"> </i><span>Surat Izin</span></a>
                    </li>
                    <!-- <li class="sidebar-list">
                        <a style="" class="sidebar-link sidebar-title link-nav" id="sidebar_aktifitas" href="<?= base_url() ?>aktifitas"><i data-feather="box"> </i><span>Aktifitas Harian</span></a>
                    </li> -->
                    <!-- <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav" id="sidebar_skp" href="<?= base_url() ?>skp"><i data-feather="feather"> </i><span>Sasaran Kerja</span></a>
                    </li> -->
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav" id="sidebar_permohonan" href="<?= base_url() ?>permohonan"><i data-feather="monitor"> </i><span>Permohonan Approval</span></a>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav" id="sidebar_spt_saya" href="<?= base_url() ?>spt-saya"><i data-feather="box"> </i><span>SPT & SPPD Saya</span></a>
                    </li>

                    <li class="sidebar-list">
                        <label class="badge badge-light-primary"></label><a class="sidebar-link sidebar-title active" id="menu_2" href="#" data-bs-original-title="" title=""><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-tag">
                                <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
                                <line x1="7" y1="7" x2="7" y2="7"></line>
                            </svg><span class="">SPT / SPPD </span>
                            <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                        </a>
                        <ul class="sidebar-submenu" id="opmenu_2" style="">
                            <li><a id="submenu_5" href="<?= base_url() ?>spt/daftar_pengajuan" class="active" data-bs-original-title="" title="">Daftar Pengajuan</a></li>
                            <li><a id="submenu_6" href="<?= base_url() ?>spt/create/spt" data-bs-original-title="" title="">Entri SPT</a></li>
                            <li><a id="submenu_8" href="<?= base_url() ?>spt/create/spt_sppd" data-bs-original-title="" title="">Entri SPT SPPD</a></li>
                            <?php if (in_array($this->session->userdata('id_bagian'), [1, 2, 3, 8, 9])) {
                                echo '<li><a id="submenu_9" href="' . base_url() . 'spt/create/lembur" data-bs-original-title="" title="">Entri Lembur</a></li>';
                            } ?>
                        </ul>
                    </li>

                    <?php $menu = User_Access($this->session->userdata('id_role'));
                    if (!empty($menu))
                        foreach ($menu as $m) {
                            if ($m['subs'] == 1) {
                                echo ' <li class="sidebar-list">
                                        <label class="badge badge-light-primary"></label><a class="sidebar-link sidebar-title" id="menu_' . $m['id_menu'] . '" href="#"><i data-feather="' . $m['icon'] . '"></i><span class="">' . $m['label_menu'] . ' </span></a>
                                        <ul class="sidebar-submenu" id="opmenu_' . $m['id_menu'] . '" >
                                        ';
                                foreach ($m['child'] as $mc) {
                                    echo '<li><a id="submenu_' . $mc['id_menulist'] . '" href="' . base_url() . $mc['url'] . '">' . $mc['label_menulist'] . '</a></li>';
                                }
                                echo '</ul> </li>';
                            } else {
                                echo ' <li class="sidebar-list">
                                <a class="sidebar-link sidebar-title link-nav" id="menu_' . $m['id_menu'] . '" href="' . base_url() . $m['menu_url'] . '"><i data-feather="' . $m['icon'] . '"></i><span class="">' . $m['label_menu'] . ' </span></a>
                                 </li>';
                            }
                        }
                    ?>
                    <!-- </li> -->
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav" href="<?= base_url() ?>panduan"><i data-feather="help-circle"> </i><span>Panduan</span></a>
                    </li>
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow">
                <i data-feather="arrow-right"></i>
            </div>
        </nav>
    </div>
</div>
<div class="page-body">