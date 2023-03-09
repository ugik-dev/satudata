<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12 col-lg-12 mt-3">
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
                                                <label class="col-sm-3 col-form-label">Status </label>
                                                <div class="col-sm-8">
                                                    <select class="form-control " name="status_permohonan" id="status">
                                                        <option value=""> Semua </option>
                                                        <option value="menunggu-saya" selected> Menunggu Saya</option>
                                                        <option value="my-approv"> Sudah Saya Approve </option>
                                                        <option value="ditolak"> Ditolak </option>
                                                        <option value="selesai"> Selesai </option>
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
                                                    <input class="form-control m-input digits" type="date" value="<?= date("Y-m-d", strtotime("-1 months")); ?>" data-bs-original-title="" title="">
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="mb-3 row">
                                                <label class="col-sm-3 col-form-label">Sampai</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control m-input digits" type="date" value="<?= date('Y-m-d') ?>" data-bs-original-title="" title="">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- <div class="job-filter mb-2">
                                            <div class="faq-form">
                                                <input class="form-control" type="text" placeholder="Search.." /><i class="search-icon" data-feather="search"></i>
                                            </div>
                                        </div>
                                        <div class="job-filter">
                                            <div class="faq-form">
                                                <input class="form-control" type="text" placeholder="location.." /><i class="search-icon" data-feather="map-pin"></i>
                                            </div>
                                        </div> -->
                                        <div class="checkbox-animated m-checkbox-inline">
                                            <label class="form-check form-check-inline" for="chk-spt">
                                                <input class="checkbox_animated" id="chk-spt" name="chk-spt" type="checkbox" checked />SPT
                                            </label>
                                            <label class="form-check form-check-inline" for="chk-sppd">
                                                <input class="checkbox_animated" id="chk-sppd" name="chk-sppd" type="checkbox" checked />SPPD
                                            </label>
                                            <label class="form-check form-check-inline" for="chk-lembur">
                                                <input class="checkbox_animated" id="chk-lembur" name="chk-lembur" type="checkbox" checked />Lembur
                                            </label><label class="form-check form-check-inline" for="chk-surat-izin">
                                                <input class="checkbox_animated" id="chk-surat-izin" name="chk-surat-izin" type="checkbox" checked />Surat Izin
                                            </label>
                                            <label class="form-check form-check-inline" for="chk-surat-cuti">
                                                <input class="checkbox_animated" id="chk-surat-cuti" name="chk-surat-cuti" type="checkbox" checked />Surat Cuti
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
                    <div class="table-responsive">
                        <table id="FDataTable" class="table table-border-horizontal" style="padding-bottom: 100px">
                            <thead>
                                <tr>
                                    <th style="width: 5%; text-align:center!important">Jenis</th>
                                    <th style="width: 10%; text-align:center!important">TANGGAL</th>
                                    <th style="width: 10%; text-align:center!important">PEGAWAI</th>
                                    <th style="width: 20%; text-align:center!important">INFORMASI LAINNYA</th>
                                    <th style="width: 5%; text-align:center!important">STATUS</th>
                                    <th style="width: 2%; text-align:center!important">ID</th>
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

