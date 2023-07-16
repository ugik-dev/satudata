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
                                                <label class="col-sm-3 col-form-label">Approval </label>
                                                <div class="col-sm-8">
                                                    <select class="form-control " name="status_rekap" id="status_rekap">
                                                        <option value=""> Semua </option>
                                                        <option value="menunggu"> Menunggu </option>
                                                        <option value="ditolak"> Di Tolak </option>
                                                        <option value="selesai" selected> Diterima </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="mb-3 row">
                                                <label class="col-sm-3 col-form-label">LPD</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control " name="status_lpd" id="status_lpd">
                                                        <option value="" selected> Semua </option>
                                                        <option value="belum"> Belum Entri LPD </option>
                                                        <option value="sudah"> Sudah Entri LPD </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="mb-3 row">
                                                <label class="col-sm-3 col-form-label">Instansi </label>
                                                <div class="col-sm-8">
                                                    <?php $curUser = $this->session->userdata(); ?>
                                                    <select class="select2 form-control " name="id_satuan" id="id_satuan">
                                                        <option value=""> Semua </option>
                                                        <?php

                                                        foreach ($dataContent['instansi'] as $ji) {
                                                            if ($curUser['id_satuan'] == $ji['id_satuan'])
                                                                echo "<option value='{$ji['id_satuan']}' selected> {$ji['nama_satuan']} </option>    ";
                                                            else
                                                                echo "<option value='{$ji['id_satuan']}' > {$ji['nama_satuan']} </option>    ";
                                                        }
                                                        ?>
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
                                        <div class="checkbox-animated m-checkbox-inline">

                                            <label class="form-check form-check-inline" for="chk-spt">
                                                <input class="checkbox_animated" id="chk-spt" name="chk-spt" type="checkbox" checked />SPT
                                            </label>
                                            <label class="form-check form-check-inline" for="chk-sppd">
                                                <input class="checkbox_animated" id="chk-sppd" name="chk-sppd" type="checkbox" checked />SPPD
                                            </label>
                                            <label class="form-check form-check-inline" for="chk-lembur">
                                                <input class="checkbox_animated" id="chk-lembur" name="chk-lembur" type="checkbox" checked />Lembur
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
                                    <th style="width: 5%; text-align:center!important">JENIS</th>
                                    <th style="width: 10%; text-align:center!important">TGL PENGAJUAN</th>
                                    <th style="width: 12%; text-align:center!important">TGL DINAS</th>
                                    <th style="width: 12%; text-align:center!important">TUJUAN</th>
                                    <!-- <th style="width: 12%; text-align:center!important">MAKSUD</th> -->
                                    <th style="width: 10%; text-align:center!important">INSTANSI</th>
                                    <th style="width: 10%; text-align:center!important">PEGAWAI</th>
                                    <th style="width: 10%; text-align:center!important">NO SPT</th>
                                    <th style="width: 10%; text-align:center!important">NO SPPD</th>
                                    <th style="width: 10%; text-align:center!important">Maksud</th>
                                    <th style="width: 10%; text-align:center!important">LPD</th>
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


