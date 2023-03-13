<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <form class="col-lg-12" id="toolbar_form" onsubmit="return false;">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label" for="tahun">Tahun</label>
                                <!-- <select class="form-control mr-2" name="tahun" id="tahun">
                                    <option value="">Semua Tahun</option>
                                    <option value="2023">2023</option>
                                    <option value="2022">2022</option>
                                </select> -->
                            </div>
                            <div class="col-md-7">
                                <label class="form-label" for="pkm">Puskesmas</label>
                                <select class='form-control select2 ' name="pkm" id="pkm">
                                    <option value="">Semua</option>

                                    <option value="bakam">Bakam</option>
                                    <option value="baturusa">Baturusa</option>
                                    <option value="belinyu">Belinyu</option>
                                    <option value="gunungmuda">Gunung Muda</option>
                                    <option value="kenanga">Kenanga</option>
                                    <option value="pemali">Pemali</option>
                                    <option value="penagan">Penagan</option>
                                    <option value="petaling">Petaling</option>
                                    <option value="pudingbesar">Puding Besar</option>
                                    <option value="riausilip">Riau Silip</option>
                                    <option value="sinarbaru">Sinar Baru</option>
                                    <option value="sungailiat">Sungailiat</option>
                                </select>
                            </div>
                        </div>
                    </form>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="FDataTable" class="table table-bordered table-hover" style="padding:0px">
                                <thead>
                                    <tr>
                                        <th style="width: 2%; text-align:center!important">Pkm</th>
                                        <th style="width: 2%; text-align:center!important">Tanggal</th>
                                        <th style="width: 60%; text-align:center!important">Judul</th>
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
</div>

<script>
    $(document).ready(function() {
        $('#ikm').addClass('active');

        var toolbar = {
            'form': $('#toolbar_form'),
            'id_ref': $('#toolbar_form').find('#id_ref'),
            'tahun': $('#toolbar_form').find('#tahun'),
            'pkm': $('#toolbar_form').find('#pkm'),
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
        var dataUser = {}

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

        $.when(getAllUser()).then((e) => {
            toolbar.newBtn.prop('disabled', false);
        }).fail((e) => {
            console.log(e)
        });


        toolbar.tahun.on('change', function() {
            getAllUser();
        })
        toolbar.pkm.on('change', function() {
            getAllUser();
        })

        function getAllUser() {
            swalLoading()
            return $.ajax({
                url: `<?= base_url() ?>MonitoringWebsite/getAll`,
                'type': 'get',
                data: toolbar.form.serialize(),
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                success: function(data) {
                    swal.close();
                    var json = JSON.parse(data);
                    if (json['error']) {
                        return;
                    }
                    dataUser = json['data'];
                    renderUser(dataUser);
                },
                error: function(e) {}
            });
        }

        function renderUser(data) {
            if (data == null || typeof data != "object") {
                console.log("User::UNKNOWN DATA");
                return;
            }
            var i = 0;

            var renderData = [];
            Object.values(data).forEach((bank_data) => {
                var lihat = `
        <a class="dropdown-item"  target="_blank" href='https://${bank_data['pkm']}.puskesmas.bangka.go.id/${bank_data['tulisan_jenis'].toLowerCase()}/${bank_data['tulisan_slug']}'><i class='fa fa-eye'></i> Lihat</a>
      `;
                var hide = `
        <a class="hide_survey dropdown-item" data-id='${bank_data['tulisan_id']}'><i class='fa fa-eye-slash'></i> Sembunyikan</a>
      `;

                renderData.push([bank_data['pkm'], bank_data['tulisan_tanggal'], bank_data['tulisan_judul'], lihat]);
            });
            FDataTable.clear().rows.add(renderData).draw('full-hold');
        }

        function statusRespon(realisasi) {
            var realisasi = parseFloat(realisasi);
            if (realisasi == 1)
                return `<span class="label label-danger">Tidak Baik</span>`;
            else if (realisasi == 2)
                return `<span class="label label-warning">Kurang Baik</span>`;
            else if (realisasi == 3)
                return `<span class="label label-info">Cukup Baik</span>`;
            else if (realisasi == 4)
                return `<span class="label label-success">Sangat Baik</span>`;
            else return `-`;
        }

        FDataTable.on('click', '.show_survey', function() {
            var currentData = $(this).data('id');
            edit_survey(currentData, 1)
            dataUser[$(this).data('id')]['show_survey'] = 1;
            renderUser(dataUser);

        });


        FDataTable.on('click', '.hide_survey', function() {
            var currentData = $(this).data('id');
            edit_survey(currentData, 2)
            dataUser[$(this).data('id')]['show_survey'] = 2;
            renderUser(dataUser);
        });

        function edit_survey(id, sh) {
            event.preventDefault();
            var url = "<?= site_url('Admin/edit_survey') ?>";

            swal(swalSaveConfigure).then((result) => {
                if (!result.value) {
                    return;
                }
                // buttonLoading(button);
                $.ajax({
                    url: url,
                    'type': 'POST',
                    data: {
                        'id': id,
                        'sh': sh
                    },
                    success: function(data) {
                        var json = JSON.parse(data);
                        if (json['error']) {
                            swal("Simpan Gagal", json['message'], "error");
                            return;
                        }
                        swal("Simpan Berhasil", "", "success");
                    },
                    error: function(e) {}
                });
            });
        };


    });
</script>