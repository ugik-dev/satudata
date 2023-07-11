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
                                                    <select class="form-control " name="status_rekap" id="status_rekap">
                                                        <option value=""> Semua </option>
                                                        <option value="ditolak" selected> Di Tolak </option>
                                                        <option value="selesai" selected> Selesai </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="mb-3 row">
                                                <label class="col-sm-3 col-form-label">Jenis Pegawai </label>
                                                <div class="col-sm-8">
                                                    <select class="form-control " name="jen_izin" id="jen_izin">
                                                        <option value=""> Semua </option>
                                                        <option value="1"> ASN</option>
                                                        <option value="2"> Honorer </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="mb-3 row">
                                                <label class="col-sm-3 col-form-label">Jenis Izin </label>
                                                <div class="col-sm-8">
                                                    <select class="form-control " name="jenis_izin" id="jenis_izin">
                                                        <option value=""> Semua </option>
                                                        <?php
                                                        foreach ($dataContent['jenis_izin'] as $ji) {
                                                            echo "<option value='{$ji['id_ref_jen_izin']}'> {$ji['nama_izin']} </option>    ";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="mb-3 row">
                                                <label class="col-sm-3 col-form-label">Instansi </label>
                                                <div class="col-sm-8">
                                                    <select class="form-control " name="id_satuan" id="id_satuan">
                                                        <option value=""> Semua </option>
                                                        <?php
                                                        foreach ($dataContent['instansi'] as $ji) {
                                                            echo "<option value='{$ji['id_satuan']}'> {$ji['nama_satuan']} </option>    ";
                                                        }
                                                        ?>
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
                                                    <input class="form-control m-input digits" id="dari" name="dari" type="date" value="<?= date("Y-m-d", strtotime("-1 months")); ?>" data-bs-original-title="" title="">
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="mb-3 row">
                                                <label class="col-sm-3 col-form-label">Sampai</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control m-input digits" id="sampai" name="sampai" type="date" value="<?= date('Y-m-d') ?>" data-bs-original-title="" title="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="checkbox-animated m-checkbox-inline">
                                            <label class="form-check form-check-inline" for="chk-surat-izin">
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
                                    <th rowspan=2 style=" width: 5%; text-align:center!important">JENIS</th>
                                    <th rowspan=2 style="width: 10%; text-align:center!important">TGL PENGAJUAN</th>
                                    <th rowspan=2 style="width: 10%; text-align:center!important">DARI</th>
                                    <th rowspan=2 style="width: 10%; text-align:center!important">SAMPAI</th>
                                    <th rowspan=2 style="width: 10%; text-align:center!important">INSTANSI</th>
                                    <th rowspan=2 style="width: 10%; text-align:center!important">NOMOR</th>
                                    <th rowspan=2 style="width: 10%; text-align:center!important">PEGAWAI</th>
                                    <th rowspan=2 style="width: 20%; text-align:center!important">PENGGANTI</th>
                                    <th rowspan=2 style="width: 20%; text-align:center!important">LAMA (Hari)</th>
                                    <th style="width: 5%; text-align:center!important" colspan="3">CUTI TAHUNAN</th>
                                    <th rowspan=2 style="width: 5%; text-align:center!important">STATUS</th>
                                    <th rowspan=2 style="width: 2%; text-align:center!important">ID</th>
                                    <th rowspan=2 style="width: 5%; text-align:center!important">Action</th>
                                </tr>
                                <tr>
                                    <td>N</td>
                                    <td>N1</td>
                                    <td>N2</td>
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
                                    <div class="col-form-label">Tahun <span class="c_label_n">N</span></div>
                                    <input type="number" name="c_n" id="c_n" class="form-control" readonly />
                                </div>
                                <div class="col-lg-4 layout_c_tahunan">
                                    <div class="col-form-label">Tahun <span class="c_label_n1">N</span></div>
                                    <input type="number" name="c_n1" id="c_n1" class="form-control" readonly />
                                </div>
                                <div class="col-lg-4 layout_c_tahunan">
                                    <div class="col-form-label">Tahun <span class="c_label_n2">N</span></div>
                                    <input type="number" name="c_n2" id="c_n2" class="form-control" readonly />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 layout_c_tahunan">
                                    <div class="col-form-label">Sisa Tahun <span class="c_label_n">N</span></div>
                                    <input type="number" name="c_sisa_n" id="c_sisa_n" class="form-control" readonly />
                                </div>
                                <div class="col-lg-4 layout_c_tahunan">
                                    <div class="col-form-label">Sisa Tahun <span class="c_label_n1">N</span></div>
                                    <input type="number" name="c_sisa_n1" id="c_sisa_n1" class="form-control" readonly />
                                </div>
                                <div class="col-lg-4 layout_c_tahunan">
                                    <div class="col-form-label">Sisa Tahun <span class="c_label_n2">N</span></div>
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
                                    <div class="col-form-label">Sisa Tahun <span class="c_label_n">N</span></div>
                                    <input type="number" name="c_sisa_n" id="c_sisa_n" class="form-control" required />
                                </div>
                                <div class="col-lg-4 layout_c_tahunan">
                                    <div class="col-form-label">Sisa Tahun <span class="c_label_n1">N-1</span></div>
                                    <input type="number" name="c_sisa_n1" id="c_sisa_n1" class="form-control" required />
                                </div>
                                <div class="col-lg-4 layout_c_tahunan">
                                    <div class="col-form-label">Sisa Tahun <span class="c_label_n2">N-2</span></div>
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

<div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form opd="form" id="edit_form" onsubmit="return false;" type="multipart" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_title">
                        Form Edit Cuti
                    </h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id_surat_izin" name="id_surat_izin">
                    <div class="row">
                        <div class="col-lg-2">
                            <div class="col-form-label">Aksi</div>
                            <button class="btn btn-primary" id="save_edit_btn" data-loading-text="Loading..."><strong>Simpan</strong></button>
                        </div>
                        <!-- <div class="col-lg-4">
                            <div class="col-form-label">Status Verifikasi</div>
                            <select id="verif" name="verif" class="form-control">
                                <option value="1">Diterima</option>
                                <option value="2">Ditolak</option>
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <div class="col-form-label">Catatan Verifikator Cuti</div>
                            <input id="cttn_verif" name="cttn_verif" class="form-control"></input>
                        </div> -->
                    </div>
                    <div class="hr-line-dashed"></div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-form-label">Nomor Surat Pemberian Cuti / Izin</div>
                            <input id="no_spc" name="no_spc" class="form-control">
                        </div>
                        <div class="col-lg-6">
                            <div class="col-form-label">Yang Mengajukan</div>
                            <input id="nama_pegawai" class="form-control" readonly>
                        </div>
                        <div class="col-lg-6">
                            <div class="col-form-label">Pegawai Pengganti</div>
                            <input id="nama_pengganti" class="form-control" readonly>
                        </div>
                        <div class="col-lg-6">
                            <div class="col-form-label">Jenis</div>
                            <input id="nama_izin" class="form-control" readonly>
                        </div>
                        <div class="col-lg-6">
                            <div class="col-form-label">Tanggal Pengajuan</div>
                            <input id="tanggal_pengajuan" name="tanggal_pengajuan" type="date" class="form-control">
                        </div>
                        <!-- <div class="hr-line-dashed"></div> -->
                        <div class="col-lg-8">
                            <div class="col-form-label">Tanggal Izin</div>
                            <div class="row">
                                <div class="col">
                                    <input name="periode_start" type="date" id="periode_start" class="form-control" value="<?= !empty($dataContent['return_data']['periode_start']) ? $dataContent['return_data']['periode_start'] : date("Y-m-d") ?>">
                                </div>
                                <div class="col-1 d-flex align-items-center">
                                    s.d.
                                </div>
                                <div class="col">
                                    <input name="periode_end" type="date" id="periode_end" class="form-control" value="<?= !empty($dataContent['return_data']['periode_end']) ? $dataContent['return_data']['periode_end'] : date("Y-m-d") ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="col-form-label">Lama Izin (hari)</div>
                            <div class="row">
                                <div class="col">
                                    <input type="number" name="lama_izin" id="lama_izin" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="col-form-label">Alasan</div>
                            <div class="row">
                                <div class="col">
                                    <textarea type="text" name="alasan" id="alasan" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="col-form-label">Alamat Selamat Menjalankan Cuti / Izin</div>
                            <div class="row">
                                <div class="col">
                                    <textarea type="text" name="alamat_izin" id="alamat_izin" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-4 layout_c_tahunan">
                                    <div class="col-form-label">Sisa Tahun <span class="c_label_n">N</span></div>
                                    <input type="number" name="c_sisa_n" id="c_sisa_n" class="form-control" required />
                                </div>
                                <div class="col-lg-4 layout_c_tahunan">
                                    <div class="col-form-label">Sisa Tahun <span class="c_label_n1">N-1</span></div>
                                    <input type="number" name="c_sisa_n1" id="c_sisa_n1" class="form-control" required />
                                </div>
                                <div class="col-lg-4 layout_c_tahunan">
                                    <div class="col-form-label">Sisa Tahun <span class="c_label_n2">N-2</span></div>
                                    <input type="number" name="c_sisa_n2" id="c_sisa_n2" class="form-control" required />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 layout_c_tahunan">
                                    <div class="col-form-label">Digunakan Tahun <span class="c_label_n">N</span></div>
                                    <input type="number" name="c_n" id="c_n" class="form-control" required />
                                </div>
                                <div class="col-lg-4 layout_c_tahunan">
                                    <div class="col-form-label">Digunakan Tahun <span class="c_label_n1">N-1</span></div>
                                    <input type="number" name="c_n1" id="c_n1" class="form-control" required />
                                </div>
                                <div class="col-lg-4 layout_c_tahunan">
                                    <div class="col-form-label">Digunakan Tahun <span class="c_label_n2">N-2</span></div>
                                    <input type="number" name="c_n2" id="c_n2" class="form-control" required />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="col-form-label">Dokumen Lampiran (*kosongkan jika tidak diganti)</div>
                        <input type="file" name="file_lampiran" id="file_foto" class="form-control">

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


<div class="modal fade" id="riwayat_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form opd="form" id="" onsubmit="return false;" type="multipart" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_title">
                        Riwayat Approval
                    </h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6" id="status_izin"> </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="col-lg-12" id="layer_riwayat">
                    </div>
                    <table id="TableRiwayat" class="table table-border-horizontal" style="padding-bottom: 100px">
                        <thead>
                            <tr>
                                <th style="width: 5%; text-align:center!important">Waktu</th>
                                <th style="width: 10%; text-align:center!important">Keterangan</th>
                                <th style="width: 10%; text-align:center!important">Nama</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
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

        $('#menu_4').addClass('active');
        $('#opmenu_4').show();
        $('#submenu_12').addClass('active');
        var toolbar = {
            'form': $('#toolbar_form'),
            'jenis_permohonan': $('#toolbar_form').find('#jenis_permohonan'),
            'status': $('#toolbar_form').find('#status'),
            'newBtn': $('#new_btn'),
        }

        var FDataTable = $('#FDataTable').DataTable({
            dom: 'Bfrtip',
            'columnDefs': [],
            // responsive: true,
            deferRender: true,
            "order": [
                [1, "desc"]
            ],
            buttons: [{
                extend: 'excel',
                text: '<i class="fa fa-download ">  Export Excel</i>',
                className: 'excelButton btn btn-primary  font-weight-bold text-light',
                exportOptions: {
                    modifier: {}
                }
            }]
        });
        var TableRiwayat = $("#TableRiwayat").DataTable({
            columnDefs: [],
            responsive: false,
            deferRender: true,
            order: false,
        });

        var RiwayatModal = {
            self: $("#riwayat_modal"),
            layer_riwayat: $("#riwayat_modal").find("#layer_riwayat"),
        };

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
            'c_label_n': $('#verif_modal').find('#c_label_n'),
            'c_label_n1': $('#verif_modal').find('#c_label_n1'),
            'c_label_n2': $('#verif_modal').find('#c_label_n2'),
            'alasan': $('#verif_modal').find('#alasan'),
            'alamat_izin': $('#verif_modal').find('#alamat_izin'),
            'nama_izin': $('#verif_modal').find('#nama_izin'),
            'nama_pegawai': $('#verif_modal').find('#nama_pegawai'),
            'nama_pengganti': $('#verif_modal').find('#nama_pengganti'),
            'layout_lampiran': $('#verif_modal').find('#layout_lampiran'),
        }
        <?php if ($dataContent['edit_cuti']) { ?>
            var EditModal = {
                'self': $('#edit_modal'),
                'info': $('#edit_modal').find('.info'),
                'form': $('#edit_modal').find('#edit_form'),
                'addBtn': $('#edit_modal').find('#add_btn'),
                'saveEditBtn': $('#edit_modal').find('#save_edit_btn'),
                'idSuratIzin': $('#edit_modal').find('#id_surat_izin'),
                'periode_start': $('#edit_modal').find('#periode_start'),
                'periode_end': $('#edit_modal').find('#periode_end'),
                'lama_izin': $('#edit_modal').find('#lama_izin'),
                'no_spc': $('#edit_modal').find('#no_spc'),
                'status_izin': $('#edit_modal').find('#status_izin'),
                'c_sisa_n': $('#edit_modal').find('#c_sisa_n'),
                'c_sisa_n1': $('#edit_modal').find('#c_sisa_n1'),
                'c_sisa_n2': $('#edit_modal').find('#c_sisa_n2'),
                'c_label_n': $('#edit_modal').find('#c_label_n'),
                'c_label_n1': $('#edit_modal').find('#c_label_n1'),
                'c_label_n2': $('#edit_modal').find('#c_label_n2'),
                'c_n': $('#edit_modal').find('#c_n'),
                'c_n1': $('#edit_modal').find('#c_n1'),
                'c_n2': $('#edit_modal').find('#c_n2'),
                'tanggal_pengajuan': $('#edit_modal').find('#tanggal_pengajuan'),
                'alasan': $('#edit_modal').find('#alasan'),
                'alamat_izin': $('#edit_modal').find('#alamat_izin'),
                'nama_izin': $('#edit_modal').find('#nama_izin'),
                'nama_pegawai': $('#edit_modal').find('#nama_pegawai'),
                'nama_pengganti': $('#edit_modal').find('#nama_pengganti'),
                'layout_lampiran': $('#edit_modal').find('#layout_lampiran'),
            }
        <?php } ?>
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
        var dataRole = {}
        var dataIzin = {}
        <?php $curUser = $this->session->userdata(); ?>
        var currentUser = <?= json_encode([
                                'level' => $curUser['level'],
                                'id_seksi' => $curUser['id_seksi'],
                                'id_bagian' => $curUser['id_bagian'],
                                'id_satuan' => $curUser['id_satuan'],
                                'id' => $curUser['id'],
                            ]) ?>;
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

        $.when(getAllPermohonan()).then((e) => {}).fail((e) => {
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
                title: 'Loading Cuti!',
                allowOutsideClick: false,
            });
            Swal.showLoading()
            return $.ajax({
                url: `<?php echo site_url('rekap/getAllCuti/') ?>`,
                'type': 'get',
                data: toolbar.form.serialize(),
                success: function(data) {
                    Swal.close();
                    var json = JSON.parse(data);
                    if (json['error']) {
                        return;
                    }
                    dataIzin = json['data'];
                    renderSKP(dataIzin);
                },
                error: function(e) {}
            });
        }

        function renderSKP(data) {
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
            seksi = <?= $this->session->userdata()['id_seksi'] ? $this->session->userdata()['id_seksi']  : "''" ?>;
            Object.values(data).forEach((d) => {
                var aksiBtn = '';

                if (d['status_izin'] == '0' && curUser == d['id_pengganti']) {
                    aksiBtn =
                        `<a class="approv dropdown-item"  data-jenis='SuratIzin' data-id='${d['id_surat_izin']}' ><i class='fa fa-check'></i> Approv</a>
                          <a class="deapprov dropdown-item " data-jenis='SuratIzin' data-id='${d['id_surat_izin']}' ><i class='fa fa-times'></i> Tolak Approv</a>
                    `;
                }
                if (d['status_izin'] == '1' && d['id_seksi'] == seksi && curLevel == 5) {
                    aksiBtn =
                        `<a class="approv dropdown-item"  data-jenis='SuratIzin' data-id='${d['id_surat_izin']}' ><i class='fa fa-check'></i> Approv</a>
                          <a class="deapprov dropdown-item " data-jenis='SuratIzin' data-id='${d['id_surat_izin']}' ><i class='fa fa-times'></i> Tolak Approv</a>
                    `;
                }
                if (d['status_izin'] == '2' && d['id_bagian'] == bagian && (curLevel == 3 || curLevel == 4)) {
                    aksiBtn =
                        `<a class="approv dropdown-item"  data-jenis='SuratIzin' data-id='${d['id_surat_izin']}' ><i class='fa fa-check'></i> Approv</a>
                          <a class="deapprov dropdown-item " data-jenis='SuratIzin' data-id='${d['id_surat_izin']}' ><i class='fa fa-times'></i> Tolak Approv</a>
                    `;
                }
                if (d['status_izin'] == '14' && curLevel == 2) {
                    aksiBtn =
                        `<a class="approv dropdown-item"  data-jenis='SuratIzin' data-id='${d['id_surat_izin']}' ><i class='fa fa-check'></i> Approv</a>
                          <a class="deapprov dropdown-item " data-jenis='SuratIzin' data-id='${d['id_surat_izin']}' ><i class='fa fa-times'></i> Tolak Approv</a>
                    `;
                }
                if ((d['status_izin'] == '10' || d['status_izin'] == '11') && curUser == d['verif_cuti']) {
                    aksiBtn =
                        `<a class="verif_cuti dropdown-item"  data-jenis='SuratIzin' data-id='${d['id_surat_izin']}' ><i class='fa fa-check'></i> Approv / Batal</a>
                    `;
                }
                if (d['status_izin'] == '11' && bagian == 2 && curLevel == 3) {
                    aksiBtn =
                        `<a class="approv dropdown-item"  data-jenis='SuratIzin' data-id='${d['id_surat_izin']}' ><i class='fa fa-check'></i> Approv</a>
                          <a class="deapprov dropdown-item " data-jenis='SuratIzin' data-id='${d['id_surat_izin']}' ><i class='fa fa-times'></i> Tolak Approv</a>
                    `;
                }
                if ((d['status_izin'] == '15') && curLevel == 1) {
                    aksiBtn =
                        `<a class="approv dropdown-item"  data-jenis='SuratIzin' data-id='${d['id_surat_izin']}' ><i class='fa fa-check'></i> Approv</a>
                          <a class="deapprov dropdown-item " data-jenis='SuratIzin' data-id='${d['id_surat_izin']}' ><i class='fa fa-times'></i> Tolak Approv</a>
                    `;
                }
                if ((d['status_izin'] == '50') && curLevel == 8) {
                    aksiBtn =
                        `<a class="approv dropdown-item"  data-jenis='SuratIzin' data-id='${d['id_surat_izin']}' ><i class='fa fa-check'></i> Approv</a>
                          <a class="deapprov dropdown-item " data-jenis='SuratIzin' data-id='${d['id_surat_izin']}' ><i class='fa fa-times'></i> Tolak Approv</a>
                    `;
                }
                if ((d['status_izin'] == '51') && curLevel == 7) {
                    aksiBtn =
                        `<a class="approv dropdown-item"  data-jenis='SuratIzin' data-id='${d['id_surat_izin']}' ><i class='fa fa-check'></i> Approv</a>
                          <a class="deapprov dropdown-item " data-jenis='SuratIzin' data-id='${d['id_surat_izin']}' ><i class='fa fa-times'></i> Tolak Approv</a>
                    `;
                } // if ((d['status_izin'] == '99')) {
                cek_btn =
                    `
                    <a class="riwayat_approval dropdown-item"  data-jenis='SuratIzin' data-id='${d['id_surat_izin']}' ><i class='fa fa-eye'></i> Riwayat Approval</a>
                    <a class="data_izin dropdown-item"  data-jenis='SuratIzin' data-id='${d['id_surat_izin']}' ><i class='fa fa-eye'></i> Lihat</a>
                    `;
                print_btn = `
                    <?php
                    if ($dataContent['edit_cuti']) {
                        echo "<a class='form_edit dropdown-item' target='_blank' style='width: 110px' data-jenis='SuratIzin' data-id='$" . "{d['id_surat_izin']}'><i class='fa fa-pencil'></i> Edit </a>";
                        echo "<a class='delete_adm dropdown-item' target='_blank' style='width: 110px' data-jenis='SuratIzin' data-id='$" . "{d['id_surat_izin']}'><i class='fa fa-pencil'></i> Hapus </a>";
                    }
                    ?>
                    <a class="dropdown-item" target="_blank" style="width: 110px" href='<?= base_url() ?>surat-izin/print/${d['id_surat_izin']}/1'><i class='fa fa-eye'></i> PDF SPW </a>
                    <a class="dropdown-item" target="_blank" style="width: 110px" href='<?= base_url() ?>surat-izin/print/${d['id_surat_izin']}/2'><i class='fa fa-eye'></i> PDF SPC </a>
                    <a class="dropdown-item" target="_blank" style="width: 110px" href='<?= base_url() ?>surat-izin/print/${d['id_surat_izin']}/3'><i class='fa fa-eye'></i> PDF Form Cuti </a>
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
                                        ${cek_btn}
                                        ${print_btn}
                                    </div>
                                </div>
                            </div>
                        </div>`;

                info = 'Pengganti : ' + (d['nama_pengganti'] ? d['nama_pengganti'] : '-');
                renderData.push([d['nama_izin'],
                    tgl_indo(d['tanggal_pengajuan']),
                    tgl_indo(d['periode_start']),
                    tgl_indo(d['periode_end']),
                    // d['periode_start'] + (d['periode_start'] == d['periode_end'] ? '' : ' s.d. ' + d['periode_end']),
                    d['nama_satuan'],
                    d['no_spc'],
                    d['nama_pegawai'],
                    d['nama_pengganti'],
                    d['lama_izin'],
                    d['c_n'],
                    d['c_n1'],
                    d['c_n2'],
                    statusIzin(d['status_izin'], d['unapprove_nama']), d['id_surat_izin'], button
                ]);
            });
            FDataTable.clear().rows.add(renderData).draw('full-hold');
        };


        FDataTable.on("click", ".riwayat_approval", function() {
            var jenis = $(this).data("jenis");
            var link = $(this).data("link");

            Swal.fire({
                title: "Loading!",
                allowOutsideClick: false,
            });
            Swal.showLoading();
            cur_id = $(this).data("id");
            $.ajax({
                url: `<?= base_url() ?>SuratIzin/riwayat_approval/${cur_id}`,
                type: "get",
                data: {
                    jenis: jenis,
                },
                success: function(data) {
                    Swal.close();
                    // buttonIdle(button);
                    var json = JSON.parse(data);
                    if (json["error"]) {
                        Swal.fire("Simpan Gagal", json["message"], "error");
                        return;
                    }

                    var dat = json["data"];
                    var dataRiwayat = [];
                    RiwayatModal.self.modal("show");
                    RiwayatModal.layer_riwayat.html("");
                    var htmlRiwayat = "";
                    Object.values(dat).forEach((d) => {
                        htmlRiwayat += d["nama"] + " " + d["time_logs"] + "<br>";
                        dataRiwayat.push([d["time_logs"], d["deskripsi"], d["nama"]]);
                    });
                    TableRiwayat.clear().rows.add(dataRiwayat).draw("full-hold");
                    // console.log(htmlRiwayat)
                    // RiwayatModal.layer_riwayat.html(htmlRiwayat)

                    // if (jenis == 'spt')
                    //     dataSKP[jenis][d['id_spt']] = d;
                    // else if (jenis == 'SuratIzin')
                    //     dataSKP['surat_izin'][d['id_surat_izin']] = d;
                    // Swal.fire("Approv Berhasil", "", "success");
                    // renderSKP(dataSKP);
                },
                error: function(e) {},
            });
        });


        function tgl_indo(tgl) {
            ex_tgl = tgl.split('-');
            var bulan = ['', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
            return ex_tgl[2] + ' ' + bulan[parseInt(ex_tgl[1])] + ' ' + ex_tgl[0]
        }

        FDataTable.on('click', '.verif_cuti', function() {
            curData = dataIzin[$(this).data('id')];

            VerifModal.self.modal('show');
            $('#edit_modal').modal('show');
            VerifModal.idSuratIzin.val(curData['id_surat_izin']);
            VerifModal.periode_start.val(curData['periode_start']);
            VerifModal.periode_end.val(curData['periode_end']);
            VerifModal.lama_izin.val(curData['lama_izin']);
            VerifModal.nama_izin.val(curData['nama_izin']);
            VerifModal.nama_pegawai.val(curData['nama_pegawai']);
            VerifModal.nama_pengganti.val(curData['nama_pengganti']);
            VerifModal.alasan.val(curData['alasan']);
            VerifModal.alamat_izin.val(curData['alamat_izin']);
            if (curData['jenis_izin'] == '11') {
                VerifModal.c_sisa_n.prop('required', true)
                VerifModal.c_sisa_n1.prop('required', true)
                VerifModal.c_sisa_n2.prop('required', true)
                $('.layout_c_tahunan').show();
            } else {
                VerifModal.c_sisa_n.prop('required', false)
                VerifModal.c_sisa_n1.prop('required', false)
                VerifModal.c_sisa_n2.prop('required', false)
                $('.layout_c_tahunan').hide();
            }
            cur_tahun = curData['periode_start'].split('-')[0];
            $('.c_label_n').html(cur_tahun);
            $('.c_label_n1').html(cur_tahun - 1);
            $('.c_label_n2').html(cur_tahun - 2);
            VerifModal.c_sisa_n.val(curData['c_sisa_n']);
            VerifModal.c_sisa_n1.val(curData['c_sisa_n1']);
            VerifModal.c_sisa_n2.val(curData['c_sisa_n2']);
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
                // file_lampiran[1];
                VerifModal.layout_lampiran.html(lampHtml);

            } else
                VerifModal.layout_lampiran.html('<b>tidak ada lampiran</b>');

        });

        <?php if ($dataContent['edit_cuti']) { ?>
            FDataTable.on('click', '.form_edit', function() {
                curData = dataIzin[$(this).data('id')];
                console.log(curData);
                EditModal.self.modal('show');
                $('#edit_modal').modal('show');
                EditModal.idSuratIzin.val(curData['id_surat_izin']);
                EditModal.periode_start.val(curData['periode_start']);
                EditModal.periode_end.val(curData['periode_end']);
                EditModal.lama_izin.val(curData['lama_izin']);
                EditModal.nama_izin.val(curData['nama_izin']);
                EditModal.nama_pegawai.val(curData['nama_pegawai']);
                EditModal.nama_pengganti.val(curData['nama_pengganti']);
                EditModal.alasan.val(curData['alasan']);
                EditModal.no_spc.val(curData['no_spc']);
                EditModal.alamat_izin.val(curData['alamat_izin']);
                EditModal.tanggal_pengajuan.val(curData['tanggal_pengajuan']);
                if (curData['jenis_izin'] == '11') {
                    EditModal.c_sisa_n.prop('required', true)
                    EditModal.c_sisa_n1.prop('required', true)
                    EditModal.c_sisa_n2.prop('required', true)
                    EditModal.c_n.prop('required', true)
                    EditModal.c_n1.prop('required', true)
                    EditModal.c_n2.prop('required', true)
                    EditModal.c_sisa_n.val(curData['c_sisa_n']);
                    EditModal.c_sisa_n1.val(curData['c_sisa_n1']);
                    EditModal.c_sisa_n2.val(curData['c_sisa_n2']);
                    EditModal.c_n.val(curData['c_n']);
                    EditModal.c_n1.val(curData['c_n1']);
                    EditModal.c_n2.val(curData['c_n2']);
                    $('.layout_c_tahunan').show();
                } else {
                    EditModal.c_sisa_n.prop('required', false)
                    EditModal.c_sisa_n1.prop('required', false)
                    EditModal.c_sisa_n2.prop('required', false)
                    EditModal.c_n.prop('required', false)
                    EditModal.c_n.prop('required', false)
                    EditModal.c_n.prop('required', false)
                    $('.layout_c_tahunan').hide();
                }
                cur_tahun = curData['periode_start'].split('-')[0];
                $('.c_label_n').html(cur_tahun);
                $('.c_label_n1').html(cur_tahun - 1);
                $('.c_label_n2').html(cur_tahun - 2);
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
                    EditModal.layout_lampiran.html(lampHtml);

                } else
                    EditModal.layout_lampiran.html('<b>tidak ada lampiran</b>');

            });

            EditModal.saveEditBtn.on('click', function(event) {
                event.preventDefault();
                var url = "<?= site_url('SuratIzin/action_edit/') ?>";
                Swal.fire(swalSaveConfigure).then((result) => {
                    if (!result.value) {
                        return;
                    }

                    $.ajax({
                        url: url,
                        'type': 'POST',
                        // data: EditModal.form.serialize(),
                        data: new FormData(EditModal.form[0]),
                        contentType: false,
                        processData: false,
                        success: function(data) {
                            // buttonIdle(button);
                            var json = JSON.parse(data);
                            if (json['error']) {
                                Swal.fire("Simpan Gagal", json['message'], "error");
                                return;
                            }
                            var d = json['data']
                            dataIzin[d['id_surat_izin']] = d;
                            Swal.fire("Simpan Berhasil", "", "success");
                            renderSKP(dataIzin);
                            EditModal.self.modal('hide');
                        },
                        error: function(e) {}
                    });
                });
            });

            FDataTable.on('click', '.delete_adm', function() {
                curData = $(this).data('id');
                Swal.fire(swalDeleteConfigure).then((result) => {
                    if (!result.value) {
                        return;
                    }

                    $.ajax({
                        url: '<?= base_url() ?>/SuratIzin/delete_adm',
                        'type': 'POST',
                        // data: EditModal.form.serialize(),
                        data: {
                            id_surat_izin: curData
                        },
                        success: function(data) {
                            // buttonIdle(button);
                            var json = JSON.parse(data);
                            if (json['error']) {
                                Swal.fire("Delete Gagal", json['message'], "error");
                                return;
                            }
                            delete dataIzin[curData];
                            Swal.fire("Delete Berhasil", "", "success");
                            renderSKP(dataIzin);
                            EditModal.self.modal('hide');
                        },
                        error: function(e) {}
                    });
                });
            });

        <?php } ?>
        FDataTable.on('click', '.data_izin', function() {
            var jenis = $(this).data('jenis');
            curData = dataIzin[$(this).data('id')];
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
            LihatModal.c_sisa_n.val(curData['c_sisa_n']);
            LihatModal.c_sisa_n1.val(curData['c_sisa_n1']);
            LihatModal.c_sisa_n2.val(curData['c_sisa_n2']);
            cur_tahun = curData['periode_start'].split('-')[0];
            $('.c_label_n').html(cur_tahun);
            $('.c_label_n1').html(cur_tahun - 1);
            $('.c_label_n2').html(cur_tahun - 2);
            LihatModal.status_izin.html(statusIzin(curData['status_izin'], curData['unapprove_nama']))
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

        VerifModal.form.submit(function(event) {
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
                        dataIzin[d['id_surat_izin']] = d;
                        Swal.fire("Simpan Berhasil", "", "success");
                        renderSKP(dataIzin);
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
                            dataIzin[jenis][d['id_spt']] = d;
                        else if (jenis == 'SuratIzin')
                            dataIzin[d['id_surat_izin']] = d;
                        Swal.fire("Approv Berhasil", "", "success");
                        renderSKP(dataIzin);
                    },
                    error: function(e) {}
                });
            });
        })

        FDataTable.on('click', '.deapprov', function() {
            var currentData = dataIzin[$(this).data('id')];
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
                        dataIzin[jenis][d['id_spt']] = d;
                        Swal.fire("SKP Berhasil ditolak", "", "success");
                        renderSKP(dataIzin);
                    },
                    error: function(e) {}
                });
            });
        })

        FDataTable.on('click', '.batal_aksi', function() {
            var currentData = dataIzin[$(this).data('id')];
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
                        dataIzin[jenis][d['id_spt']] = d;
                        Swal.fire("Pembatalan Berhasil", "", "success");
                        renderSKP(dataIzin);
                    },
                    error: function(e) {}
                });
            });
        })


    });
</script>