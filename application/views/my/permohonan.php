<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-header">

                    <form class="form-inline" id="toolbar_form" onsubmit="return false;">
                        <!-- <div class="col-lg-2"> -->
                        <!-- <input type="hidden" id="is_not_self" name="is_not_self" value="1"> -->
                        <!-- </div> -->
                        <div class="col-lg-2">
                            <select class="form-control " name="status_permohonan" id="status">
                                <option value=""> Semua </option>
                                <option value="menunggu"> Menunggu </option>
                                <option value="approv"> Approv </option>
                                <option value="ditolak"> Ditolak </option>
                                <option value="selesai"> Selesai </option>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <select class="form-control mr-sm-2" name="jenis_permohonan" id="jenis_permohonan">
                                <option value=""> Semua Permohonan </option>
                                <option value="spt_all"> SPT / SPPD / Lembur </option>
                                <option value="spt"> SPT </option>
                                <option value="sppd"> SPT & SPPD</option>
                                <option value="lembur"> Lembur </option>
                                <option value="skp"> SKP </option>
                                <option value="aktifitas_harian"> Laporan Bulanan Aktifitas Harian </option>
                            </select>
                        </div>
                        <div class="col-lg-2">

                            <!-- <a type="button" class="btn btn-success my-1 mr-sm-2" href="<?= base_url('skp/add') ?>" id="new_btn" disabled="disabled"><i class="fa fa-plus"></i> Tambah </a> -->
                        </div>
                    </form>
                </div>

                <div class="card-body">
                    <!-- <div class="col-lg-12"> -->
                    <!-- <div class="ibox"> -->
                    <!-- <div class="ibox-content"> -->

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
<!-- </div> -->



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
                [5, "desc"]
            ]
        });

        var dataRole = {}
        var dataSKP = {}
        <?php $curUser = $this->session->userdata(); ?>
        var currentUser = <?= json_encode([
                                'level' => $curUser['level'],
                                'id_seksi' => $curUser['id_seksi'],
                                'id_bagian' => $curUser['id_bagian'],
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

        $.when(getAllSppd()).then((e) => {
            // toolbar.newBtn.prop('disabled', false);
        }).fail((e) => {
            console.log(e)
        });



        toolbar.status.on('change', (e) => {
            getAllSppd();
        });


        toolbar.jenis_permohonan.on('change', (e) => {
            getAllSppd();
        });

        function getAllSppd() {
            Swal.fire({
                title: 'Loading SPPD!',
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
            Object.values(data['spt']).forEach((spt) => {
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
                    console.log(spt['status'])
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

                if (spt['status'] == 10 && spt['id_ppk'] == '<?= $this->session->userdata()['id'] ?>' && spt['id_ppk'] != '') {
                    var aksiBtn = `
                    <a class="approv dropdown-item"  data-jenis='spt' data-id='${spt['id_spt']}' ><i class='fa fa-check'></i> Approv</a>
                    <a class="deapprov dropdown-item " data-jenis='spt' data-id='${spt['id_spt']}' ><i class='fa fa-times'></i> Tolak Approv</a>
                    `;
                } else if ((spt['status'] == 11 || spt['unapprove_oleh'] == '<?= $this->session->userdata()['id'] ?>') && spt['id_ppk'] == '<?= $this->session->userdata()['id'] ?>' && spt['id_ppk'] != '') {
                    var aksiBtn = `
                        <a class="batal_aksi dropdown-item"  data-jenis='spt'  data-id='${spt['id_spt']}' ><i class='fa fa-check'></i> Batal Aksi</a>
                        `;
                }

                var lihatButton = `
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

                dfix = d1.split(" ")[0] + ' s.d ' + d1.split(" ")[0];
                renderData.push([spt['nama_ref_jen_spt'], dfix, pegawai, tmpt, statusSPT(spt['status']), spt['id_spt'], button]);
            });
            // Object.values(data).forEach((skp) => {
            //     var aksiBtn = '';
            //     if (skp['status'] == 1) {
            //         var lihatButton = `
            //         <a class="dropdown-item" style="width: 110px" href='<?= base_url() ?>skp/print/${skp['id_skp']}'><i class='fa fa-eye'></i> Lihat </a>
            //     `;
            //         var aksiBtn = `
            //         <a class="approv dropdown-item"  data-id='${skp['id_skp']}' ><i class='fa fa-check'></i> Approv</a>
            //         <a class="deapprov dropdown-item "  data-id='${skp['id_skp']}' ><i class='fa fa-times'></i> Tolak Approv</a>
            //         `;
            //     } else if (skp['status'] == 2) {
            //         // var aksiBtn = `
            //         // <a class="batal_aksi dropdown-item"  data-id='${skp['id_skp']}' ><i class='fa fa-check'></i> Batal Aksi</a>
            //         // `;
            //         var lihatButton = `
            //          <a class="dropdown-item" target="_blank" style="width: 110px" href='<?= base_url() ?>skp/print/${skp['id_skp']}'><i class='fa fa-eye'></i> Cetak </a>
            //           <a class="dropdown-item" target="_blank" style="width: 110px" href='<?= base_url() ?>skp/print/${skp['id_skp']}/barcode'><i class='fa fa-eye'></i> Cetak + Barcode </a>
            //   `;
            //     } else if (skp['status'] == 3) {
            //         var aksiBtn = `
            //         <a class="batal_aksi dropdown-item"  data-id='${skp['id_skp']}' ><i class='fa fa-check'></i> Batal Aksi</a>
            //         `;
            //         var lihatButton = ``;
            //     }
            //     var aprvButton = `
            //                     `;
            //     var deaprvButton = `
            //                     `;
            //     var button = `
            //                <div class="dropdown-basic">
            //                 <div class="dropdown">
            //                     <div class="btn-group mb-1">
            //                         <button class="dropbtn btn-square btn-sm btn-primary" style="width : 120px"  type="button">
            //                             Aksi
            //                             <span><i class="icofont icofont-arrow-down"> </i></span>
            //                         </button>
            //                         <div class="dropdown-content">
            //                             ${aksiBtn}
            //                             ${lihatButton}
            //                         </div>
            //                     </div>
            //                 </div>
            //             </div>`;
            //     // console.log(button)
            //     i = 1;
            //     renderData.push([skp['id_skp'], skp['periode_start'] + ' s.d ' + skp['periode_end'], skp['nama_pengaju'], skp['skp'], statusSKP(skp['status']), button]);
            // });
            FDataTable.clear().rows.add(renderData).draw('full-hold');
        }

        FDataTable.on('click', '.approv', function() {
            var currentData = dataSKP[$(this).data('id')];
            var jenis = $(this).data('jenis');
            Swal.fire({
                title: "Konfrirmasi Approv",
                text: "Data ini akan di approv anda yakin ?",
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
                Swal.fire({
                    title: 'Loading Approv!',
                    allowOutsideClick: false,
                });
                Swal.showLoading()
                cur_id = $(this).data('id')
                $.ajax({
                    url: `<?= base_url('Spt/action/approv/') ?>${cur_id}`,
                    'type': 'get',
                    data: {
                        jenis: jenis
                    },
                    success: function(data) {

                        Swal.close();

                        // buttonIdle(button);
                        var json = JSON.parse(data);
                        if (json['error']) {
                            Swal.fire("Simpan Gagal", json['message'], "error");
                            return;
                        }
                        var d = json['data']
                        dataSKP[jenis][d['id_spt']] = d;
                        Swal.fire("Approv Berhasil", "", "success");
                        renderSKP(dataSKP);
                    },
                    error: function(e) {}
                });
            });
        })

        FDataTable.on('click', '.deapprov', function() {
            var currentData = dataSKP[$(this).data('id')];
            var jenis = $(this).data('jenis');
            Swal.fire({
                title: "Konfrirmasi Penolakan",
                text: "Data ini akan ditolak ?",
                icon: "warning",
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
                Swal.fire({
                    title: 'Loading Tolak Approv!',
                    allowOutsideClick: false,
                });
                Swal.showLoading()
                cur_id = $(this).data('id')
                $.ajax({
                    url: `<?= base_url('Spt/action/unapprov/') ?>${cur_id}`,
                    'type': 'get',
                    data: {
                        id: $(this).data('id'),
                        aksi: 3,
                        jenis: jenis
                    },
                    success: function(data) {

                        Swal.close();

                        // buttonIdle(button);
                        var json = JSON.parse(data);
                        if (json['error']) {
                            Swal.fire("Tolak Gagal", json['message'], "error");
                            return;
                        }
                        var d = json['data']
                        dataSKP[jenis][d['id_spt']] = d;
                        Swal.fire("SKP Berhasil ditolak", "", "success");
                        renderSKP(dataSKP);
                    },
                    error: function(e) {}
                });
            });
        })

        FDataTable.on('click', '.batal_aksi', function() {
            var currentData = dataSKP[$(this).data('id')];
            var jenis = $(this).data('jenis');
            Swal.fire({
                title: "Konfrirmasi Batal",
                text: "Aksi untuk data ini akan dibatalkan?",
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
                console.log(result)
                if (!result.isConfirmed) {
                    return;
                }
                Swal.fire({
                    title: 'Loading Pembatalan!',
                    allowOutsideClick: false,
                });
                Swal.showLoading()
                cur_id = $(this).data('id')
                $.ajax({
                    url: `<?= base_url('Spt/action/undo/') ?>${cur_id}`,
                    'type': 'get',
                    data: {
                        id: $(this).data('id'),
                        aksi: 1,
                        jenis: jenis
                    },
                    success: function(data) {

                        Swal.close();

                        // buttonIdle(button);
                        var json = JSON.parse(data);
                        if (json['error']) {
                            Swal.fire("Pembatalan Gagal", json['message'], "error");
                            return;
                        }
                        var d = json['data'];
                        dataSKP[jenis][d['id_spt']] = d;
                        Swal.fire("Pembatalan Berhasil", "", "success");
                        renderSKP(dataSKP);
                    },
                    error: function(e) {}
                });
            });
        })
    });
</script>