<div class="modal fade" id="verif_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form opd="form" id="verif_form" onsubmit="return false;" type="multipart" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_title">
                        Form Verifikasi Cuti
                    </h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id_surat_izin" name="id_surat_izin">
                    <div class="row">
                        <div class="col-lg-2">
                            <div class="col-form-label">Aksi</div>
                            <button class="btn btn-primary" type="submit" id="save_edit_btn" data-loading-text="Loading..."><strong>Simpan</strong></button>
                        </div>
                        <div class="col-lg-4">
                            <div class="col-form-label">Status Verifikasi</div>
                            <select id="verif" name="verif" class="form-control">
                                <option value="1">Diterima</option>
                                <option value="2">Ditolak</option>
                            </select>
                        </div>

                        <div class="col-lg-6">
                            <div class="col-form-label">Catatan Verifikator Cuti</div>
                            <input id="cttn_verif" name="cttn_verif" class="form-control"></input>
                        </div>

                    </div>
                    <div class="hr-line-dashed"></div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="col-form-label">Pegawai Cuti</div>
                            <input id="nama_pegawai" class="form-control" readonly>
                        </div>
                        <div class="col-lg-6">
                            <div class="col-form-label">Pegawai Pengganti</div>
                            <input id="nama_pengganti" class="form-control" readonly>
                        </div>
                        <div class="col-lg-3">
                            <div class="col-form-label">Jenis Cuti</div>
                            <input id="nama_izin" class="form-control" readonly>
                        </div>
                        <!-- <div class="hr-line-dashed"></div> -->
                        <div class="col-lg-7">
                            <div class="col-form-label">Tanggal Izin</div>
                            <div class="row">
                                <div class="col">
                                    <input name="periode_start" type="date" id="periode_start" readonly class="form-control" value="<?= !empty($dataContent['return_data']['periode_start']) ? $dataContent['return_data']['periode_start'] : date("Y-m-d") ?>">
                                </div>
                                <div class="col-1 d-flex align-items-center">
                                    s.d.
                                </div>
                                <div class="col">
                                    <input name="periode_end" type="date" id="periode_end" readonly class="form-control" value="<?= !empty($dataContent['return_data']['periode_end']) ? $dataContent['return_data']['periode_end'] : date("Y-m-d") ?>">
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
                            <div class="row">
                                <div class="col-lg-4 layout_c_tahunan">
                                    <div class="col-form-label">Tahun N</div>
                                    <input type="number" name="c_n" id="c_n" class="form-control" required />
                                </div>
                                <div class="col-lg-4 layout_c_tahunan">
                                    <div class="col-form-label">Tahun N-1</div>
                                    <input type="number" name="c_n1" id="c_n1" class="form-control" required />
                                </div>
                                <div class="col-lg-4 layout_c_tahunan">
                                    <div class="col-form-label">Tahun N-2</div>
                                    <input type="number" name="c_n2" id="c_n2" class="form-control" required />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 layout_c_tahunan">
                                    <div class="col-form-label">Sisa Tahun N</div>
                                    <input type="number" name="c_sisa_n" id="c_sisa_n" class="form-control" required />
                                </div>
                                <div class="col-lg-4 layout_c_tahunan">
                                    <div class="col-form-label">Sisa Tahun N-1</div>
                                    <input type="number" name="c_sisa_n1" id="c_sisa_n1" class="form-control" required />
                                </div>
                                <div class="col-lg-4 layout_c_tahunan">
                                    <div class="col-form-label">Sisa Tahun N-2</div>
                                    <input type="number" name="c_sisa_n2" id="c_sisa_n2" class="form-control" required />
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
        $('#sidebar_permohonan').addClass('active_c');

        var toolbar = {
            'form': $('#toolbar_form'),
            'jenis_permohonan': $('#toolbar_form').find('#jenis_permohonan'),
            'status': $('#toolbar_form').find('#status'),
            'newBtn': $('#new_btn'),
        }

        var FDataTable = $('#FDataTable').DataTable({
            'columnDefs': [],
            responsive: true,
            deferRender: true,
            "order": [
                [1, "desc"]
            ]
        });
        var VerifModal = {
            'self': $('#verif_modal'),
            'info': $('#verif_modal').find('.info'),
            'form': $('#verif_modal').find('#verif_form'),
            'addBtn': $('#verif_modal').find('#add_btn'),
            'saveEditBtn': $('#verif_modal').find('#save_edit_btn'),
            'idSuratIzin': $('#verif_modal').find('#id_surat_izin'),
            'periode_start': $('#verif_modal').find('#periode_start'),
            'periode_end': $('#verif_modal').find('#periode_end'),
            'lama_izin': $('#verif_modal').find('#lama_izin'),
            'status_izin': $('#verif_modal').find('#status_izin'),
            'c_sisa_n': $('#verif_modal').find('#c_sisa_n'),
            'c_sisa_n1': $('#verif_modal').find('#c_sisa_n1'),
            'c_sisa_n2': $('#verif_modal').find('#c_sisa_n2'),
            'c_n': $('#verif_modal').find('#c_n'),
            'c_n1': $('#verif_modal').find('#c_n1'),
            'c_n2': $('#verif_modal').find('#c_n2'),
            'alasan': $('#verif_modal').find('#alasan'),
            'nama_izin': $('#verif_modal').find('#nama_izin'),
            'nama_pegawai': $('#verif_modal').find('#nama_pegawai'),
            'nama_pengganti': $('#verif_modal').find('#nama_pengganti'),
            'layout_lampiran': $('#verif_modal').find('#layout_lampiran'),
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
            'nama_izin': $('#lihat_modal').find('#nama_izin'),
            'nama_pegawai': $('#lihat_modal').find('#nama_pegawai'),
            'nama_pengganti': $('#lihat_modal').find('#nama_pengganti'),
            'layout_lampiran': $('#lihat_modal').find('#layout_lampiran'),
        }
        var dataRole = {}
        var dataSKP = {}
        <?php $curUser = $this->session->userdata(); ?>
        var currentUser = <?= json_encode([
                                'level' => $curUser['level'],
                                'id_seksi' => $curUser['id_seksi'],
                                'id_bagian' => $curUser['id_bagian'],
                                'id_satuan' => $curUser['id_satuan'],
                                'id' => $curUser['id'],
                            ]) ?>;
        console.log(currentUser);
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

        $.when(getAllPermohonan()).then((e) => {
            // toolbar.newBtn.prop('disabled', false);
        }).fail((e) => {
            console.log(e)
        });

        toolbar.form.on('submit', (e) => {
            getAllPermohonan();
        });
        toolbar.status.on('change', (e) => {
            getAllPermohonan();
        });


        toolbar.jenis_permohonan.on('change', (e) => {
            getAllPermohonan();
        });

        function getAllPermohonan() {
            Swal.fire({
                title: 'Loading SPPD!',
                allowOutsideClick: false,
            });
            Swal.showLoading()
            return $.ajax({
                url: `<?php echo site_url('permohonan/getAll/') ?>`,
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
            curUser = <?= $this->session->userdata()['id'] ?>;
            curLevel = <?= $this->session->userdata()['level'] ?>;
            curSatuan = <?= $this->session->userdata()['id_satuan'] ?>;
            bagian = <?= $this->session->userdata()['id_bagian'] ? $this->session->userdata()['id_bagian']  : "''" ?>;
            Object.values(data['surat_izin']).forEach((d) => {
                var aksiBtn = '';
                console.log('pengganti :' +
                    d['id_pengganti'])
                console.log(d['status_izin'] + curUser + d['id_pengganti'])
                if (d['status_izin'] == '0' && curUser == d['id_pengganti']) {
                    aksiBtn =
                        `<a class="approv dropdown-item"  data-jenis='suratizin' data-id='${d['id_surat_izin']}' ><i class='fa fa-check'></i> Approv</a>
                          <a class="deapprov dropdown-item " data-jenis='suratizin' data-id='${d['id_surat_izin']}' ><i class='fa fa-times'></i> Tolak Approv</a>
                    `;
                }
                if (d['status_izin'] == '2' && d['id_bagian'] == bagian && (curLevel == 3 || curLevel == 4)) {
                    aksiBtn =
                        `<a class="approv dropdown-item"  data-jenis='suratizin' data-id='${d['id_surat_izin']}' ><i class='fa fa-check'></i> Approv</a>
                          <a class="deapprov dropdown-item " data-jenis='suratizin' data-id='${d['id_surat_izin']}' ><i class='fa fa-times'></i> Tolak Approv</a>
                    `;
                }
                if (d['status_izin'] == '3' && curLevel == 2) {
                    aksiBtn =
                        `<a class="approv dropdown-item"  data-jenis='suratizin' data-id='${d['id_surat_izin']}' ><i class='fa fa-check'></i> Approv</a>
                          <a class="deapprov dropdown-item " data-jenis='suratizin' data-id='${d['id_surat_izin']}' ><i class='fa fa-times'></i> Tolak Approv</a>
                    `;
                }
                if ((d['status_izin'] == '10' || d['status_izin'] == '11') && curUser == d['verif_cuti']) {
                    aksiBtn =
                        `<a class="verif_cuti dropdown-item"  data-jenis='suratizin' data-id='${d['id_surat_izin']}' ><i class='fa fa-check'></i> Approv / Batal</a>
                    `;
                }
                if (d['status_izin'] == '11' && bagian == 2 && curLevel == 3) {
                    aksiBtn =
                        `<a class="approv dropdown-item"  data-jenis='suratizin' data-id='${d['id_surat_izin']}' ><i class='fa fa-check'></i> Approv</a>
                          <a class="deapprov dropdown-item " data-jenis='suratizin' data-id='${d['id_surat_izin']}' ><i class='fa fa-times'></i> Tolak Approv</a>
                    `;
                }
                if ((d['status_izin'] == '15') && curLevel == 1) {
                    aksiBtn =
                        `<a class="approv dropdown-item"  data-jenis='suratizin' data-id='${d['id_surat_izin']}' ><i class='fa fa-check'></i> Approv</a>
                          <a class="deapprov dropdown-item " data-jenis='suratizin' data-id='${d['id_surat_izin']}' ><i class='fa fa-times'></i> Tolak Approv</a>
                    `;
                }
                // if ((d['status_izin'] == '99')) {
                cek_btn =
                    `<a class="data_izin dropdown-item"  data-jenis='suratizin' data-id='${d['id_surat_izin']}' ><i class='fa fa-eye'></i> Lihat</a>
                    `;
                // }
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
                                        ${cek_btn}
                                    </div>
                                </div>
                            </div>
                        </div>`;

                info = 'Pengganti : ' + d['nama_pengganti'];
                console.log(d['unapprove']);
                renderData.push([d['nama_izin'],
                    d['periode_start'] + (d['periode_start'] == d['periode_end'] ? '' : ' s.d. ' + d['periode_end']),
                    d['nama_pegawai'], info, statusIzin(d['status_izin'], d['unapprove']), d['id_surat_izin'], button
                ]);
            });

            Object.values(data['spt']).forEach((spt) => {
                var aksiBtn = '';
                <?php if ($this->session->userdata()['level'] == 3 or $this->session->userdata()['level'] == 4) { ?>
                    console.log('ini level 3 KASUBAG / KABID');
                    if (spt['status'] == 2) {
                        var aksiBtn = `
                    <a class="approv dropdown-item"  data-jenis='spt' data-id='${spt['id_spt']}' ><i class='fa fa-check'></i> Approv</a>
                    <a class="deapprov dropdown-item " data-jenis='spt' data-id='${spt['id_spt']}' ><i class='fa fa-times'></i> Tolak Approv</a>
                    `;
                    } else if (spt['status'] == 10) {
                        var aksiBtn = `
                    <a class="batal_aksi dropdown-item"  data-jenis='spt'  data-id='${spt['id_spt']}' ><i class='fa fa-check'></i> Batal Aksi</a>
                    `;
                    }
                <?php } else if ($this->session->userdata()['level'] == 2) { ?>
                    if (spt['status'] == 11) {
                        var aksiBtn = `
                    <a class="approv dropdown-item"  data-jenis='spt' data-id='${spt['id_spt']}' ><i class='fa fa-check'></i> Approv</a>
                    <a class="deapprov dropdown-item " data-jenis='spt' data-id='${spt['id_spt']}' ><i class='fa fa-times'></i> Tolak Approv</a>
                    `;
                    } else if (spt['status'] == 12 || spt['unapprove_oleh'] == '<?= $this->session->userdata()['id'] ?>') {
                        var aksiBtn = `
                        <a class="batal_aksi dropdown-item"  data-jenis='spt'  data-id='${spt['id_spt']}' ><i class='fa fa-check'></i> Batal Aksi</a>
                        `;
                    }
                <?php  } else if ($this->session->userdata()['level'] == 1) { ?>
                    if (spt['status'] == 12) {
                        var aksiBtn = `
                    <a class="approv dropdown-item"  data-jenis='spt' data-id='${spt['id_spt']}' ><i class='fa fa-check'></i> Approv</a>
                    <a class="deapprov dropdown-item " data-jenis='spt' data-id='${spt['id_spt']}' ><i class='fa fa-times'></i> Tolak Approv</a>
                    `;
                    } else if (spt['status'] == 99 || spt['unapprove_oleh'] == '<?= $this->session->userdata()['id'] ?>') {
                        var aksiBtn = `
                        <a class="batal_aksi dropdown-item"  data-jenis='spt'  data-id='${spt['id_spt']}' ><i class='fa fa-check'></i> Batal Aksi</a>
                        `;
                    }
                <?php  } else if ($this->session->userdata()['level'] == 5) { ?>
                    console.log(spt['status'])
                    if (spt['status'] == 1 && spt['id_seksi'] == currentUser['id_seksi']) {
                        var aksiBtn = `
                    <a class="approv dropdown-item"  data-jenis='spt' data-id='${spt['id_spt']}' ><i class='fa fa-check'></i> Approv</a>
                    <a class="deapprov dropdown-item " data-jenis='spt' data-id='${spt['id_spt']}' ><i class='fa fa-times'></i> Tolak Approv</a>
                    `;
                    } else if ((spt['status'] == 2 || spt['unapprove_oleh'] == currentUser['id']) && spt['id_seksi'] == currentUser['id_seksi']) {
                        var aksiBtn = `
                        <a class="batal_aksi dropdown-item"  data-jenis='spt'  data-id='${spt['id_spt']}' ><i class='fa fa-check'></i> Batal Aksi</a>
                        `;
                    }
                <?php  } else if ($this->session->userdata()['level'] == 8) { ?>
                    console.log(spt['id_satuan'])
                    if (spt['status'] == 50 && spt['id_satuan'] == currentUser['id_satuan']) {
                        console.log("hereess23")
                        var aksiBtn = `
                    <a class="approv dropdown-item"  data-jenis='spt' data-id='${spt['id_spt']}' ><i class='fa fa-check'></i> Approv</a>
                    <a class="deapprov dropdown-item " data-jenis='spt' data-id='${spt['id_spt']}' ><i class='fa fa-times'></i> Tolak Approv</a>
                    `;
                    } else if ((spt['status'] == 51 || spt['unapprove_oleh'] == currentUser['id']) && spt['id_satuan'] == currentUser['id_satuan']) {
                        var aksiBtn = `
                        <a class="batal_aksi dropdown-item"  data-jenis='spt'  data-id='${spt['id_spt']}' ><i class='fa fa-check'></i> Batal Aksi</a>
                        `;
                    }
                <?php  } else if ($this->session->userdata()['level'] == 7) { ?>
                    console.log(spt['id_satuan'])
                    if (spt['status'] == 59 && spt['id_satuan'] == currentUser['id_satuan']) {
                        console.log("hereess23")
                        var aksiBtn = `
                    <a class="approv dropdown-item"  data-jenis='spt' data-id='${spt['id_spt']}' ><i class='fa fa-check'></i> Approv</a>
                    <a class="deapprov dropdown-item " data-jenis='spt' data-id='${spt['id_spt']}' ><i class='fa fa-times'></i> Tolak Approv</a>
                    `;
                    } else if ((spt['status'] == 51 || spt['unapprove_oleh'] == currentUser['id']) && spt['id_satuan'] == currentUser['id_satuan']) {
                        var aksiBtn = `
                        <a class="batal_aksi dropdown-item"  data-jenis='spt'  data-id='${spt['id_spt']}' ><i class='fa fa-check'></i> Batal Aksi</a>
                        `;
                    }
                <?php  } else if ($this->session->userdata()['penomoran'] == 1) { ?>
                    console.log('here')
                    if (spt['status'] == 99) {
                        var aksiBtn = `
                    <a class="approv dropdown-item"  data-jenis='spt' data-id='${spt['id_spt']}' ><i class='fa fa-check'></i> Approv</a>
                    <a class="deapprov dropdown-item " data-jenis='spt' data-id='${spt['id_spt']}' ><i class='fa fa-times'></i> Tolak Approv</a>
                    `;
                    }
                <?php  } ?>
                if (spt['status'] == 6 && spt['id_ppk2'] == '<?= $this->session->userdata()['id'] ?>' && spt['id_ppk2'] != '') {
                    var aksiBtn = `
                    <a class="approv dropdown-item"  data-jenis='spt' data-id='${spt['id_spt']}' ><i class='fa fa-check'></i> Approv</a>
                    <a class="deapprov dropdown-item " data-jenis='spt' data-id='${spt['id_spt']}' ><i class='fa fa-times'></i> Tolak Approv</a>
                    `;
                } else if ((spt['status'] == 11 || spt['unapprove_oleh'] == '<?= $this->session->userdata()['id'] ?>') && spt['id_ppk'] == '<?= $this->session->userdata()['id'] ?>' && spt['id_ppk'] != '') {
                    var aksiBtn = `
                        <a class="batal_aksi dropdown-item"  data-jenis='spt'  data-id='${spt['id_spt']}' ><i class='fa fa-check'></i> Batal Aksi</a>
                        `;
                } else if (
                    (spt['status'] == 51 && spt['id_pptk'] == '<?= $this->session->userdata()['id'] ?>' && spt['id_pptk'] != '') ||
                    (spt['status'] == 52 && spt['id_ppk2'] == '<?= $this->session->userdata()['id'] ?>' && spt['id_ppk'] != '')
                ) {
                    var aksiBtn = `
                    <a class="approv dropdown-item"  data-jenis='spt' data-id='${spt['id_spt']}' ><i class='fa fa-check'></i> Approv</a>
                    <a class="deapprov dropdown-item " data-jenis='spt' data-id='${spt['id_spt']}' ><i class='fa fa-times'></i> Tolak Approv</a>
                    `;
                };
                if ((spt['unapprove_oleh'] == '<?= $this->session->userdata()['id'] ?>')) {
                    var aksiBtn = `
                        <a class="batal_aksi dropdown-item"  data-jenis='spt'  data-id='${spt['id_spt']}' ><i class='fa fa-check'></i> Batal Aksi</a>
                        `;
                }
                var lihatButton = `
                     <a class="dropdown-item" target="_blank" style="width: 110px" href='<?= base_url() ?>spt/print/${spt['id_spt']}/1'><i class='fa fa-eye'></i> PDF SPT  </a>
                         `;
                if (spt['jenis'] == 2) {
                    lihatButton = lihatButton +
                        `
                        <a class="dropdown-item" target="_blank" style="width: 110px" href='<?= base_url() ?>spt/print/${spt['id_spt']}/2'><i class='fa fa-eye'></i> PDF SPPD </a>
                `;

                }
                // var lihatButton = `
                //      <a class="dropdown-item" target="_blank" style="width: 110px" href='<?= base_url() ?>spt/print/${spt['id_spt']}/1'><i class='fa fa-eye'></i> PDF SPT  </a>
                //      <a class="dropdown-item" target="_blank" style="width: 110px" href='<?= base_url() ?>spt/print/${spt['id_spt']}/2'><i class='fa fa-eye'></i> PDF SPPD </a>
                //      <a class="dropdown-item" target="_blank" style="width: 110px" href='<?= base_url() ?>spt/print/${spt['id_spt']}/3'><i class='fa fa-eye'></i> PDF SPT Barcode </a>
                //      <a class="dropdown-item" target="_blank" style="width: 110px" href='<?= base_url() ?>spt/print/${spt['id_spt']}/barcode'><i class='fa fa-eye'></i> PDF Barcode </a>
                //   `;
                lihatButton = lihatButton +
                    `
                         <a class="dropdown-item" target="_blank" style="width: 110px" href='<?= base_url() ?>spt/detail/${spt['id_spt']}'><i class='fa fa-eye'></i> Lihat </a>
                 `;

                var aprvButton = `
                                `;
                var deaprvButton = `
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
                // console.log(button)
                i = 1;
                d1 = '';
                d2 = '';
                tmpt = 'Tujuan : ';
                Object.values(spt['tujuan']).forEach((tj) => {
                    if (i == 1) {
                        d1 = tj['date_berangkat'];
                        tmpt = tmpt + tj['tempat_tujuan'];
                    } else {
                        tmpt = tmpt + ', ' + tj['tempat_tujuan'];

                    }
                    d2 = tj['date_kembali'];

                    i++;
                })
                if (spt['jenis'] == 2) {
                    tmpt = tmpt + '<br>No SPT : ' + (spt['no_spt'] ? spt['no_spt'] : '') + '<br>No SPPD : ' + (spt['no_sppd'] ? spt['no_sppd'] : '');
                } else {
                    tmpt = tmpt + '<br>No SPT : ' + (spt['no_spt'] ? spt['no_spt'] : '');

                }
                pegawai = spt['nama_pegawai'];
                i = 1;
                Object.values(spt['pengikut']).forEach((p) => {
                    if (i == 1)
                        pegawai = pegawai + '<br> Pengikut : ';
                    pegawai = pegawai + '<br>' + i + '. ' + p['nama'];
                    // d2 = tj['date_kembali']
                    i++;
                })

                dfix = d1.split(" ")[0] + ' s.d ' + d1.split(" ")[0];
                renderData.push([spt['nama_ref_jen_spt'], dfix, pegawai, tmpt, statusSPT(spt['status'], spt['unapprove_oleh']), spt['id_spt'], button]);
            });
            FDataTable.clear().rows.add(renderData).draw('full-hold');
        };
        FDataTable.on('click', '.verif_cuti', function() {
            // var jenis = $(this).data('jenis');
            curData = dataSKP['surat_izin'][$(this).data('id')];
            console.log('verf');
            console.log(curData);
            VerifModal.self.modal('show');
            $('#verif_modal').modal('show');
            VerifModal.idSuratIzin.val(curData['id_surat_izin']);
            VerifModal.periode_start.val(curData['periode_start']);
            VerifModal.periode_end.val(curData['periode_end']);
            VerifModal.lama_izin.val(curData['lama_izin']);
            VerifModal.nama_izin.val(curData['nama_izin']);
            VerifModal.nama_pegawai.val(curData['nama_pegawai']);
            VerifModal.nama_pengganti.val(curData['nama_pengganti']);
            VerifModal.alasan.val(curData['alasan']);
            if (curData['jenis_izin'] == '11') {
                VerifModal.c_n.prop('required', true)
                VerifModal.c_n1.prop('required', true)
                VerifModal.c_n2.prop('required', true)
                VerifModal.c_sisa_n.prop('required', true)
                VerifModal.c_sisa_n1.prop('required', true)
                VerifModal.c_sisa_n2.prop('required', true)
                $('.layout_c_tahunan').show();
            } else {
                VerifModal.c_n.prop('required', false)
                VerifModal.c_n1.prop('required', false)
                VerifModal.c_n2.prop('required', false)
                VerifModal.c_sisa_n.prop('required', false)
                VerifModal.c_sisa_n1.prop('required', false)
                VerifModal.c_sisa_n2.prop('required', false)
                $('.layout_c_tahunan').hide();
            }
            VerifModal.c_n.val(curData['c_n']);
            VerifModal.c_n1.val(curData['c_n1']);
            VerifModal.c_n2.val(curData['c_n2']);
            VerifModal.c_sisa_n.val(curData['c_sisa_n']);
            VerifModal.c_sisa_n1.val(curData['c_sisa_n1']);
            VerifModal.c_sisa_n2.val(curData['c_sisa_n2']);
            if (curData['lampiran'] != null && curData['lampiran'] != '') {
                file_lampiran = curData['lampiran'].split(".");
                // if (file_lampiran[1] == 'pdf')

                lampHtml = `<a href='<?= base_url('uploads/lampiran_izin/') ?>${curData['lampiran']}'> Download </a>

                `
                lampHtml += `
                <div class="col-lg-12">
                <object width="100%" height="700px"data="<?= base_url('uploads/lampiran_izin/') ?>${curData['lampiran']}" type="application/pdf">
                                <iframe src="<?= base_url('uploads/lampiran_izin/') ?>${curData['lampiran']}"></iframe>
                            </object>
                            </div>`
                // file_lampiran[1];
                VerifModal.layout_lampiran.html(lampHtml);

            } else
                VerifModal.layout_lampiran.html('<b>tidak ada lampiran</b>');

        });

        FDataTable.on('click', '.data_izin', function() {
            var jenis = $(this).data('jenis');
            curData = dataSKP['surat_izin'][$(this).data('id')];
            console.log(curData);
            LihatModal.self.modal('show');
            LihatModal.periode_start.val(curData['periode_start']);
            LihatModal.periode_end.val(curData['periode_end']);
            LihatModal.lama_izin.val(curData['lama_izin']);
            LihatModal.nama_izin.val(curData['nama_izin']);
            LihatModal.nama_pegawai.val(curData['nama_pegawai']);
            LihatModal.nama_pengganti.val(curData['nama_pengganti']);
            LihatModal.alasan.val(curData['alasan']);
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
                VerifModal.layout_lampiran.html('<b>tidak ada lampiran</b>');

        });
        VerifModal.form.submit(function(event) {
            console.log('sub');
            event.preventDefault();
            var url = "<?= site_url('SuratIzin/action_verif/') ?>";
            Swal.fire(swalSaveConfigure).then((result) => {
                if (!result.value) {
                    return;
                }
                // buttonLoading(button);

                $.ajax({
                    url: url,
                    'type': 'POST',
                    data: VerifModal.form.serialize(),
                    success: function(data) {
                        // buttonIdle(button);
                        var json = JSON.parse(data);
                        if (json['error']) {
                            Swal.fire("Simpan Gagal", json['message'], "error");
                            return;
                        }
                        var d = json['data']
                        dataSKP['surat_izin'][d['id_surat_izin']] = d;
                        Swal.fire("Simpan Berhasil", "", "success");
                        renderSKP(dataSKP);
                        VerifModal.self.modal('hide');
                    },
                    error: function(e) {}
                });
            });
        });


        FDataTable.on('click', '.approv', function() {
            var jenis = $(this).data('jenis');
            var link = $(this).data('link');
            Swal.fire({
                title: "Konfrirmasi Approv",
                text: "Data ini akan di approv anda yakin ?",
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
                if (!result.isConfirmed) {
                    return;
                }
                Swal.fire({
                    title: 'Loading Approv!',
                    allowOutsideClick: false,
                });
                Swal.showLoading()
                cur_id = $(this).data('id')
                $.ajax({
                    url: `<?= base_url() ?>${jenis}/action/approv/${cur_id}`,
                    'type': 'get',
                    data: {
                        jenis: jenis
                    },
                    success: function(data) {
                        Swal.close();
                        // buttonIdle(button);
                        var json = JSON.parse(data);
                        if (json['error']) {
                            Swal.fire("Simpan Gagal", json['message'], "error");
                            return;
                        }
                        var d = json['data']
                        if (jenis == 'spt')
                            dataSKP[jenis][d['id_spt']] = d;
                        else if (jenis == 'suratizin')
                            dataSKP['surat_izin'][d['id_surat_izin']] = d;
                        console.log(jenis);
                        Swal.fire("Approv Berhasil", "", "success");
                        renderSKP(dataSKP);
                    },
                    error: function(e) {}
                });
            });
        })

        FDataTable.on('click', '.deapprov', function() {
            var currentData = dataSKP[$(this).data('id')];
            var jenis = $(this).data('jenis');
            Swal.fire({
                title: "Konfrirmasi Penolakan",
                text: "Data ini akan ditolak ?",
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
                if (!result.isConfirmed) {
                    return;
                }
                Swal.fire({
                    title: 'Loading Tolak Approv!',
                    allowOutsideClick: false,
                });
                Swal.showLoading()
                cur_id = $(this).data('id')
                $.ajax({
                    url: `<?= base_url('Spt/action/unapprov/') ?>${cur_id}`,
                    'type': 'get',
                    data: {
                        id: $(this).data('id'),
                        aksi: 3,
                        jenis: jenis
                    },
                    success: function(data) {

                        Swal.close();

                        // buttonIdle(button);
                        var json = JSON.parse(data);
                        if (json['error']) {
                            Swal.fire("Tolak Gagal", json['message'], "error");
                            return;
                        }
                        var d = json['data']
                        dataSKP[jenis][d['id_spt']] = d;
                        Swal.fire("SKP Berhasil ditolak", "", "success");
                        renderSKP(dataSKP);
                    },
                    error: function(e) {}
                });
            });
        })

        FDataTable.on('click', '.batal_aksi', function() {
            var currentData = dataSKP[$(this).data('id')];
            var jenis = $(this).data('jenis');
            Swal.fire({
                title: "Konfrirmasi Batal",
                text: "Aksi untuk data ini akan dibatalkan?",
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
                console.log(result)
                if (!result.isConfirmed) {
                    return;
                }
                Swal.fire({
                    title: 'Loading Pembatalan!',
                    allowOutsideClick: false,
                });
                Swal.showLoading()
                cur_id = $(this).data('id')
                $.ajax({
                    url: `<?= base_url('Spt/action/undo/') ?>${cur_id}`,
                    'type': 'get',
                    data: {
                        id: $(this).data('id'),
                        aksi: 1,
                        jenis: jenis
                    },
                    success: function(data) {

                        Swal.close();

                        // buttonIdle(button);
                        var json = JSON.parse(data);
                        if (json['error']) {
                            Swal.fire("Pembatalan Gagal", json['message'], "error");
                            return;
                        }
                        var d = json['data'];
                        dataSKP[jenis][d['id_spt']] = d;
                        Swal.fire("Pembatalan Berhasil", "", "success");
                        renderSKP(dataSKP);
                    },
                    error: function(e) {}
                });
            });
        })


    });
</script>