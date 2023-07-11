<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-header">

                    <form class="form-inline" id="toolbar_form" onsubmit="return false;">
                        <!-- <div class="col-lg-2"> -->
                        <input type="hidden" id="is_not_self" name="is_not_self" value="1">
                        <!-- </div> -->
                        <!-- <div class="col-lg-2">
                            <select class="form-control mr-sm-2" name="tool_id_role" id="tool_id_role"></select>
                        </div> -->
                        <a type="button" class="btn btn-success my-1 mr-sm-2" href="<?= base_url('cuti/add') ?>" id="new_btn" disabled="disabled"><i class="fa fa-plus"></i> Tambah </a>
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
                                    <th style="width: 10%; text-align:center!important">STATUS</th>
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


<div class="modal fade" id="riwayat_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form opd="form" id="" onsubmit="return false;" type="multipart" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_title">
                        Riwayat Approval
                    </h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6" id="status_izin"> </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="col-lg-12" id="layer_riwayat">
                    </div>
                    <table id="TableRiwayat" class="table table-border-horizontal" style="padding-bottom: 100px">
                        <thead>
                            <tr>
                                <th style="width: 5%; text-align:center!important">Waktu</th>
                                <th style="width: 10%; text-align:center!important">Keterangan</th>
                                <th style="width: 10%; text-align:center!important">Nama</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
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
        $('#sidebar_cuti').addClass('active_c');

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
        var TableRiwayat = $("#TableRiwayat").DataTable({
            columnDefs: [],
            responsive: false,
            deferRender: true,
            order: false,
        });

        var RiwayatModal = {
            self: $("#riwayat_modal"),
            layer_riwayat: $("#riwayat_modal").find("#layer_riwayat"),
        };
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
                url: `<?php echo site_url('cuti/getAllSKP/') ?>`,
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
            Object.values(data).forEach((cuti) => {
                var editButton = `
                    <a class="dropdown-item"  href='<?= base_url() ?>cuti/edit/${cuti['id_cuti']}'><i class='fa fa-pencil'></i> Edit</a>
                  `;
                var deleteButton = `
                    <a class="delete dropdown-item" data-id='${cuti['id_cuti']}'><i class='fa fa-trash'></i> Hapus</a>
                  `;
                var aksiBtn = `
                  <a class="dropdown-item ajukan_approv" style="width: 110px" data-id='${cuti['id_cuti']}'><i class='fa fa-eye'></i> Ajukan Approv </a>
                     `;
                console.log(cuti['status']);
                if (cuti['status'] == 2) {
                    var deleteButton = '';
                    var editButton = '';
                    var aksiBtn = '';
                    var lihatButton = `
                    <a class="dropdown-item" target="_blank" style="width: 110px" href='<?= base_url() ?>cuti/print/${cuti['id_cuti']}'><i class='fa fa-eye'></i> Cetak </a>
                    <a class="dropdown-item" target="_blank" style="width: 110px" href='<?= base_url() ?>cuti/print/${cuti['id_cuti']}/barcode'><i class='fa fa-eye'></i> Cetak + Barcode </a>
                `;
                } else {
                    //     var aksiBtn = `
                    //   <a class="dropdown-item ajukan_approv" style="width: 110px" data-id='${cuti['id_cuti']}'><i class='fa fa-eye'></i> Ajukan Approv </a>
                    //      `;
                    var lihatButton = `
                        <a class="dropdown-item" target="_blank" style="width: 110px" href='<?= base_url() ?>cuti/print/${cuti['id_cuti']}'><i class='fa fa-eye'></i> Lihat </a>
                    `;
                }
                var button = `
                           <div class="dropdown-basic">
                            <div class="dropdown">
                                <div class="btn-group mb-1">
                                    <button class="dropbtn btn-square btn-sm btn-primary" style="width : 120px"  type="button">
                                        Aksi
                                        <span><i class="icofont icofont-arrow-down"> </i></span>
                                    </button>
                                    <div class="dropdown-content">
                                    <a class="riwayat_approval dropdown-item"  data-jenis='SuratIzin' data-id='${d['id_surat_izin']}' ><i class='fa fa-eye'></i> Riwayat Approval</a>
                                    ${editButton}
                                    ${aksiBtn}
                                    ${deleteButton}
                                    ${lihatButton}
                                    </div>
                                </div>
                            </div>
                        </div>`;
                tujuan = '';
                i = 1;

                renderData.push([cuti['id_cuti'], cuti['periode_start'], cuti['nama_penilai'], cuti['cuti'], statusSKP(cuti['status']), button]);
            });
            FDataTable.clear().rows.add(renderData).draw('full-hold');
        }

        FDataTable.on('click', '.ajukan_approv', function() {
            var currentData = dataSKP[$(this).data('id')];
            Swal.fire({
                title: "Konfrirmasi",
                text: "Akan mengajukan approval data ini ?",
                icon: "warning",
                allowOutsideClick: false,
                showCancelButton: true,
                buttons: {
                    cancel: 'Batal !!',
                    catch: {
                        text: "Ya, Ajukan !!",
                        value: true,
                    },
                },
            }).then((result) => {
                if (!result.isConfirmed) {
                    return;
                }
                $.ajax({
                    url: '<?= base_url('cuti/ajukan_approv') ?>',
                    'type': 'get',
                    data: {
                        id: $(this).data('id')
                    },
                    success: function(data) {
                        Swal.fire({
                            title: 'Loading Approv!',
                            allowOutsideClick: false,
                        });
                        Swal.showLoading()
                        // buttonIdle(button);
                        Swal.close();
                        var json = JSON.parse(data);
                        if (json['error']) {
                            Swal.fire("Simpan Gagal", json['message'], "error");
                            return;
                        }
                        var user = json['data']
                        dataSKP[user['id_cuti']] = user;
                        Swal.fire("Simpan Berhasil", "", "success");
                        renderSKP(dataSKP);
                        // UserModal.self.modal('hide');
                    },
                    error: function(e) {}
                });
            });
        })

        FDataTable.on("click", ".riwayat_approval", function() {
            var jenis = $(this).data("jenis");
            var link = $(this).data("link");

            Swal.fire({
                title: "Loading!",
                allowOutsideClick: false,
            });
            Swal.showLoading();
            cur_id = $(this).data("id");
            $.ajax({
                url: `<?= base_url() ?>SuratIzin/riwayat_approval/${cur_id}`,
                type: "get",
                data: {
                    jenis: jenis,
                },
                success: function(data) {
                    Swal.close();
                    // buttonIdle(button);
                    var json = JSON.parse(data);
                    if (json["error"]) {
                        Swal.fire("Simpan Gagal", json["message"], "error");
                        return;
                    }

                    var dat = json["data"];
                    var dataRiwayat = [];
                    RiwayatModal.self.modal("show");
                    RiwayatModal.layer_riwayat.html("");
                    var htmlRiwayat = "";
                    Object.values(dat).forEach((d) => {
                        htmlRiwayat += d["nama"] + " " + d["time_logs"] + "<br>";
                        dataRiwayat.push([d["time_logs"], d["deskripsi"], d["nama"]]);
                    });
                    TableRiwayat.clear().rows.add(dataRiwayat).draw("full-hold");
                    // console.log(htmlRiwayat)
                    // RiwayatModal.layer_riwayat.html(htmlRiwayat)

                    // if (jenis == 'spt')
                    //     dataSKP[jenis][d['id_spt']] = d;
                    // else if (jenis == 'SuratIzin')
                    //     dataSKP['surat_izin'][d['id_surat_izin']] = d;
                    // Swal.fire("Approv Berhasil", "", "success");
                    // renderSKP(dataSKP);
                },
                error: function(e) {},
            });
        });

        FDataTable.on('click', '.delete', function() {
            event.preventDefault();
            var id = $(this).data('id');
            Swal.fire({
                title: "Apakah anda Yakin?",
                text: "Hapus data!",
                icon: "warning",
                allowOutsideClick: false,
                showCancelButton: true,
                buttons: {
                    cancel: 'Batal !!',
                    catch: {
                        text: "Ya, Saya Hapus !!",
                        value: true,
                    },
                },
            }).then((result) => {
                if (!result.isConfirmed) {
                    return;
                }
                $.ajax({
                    url: "<?= site_url('User/deleteMySKP') ?>",
                    'type': 'get',
                    data: {
                        'id_cuti': id
                    },
                    success: function(data) {
                        var json = JSON.parse(data);
                        if (json['error']) {
                            Swal.fire("Delete Gagal", json['message'], "error");
                            return;
                        }
                        delete dataSKP[id];
                        Swal.fire("Delete Berhasil", "", "success");
                        renderSKP(dataSKP);
                    },
                    error: function(e) {}
                });
            });
        });
    });
</script>