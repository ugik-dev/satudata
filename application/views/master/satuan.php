<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-header">

                    <form class="form-inline" id="toolbar_form" onsubmit="return false;">
                        <!-- <div class="col-lg-2"> -->
                        <input type="hidden" id="is_not_self" name="is_not_self" value="1">
                        <!-- </div> -->
                        <div class="col-lg-2" hidden>
                            <select class="form-control mr-sm-2" name="no_tlp" id="no_tlp"></select>
                        </div>
                        <button type="button" class="btn btn-primary my-1 mr-sm-2" id="new_btn" disabled="disabled"><i class="fa fa-plus"></i> Tambah Satuan Baru</button>
                    </form>
                </div>

                <div class="card-body">
                    <!-- <div class="col-lg-12"> -->
                    <!-- <div class="ibox"> -->
                    <!-- <div class="ibox-content"> -->
                    <div class="table-responsive">
                        <table id="FDataTable" class="table table-bordered table-hover" style="padding:0px">
                            <thead>
                                <tr>
                                    <th style="width: 7%; text-align:center!important">ID</th>
                                    <th style="width: 24%; text-align:center!important">Satuanname</th>
                                    <th style="width: 24%; text-align:center!important">Nama</th>
                                    <th style="width: 16%; text-align:center!important">Role</th>
                                    <th style="width: 5%; text-align:center!important">Aksi</th>
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

