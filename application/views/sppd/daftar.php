<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-header">

                    <form class="form-inline" id="toolbar_form" onsubmit="return false;">
                        <!-- <div class="col-lg-2"> -->
                        <input type="hidden" id="is_not_self" name="is_not_self" value="1">
                        <!-- </div> -->
                        <div class="col-lg-2">
                            <select class="form-control mr-sm-2" name="tool_id_role" id="tool_id_role"></select>
                        </div>
                        <button type="button" class="btn btn-success my-1 mr-sm-2" id="new_btn" disabled="disabled"><i class="fal fa-plus"></i> Tambah Sppd Baru</button>
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
                                    <th style="width: 10%; text-align:center!important">NO SPT</th>
                                    <th style="width: 10%; text-align:center!important">NO SPPD</th>
                                    <th style="width: 24%; text-align:center!important">PEGAWAI</th>
                                    <th style="width: 10%; text-align:center!important">TUJUAN</th>
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
            'id_bidang': $('#sppd_modal').find('#id_bidang'),
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
                url: `<?php echo site_url('Sppd/getAllSppd/') ?>`,
                'type': 'POST',
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
                var editButton = `
        <a class="dropdown-item"  href='<?= base_url() ?>sppd/edit/${sppd['id_spd']}'><i class='fa fa-pencil'></i> Edit Sppd</a>
      `;
                var lihatButton = `
        <a class="dropdown-item" href='<?= base_url() ?>sppd/detail/${sppd['id_spd']}'><i class='fa fa-eye'></i> Lihat Detail</a>
      `;
                var deleteButton = `
        <a class="delete dropdown-item" data-id='${sppd['id']}'><i class='fa fa-trash'></i> Hapus Sppd</a>
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
                Object.values(sppd['tujuan']).forEach((tj) => {
                    if (i == 1)
                        tujuan += '1. ' + tj['tempat_tujuan'] + ' (' + tj['date_berangkat'] + ')';
                    else
                        tujuan += '<br>' + i + '. ' + tj['tempat_tujuan'] + ' (' + tj['date_berangkat'] + ')';
                    i++;

                })
                renderData.push([sppd['id_spd'], sppd['no_sppd'], sppd['no_spt'], sppd['nama_pegawai'], tujuan, button]);
            });
            FDataTable.clear().rows.add(renderData).draw('full-hold');
        }

        FDataTable.on('click', '.delete', function() {
            event.preventDefault();
            var id = $(this).data('id');
            swal(swalDeleteConfigure).then((result) => {
                if (!result.value) {
                    return;
                }
                $.ajax({
                    url: "<?= site_url('SppdController/deleteSppd') ?>",
                    'type': 'POST',
                    data: {
                        'id': id
                    },
                    success: function(data) {
                        var json = JSON.parse(data);
                        if (json['error']) {
                            swal("Delete Gagal", json['message'], "error");
                            return;
                        }
                        delete dataSppd[id];
                        swal("Delete Berhasil", "", "success");
                        renderSppd(dataSppd);
                    },
                    error: function(e) {}
                });
            });
        });
    });
</script>