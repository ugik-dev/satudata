<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12 col-lg-12">
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
                                                <input type="hidden" name="sort" value="1">
                                                <label class="col-sm-3 col-form-label">Approval </label>
                                                <div class="col-sm-8">
                                                    <select class="form-control " name="status_rekap" id="status_rekap">
                                                        <option value="" selected> Semua </option>
                                                        <option value="menunggu"> Menunggu </option>
                                                        <option value="ditolak"> Di Tolak </option>
                                                        <option value="selesai"> Diterima </option>
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
                                                    <input class="form-control m-input digits" id="sampai" name="sampai" type="date" value="<?= date("Y-m-d", strtotime("1 months"));  ?>" data-bs-original-title="" title="">
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
                    <!-- <div class="col-lg-12"> -->
                    <!-- <div class="ibox"> -->
                    <!-- <div class="ibox-content"> -->

                    <div class="table-responsive">
                        <table id="FDataTable" class="table table-border-horizontal" style="padding-bottom: 100px">
                            <thead>
                                <tr>
                                    <th style="width: 2%; text-align:center!important">ID</th>
                                    <th style="width: 10%; text-align:center!important">Jenis</th>
                                    <th style="width: 10%; text-align:center!important">INFO</th>
                                    <th style="width: 24%; text-align:center!important">PEGAWAI</th>
                                    <th style="width: 10%; text-align:center!important">TUJUAN</th>
                                    <th style="width: 10%; text-align:center!important">LPD</th>
                                    <th style="width: 10%; text-align:center!important">Status</th>
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
        $('#menu_2').addClass('active');
        $('#opmenu_2').show();
        $('#submenu_5').addClass('active');
        var toolbar = {
            'form': $('#toolbar_form'),
            'id_satuan': $('#toolbar_form').find('#id_satuan'),
            'status_rekap': $('#toolbar_form').find('#status_rekap'),
            'status_lpd': $('#toolbar_form').find('#status_lpd'),
        }

        var FDataTable = $('#FDataTable').DataTable({
            'columnDefs': [],
            responsive: true,
            deferRender: true,
            "order": [
                [0, "desc"]
            ]
        });

        var SppdModal = {
            'self': $('#sppd_modal'),
            'info': $('#sppd_modal').find('.info'),
            'form': $('#sppd_modal').find('#sppd_form'),
            'addBtn': $('#sppd_modal').find('#add_btn'),
            'saveEditBtn': $('#sppd_modal').find('#save_edit_btn'),
            'idSppd': $('#sppd_modal').find('#id'),
            'sppdname': $('#sppd_modal').find('#sppdname'),
            'nama': $('#sppd_modal').find('#nama'),
            'nip': $('#sppd_modal').find('#nip'),
            'email': $('#sppd_modal').find('#email'),
            'no_hp': $('#sppd_modal').find('#no_hp'),
            'status': $('#sppd_modal').find('#status'),
            'password': $('#sppd_modal').find('#password'),
            'jabatan': $('#sppd_modal').find('#jabatan'),
            'pangkat_gol': $('#sppd_modal').find('#pangkat_gol'),
            'id_role': $('#sppd_modal').find('#id_role'),
            'id_bagian': $('#sppd_modal').find('#id_bagian'),
            'id_seksi': $('#sppd_modal').find('#id_seksi'),
            'id_satuan': $('#sppd_modal').find('#id_satuan'),
        }

        var dataRole = {}
        var dataSppd = {}

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
            toolbar.newBtn.prop('disabled', false);
        }).fail((e) => {
            console.log(e)
        });


        toolbar.form.on('submit', (e) => {
            getAllSppd();
        });
        toolbar.status_rekap.on('change', (e) => {
            getAllSppd();
        });
        toolbar.status_lpd.on('change', (e) => {
            getAllSppd();
        });

        // toolbar.id_satuan.on('change', (e) => {
        //     getAllSppd();
        // });

        function getAllSppd() {
            Swal.fire({
                title: 'Loading SPT!',
                allowOutsideClick: false,
            });
            Swal.showLoading()
            return $.ajax({
                url: `<?php echo site_url('Spt/getAllSppd/') ?>`,
                'type': 'get',
                data: toolbar.form.serialize(),
                success: function(data) {
                    Swal.close();
                    var json = JSON.parse(data);
                    if (json['error']) {
                        return;
                    }
                    dataSppd = json['data'];
                    renderSppd(dataSppd);
                },
                error: function(e) {}
            });
        }

        function renderSppd(data) {
            if (data == null || typeof data != "object") {
                console.log("Spt::UNKNOWN DATA");
                return;
            }
            var i = 0;

            var renderData = [];
            Object.values(data).forEach((spt) => {
                var editButton = `
        <a class="dropdown-item"  href='<?= base_url() ?>spt/edit/${spt['id_spt']}'><i class='fa fa-pencil'></i> Edit Spt</a>
      `;
                var lihatButton = `
        <a class="dropdown-item" href='<?= base_url() ?>spt/detail/${spt['id_spt']}'><i class='fa fa-eye'></i> Lihat Detail</a>
      `;
                var deleteButton = `
        <a class="delete dropdown-item" data-id='${spt['id_spt']}'><i class='fa fa-trash'></i> Hapus Spt</a>
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
                                    ${lihatButton}
                                    ${editButton}
                                    ${deleteButton}
                                    </div>
                                </div>
                            </div>
                        </div>`;
                tujuan = '';
                i = 1;
                Object.values(spt['tujuan']).forEach((tj) => {
                    if (i == 1)
                        tujuan += '1. ' + tj['tempat_tujuan'] + ' (' + tj['date_berangkat'] + ')';
                    else
                        tujuan += '<br>' + i + '. ' + tj['tempat_tujuan'] + ' (' + tj['date_berangkat'] + ')';
                    i++;

                })
                i = 2;
                pegawai = '1. ' + spt['pel_nama'];
                Object.values(spt['pengikut']).forEach((p) => {
                    // if (i == 1)
                    //     p += '1. ' + tj['tempat_tujuan'] + ' (' + tj['date_berangkat'] + ')';
                    // else
                    pegawai += '<br>' + i + '. ' + p['p_nama'];
                    i++;

                })
                info = `Petugas : ${spt['nama_input']}<br>
                No SPT : ${ spt['no_spt']?spt['no_spt']:''}<br>
                No SPPD : ${ spt['no_sppd']?spt['no_sppd']:''}
                `;
                renderData.push([spt['id_spt'], spt['nama_ref_jen_spt'], info, pegawai, tujuan, spt['id_laporan'] == null ? "<i class='fa fa-times text-danger'></i><b class='text-danger'>Belum</b>" : "<i class='fa fa-check text-success'></i><b class='text-success'>Sudah</b>", statusSPT(spt['status'], spt['unapprove_oleh']), button]);
            });
            FDataTable.clear().rows.add(renderData).draw('full-hold');
        }

        FDataTable.on('click', '.delete', function() {
            event.preventDefault();
            var id = $(this).data('id');
            Swal.fire(swalDeleteConfigure).then((result) => {
                if (!result.value) {
                    return;
                }
                swalLoading();
                $.ajax({
                    url: "<?= site_url('spt/delete') ?>",
                    'type': 'get',
                    data: {
                        'id_spt': id
                    },
                    success: function(data) {
                        var json = JSON.parse(data);
                        if (json['error']) {
                            Swal.fire("Delete Gagal", json['message'], "error");
                            return;
                        }
                        delete dataSppd[id];
                        Swal.fire("Delete Berhasil", "", "success");
                        renderSppd(dataSppd);
                    },
                    error: function(e) {}
                });
            });
        });
    });
</script>