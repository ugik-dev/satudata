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


<div class="modal fade" id="riwayat_izin_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form opd="form" id="" onsubmit="return false;" type="multipart" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_title">
                        Riwayat Izin / Cuti
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
                    <table id="TableRiwayatIzin" class="table table-border-horizontal" style="padding-bottom: 100px">
                        <thead>
                            <tr>
                                <!-- <th style="width: 2%; text-align:center!important">ID</th> -->
                                <th style="width: 10%; text-align:center!important">Tanggal Izin</th>
                                <th style="width: 10%; text-align:center!important">Pengganti</th>
                                <th style="width: 10%; text-align:center!important">Jenis</th>
                                <th style="width: 10%; text-align:center!important">Status</th>
                                <th style="width: 5%; text-align:center!important">Durasi(hari)</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4">Total lama izin / cuti yang sudah disetujui</td>
                                <td id="total_lama_izin"></td>
                            </tr>
                        </tfoot>

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