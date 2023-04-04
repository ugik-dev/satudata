<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12 col-lg-12 mt-3">
            <div class="default-according style-1 faq-accordion job-accordion">
                <div class="accordion" id="accordionExample">
                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <h2 class="mb-0">
                                <button class="btn btn-link btn-block text-start" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Filter
                                </button>
                            </h2>
                        </div>
                        <div class="collapse show" id="collapseOne" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <form class="form-inline" id="toolbar_form" onsubmit="return false;">

                                <div class="card-body filter-cards-view animate-chk">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="mb-3 row">
                                                <label class="col-sm-3 col-form-label">Status </label>
                                                <div class="col-sm-8">
                                                    <select class="form-control " name="status_permohonan" id="status">
                                                        <option value=""> Semua </option>
                                                        <option value="menunggu-saya" selected> Menunggu Saya</option>
                                                        <option value="my-approv"> Sudah Saya Approve </option>
                                                        <option value="ditolak"> Ditolak </option>
                                                        <option value="selesai"> Selesai </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="mb-3 row">
                                                <?php
                                                $date = new DateTime(date('Y-m-d'));
                                                $date->add(new DateInterval('P1M'));
                                                $date->invert = 1;
                                                ?>
                                                <label class="col-sm-3 col-form-label">Dari</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control m-input digits" id="dari" name="dari" type="date" value="<?= date("Y-m-d", strtotime("-1 months")); ?>" data-bs-original-title="" title="">
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="mb-3 row">
                                                <label class="col-sm-3 col-form-label">Sampai</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control m-input digits" id="sampai" name="sampai" type="date" value="<?= date('Y-m-d') ?>" data-bs-original-title="" title="">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- <div class="job-filter mb-2">
                                            <div class="faq-form">
                                                <input class="form-control" type="text" placeholder="Search.." /><i class="search-icon" data-feather="search"></i>
                                            </div>
                                        </div>
                                        <div class="job-filter">
                                            <div class="faq-form">
                                                <input class="form-control" type="text" placeholder="location.." /><i class="search-icon" data-feather="map-pin"></i>
                                            </div>
                                        </div> -->
                                        <div class="checkbox-animated m-checkbox-inline">
                                            <label class="form-check form-check-inline" for="chk-spt">
                                                <input class="checkbox_animated" id="chk-spt" name="chk-spt" type="checkbox" checked />SPT
                                            </label>
                                            <label class="form-check form-check-inline" for="chk-sppd">
                                                <input class="checkbox_animated" id="chk-sppd" name="chk-sppd" type="checkbox" checked />SPPD
                                            </label>
                                            <label class="form-check form-check-inline" for="chk-lembur">
                                                <input class="checkbox_animated" id="chk-lembur" name="chk-lembur" type="checkbox" checked />Lembur
                                            </label><label class="form-check form-check-inline" for="chk-surat-izin">
                                                <input class="checkbox_animated" id="chk-surat-izin" name="chk-surat-izin" type="checkbox" checked />Surat Izin
                                            </label>
                                            <label class="form-check form-check-inline" for="chk-surat-cuti">
                                                <input class="checkbox_animated" id="chk-surat-cuti" name="chk-surat-cuti" type="checkbox" checked />Surat Cuti
                                            </label>
                                        </div>
                                        <button class="btn btn-primary text-center" type="submit">
                                            <i class="fa fa-search ml-3 mr-3"></i> Cari
                                        </button>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="FDataTable" class="table table-border-horizontal" style="padding-bottom: 100px">
                            <thead>
                                <tr>
                                    <th style="width: 5%; text-align:center!important">Jenis</th>
                                    <th style="width: 10%; text-align:center!important">TANGGAL</th>
                                    <th style="width: 10%; text-align:center!important">PEGAWAI</th>
                                    <th style="width: 20%; text-align:center!important">INFORMASI LAINNYA</th>
                                    <th style="width: 5%; text-align:center!important">STATUS</th>
                                    <th style="width: 2%; text-align:center!important">ID</th>
                                    <th style="width: 5%; text-align:center!important">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('#sidebar_permohonan').addClass('active_c');

        var toolbar = {
            'form': $('#toolbar_form'),
            'jenis_permohonan': $('#toolbar_form').find('#jenis_permohonan'),
            'status': $('#toolbar_form').find('#status'),
            'newBtn': $('#new_btn'),
        }

        var FDataTable = $('#FDataTable').DataTable({
            'columnDefs': [],
            responsive: true,
            deferRender: true,
            "order": [
                [1, "desc"]
            ]
        });

        var dataRole = {}
        var dataSKP = {}
        <?php $curUser = $this->session->userdata(); ?>
        var currentUser = <?= json_encode([
                                'level' => $curUser['level'],
                                'id_seksi' => $curUser['id_seksi'],
                                'id_bagian' => $curUser['id_bagian'],
                                'id_satuan' => $curUser['id_satuan'],
                                'id' => $curUser['id'],
                            ]) ?>;
        console.log(currentUser);
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
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, Hapus!",
        };

        $.when(getAllPermohonan()).then((e) => {
            // toolbar.newBtn.prop('disabled', false);
        }).fail((e) => {
            console.log(e)
        });

        toolbar.form.on('submit', (e) => {
            getAllPermohonan();
        });
        toolbar.status.on('change', (e) => {
            getAllPermohonan();
        });


        toolbar.jenis_permohonan.on('change', (e) => {
            getAllPermohonan();
        });

        function getAllPermohonan() {
            Swal.fire({
                title: 'Loading SPT!',
                allowOutsideClick: false,
            });
            Swal.showLoading()
            return $.ajax({
                url: `<?php echo site_url('permohonan/getAll/') ?>`,
                'type': 'get',
                data: toolbar.form.serialize(),
                success: function(data) {
                    Swal.close();
                    var json = JSON.parse(data);
                    if (json['error']) {
                        return;
                    }
                    dataSKP = json['data'];
                    renderSKP(dataSKP);
                },
                error: function(e) {}
            });
        }

        function renderSKP(data) {
            console.log(data)
            if (data == null || typeof data != "object") {
                console.log("Sppd::UNKNOWN DATA");
                return;
            }
            var i = 0;

            var renderData = [];

            Object.values(data).forEach((spt) => {
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
                     <a class="dropdown-item" target="_blank" style="width: 110px" href='<?= base_url() ?>spt/print/${spt['id_spt']}/1'><i class='fa fa-eye'></i> PDF SPT  </a>
                         `;
                if (spt['jenis'] == 2) {
                    lihatButton = lihatButton +
                        `
                        <a class="dropdown-item" target="_blank" style="width: 110px" href='<?= base_url() ?>spt/print/${spt['id_spt']}/2'><i class='fa fa-eye'></i> PDF SPPD </a>
                `;

                }
                // var lihatButton = `
                //      <a class="dropdown-item" target="_blank" style="width: 110px" href='<?= base_url() ?>spt/print/${spt['id_spt']}/1'><i class='fa fa-eye'></i> PDF SPT  </a>
                //      <a class="dropdown-item" target="_blank" style="width: 110px" href='<?= base_url() ?>spt/print/${spt['id_spt']}/2'><i class='fa fa-eye'></i> PDF SPPD </a>
                //      <a class="dropdown-item" target="_blank" style="width: 110px" href='<?= base_url() ?>spt/print/${spt['id_spt']}/3'><i class='fa fa-eye'></i> PDF SPT Barcode </a>
                //      <a class="dropdown-item" target="_blank" style="width: 110px" href='<?= base_url() ?>spt/print/${spt['id_spt']}/barcode'><i class='fa fa-eye'></i> PDF Barcode </a>
                //   `;
                lihatButton = lihatButton +
                    `
                         <a class="dropdown-item" target="_blank" style="width: 110px" href='<?= base_url() ?>spt/detail/${spt['id_spt']}'><i class='fa fa-eye'></i> Lihat </a>
                 `;

                var aprvButton = `
                                `;
                var deaprvButton = `
                                `;
                var button = `
                           <div class="dropdown-basic">
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
                // console.log(button)
                i = 1;
                d1 = '';
                d2 = '';
                tmpt = 'Tujuan : ';
                Object.values(spt['tujuan']).forEach((tj) => {
                    if (i == 1) {
                        d1 = tj['date_berangkat'];
                        tmpt = tmpt + tj['tempat_tujuan'];
                    } else {
                        tmpt = tmpt + ', ' + tj['tempat_tujuan'];

                    }
                    d2 = tj['date_kembali'];

                    i++;
                })
                if (spt['jenis'] == 2) {
                    tmpt = tmpt + '<br>No SPT : ' + (spt['no_spt'] ? spt['no_spt'] : '') + '<br>No SPPD : ' + (spt['no_sppd'] ? spt['no_sppd'] : '');
                } else {
                    tmpt = tmpt + '<br>No SPT : ' + (spt['no_spt'] ? spt['no_spt'] : '');

                }
                pegawai = spt['nama_pegawai'];
                i = 1;
                Object.values(spt['pengikut']).forEach((p) => {
                    if (i == 1)
                        pegawai = pegawai + '<br> Pengikut : ';
                    pegawai = pegawai + '<br>' + i + '. ' + p['nama'];
                    // d2 = tj['date_kembali']
                    i++;
                })

                dfix = d1.split(" ")[0] + ' s.d ' + d2.split(" ")[0];
                renderData.push([spt['nama_ref_jen_spt'], dfix, pegawai, tmpt, statusSPT(spt['status'], spt['unapprove_oleh']), spt['id_spt'], button]);
            });
            FDataTable.clear().rows.add(renderData).draw('full-hold');
        };

    });
</script>