<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-header">

                    <form class="form-inline" id="toolbar_form" onsubmit="return false;">
                        <!-- <div class="col-lg-2"> -->
                        <input type="hidden" id="is_not_self" name="is_not_self" value="1">
                        <input type="hidden" id="id_pegawai" name="id_pegawai" value="<?= $this->session->userdata('id') ?>">
                        <!-- </div> -->
                        <!-- <div class="col-lg-2">
                            <select class="form-control mr-sm-2" name="tool_id_role" id="tool_id_role"></select>
                        </div> -->
                        <a type="button" class="btn btn-success my-1 mr-sm-2" href="<?= base_url('surat-izin/add') ?>" id="new_btn" disabled="disabled"><i class="fa fa-plus"></i> Tambah </a>
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
                                    <th style="width: 10%; text-align:center!important">PELIMPAHAN</th>
                                    <th style="width: 10%; text-align:center!important">PENILAI</th>
                                    <th style="width: 10%; text-align:center!important">JENIS</th>
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
<script>
    $(document).ready(function() {
        $('#sidebar_surat_izin').addClass('active_c');
        var toolbar = {
            'form': $('#toolbar_form'),
            'id_role': $('#toolbar_form').find('#id_role'),
            'id_pegawai': $('#toolbar_form').find('#id_pegawai'),
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
                title: 'Loading Surat Izin!',
                allowOutsideClick: false,
            });
            Swal.showLoading()
            return $.ajax({
                url: `<?php echo site_url('surat-izin/getAll/') ?>`,
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
            Object.values(data).forEach((d) => {
                var editButton = `
                    <a class="dropdown-item"  href='<?= base_url() ?>surat-izin/edit/${d['id_surat_izin']}'><i class='fa fa-pencil'></i> Edit</a>
                  `;
                var deleteButton = `
                    <a class="delete dropdown-item" data-id='${d['id_surat_izin']}'><i class='fa fa-trash'></i> Hapus</a>
                  `;
                console.log(d['status']);
                if (d['status'] == 2) {
                    var deleteButton = '';
                    var editButton = '';
                    var lihatButton = `
                    <a class="dropdown-item" target="_blank" style="width: 110px" href='<?= base_url() ?>surat-izin/print/${d['id_surat_izin']}'><i class='fa fa-eye'></i> Cetak </a>
                    <a class="dropdown-item" target="_blank" style="width: 110px" href='<?= base_url() ?>surat-izin/print/${d['id_surat_izin']}/barcode'><i class='fa fa-eye'></i> Cetak + Barcode </a>
                `;
                } else {
                    //     var aksiBtn = `
                    //   <a class="dropdown-item ajukan_approv" style="width: 110px" data-id='${surat-izin['id_surat_izin']}'><i class='fa fa-eye'></i> Ajukan Approv </a>
                    //      `;
                    var lihatButton = `
                        <a class="dropdown-item" target="_blank" style="width: 110px" href='<?= base_url() ?>surat-izin/print/${d['id_surat_izin']}'><i class='fa fa-eye'></i> Lihat </a>
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
                                    ${editButton}
                                    ${deleteButton}
                                    ${lihatButton}
                                    </div>
                                </div>
                            </div>
                        </div>`;
                tujuan = '';
                i = 1;

                renderData.push([d['id_surat_izin'], d['periode_start'] + (d['periode_start'] == d['periode_end'] ? '' : ' s.d. ' + d['periode_end']), d['nama_pengganti'], d['nama_izin'], statusIzin(d['status_izin'], d['unapprove']), button]);
            });
            FDataTable.clear().rows.add(renderData).draw('full-hold');
        }

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
                    url: "<?= site_url('surat-izin/delete') ?>",
                    'type': 'get',
                    data: {
                        'id_surat_izin': id
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