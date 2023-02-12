<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <form class="form-inline" id="toolbar_form" onsubmit="return false;">
                        <div class="col-sm-12 col-md-6 col-lg-4 mr-2 pl-10 pr-10 ml-10">
                                    <div class="row">
                                <div class="col-md-4">
                                    <select class="form-control" name="tahun" id="tahun">
                                        <option value="2023">2023</option>
                                        <option value="2022">2022</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <select class="form-control" name="bulan" id="bulan">
                                        <option value="01">Januari</option>
                                        <option value="02">Februari</option>
                                        <option value="03">Maret</option>
                                        <option value="04">April</option>
                                        <option value="05">Mei</option>
                                        <option value="06">Juni</option>
                                        <option value="07">Juli</option>
                                        <option value="08">Agustus</option>
                                        <option value="09">September</option>
                                        <option value="10">Oktober</option>
                                        <option value="11">November</option>
                                        <option value="12">Desember</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class=" col-md-6 col-lg-8">
                            <button type="button" class="btn btn-primary btn-md" name="btn_cari" id="btn_cari"><i class="fa fa-search"></i> Cari </button>
                            <a type="button" class="btn btn-success btn-md" href="<?= base_url('aktifitas/add') ?>" id="new_btn" disabled="disabled"><i class="fa fa-plus"></i> Tambah </a>
                            <a href="<?= base_url('absen/record') ?>" class="btn btn-warning btn-md"><i class="fa fa-calendar"></i> Absen </a>
                            <button type="button" class="btn btn-light btn-md float-end" name="btn_print" id="btn_print"><i class="fa fa-print"></i> Print </button>
                            <!-- <button type="button" class="btn btn-primary btn-sm" name="btn_cari" id="btn_cari"><i class="fa fa-search"></i> Cari </button> -->
                            <!-- <a type="button" class="btn btn-primary btn-sm mr-10 ml-10" href="<?= base_url('aktifitas/print/1') ?>" id="" disabled="disabled"><i class="fa fa-print"></i> Print </a> -->
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
                                    <th style="width: 10%; text-align:center!important">AKTIFITAS</th>
                                    <!-- <th style="width: 24%; text-align:center!important">PEGAWAI</th> -->
                                    <!-- <th style="width: 10%; text-align:center!important">TUJUAN</th> -->
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
        $('#sidebar_aktifitas').addClass('active_c');

        var toolbar = {
            'form': $('#toolbar_form'),
            'tahun': $('#toolbar_form').find('#tahun'),
            'bulan': $('#toolbar_form').find('#bulan'),
            'btn_cari': $('#btn_cari'),
            'btn_print': $('#btn_print'),

        }

        toolbar.tahun.val('<?= $dataContent['tahun'] ?>');
        toolbar.bulan.val('<?= $dataContent['bulan'] ?>');
        var FDataTable = $('#FDataTable').DataTable({
            'columnDefs': [],
            deferRender: true,
            "order": [
                [0, "desc"]
            ]
        });

        // var SppdModal = {
        //     'self': $('#aktifitas_modal'),
        //     'info': $('#aktifitas_modal').find('.info'),
        //     'form': $('#aktifitas_modal').find('#aktifitas_form'),
        //     'addBtn': $('#aktifitas_modal').find('#add_btn'),
        //     'saveEditBtn': $('#aktifitas_modal').find('#save_edit_btn'),
        //     'idSppd': $('#aktifitas_modal').find('#id'),
        //     'aktifitasname': $('#aktifitas_modal').find('#aktifitasname'),
        //     'nama': $('#aktifitas_modal').find('#nama'),
        //     'nip': $('#aktifitas_modal').find('#nip'),
        //     'email': $('#aktifitas_modal').find('#email'),
        //     'no_hp': $('#aktifitas_modal').find('#no_hp'),
        //     'status': $('#aktifitas_modal').find('#status'),
        //     'password': $('#aktifitas_modal').find('#password'),
        //     'jabatan': $('#aktifitas_modal').find('#jabatan'),
        //     'pangkat_gol': $('#aktifitas_modal').find('#pangkat_gol'),
        //     'id_role': $('#aktifitas_modal').find('#id_role'),
        //     'id_bagian': $('#aktifitas_modal').find('#id_bagian'),
        //     'id_seksi': $('#aktifitas_modal').find('#id_seksi'),
        //     'id_satuan': $('#aktifitas_modal').find('#id_satuan'),
        // }

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

        $.when().then((e) => {
            toolbar.newBtn.prop('disabled', false);
        }).fail((e) => {
            console.log(e)
        });



        toolbar.btn_cari.on('click', (e) => {
            getAllSppd();
        });
        toolbar.btn_print.on('click', (e) => {
            print();
        });
        toolbar.btn_cari.trigger('click');

        function getAllSppd() {
            Swal.fire({
                title: 'Loading!',
                allowOutsideClick: false,
            });
            Swal.showLoading()
            return $.ajax({
                url: `<?php echo site_url('aktifitas/getAllAktifitas/') ?>`,
                'type': 'post',
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


        function print() {
            toolbar.tahun.val()
            window.open(`<?= base_url('aktifitas/print/') ?>?tahun=${toolbar.tahun.val()}&bulan=${toolbar.bulan.val()}`);
            // Swal.fire({
            //     title: 'Loading SPPD!',
            //     allowOutsideClick: false,
            // });
            // Swal.showLoading()
            // return $.get({
            //     url: ``,
            //     data: toolbar.form.serialize(),
            //     function(data) {
            //         var w = window.open('about:blank');
            //         w.document.open();
            //         w.document.write(data);
            //         w.document.close();
            //     },
            //     error: function(e) {}
            // });
        }

        function renderSppd(data) {
            console.log(data)
            if (data == null || typeof data != "object") {
                console.log("Sppd::UNKNOWN DATA");
                return;
            }
            var i = 0;

            var renderData = [];
            Object.values(data).forEach((aktifitas) => {
                var editButton = `
                    <a class="dropdown-item"  href='<?= base_url() ?>aktifitas/edit/${aktifitas['id_aktifitas']}'><i class='fa fa-pencil'></i> Edit</a>
                  `;

                var lihatButton = `
                    <a class="dropdown-item" style="width: 110px" href='<?= base_url() ?>user/detail_perjadin/${aktifitas['id_aktifitas']}'><i class='fa fa-eye'></i> Buka</a>
                `;

                var deleteButton = `
                    <a class="delete dropdown-item" data-id='${aktifitas['id']}'><i class='fa fa-trash'></i> Hapus </a>
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
                                    ${editButton}
                                    ${deleteButton}
                                    ${lihatButton}
                                    </div>
                                </div>
                            </div>
                        </div>`;
                tujuan = '';
                i = 1;
                // Object.values(aktifitas['tujuan']).forEach((tj) => {
                //     if (i == 1)
                //         tujuan += '1. ' + tj['tempat_tujuan'] + ' (' + tj['date_berangkat'] + ')';
                //     else
                //         tujuan += '<br>' + i + '. ' + tj['tempat_tujuan'] + ' (' + tj['date_berangkat'] + ')';
                //     i++;

                // })
                renderData.push([aktifitas['id_aktifitas'], aktifitas['date'], aktifitas['aktifitas'], button]);
            });
            FDataTable.clear().rows.add(renderData).draw('full-hold');
        }


    });
</script>