<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-header">

                    <form class="form-inline" id="toolbar_form" onsubmit="return false;">
                        <input type="hidden" id="disposisi" name="disposisi" value="1">
                    </form>
                </div>

                <div class="card-body">

                    <div class="table-responsive">
                        <table id="FDataTable" class="table table-border-horizontal" style="padding-bottom: 100px">
                            <thead>
                                <tr>
                                    <th style="width: 2%; text-align:center!important">ID</th>
                                    <th style="width: 10%; text-align:center!important">Tanggal Surat</th>
                                    <th style="width: 10%; text-align:center!important">Dari</th>
                                    <th style="width: 10%; text-align:center!important">Tujuan</th>
                                    <th style="width: 10%; text-align:center!important">Nomor</th>
                                    <th style="width: 10%; text-align:center!important">Disposisi</th>
                                    <th style="width: 5%; text-align:center!important">Lihat File</th>
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

<div class="modal fade" id="dispo_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form opd="form" id="dispo_form" onsubmit="return false;" type="multipart" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_title">
                        Data Surat Izin / Cuti
                    </h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="id_pegawai_after">Disposisikan Kepada</label>
                            <input type="" id="id_surat_masuk" name="id_surat_masuk" />
                            <select class="select2 col-sm-12" id="id_pegawai_after" name="id_pegawai_after"></select>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="col-form-label">Catatan</div>
                            <div class="row">
                                <div class="col">
                                    <textarea type="text" name="catatan_dispo" id="catatan_dispo" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit" id="add_btn" data-loading-text="Loading..."><strong>Simpan</strong></button>

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
        $('#menu_9').addClass('active');
        var toolbar = {
            'form': $('#toolbar_form'),
            'id_role': $('#toolbar_form').find('#id_role'),
            'newBtn': $('#new_btn'),
        }
        var DispoModal = {
            'self': $('#dispo_modal'),
            'form': $('#dispo_modal').find('#dispo_form'),
            'id_surat_masuk': $('#dispo_modal').find('#id_surat_masuk'),
            'id_pegawai_after': $('#dispo_modal').find('#id_pegawai_after'),
            'catatan_dispo': $('#dispo_modal').find('#catatan_dispo'),
        }
        var FDataTable = $('#FDataTable').DataTable({
            'columnDefs': [],
            deferRender: true,
            "order": [
                [0, "desc"]
            ]
        });

        var dataRole = {}
        var dataSurat = {}

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
                url: `<?php echo site_url('Surat/getAll/') ?>`,
                'type': 'get',
                data: toolbar.form.serialize(),
                success: function(data) {
                    Swal.close();
                    var json = JSON.parse(data);
                    if (json['error']) {
                        return;
                    }
                    dataSurat = json['data'];
                    renderSurat(dataSurat);
                },
                error: function(e) {}
            });
        }

        $("#id_pegawai_after").select2({
            dropdownParent: $('#dispo_modal .modal-content'),
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

        function renderSurat(data) {
            console.log(data)
            if (data == null || typeof data != "object") {
                console.log("Sppd::UNKNOWN DATA");
                return;
            }
            var i = 0;

            var renderData = [];
            Object.values(data).forEach((d) => {
                var editButton = `
                    <a class="dropdown-item"  href='<?= base_url() ?>Surat/edit/${d['id_surat_masuk']}'><i class='fa fa-pencil'></i> Edit</a>
                  `;
                var dispoButton = `
                    <a class="dispo dropdown-item" data-id='${d['id_surat_masuk']}'><i class='fa fa-book'></i> Diposisi</a>
                  `;
                var deleteButton = `
                    <a class="delete dropdown-item" data-id='${d['id_surat_masuk']}'><i class='fa fa-trash'></i> Hapus</a>
                  `;
                var lihatButton = `
                    <a class="dropdown-item"  href='<?= base_url() ?>Surat/detail_surat_masuk/${d['id_surat_masuk']}'><i class='fa fa-eye'></i> Lihat</a>
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
                                    ${dispoButton}
                                    ${lihatButton}
                                    ${editButton}
                                    ${deleteButton}
                                    </div>
                                </div>
                            </div>
                        </div>`;
                tujuan = '';
                i = 1;

                renderData.push([d['id_surat_masuk'], d['tanggal_surat'], nl2br(d['dari']), nl2br(d['kepada']), d['nomor_surat'], d['current_dispo_nama'], button]);
            });
            FDataTable.clear().rows.add(renderData).draw('full-hold');
        }



        FDataTable.on('click', '.dispo', function() {
            curData = dataSurat[$(this).data('id')];
            console.log(curData);
            DispoModal.self.modal('show');
            DispoModal.id_surat_masuk.val(curData['id_surat_masuk']);
        });


        DispoModal.form.submit(function(event) {
            event.preventDefault();
            var url = "<?= site_url('Surat/action_disposisi') ?>";

            Swal.fire(swalSaveConfigure).then((result) => {
                if (!result.value) {
                    return;
                }
                swalLoading();

                $.ajax({
                    url: url,
                    'type': 'POST',
                    data: DispoModal.form.serialize(),
                    success: function(data) {
                        var json = JSON.parse(data);
                        if (json['error']) {
                            Swal.fire("Simpan Gagal", json['message'], "error");
                            return;
                        }
                        var data = json['data']
                        dataSurat[data['id_surat_masuk']] = data;
                        Swal.fire("Simpan Berhasil", "", "success");
                        renderSurat(dataSurat);
                        DispoModal.self.modal('hide');
                    },
                    error: function(e) {}
                });
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
                    url: "<?= site_url('Surat/delete') ?>",
                    'type': 'get',
                    data: {
                        'id_surat_masuk': id
                    },
                    success: function(data) {
                        var json = JSON.parse(data);
                        if (json['error']) {
                            Swal.fire("Delete Gagal", json['message'], "error");
                            return;
                        }
                        delete dataSurat[id];
                        Swal.fire("Delete Berhasil", "", "success");
                        renderSurat(dataSurat);
                    },
                    error: function(e) {}
                });
            });
        });
    });
</script>