<div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form opd="form" id="edit_form" onsubmit="return false;" type="multipart" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_title">
                        Edit SPT
                    </h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id_spt" name="id_spt">
                    <div class="row">
                        <div class="col-lg-2">
                            <div class="col-form-label">Aksi</div>
                            <button class="btn btn-primary" type="submit" id="save_edit_btn" data-loading-text="Loading..."><strong>Simpan</strong></button>
                        </div>
                        <div class="col-lg-4">
                            <div class="col-form-label">Tanggal Pengajuan</div>
                            <input id="tgl_pengajuan" type="datetime-local" name="tgl_pengajuan" class="form-control"></input>
                        </div>
                        <div class="col-lg-6">
                            <div class="col-form-label">Nomor SPT</div>
                            <input id="no_spt" name="no_spt" class="form-control"></input>
                        </div>
                        <div class="col-lg-6">
                            <div class="col-form-label">Nomor SPPD</div>
                            <input id="no_sppd" name="no_sppd" class="form-control"></input>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">
                            Close
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        $('#menu_4').addClass('active');
        $('#opmenu_4').show();
        $('#submenu_13').addClass('active');
        $('.select2').select2()
        var toolbar = {
            'form': $('#toolbar_form'),
            'id_satuan': $('#toolbar_form').find('#id_satuan'),
            'status_rekap': $('#toolbar_form').find('#status_rekap'),
            'status_lpd': $('#toolbar_form').find('#status_lpd'),
        }

        var FDataTable = $('#FDataTable').DataTable({
            dom: 'Bfrtip',
            'columnDefs': [],
            // responsive: true,
            deferRender: true,
            "order": [
                [1, "desc"]
            ],
            buttons: [{
                extend: 'excel',
                text: '<i class="fa fa-download ">  Export Excel</i>',
                className: 'excelButton btn btn-primary  font-weight-bold text-light',
                exportOptions: {
                    modifier: {
                        // page: 'current'
                    }
                }
            }]
        });

        var EditModal = {
            'self': $('#edit_modal'),
            'info': $('#edit_modal').find('.info'),
            'form': $('#edit_modal').find('#edit_form'),
            'addBtn': $('#edit_modal').find('#add_btn'),
            'saveEditBtn': $('#edit_modal').find('#save_edit_btn'),
            'idSuratIzin': $('#edit_modal').find('#id_spt'),
            'tgl_pengajuan': $('#edit_modal').find('#tgl_pengajuan'),
            'no_spt': $('#edit_modal').find('#no_spt'),
            'no_sppd': $('#edit_modal').find('#no_sppd'),
        }

        var dataRole = {}
        var dataIzin = {}
        var currentUser = <?= json_encode([
                                'level' => $curUser['level'],
                                'id_seksi' => $curUser['id_seksi'],
                                'id_bagian' => $curUser['id_bagian'],
                                'id_satuan' => $curUser['id_satuan'],
                                'id' => $curUser['id'],
                            ]) ?>;
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

        toolbar.form.on('submit', (e) => {
            getAllPermohonan();
        });
        toolbar.status_rekap.on('change', (e) => {
            getAllPermohonan();
        });
        toolbar.status_lpd.on('change', (e) => {
            getAllPermohonan();
        });

        toolbar.id_satuan.on('change', (e) => {
            getAllPermohonan();
        });

        function getAllPermohonan() {
            Swal.fire({
                title: 'Loading SPT!',
                allowOutsideClick: false,
            });
            Swal.showLoading()
            return $.ajax({
                url: `<?php echo site_url('rekap/getAllSPT/') ?>`,
                'type': 'get',
                data: toolbar.form.serialize(),
                success: function(data) {
                    Swal.close();
                    var json = JSON.parse(data);
                    if (json['error']) {
                        return;
                    }
                    dataIzin = json['data'];
                    renderSKP(dataIzin);
                },
                error: function(e) {}
            });
        }

        function renderSKP(data) {
            if (data == null || typeof data != "object") {
                console.log("Sppd::UNKNOWN DATA");
                return;
            }
            var i = 0;

            var renderData = [];
            curUser = <?= $this->session->userdata()['id'] ?>;
            curLevel = <?= $this->session->userdata()['level'] ?>;
            curSatuan = <?= $this->session->userdata()['id_satuan'] ?>;
            bagian = <?= $this->session->userdata()['id_bagian'] ? $this->session->userdata()['id_bagian']  : "''" ?>;
            seksi = <?= $this->session->userdata()['id_seksi'] ? $this->session->userdata()['id_seksi']  : "''" ?>;
            Object.values(data).forEach((d) => {
                var aksiBtn = '';

                i = 1;
                d1 = '';
                d2 = '';
                tmpt = '';
                Object.values(d['tujuan']).forEach((tj) => {
                    if (i == 1) {
                        d1 = tj['date_berangkat'];
                        tmpt = tmpt + '1. ' + tj['tempat_tujuan'];
                    } else {
                        tmpt = tmpt + '<br>' + i + '. ' + tj['tempat_tujuan'];

                    }
                    d2 = tj['date_kembali'];

                    i++;
                })
                if (d['jenis'] == 2) {
                    // tmpt = tmpt + '<br>No SPT : ' + (d['no_spt'] ? d['no_spt'] : '') + '<br>No SPPD : ' + (d['no_sppd'] ? d['no_sppd'] : '');
                } else {
                    // tmpt = tmpt + '<br>No SPT : ' + (d['no_spt'] ? d['no_spt'] : '');

                }
                pegawai = d['nama_pelaksana'];
                i = 1;
                if (d['pengikut'] == null || typeof d['pengikut'] != "object") {

                } else {
                    Object.values(d['pengikut']).forEach((p) => {
                        if (i == 1)
                            pegawai = pegawai + '<br> Pengikut : ';
                        pegawai = pegawai + '<br>' + i + '. ' + p['nama'];
                        // d2 = tj['date_kembali']
                        i++;
                    })
                }

                if (d1.split(" ")[0] != d1.split(" ")[0])
                    dfix = tgl_indo(d1.split(" ")[0]) + ' s.d ' + tgl_indo(d2.split(" ")[0]);
                else
                    dfix = tgl_indo(d1.split(" ")[0]);
                lihatButton = `
                <?php
                if ($dataContent['edit_spt']) {
                    echo "<a class='form_edit dropdown-item' target='_blank' style='width: 110px' data-jenis='SuratIzin' data-id='$" . "{d['id_spt']}'><i class='fa fa-pencil'></i> Edit </a>";
                    echo "<a class='delete_adm dropdown-item' target='_blank' style='width: 110px' data-jenis='SuratIzin' data-id='$" . "{d['id_spt']}'><i class='fa fa-pencil'></i> Hapus </a>";
                }
                ?>
                         <a class="dropdown-item" target="_blank" style="width: 110px" href='<?= base_url() ?>spt/detail/${d['id_spt']}'><i class='fa fa-eye'></i> Lihat </a>
                 `;

                var aksiBtn = `
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

                renderData.push([d['rjs'],
                    tgl_indo(d['tgl_pengajuan']),
                    dfix,
                    // tgl_indo(d['periode_end']),
                    // d['periode_start'] + (d['periode_start'] == d['periode_end'] ? '' : ' s.d. ' + d['periode_end']),
                    tmpt,
                    // d['maksud'],
                    d['nama_satuan'],
                    pegawai,
                    d['no_spt'],
                    d['no_sppd'],
                    d['maksud'],
                    d['id_laporan'] == null ? "<i class='fa fa-times text-danger'></i><b class='text-danger'>Belum</b>" : "<i class='fa fa-check text-success'></i><b class='text-success'>Sudah</b>",
                    statusSPT(d['status'], d['unapprove_oleh']), d['id_spt'], button
                ]);
            });
            FDataTable.clear().rows.add(renderData).draw('full-hold');
        };

        function tgl_indo(tgl) {
            tgl2 = tgl.split(' ');
            ex_tgl = tgl2[0].split('-');
            var bulan = ['', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
            return ex_tgl[2] + ' ' + bulan[parseInt(ex_tgl[1])] + ' ' + ex_tgl[0]
        }

        <?php if ($dataContent['edit_spt']) { ?>
            FDataTable.on('click', '.form_edit', function() {
                curData = dataIzin[$(this).data('id')];
                console.log(curData);
                EditModal.self.modal('show');
                $('#edit_modal').modal('show');
                EditModal.idSuratIzin.val(curData['id_spt']);
                EditModal.tgl_pengajuan.val(curData['tgl_pengajuan']);
                EditModal.no_spt.val(curData['no_spt']);
                EditModal.no_sppd.val(curData['no_sppd']);

                lampHtml = `
                             <div class="col-lg-12">
                            </div>`
                EditModal.layout_lampiran.html(lampHtml);


            });

            EditModal.saveEditBtn.on('click', function(event) {
                event.preventDefault();
                var url = "<?= site_url('Spt/action_edit/') ?>";
                Swal.fire(swalSaveConfigure).then((result) => {
                    if (!result.value) {
                        return;
                    }

                    $.ajax({
                        url: url,
                        'type': 'POST',
                        // data: EditModal.form.serialize(),
                        data: new FormData(EditModal.form[0]),
                        contentType: false,
                        processData: false,
                        success: function(data) {
                            // buttonIdle(button);
                            var json = JSON.parse(data);
                            if (json['error']) {
                                Swal.fire("Simpan Gagal", json['message'], "error");
                                return;
                            }
                            var d = json['data']
                            dataIzin[d['id_spt']] = d;
                            Swal.fire("Simpan Berhasil", "", "success");
                            renderSKP(dataIzin);
                            EditModal.self.modal('hide');
                        },
                        error: function(e) {}
                    });
                });
            });

            FDataTable.on('click', '.delete_adm', function() {
                curData = $(this).data('id');
                Swal.fire(swalDeleteConfigure).then((result) => {
                    if (!result.value) {
                        return;
                    }

                    $.ajax({
                        url: '<?= base_url() ?>/Spt/delete_adm',
                        'type': 'POST',
                        // data: EditModal.form.serialize(),
                        data: {
                            id_spt: curData
                        },
                        success: function(data) {
                            // buttonIdle(button);
                            var json = JSON.parse(data);
                            if (json['error']) {
                                Swal.fire("Delete Gagal", json['message'], "error");
                                return;
                            }
                            delete dataIzin[curData];
                            Swal.fire("Delete Berhasil", "", "success");
                            renderSKP(dataIzin);
                            EditModal.self.modal('hide');
                        },
                        error: function(e) {}
                    });
                });
            });

        <?php } ?>


    });
</script>