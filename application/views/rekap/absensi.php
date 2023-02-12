<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <form class="form-inline" id="toolbar_form">
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
                            <button type="button" class="btn btn-light btn-md float-end" name="btn_print" id="btn_print"><i class="fa fa-print"></i> Print </button>
                        </div>
                    </form>
                </div>

                <div class="card-body">
                    <div class="">
                        <table id="tbAbsensi" class="display">
                            <thead>
                                <tr>
                                    <?php
                                    $bln = (int) $filter['bulan'];
                                    $thn = (int) $filter['tahun'];

                                    $jlh_hari_kerja = 0;
                                    $td_tgl = '';
                                    $arr_tgl = [];
                                    for ($i = 1; $i < 31; $i++) {
                                        $hari = date("l", mktime(0, 0, 0, $bln, $i, $thn));
                                        // deteksi hari kerja
                                        // $hari != 'Saturday' && :untuk hari sabtu 
                                        if ($hari != 'Saturday' &&  $hari != 'Sunday' && $hari != '-') {
                                            array_push($arr_tgl, $i);
                                            $jlh_hari_kerja++;
                                            $td_tgl .=  "<td class='goto' data-tgl='{$i}'> {$i}</td>";
                                        }
                                    }
                                    ?>
                                    <th style=" text-align:center!important" rowspan="2">Nama Pegawai</th>
                                    <th style="display:none; text-align:center!important" rowspan="2">OPD</th>
                                    <th style=" text-align:center!important" colspan="<?= $jlh_hari_kerja ?>">Tanggal</th>
                                </tr>
                                <tr>
                                    <?= $td_tgl ?> </tr>
                            </thead>
                            <tbody>

                                <?php
                                //untuk menyusun hitungan setiap user, h: hadir, htf:hadir tidak full, s :sakit
                                foreach ($dataAbsen as $bagian) {
                                    foreach ($bagian['pegawai'] as $key => $usr) {
                                        if (empty($usr['nama'])) {

                                            var_dump($usr);
                                            die();
                                        }
                                        echo "<tr> <td class='nama text-left'> {$usr['nama']} </td>";
                                        echo "<td style='display:none'class='nama text-left'> {$bagian['nama_bag']} </td>";
                                        $absensi[$key]['h'] = 0;
                                        $absensi[$key]['htf'] = 0;
                                        $absensi[$key]['i'] = 0;
                                        $absensi[$key]['s'] = 0;
                                        $absensi[$key]['c'] = 0;
                                        $absensi[$key]['dl'] = 0;
                                        foreach ($arr_tgl as $i) {
                                            if (!empty($usr['child'][$thn][$bln][$i]['s']) && !empty($usr['child'][$thn][$bln][$i]['p'])) {

                                                $absensi[$key]['h']++;
                                                echo '<td class="edit green" data-ids="' . $usr['child'][$thn][$bln][$i]['s']['id_absen'] . '" data-idp="' . $usr['child'][$thn][$bln][$i]['p']['id_absen'] . '">.</td>';
                                            } else if (!empty($usr['child'][$thn][$bln][$i]['p'])) {
                                                if ($usr['child'][$thn][$bln][$i]['p']['st_absen'] == 'i')
                                                    $absensi[$key]['i']++;
                                                if ($usr['child'][$thn][$bln][$i]['p']['st_absen'] == 's')
                                                    $absensi[$key]['s']++;
                                                if ($usr['child'][$thn][$bln][$i]['p']['st_absen'] == 'dl')
                                                    $absensi[$key]['dl']++;
                                                if ($usr['child'][$thn][$bln][$i]['p']['st_absen'] == 'c')
                                                    $absensi[$key]['c']++;
                                                if ($usr['child'][$thn][$bln][$i]['p']['st_absen'] == 'h')
                                                    $absensi[$key]['htf']++;
                                                echo '<td class="yellow">' . $usr['child'][$thn][$bln][$i]['p']['st_absen'] . '</td>';
                                            } else {
                                                echo '<td class="edit red" data-ids="" data-idp="">a</td>';
                                            }
                                        }
                                        echo '</tr>';
                                    }
                                }
                                ?>
                            </tbody>
                        </table>


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
        $('#sidebar_wrapper_func').addClass('close_icon');
        // $('#sidebar_skp').addClass('active_c');
        $('#menu_4').addClass('active');
        $('#opmenu_4').show();
        $('#submenu_11').addClass('active');
        var toolbar = {
            'form': $('#toolbar_form'),
            'bulan': $('#toolbar_form').find('#bulan'),
            'tahun': $('#toolbar_form').find('#tahun'),
            'btn_cari': $('#btn_cari'),
            'btn_print': $('#btn_print'),
        }

        $('#tbAbsensi').DataTable({
            // order: [
            //     [2, 'asc']
            // ],
            ordering: false,
            rowGroup: {
                dataSrc: 1
            }
        });


        toolbar.bulan.val(<?= $bln ?>);
        toolbar.tahun.val(<?= $thn ?>);
        toolbar.bulan.on('change', function() {
            toolbar_form.submit();
        })
        toolbar.tahun.on('change', function() {
            toolbar_form.submit();
        })

        toolbar.tahun.on('change', function() {
            console.log('gan');
            console.log(toolbar.bulan.val());
            getAbsensi();
        })

        var dataRole = {}
        var dataSppd = {}


        // toolbar.btn_cari.on('click', (e) => {});
        // toolbar.btn_cari.trigger('click');



    });
</script>