<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-header">

                    <form class="form-inline" id="toolbar_form" onsubmit="return false;">
                        <input type="hidden" id="is_not_self" name="is_not_self" value="1">
                        <input type="hidden" id="id_pegawai" name="id_pegawai" value="<?= $this->session->userdata('id') ?>">
                        <a type="button" class="btn btn-success my-1 mr-sm-2" href="<?= base_url('Surat/add_surat_masuk') ?>" id="new_btn" disabled="disabled"><i class="fa fa-plus"></i> Tambah </a>
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

<div class="modal fade" id="lihat_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form opd="form" id="lihat_form" onsubmit="return false;" type="multipart" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_title">
                        Data Surat Izin / Cuti
                    </h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6" id="status_izin"> </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="col-form-label">Pegawai Cuti</div>
                            <input id="nama_pegawai" class="form-control" readonly />
                        </div>
                        <div class="col-lg-6">
                            <div class="col-form-label">Pegawai Pengganti</div>
                            <input id="nama_pengganti" class="form-control" readonly />
                        </div>
                        <div class="col-lg-3">
                            <div class="col-form-label">Jenis Cuti</div>
                            <input id="nama_izin" class="form-control" readonly />
                        </div>
                        <div class="col-lg-7">
                            <div class="col-form-label">Tanggal Izin</div>
                            <div class="row">
                                <div class="col">
                                    <input name="periode_start" type="date" id="periode_start" readonly class="form-control" value="<?= !empty($dataContent['return_data']['periode_start']) ? $dataContent['return_data']['periode_start'] : date("Y-m-d") ?>" />
                                </div>
                                <div class="col-1 d-flex align-items-center">
                                    s.d.
                                </div>
                                <div class="col">
                                    <input name="periode_end" type="date" id="periode_end" readonly class="form-control" value="<?= !empty($dataContent['return_data']['periode_end']) ? $dataContent['return_data']['periode_end'] : date("Y-m-d") ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="col-form-label">Lama Izin (hari)</div>
                            <div class="row">
                                <div class="col">
                                    <input type="number" name="lama_izin" readonly id="lama_izin" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="col-form-label">Alasan</div>
                            <div class="row">
                                <div class="col">
                                    <textarea type="text" readonly id="alasan" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="col-form-label">Alamat Selamat Menjalankan Cuti / Izin</div>
                            <div class="row">
                                <div class="col">
                                    <textarea type="text" readonly id="alamat_izin" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-4 layout_c_tahunan">
                                    <div class="col-form-label">Tahun N</div>
                                    <input type="number" name="c_n" id="c_n" class="form-control" readonly />
                                </div>
                                <div class="col-lg-4 layout_c_tahunan">
                                    <div class="col-form-label">Tahun N-1</div>
                                    <input type="number" name="c_n1" id="c_n1" class="form-control" readonly />
                                </div>
                                <div class="col-lg-4 layout_c_tahunan">
                                    <div class="col-form-label">Tahun N-2</div>
                                    <input type="number" name="c_n2" id="c_n2" class="form-control" readonly />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 layout_c_tahunan">
                                    <div class="col-form-label">Sisa Tahun N</div>
                                    <input type="number" name="c_sisa_n" id="c_sisa_n" class="form-control" readonly />
                                </div>
                                <div class="col-lg-4 layout_c_tahunan">
                                    <div class="col-form-label">Sisa Tahun N-1</div>
                                    <input type="number" name="c_sisa_n1" id="c_sisa_n1" class="form-control" readonly />
                                </div>
                                <div class="col-lg-4 layout_c_tahunan">
                                    <div class="col-form-label">Sisa Tahun N-2</div>
                                    <input type="number" name="c_sisa_n2" id="c_sisa_n2" class="form-control" readonly />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="col-form-label">Dokumen Lampiran</div>
                        <div class="col" id="layout_lampiran">
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
        $('#menu_8').addClass('active');
        $('#opmenu_8').show();
        $('#submenu_18').addClass('active');
        var toolbar = {
            'form': $('#toolbar_form'),
            'id_role': $('#toolbar_form').find('#id_role'),
            'id_pegawai': $('#toolbar_form').find('#id_pegawai'),
            'newBtn': $('#new_btn'),
        }
        var LihatModal = {
            'self': $('#lihat_modal'),
            // 'info': $('#lihat_modal').find('.status_izin'),
            'periode_start': $('#lihat_modal').find('#periode_start'),
            'periode_end': $('#lihat_modal').find('#periode_end'),
            'lama_izin': $('#lihat_modal').find('#lama_izin'),
            'status_izin': $('#lihat_modal').find('#status_izin'),
            'c_sisa_n': $('#lihat_modal').find('#c_sisa_n'),
            'c_sisa_n1': $('#lihat_modal').find('#c_sisa_n1'),
            'c_sisa_n2': $('#lihat_modal').find('#c_sisa_n2'),
            'c_n': $('#lihat_modal').find('#c_n'),
            'c_n1': $('#lihat_modal').find('#c_n1'),
            'c_n2': $('#lihat_modal').find('#c_n2'),
            'alasan': $('#lihat_modal').find('#alasan'),
            'alamat_izin': $('#lihat_modal').find('#alamat_izin'),
            'nama_izin': $('#lihat_modal').find('#nama_izin'),
            'nama_pegawai': $('#lihat_modal').find('#nama_pegawai'),
            'nama_pengganti': $('#lihat_modal').find('#nama_pengganti'),
            'layout_lampiran': $('#lihat_modal').find('#layout_lampiran'),
        }
        var FDataTable = $('#FDataTable').DataTable({
            'columnDefs': [],
            deferRender: true,
            "order": [
                [0, "desc"]
            ]
        });

        var dataRole = {}
        var dataSuratIzin = {}

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
                    dataSuratIzin = json['data'];
                    renderSKP(dataSuratIzin);
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
                    <a class="dropdown-item"  href='<?= base_url() ?>Surat/edit/${d['id_surat_masuk']}'><i class='fa fa-pencil'></i> Edit</a>
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
                                    ${lihatButton}
                                    ${editButton}
                                    ${deleteButton}
                                    </div>
                                </div>
                            </div>
                        </div>`;
                tujuan = '';
                i = 1;

                renderData.push([d['id_surat_masuk'], d['tanggal_surat'], nl2br(d['dari']), nl2br(d['kepada']), d['nomor_surat'], '-', button]);
            });
            FDataTable.clear().rows.add(renderData).draw('full-hold');
        }

        FDataTable.on('click', '.data_izin', function() {
            var jenis = $(this).data('jenis');
            curData = dataSuratIzin[$(this).data('id')];
            console.log(curData);
            LihatModal.self.modal('show');
            LihatModal.periode_start.val(curData['periode_start']);
            LihatModal.periode_end.val(curData['periode_end']);
            LihatModal.lama_izin.val(curData['lama_izin']);
            LihatModal.nama_izin.val(curData['nama_izin']);
            LihatModal.nama_pegawai.val(curData['nama_pegawai']);
            LihatModal.nama_pengganti.val(curData['nama_pengganti']);
            LihatModal.alasan.val(curData['alasan']);
            LihatModal.alamat_izin.val(curData['alamat_izin']);
            LihatModal.c_n.val(curData['c_n']);
            LihatModal.c_n1.val(curData['c_n1']);
            LihatModal.c_n2.val(curData['c_n2']);
            LihatModal.status_izin.html(statusIzin(curData['status_izin'], curData['unapprove']))
            if (curData['lampiran'] != null && curData['lampiran'] != '') {
                file_lampiran = curData['lampiran'].split(".");
                lampHtml = `<a href='<?= base_url('uploads/lampiran_izin/') ?>${curData['lampiran']}'> Download </a>
                `
                lampHtml += `
                <div class="col-lg-12">
                <object width="100%" height="700px"data="<?= base_url('uploads/lampiran_izin/') ?>${curData['lampiran']}" type="application/pdf">
                                <iframe src="<?= base_url('uploads/lampiran_izin/') ?>${curData['lampiran']}"></iframe>
                            </object>
                            </div>`
                LihatModal.layout_lampiran.html(lampHtml);
            } else
                LihatModal.layout_lampiran.html('<b>tidak ada lampiran</b>');

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
                        delete dataSuratIzin[id];
                        Swal.fire("Delete Berhasil", "", "success");
                        renderSKP(dataSuratIzin);
                    },
                    error: function(e) {}
                });
            });
        });
    });
</script>