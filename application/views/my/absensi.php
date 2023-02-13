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
                                        <option value="1">Januari</option>
                                        <option value="2">Februari</option>
                                        <option value="3">Maret</option>
                                        <option value="4">April</option>
                                        <option value="5">Mei</option>
                                        <option value="6">Juni</option>
                                        <option value="7">Juli</option>
                                        <option value="8">Agustus</option>
                                        <option value="9">September</option>
                                        <option value="10">Oktober</option>
                                        <option value="11">November</option>
                                        <option value="12">Desember</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class=" col-md-6 col-lg-8">
                            <!-- <button type="submit" class="btn btn-primary btn-md" ><i class="fa fa-search"></i> Cari </button> -->
                            <!-- <button type="button" class="btn btn-primary btn-md" name="btn_cari" id="btn_cari"><i class="fa fa-search"></i> Cari </button> -->
                            <a href="<?= base_url(
                                            'absensi/record'
                                        ) ?>" class="btn btn-primary btn-md"><i class="fa fa-calendar"></i>Record Absen </a>
                            <button type="button" class="btn btn-light btn-md float-end" name="btn_print" id="btn_print"><i class="fa fa-print"></i> Print </button>
                        </div>
                    </form>
                </div>

                <div class="card-body">
                    <div class="">
                        <table id="FDataTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th style=" text-align:center!important" rowspan="2">Tanggal</th>
                                    <th style=" text-align:center!important" rowspan="2">Hari</th>
                                    <th style=" text-align:center!important" colspan="2">Waktu Absen</th>
                                </tr>
                                <tr>
                                    <th style="text-align:center!important">p</th>
                                    <th style="text-align:center!important">s</th>
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
        $('#sidebar_absensi').addClass('active_c');

        var toolbar = {
            'form': $('#toolbar_form'),
            'bulan': $('#toolbar_form').find('#bulan'),
            'tahun': $('#toolbar_form').find('#tahun'),
            'btn_cari': $('#btn_cari'),
            'btn_print': $('#btn_print'),
        }

        toolbar.bulan.val(<?= date('m') ?>);
        toolbar.bulan.on('change', function() {
            console.log('gan');
            console.log(toolbar.bulan.val());
            getAbsensi();
        })


        toolbar.tahun.on('change', function() {
            console.log('gan');
            console.log(toolbar.bulan.val());
            getAbsensi();
        })
        var FDataTable = $('#FDataTable').DataTable({
            paging: false,
            ordering: false,
            info: false,
        });

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

        $.when(getAbsensi()).then((e) => {
            // toolbar.newBtn.prop('disabled', false);
        }).fail((e) => {
            console.log(e)
        });



        toolbar.btn_cari.on('click', (e) => {
            getAbsensi();
        });;
        // toolbar.btn_cari.trigger('click');

        function getAbsensi() {
            Swal.fire({
                title: 'Loading!',
                allowOutsideClick: false,
            });
            Swal.showLoading()
            return $.ajax({
                url: `<?php echo site_url('absensi/getAllAbsensi/'); ?>`,
                'type': 'get',
                data: toolbar.form.serialize(),
                success: function(data) {
                    Swal.close();
                    var json = JSON.parse(data);
                    if (json['error']) {
                        return;
                    }
                    dataSppd = json['data'];
                    renderAbsensi(dataSppd);
                },
                error: function(e) {}
            });
        }


        function renderAbsensi(data) {
            console.log(data)
            FDataTable.clear();
            if (data == null || typeof data != "object") {
                console.log("Sppd::UNKNOWN DATA");
                return;
            }
            var renderData = [];
            v_tahun = toolbar.tahun.val();
            v_bulan = toolbar.bulan.val();
            lastday = new Date(v_tahun, v_bulan, 0).getDate();
            const hari = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
            for (i = 1; i <= lastday; i++) {
                cur_date = v_tahun + '-' + v_bulan + '-' + i;
                cur_date2 = i + '-' + v_bulan + '-' + v_tahun;
                const d = new Date(cur_date);
                let day = d.getDay();
                console.log(hari[day]);
                if (day != 0 && day != 6)
                    if (data?. [v_tahun]?. [v_bulan]?. [i] === undefined) {
                        renderData.push([cur_date2, hari[day], '', '']);
                    } else {
                        renderData.push([cur_date2, hari[day],
                            (data?. [v_tahun]?. [v_bulan]?. [i]?. ['p']?. ['rec_time'] !== undefined ? data?. [v_tahun]?. [v_bulan]?. [i]?. ['p']?. ['rec_time'] : ''),
                            (data?. [v_tahun]?. [v_bulan]?. [i]?. ['s']?. ['rec_time'] !== undefined ? data?. [v_tahun]?. [v_bulan]?. [i]?. ['s']?. ['rec_time'] : '')
                        ]);
                    }
            }
            FDataTable.clear().rows.add(renderData).draw('full-hold');
        }


    });
</script>