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
                            <select class="form-control " name="status" id="status">
                                <option value="0"> Menunggu </option>
                                <option value="1"> Approv </option>
                                <option value="2"> Ditolak </option>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <select class="form-control mr-sm-2" name="jenis" id="jenis">
                                <option value=""> Semua Permohonan </option>
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
                                    <th style="width: 2%; text-align:center!important">ID</th>
                                    <th style="width: 10%; text-align:center!important">TANGGAL</th>
                                    <th style="width: 10%; text-align:center!important">PENILAI</th>
                                    <th style="width: 10%; text-align:center!important">JUMLAH KEGIATAN</th>
                                    <th style="width: 5%; text-align:center!important">STATUS</th>
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
        $('#sidebar_skp').addClass('active_c');

        var toolbar = {
            'form': $('#toolbar_form'),
            'id_role': $('#toolbar_form').find('#id_role'),
            'id_opd': $('#toolbar_form').find('#id_opd'),
            'newBtn': $('#new_btn'),
        }

        var FDataTable = $('#FDataTable').DataTable({
            'columnDefs': [],
            deferRender: true,
            "order": [
                [0, "desc"]
            ]
        });

        var dataRole = {}
        var dataSKP = {}

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



        toolbar.id_role.on('change', (e) => {
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
                'type': 'POST',
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
            Object.values(data).forEach((skp) => {
                var aksiBtn = '';
                if (skp['status'] == 1) {
                    var aksiBtn = `
                    <a class="approv dropdown-item"  data-id='${skp['id_skp']}' ><i class='fa fa-check'></i> Approv</a>
                    <a class="deapprov dropdown-item "  data-id='${skp['id_skp']}' ><i class='fa fa-times'></i> Tolak Approv</a>
                    `;
                } else if (skp['status'] == 2 || skp['status'] == 3) {
                    var aksiBtn = `
                    <a class="batal_aksi dropdown-item"  data-id='${skp['id_skp']}' ><i class='fa fa-check'></i> Batal Aksi</a>
                    `;
                }
                var aprvButton = `
                  `;
                var deaprvButton = `
                  `;
                var lihatButton = `
                    <a class="dropdown-item" style="width: 110px" href='<?= base_url() ?>skp/print/${skp['id_skp']}'><i class='fa fa-eye'></i> Lihat </a>
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
                console.log(button)
                i = 1;
                renderData.push([skp['id_skp'], skp['periode_start'] + ' s.d ' + skp['periode_end'], skp['nama_pengaju'], skp['skp'], statusSKP(skp['status']), button]);
            });
            FDataTable.clear().rows.add(renderData).draw('full-hold');
        }

        FDataTable.on('click', '.approv', function() {
            var currentData = dataSKP[$(this).data('id')];
            swal({
                title: "Konfrirmasi Approv SKP ?",
                text: currentData['nama_pengaju'],
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
                if (!result) {
                    return;
                }
                Swal.fire({
                    title: 'Loading Approv!',
                    allowOutsideClick: false,
                });
                Swal.showLoading()
                $.ajax({
                    url: '<?= base_url('permohonan/approv_data') ?>',
                    'type': 'get',
                    data: {
                        id: $(this).data('id')
                    },
                    success: function(data) {

                        Swal.close();

                        // buttonIdle(button);
                        var json = JSON.parse(data);
                        if (json['error']) {
                            swal("Simpan Gagal", json['message'], "error");
                            return;
                        }
                        var d = json['data']
                        dataSKP[d['id_skp']] = d;
                        swal("Approv Berhasil", "", "success");
                        renderSKP(dataSKP);
                    },
                    error: function(e) {}
                });
            });
        })

        FDataTable.on('click', '.deapprov', function() {
            var currentData = dataSKP[$(this).data('id')];
            swal({
                title: "Konfrirmasi Tolak Approv SKP ?",
                text: currentData['nama_pengaju'],
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
                if (!result) {
                    return;
                }
                Swal.fire({
                    title: 'Loading Tolak Approv!',
                    allowOutsideClick: false,
                });
                Swal.showLoading()
                $.ajax({
                    url: '<?= base_url('permohonan/aksi_skp') ?>',
                    'type': 'get',
                    data: {
                        id: $(this).data('id'),
                        aksi: 3
                    },
                    success: function(data) {

                        Swal.close();

                        // buttonIdle(button);
                        var json = JSON.parse(data);
                        if (json['error']) {
                            swal("Tolak Gagal", json['message'], "error");
                            return;
                        }
                        var d = json['data']
                        dataSKP[d['id_skp']] = d;
                        swal("SKP Berhasil ditolak", "", "success");
                        renderSKP(dataSKP);
                    },
                    error: function(e) {}
                });
            });
        })

        FDataTable.on('click', '.batal_aksi', function() {
            var currentData = dataSKP[$(this).data('id')];
            swal({
                title: "Konfrirmasi Pembatalan ?",
                text: currentData['nama_pengaju'],
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
                if (!result) {
                    return;
                }
                Swal.fire({
                    title: 'Loading Pembatalan!',
                    allowOutsideClick: false,
                });
                Swal.showLoading()
                $.ajax({
                    url: '<?= base_url('permohonan/aksi_skp') ?>',
                    'type': 'get',
                    data: {
                        id: $(this).data('id'),
                        aksi: 1
                    },
                    success: function(data) {

                        Swal.close();

                        // buttonIdle(button);
                        var json = JSON.parse(data);
                        if (json['error']) {
                            swal("Pembatalan Gagal", json['message'], "error");
                            return;
                        }
                        var d = json['data']
                        dataSKP[d['id_skp']] = d;
                        swal("Pembatalan Berhasil", "", "success");
                        renderSKP(dataSKP);
                    },
                    error: function(e) {}
                });
            });
        })
    });
</script>