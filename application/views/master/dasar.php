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
                        <button type="button" class="btn btn-primary my-1 mr-sm-2" id="new_btn" disabled="disabled"><i class="fa fa-plus"></i> Tambah Dasar Baru</button>
                    </form>
                </div>

                <div class="card-body">
                    <!-- <div class="col-lg-12"> -->
                    <!-- <div class="ibox"> -->
                    <!-- <div class="ibox-content"> -->
                    <div class="table-responsive">
                        <table id="FDataTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 7%; text-align:center!important">ID</th>
                                    <th style="width: 24%; text-align:center!important">Kode Rekening</th>
                                    <th style="width: 24%; text-align:center!important">Nama Dasar</th>
                                    <th style="width: 16%; text-align:center!important">Pembebanan Anggaran</th>
                                    <th style="width: 16%; text-align:center!important">PPK/BLUD</th>
                                    <th style="width: 16%; text-align:center!important">PPTK</th>
                                    <th style="width: 16%; text-align:center!important">Status</th>
                                    <th style="width: 16%; text-align:center!important">Petugas Entri</th>
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

<div class="modal fade" id="dasar_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
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
                    <input type="hidden" id="id_dasar" name="id_dasar">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="nama_dasar">Nama Dasar</label>
                                <textarea class="form-control" id="nama_dasar" name="nama_dasar"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="kode_rekening">Kode Rekening</label>
                                <input type="text" placeholder="" class="form-control" id="kode_rekening" name="kode_rekening" required="required">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="pembebanan_anggaran">Pembeban Anggaran</label>
                                <input type="text" placeholder="" class="form-control" id="pembebanan_anggaran" name="pembebanan_anggaran" required="required">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="nip">Nama PPK / Pimpinan BLUD</label>
                                <select class="select2 col-sm-12" id="id_ppk2" name="id_ppk2"></select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="nip">Jenis PPK / BLUD</label>
                                <select class="form-control" id="jen_ppk" name="jen_ppk" required>
                                    <option value="-">-</option>
                                    <option value="1">PPK</option>
                                    <option value="2">BLUD</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="nip">PPTK</label>
                                <select class="select2 col-sm-12" id="id_pptk" name="id_pptk"></select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="dasar_status">Status</label>
                                <select class="form-control" id="dasar_status" name="dasar_status">
                                    <option value="Y">Aktif</option>
                                    <option value="N">Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button class="btn btn-primary" type="submit" id="add_btn" data-loading-text="Loading..."><strong>Tambah Dasar</strong></button>
                        <button class="btn btn-primary" type="submit" id="save_edit_btn" data-loading-text="Loading..."><strong>Simpan Dasar</strong></button>
                    </div>
            </form>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('#menu_1').addClass('active');
        $('#opmenu_1').show();
        $('#submenu_10').addClass('active');
        var toolbar = {
            'form': $('#toolbar_form'),
            'no_tlp': $('#toolbar_form').find('#no_tlp'),
            'id_opd': $('#toolbar_form').find('#id_opd'),
            'newBtn': $('#new_btn'),
        }

        var FDataTable = $('#FDataTable').DataTable({
            responsive: true,
            // 'columnDefs': [],
            deferRender: true,
            "order": [
                [0, "desc"]
            ]
        });

        var DasarModal = {
            'self': $('#dasar_modal'),
            'info': $('#dasar_modal').find('.info'),
            'form': $('#dasar_modal').find('#satuan_form'),
            'addBtn': $('#dasar_modal').find('#add_btn'),
            'saveEditBtn': $('#dasar_modal').find('#save_edit_btn'),
            'idDasar': $('#dasar_modal').find('#id_dasar'),
            'kode_rekening': $('#dasar_modal').find('#kode_rekening'),
            'nama_dasar': $('#dasar_modal').find('#nama_dasar'),
            'pembebanan_anggaran': $('#dasar_modal').find('#pembebanan_anggaran'),
            'dasar_status': $('#dasar_modal').find('#dasar_status'),
            'id_ppk2': $('#dasar_modal').find('#id_ppk2'),
            'id_pptk': $('#dasar_modal').find('#id_pptk'),
            'jen_ppk': $('#dasar_modal').find('#jen_ppk'),


        }

        var dataRole = {}
        var dataDasar = {}

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

        $.when(getAllDasar()).then((e) => {
            toolbar.newBtn.prop('disabled', false);
        }).fail((e) => {
            console.log(e)
        });



        function getAllDasar() {
            Swal.fire({
                title: 'Loading Dasar / Unit!',
                allowOutsideClick: false,
            });
            Swal.showLoading()
            return $.ajax({
                url: `<?php echo site_url('General/getAllDasar/') ?>`,
                'type': 'POST',
                data: toolbar.form.serialize(),
                success: function(data) {
                    Swal.close();
                    var json = JSON.parse(data);
                    if (json['error']) {
                        return;
                    }
                    dataDasar = json['data'];
                    renderDasar(dataDasar);
                },
                error: function(e) {}
            });
        }

        function renderDasar(data) {
            if (data == null || typeof data != "object") {
                console.log("Dasar::UNKNOWN DATA");
                return;
            }
            var i = 0;

            var renderData = [];
            Object.values(data).forEach((dpa) => {
                var editButton = `
        <a class="edit dropdown-item" data-id='${dpa['id_dasar']}'><i class='fa fa-pencil'></i> Edit</a>
      `;
                var deleteButton = `
        <a class="delete dropdown-item" data-id='${dpa['id_dasar']}'><i class='fa fa-trash'></i> Hapus</a>
      `;
                var button = `
            ${editButton}
            ${deleteButton}
            `;
                renderData.push([dpa['id_dasar'], dpa['kode_rekening'], dpa['nama_dasar'], dpa['pembebanan_anggaran'],
                    dpa['nama_ppk2'], dpa['nama_pptk'], statusDasar(dpa['dasar_status']), dpa['nama_petugas'], button
                ]);
            });
            FDataTable.clear().rows.add(renderData).draw('full-hold');
        }

        function resetDasarModal() {
            DasarModal.form.trigger('reset');
            // DasarModal.no_tlp.val(toolbar.no_tlp.val());
            // DasarModal.dasar_status.val("");
            // DasarModal.alamat_lengkap.val("");
            // DasarModal.nama_dasar.val("");
            var $blankOption2 = $("<option selected='selected'></option>").val('').text('-');
            DasarModal.id_ppk2.append($blankOption2).trigger('change');
            var $blankOption = $("<option selected='selected'></option>").val('').text('-');
            DasarModal.id_pptk.append($blankOption).trigger('change');
        }

        toolbar.newBtn.on('click', (e) => {
            resetDasarModal();
            DasarModal.self.modal('show');
            DasarModal.form.trigger('reset');
            DasarModal.addBtn.show();
            DasarModal.saveEditBtn.hide();
            DasarModal.idDasar.val('');
        });
        $("#id_ppk2").select2({
            dropdownParent: $('#dasar_modal .modal-content'),
            ajax: {
                url: '<?= base_url() ?>Search/Pegawai',
                type: "get",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term // search term
                    };
                },
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });

        $("#id_pptk").select2({
            dropdownParent: $('#dasar_modal .modal-content'),
            ajax: {
                url: '<?= base_url() ?>Search/Pegawai',
                type: "get",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term // search term
                    };
                },
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });

        FDataTable.on('click', '.edit', function() {
            resetDasarModal();
            DasarModal.self.modal('show');
            DasarModal.addBtn.hide();
            DasarModal.saveEditBtn.show();
            var currentData = dataDasar[$(this).data('id')];
            DasarModal.idDasar.val(currentData['id_dasar']);
            DasarModal.dasar_status.val(currentData['dasar_status']);
            DasarModal.kode_rekening.val(currentData['kode_rekening']);
            DasarModal.nama_dasar.val(currentData['nama_dasar']);
            DasarModal.jen_ppk.val(currentData['jen_ppk']);
            DasarModal.pembebanan_anggaran.val(currentData['pembebanan_anggaran']);

            var $newOption = $("<option selected='selected'></option>").val(currentData['id_ppk2']).text(currentData['nama_ppk2']);
            DasarModal.id_ppk2.append($newOption).trigger('change');

            var $newOption2 = $("<option selected='selected'></option>").val(currentData['id_pptk']).text(currentData['nama_pptk']);
            DasarModal.id_pptk.append($newOption2).trigger('change');

        });

        DasarModal.form.submit(function(event) {
            event.preventDefault();
            var isAdd = DasarModal.addBtn.is(':visible');
            var url = "<?= site_url('Master/action_dasar/') ?>";
            url += isAdd ? "add" : "edit";
            var button = isAdd ? DasarModal.addBtn : DasarModal.saveEditBtn;

            Swal.fire(swalSaveConfigure).then((result) => {
                if (!result.value) {
                    return;
                }
                buttonLoading(button);
                $.ajax({
                    url: url,
                    'type': 'POST',
                    data: DasarModal.form.serialize(),
                    success: function(data) {
                        buttonIdle(button);
                        var json = JSON.parse(data);
                        if (json['error']) {
                            Swal.fire("Simpan Gagal", json['message'], "error");
                            return;
                        }
                        var dpa = json['data']
                        dataDasar[dpa['id_dasar']] = dpa;
                        Swal.fire("Simpan Berhasil", "", "success");
                        renderDasar(dataDasar);
                        DasarModal.self.modal('hide');
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
                    url: "<?= site_url('Master/action_dasar/delete') ?>",
                    'type': 'POST',
                    data: {
                        'id_dasar': id
                    },
                    success: function(data) {
                        var json = JSON.parse(data);
                        if (json['error']) {
                            Swal.fire("Delete Gagal", json['message'], "error");
                            return;
                        }
                        delete dataDasar[id];
                        Swal.fire("Delete Berhasil", "", "success");
                        renderDasar(dataDasar);
                    },
                    error: function(e) {}
                });
            });
        });
    });
</script>