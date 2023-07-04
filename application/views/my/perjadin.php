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
                        <div class="collapse " id="collapseOne" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <form class="form-inline" id="toolbar_form" onsubmit="return false;">
                                <div class="card-body filter-cards-view animate-chk">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3 row">
                                                <label class="col-sm-3 col-form-label">Status Aproval</label>
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
                                        <div class="col-lg-6">
                                            <div class="mb-3 row">
                                                <label class="col-sm-3 col-form-label">Status LPD</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control " name="status_lpd" id="status_lpd">
                                                        <option value="" selected> Semua </option>
                                                        <option value="belum"> Belum Entri LPD </option>
                                                        <option value="sudah"> Sudah Entri LPD </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3 row">
                                                <?php
                                                $date = new DateTime(date('Y-m-d'));
                                                $date->add(new DateInterval('P2M'));
                                                $date->invert = 1;
                                                ?>
                                                <label class="col-sm-3 col-form-label">Dari</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control m-input digits" id="dari" name="dari" type="date" value="<?= date("Y-m-d", strtotime("-4 months")); ?>" data-bs-original-title="" title="">
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="mb-3 row">
                                                <label class="col-sm-3 col-form-label">Sampai</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control m-input digits" id="sampai" name="sampai" type="date" value="<?= $date->format('Y-m-d') ?>" data-bs-original-title="" title="">
                                                </div>
                                            </div>
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
                                    <th style="width: 2%; text-align:center!important">ID</th>
                                    <th style="width: 10%; text-align:center!important">NO SPT</th>
                                    <th style="width: 10%; text-align:center!important">NO SPPD</th>
                                    <th style="width: 10%; text-align:center!important">TUJUAN</th>
                                    <th style="width: 10%; text-align:center!important">MAKSUD</th>
                                    <th style="width: 24%; text-align:center!important">LPD</th>
                                    <th style="width: 24%; text-align:center!important">STATUS</th>
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
        $('#sidebar_spt_saya').addClass('active');

        var toolbar = {
            'form': $('#toolbar_form'),
        }

        var FDataTable = $('#FDataTable').DataTable({
            'columnDefs': [],
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

        $.when(getAllSppd()).then((e) => {}).fail((e) => {
            console.log(e)
        });



        toolbar.form.on('submit', (e) => {
            getAllSppd();
        });

        function getAllSppd() {
            Swal.fire({
                title: 'Loading!!',
                allowOutsideClick: false,
            });
            Swal.showLoading()
            return $.ajax({
                url: `<?php echo site_url('user/getAllSppd/') ?>`,
                'type': 'GET',
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
                console.log("Sppd::UNKNOWN DATA");
                return;
            }
            var i = 0;

            var renderData = [];
            Object.values(data).forEach((sppd) => {
                var lihatButton = `
        <a class="btn btn-primary btn-sm" style="width: 110px" href='<?= base_url() ?>spt/detail/${sppd['id_spt']}'><i class='fa fa-eye'></i> Buka</a>
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
                                    </div>
                                </div>
                            </div>
                        </div>`;
                tujuan = '';
                i = 1;
                Object.values(sppd['tujuan']).forEach((tj) => {
                    if (i == 1)
                        tujuan += '1. ' + tj['tempat_tujuan'] + ' (' + tj['date_berangkat'] + ')';
                    else
                        tujuan += '<br>' + i + '. ' + tj['tempat_tujuan'] + ' (' + tj['date_berangkat'] + ')';
                    i++;
                })
                renderData.push([sppd['id_spt'], sppd['no_spt'], sppd['no_sppd'], tujuan, sppd['maksud'],
                    sppd['id_laporan'] == null ? "<i class='fa fa-times text-danger'></i><b class='text-danger'>Belum</b>" : "<i class='fa fa-check text-success'></i><b class='text-success'>Sudah</b>",
                    statusSPT(sppd['status'], sppd['unapprove_oleh']),
                    lihatButton
                ]);
            });
            FDataTable.clear().rows.add(renderData).draw('full-hold');
        }


    });
</script>