<div class="modal fade" id="satuan_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form opd="form" id="satuan_form" onsubmit="return false;" type="multipart" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_title">
                        Form Unit
                    </h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id_satuan" name="id_satuan">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="nama_satuan">Nama Satuan</label>
                                <input type="text" placeholder="ex. Dinas Kesehatan" class="form-control" id="nama_satuan" name="nama_satuan" required="required">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="nama_satuan2">Nama Satuan (SKPD)</label>
                                <input type="text" placeholder="ex. Dinas Kesehatan Kab.Bangka" class="form-control" id="nama_satuan2" name="nama_satuan2">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="nama_dinas">Nama Dinas</label>
                                <input type="text" placeholder="ex. Dinas Kesehatan Kab.Bangka" class="form-control" id="nama_dinas" name="nama_dinas" required="required">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="alamat">Alamat Singkat</label>
                                <input type="alamat" placeholder="ex. Sungailiat" class="form-control" id="alamat" name="alamat">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="alamat_lengkap">Alamat Lengkap</label>
                                <input type="text" placeholder="ex. Jl. Jend Sudirman - Sungailiat" class="form-control" id="alamat_lengkap" name="alamat_lengkap" required="required">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="kode_pos">Kode Pos</label>
                                <input type="text" placeholder="" class="form-control" id="kode_pos" name="kode_pos">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="kode_pos">Email</label>
                                <input type="text" placeholder="" class="form-control" id="email" name="email">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="kode_pos">Website</label>
                                <input type="text" placeholder="" class="form-control" id="website" name="website">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="no_tlp">No Telp</label>
                                <input type="text" placeholder="" class="form-control" id="no_tlp" name="no_tlp">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="kode_surat">Kode Surat</label>
                                <input type="text" placeholder="" class="form-control" id="kode_surat" name="kode_surat">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="ktrngn">Keterangan</label>
                                <input type="text" placeholder="" class="form-control" id="ktrngn" name="ktrngn">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button class="btn btn-primary" type="submit" id="add_btn" data-loading-text="Loading..."><strong>Tambah Satuan</strong></button>
                        <button class="btn btn-primary" type="submit" id="save_edit_btn" data-loading-text="Loading..."><strong>Simpan Satuan</strong></button>
                    </div>
            </form>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('#menu_1').addClass('active');
        $('#opmenu_1').show();
        $('#submenu_3').addClass('active');
        var toolbar = {
            'form': $('#toolbar_form'),
            'no_tlp': $('#toolbar_form').find('#no_tlp'),
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

        var SatuanModal = {
            'self': $('#satuan_modal'),
            'info': $('#satuan_modal').find('.info'),
            'form': $('#satuan_modal').find('#satuan_form'),
            'addBtn': $('#satuan_modal').find('#add_btn'),
            'saveEditBtn': $('#satuan_modal').find('#save_edit_btn'),
            'idSatuan': $('#satuan_modal').find('#id_satuan'),
            'nama_satuan': $('#satuan_modal').find('#nama_satuan'),
            'nama_satuan2': $('#satuan_modal').find('#nama_satuan2'),
            'nama_dinas': $('#satuan_modal').find('#nama_dinas'),
            'nama': $('#satuan_modal').find('#nama'),
            'website': $('#satuan_modal').find('#website'),
            'alamat': $('#satuan_modal').find('#alamat'),
            'alamat_lengkap': $('#satuan_modal').find('#alamat_lengkap'),
            'email': $('#satuan_modal').find('#email'),
            'kode_pos': $('#satuan_modal').find('#kode_pos'),
            'kode_surat': $('#satuan_modal').find('#kode_surat'),
            'ktrngn': $('#satuan_modal').find('#ktrngn'),
            'no_tlp': $('#satuan_modal').find('#no_tlp'),
        }

        var dataRole = {}
        var dataSatuan = {}

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

        $.when(getAllSatuan()).then((e) => {
            toolbar.newBtn.prop('disabled', false);
        }).fail((e) => {
            console.log(e)
        });



        function getAllSatuan() {
            Swal.fire({
                title: 'Loading Satuan / Unit!',
                allowOutsideClick: false,
            });
            Swal.showLoading()
            return $.ajax({
                url: `<?php echo site_url('General/getAllSatuan/') ?>`,
                'type': 'POST',
                data: toolbar.form.serialize(),
                success: function(data) {
                    Swal.close();
                    var json = JSON.parse(data);
                    if (json['error']) {
                        return;
                    }
                    dataSatuan = json['data'];
                    renderSatuan(dataSatuan);
                },
                error: function(e) {}
            });
        }

        function renderSatuan(data) {
            if (data == null || typeof data != "object") {
                console.log("Satuan::UNKNOWN DATA");
                return;
            }
            var i = 0;

            var renderData = [];
            Object.values(data).forEach((satuan) => {
                var editButton = `
        <a class="edit dropdown-item" data-id='${satuan['id_satuan']}'><i class='fa fa-pencil'></i> Edit Satuan</a>
      `;
                var deleteButton = `
        <a class="delete dropdown-item" data-id='${satuan['id_satuan']}'><i class='fa fa-trash'></i> Hapus Satuan</a>
      `;
                var button = `
            ${editButton}
            ${deleteButton}
            `;
                //     </div>
                //   </div>
                renderData.push([satuan['id_satuan'], satuan['nama_satuan'], satuan['nama_satuan2'], satuan['nama_dinas'], button]);
            });
            FDataTable.clear().rows.add(renderData).draw('full-hold');
        }

        function resetSatuanModal() {
            SatuanModal.form.trigger('reset');
            // SatuanModal.no_tlp.val(toolbar.no_tlp.val());
            // SatuanModal.alamat.val("");
            // SatuanModal.alamat_lengkap.val("");
            // SatuanModal.nama_satuan2.val("");
        }

        toolbar.newBtn.on('click', (e) => {
            resetSatuanModal();
            SatuanModal.self.modal('show');
            SatuanModal.addBtn.show();
            SatuanModal.saveEditBtn.hide();
        });

        FDataTable.on('click', '.edit', function() {
            resetSatuanModal();
            SatuanModal.self.modal('show');
            SatuanModal.addBtn.hide();
            SatuanModal.saveEditBtn.show();
            var currentData = dataSatuan[$(this).data('id')];
            SatuanModal.idSatuan.val(currentData['id_satuan']);
            SatuanModal.alamat.val(currentData['alamat']);
            SatuanModal.alamat_lengkap.val(currentData['alamat_lengkap']);
            SatuanModal.nama_satuan.val(currentData['nama_satuan']);
            SatuanModal.nama_satuan2.val(currentData['nama_satuan2']);
            SatuanModal.nama_dinas.val(currentData['nama_dinas']);
            SatuanModal.nama.val(currentData['nama']);
            SatuanModal.email.val(currentData['email']);
            SatuanModal.kode_pos.val(currentData['kode_pos']);
            SatuanModal.kode_surat.val(currentData['kode_surat']);
            SatuanModal.no_tlp.val(currentData['no_tlp']);
            SatuanModal.website.val(currentData['website']);
            SatuanModal.ktrngn.val(currentData['ktrngn']);
        });

        SatuanModal.form.submit(function(event) {
            event.preventDefault();
            var isAdd = SatuanModal.addBtn.is(':visible');
            var url = "<?= site_url('SatuanController/') ?>";
            url += isAdd ? "addSatuan" : "editSatuan";
            var button = isAdd ? SatuanModal.addBtn : SatuanModal.saveEditBtn;

            Swal.fire(swalSaveConfigure).then((result) => {
                if (!result.value) {
                    return;
                }
                buttonLoading(button);
                $.ajax({
                    url: url,
                    'type': 'POST',
                    data: SatuanModal.form.serialize(),
                    success: function(data) {
                        buttonIdle(button);
                        var json = JSON.parse(data);
                        if (json['error']) {
                            Swal.fire("Simpan Gagal", json['message'], "error");
                            return;
                        }
                        var satuan = json['data']
                        dataSatuan[satuan['id_satuan']] = satuan;
                        Swal.fire("Simpan Berhasil", "", "success");
                        renderSatuan(dataSatuan);
                        SatuanModal.self.modal('hide');
                    },
                    error: function(e) {}
                });
            });
        });

        FDataTable.on('click', '.delete', function() {
            event.preventDefault();
            var id = $(this).data('id');
            Swal.fire(swalDeleteConfigure).then((result) => {
                if (!result.value) {
                    return;
                }
                $.ajax({
                    url: "<?= site_url('SatuanController/deleteSatuan') ?>",
                    'type': 'POST',
                    data: {
                        'id_satuan': id
                    },
                    success: function(data) {
                        var json = JSON.parse(data);
                        if (json['error']) {
                            Swal.fire("Delete Gagal", json['message'], "error");
                            return;
                        }
                        delete dataSatuan[id];
                        Swal.fire("Delete Berhasil", "", "success");
                        renderSatuan(dataSatuan);
                    },
                    error: function(e) {}
                });
            });
        });
    });
</script>