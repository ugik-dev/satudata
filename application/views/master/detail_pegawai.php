<div class="container-fluid">
    <div class="edit-profile">
        <div class="row">
            <form class="" id="formProfile" type="multipart">
                <div class="row">

                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">Data Login</h4>
                                <div class="card-options">
                                    <a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#" data-bs-toggle="card-remove"><i class="fe fe-x"></i></a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="row mb-2">
                                            <div class="profile-title">
                                                <div class="media">
                                                    <img class="img-100 rounded-circle" alt="" src="<?= base_url('uploads/foto_profil/') . (!empty($data_profile['photo']) ? $data_profile['photo'] : 'default.jpg') ?>" />
                                                    <div class=" media-body">
                                                        <h5 class="mb-1"><?= $data_profile['nama'] ?></h5>
                                                        <p><?= $data_profile['nama_role'] ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-9">
                                        <div class="mb-3">
                                            <label class="form-label">Username</label>
                                            <input readonly class="form-control bg-white" value="<?= $data_profile['username'] ?>" />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Hak Aksess</label>
                                            <input readonly class="form-control bg-white" value="<?= $data_profile['nama_role'] ?>" />
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <label class="form-label">Email-Address</label>
                                                <input readonly class="form-control bg-white" name="email" value="<?= $data_profile['email'] ?>" />
                                            </div>
                                            <div class="col">
                                                <label class="form-label">No Hp</label>
                                                <input readonly class="form-control bg-white" name="no_hp" value="<?= $data_profile['no_hp'] ?>" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">Data Profile</h4>
                                <div class="card-options">
                                    <a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#" data-bs-toggle="card-remove"><i class="fe fe-x"></i></a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Nama</label>
                                            <input readonly class="form-control bg-white" name="nama" type="text" value="<?= $data_profile['nama'] ?>" />
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">NIP</label>
                                            <input readonly class="form-control bg-white" name="nip" type="text" value="<?= $data_profile['nip'] ?>" />
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">NIK</label>
                                            <input readonly class="form-control bg-white" name="nik" type="text" value="<?= $data_profile['nik'] ?>" required />
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Alamat</label>
                                            <input readonly class="form-control bg-white" name="alamat" type="text" value="<?= $data_profile['alamat'] ?>" />
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Nama Bank</label>
                                            <input readonly class="form-control bg-white" name="nama_bank" type="text" value="<?= $data_profile['nama_bank'] ?>" />
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">No Rekening Bank</label>
                                            <input readonly class="form-control bg-white" name="no_bank" type="text" value="<?= $data_profile['no_bank'] ?>" />
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Jenjang</label>
                                            <input readonly class="form-control bg-white" name="pend_jenjang" type="text" value="<?= $data_profile['pend_jenjang'] ?>" />
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Jurusan</label>
                                            <input readonly class="form-control bg-white" name="pend_jurusan" type="text" value="<?= $data_profile['pend_jurusan'] ?>" />
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Tempat Lahir</label>
                                            <input readonly class="form-control bg-white" name="tempat_lahir" type="text" value="<?= $data_profile['tempat_lahir'] ?>" />
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Tanggal Lahir</label>
                                            <input readonly class="form-control bg-white" name="tanggal_lahir" type="date" value="<?= $data_profile['tanggal_lahir'] ?>" />
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Jenis Pegawai </label>
                                            <input readonly class="form-control bg-white" name="jenis_pegawai" type="text" value="<?= $data_profile['jenis_pegawai'] == 3 ? 'Out Sourcing' : ($data_profile['jenis_pegawai'] == 1 ? 'ASN' : 'Honorer') ?>" />
                                            <!-- <select class="form-control" name="jenis_pegawai">
                                                <option value="1" <?= $data_profile['jenis_pegawai'] == '1' ? 'selected' : '' ?>>PNS</option>
                                                <option value="2" <?= $data_profile['jenis_pegawai'] == '2' ? 'selected' : '' ?>>Honorer</option>
                                                <option value="3" <?= $data_profile['jenis_pegawai'] == '3' ? 'selected' : '' ?>>Out Sourcing</option>
                                            </select> -->
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">TMT Awal Kerja</label>
                                            <input readonly class="form-control bg-white" name="tmt_kerja" type="date" value="<?= $data_profile['tmt_kerja'] ?>" />
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Jabatan</label>
                                            <input readonly class="form-control bg-white" name="jabatan" type="text" value="<?= $data_profile['jabatan'] ?>" />
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Pangkat Golongan</label>
                                            <input readonly class="form-control bg-white" name="pangkat_gol" type="text" value="<?= $data_profile['pangkat_gol'] ?>" />
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Satuan</label>
                                            <input readonly class="form-control bg-white" type="text" value="<?= $data_profile['nama_satuan'] ?>" />
                                            <!-- <select class="select2 col-sm-12" id="id_satuan" name="id_satuan" required>
                                                <option value="<?= $data_profile['id_satuan'] ?>" selected><?= $data_profile['nama_satuan'] ?></option>
                                            </select> -->
                                        </div>
                                    </div>
                                    <?php if (!empty($data_profile['nama_bag'])) { ?>
                                        <div class="col-sm-12 col-md-6" id="layout_bagian">
                                            <div class="mb-3">
                                                <label class="form-label">Bagian</label>
                                                <input readonly class="form-control bg-white" type="text" value="<?= $data_profile['nama_bag'] ?>" />
                                                <!-- <select class="select2 col-sm-12" id="id_bagian" name="id_bagian">
                                                <option value="<?= $data_profile['id_bagian'] ?>" selected><?= $data_profile['nama_bag'] ?></option>
                                            </select> -->
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <?php if (!empty($data_profile['nama_seksi'])) { ?>
                                        <div class="col-sm-12 col-md-6" id="layout_bagian">
                                            <div class="mb-3">
                                                <label class="form-label">Seksi</label>
                                                <input readonly class="form-control bg-white" type="text" value="<?= $data_profile['nama_seksi'] ?>" />
                                                <!-- <select class="select2 col-sm-12" id="id_seksi" name="id_seksi">
                                                    <option value="<?= $data_profile['id_seksi'] ?>" selected><?= $data_profile['nama_seksi'] ?></option>
                                                </select> -->
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="col-lg-6">
                                        <label for="" class="form-label">Tanda Tangan</label>
                                        <?php if (!empty($data_profile['signature'])) { ?>
                                            <div class="media">
                                                <img class="" style="max-height: 150px !important" src="<?= base_url('uploads/signature/') . $data_profile['signature'] ?>" />
                                            </div>
                                            <small>*kosongkan jika tidak diganti</small>
                                        <?php } ?>

                                        <!-- <input class="form-control" type="file" id="signature" name="signature"> -->
                                        <p class="no-margins"><span id="signature">-</span></p>
                                    </div>

                                    <div class="col-lg-6">
                                        <label for="" class="form-label">Foto Profil</label>
                                        <?php if (!empty($data_profile['photo'])) { ?>
                                            <div class="media">
                                                <img class="" style="max-height: 150px !important" alt="" src="<?= base_url('uploads/foto_profil/') . $data_profile['photo'] ?>" />
                                            </div>
                                            <small>*kosongkan jika tidak diganti</small>
                                        <?php } ?> <p class="no-margins"><span id="foto_diri">-</span></p>
                                        <!-- <input class="form-control" type="file" id="foto_diri" name="foto_diri"> -->
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <button class="btn btn-primary" id="btn_update">
                                    Simpan Profile
                                </button>
                                <!-- <button class="btn btn-primary" id='ttd_btn' type="">
                                    Ganti Tanda Tangan
                                </button> -->
                            </div>
                        </div>
                    </div>
            </form>
        </div>
    </div>
</div>

<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-0">Riwayat Satuan Kerja</h4>
            <button type="button" style='float: right;' class="btn btn-primary" id="new_riwayat"><i class="fa fa-plus"></i> Mutasi </button>
            <div class="card-options">
                <a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#" data-bs-toggle="card-remove"><i class="fe fe-x"></i></a>
            </div>
        </div>
        <div class="table-responsive add-project">
            <table id="FDataTable" class="table card-table table-vcenter text-nowrap" style="padding-bottom: 100px">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Satuan Kerja</th>
                        <th>Bagian / Bidang</th>
                        <th>Seksi</th>
                        <th>Hak Akses</th>
                        <th>Jabatan</th>
                        <th>Pangkat / Gol</th>
                        <th>Tanggal Aktif</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="riwayat_modal" style="overflow:hidden;">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form opd="form" id="user_form" onsubmit="return false;" type="multipart" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_title">
                        Form Mutasi
                    </h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id_user" name="id_user" value="<?= $data_profile['id'] ?>">
                    <input type="hidden" id="id_mutasi" name="id_mutasi">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="col-form-label">Satuan</div>
                            <select class="select2 col-sm-12" id="id_satuan" name="id_satuan" required>
                            </select>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="nip">Bagian / Bidang</label>
                                <select class="select2 col-sm-12" id="id_bagian" name="id_bagian"></select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="col-form-label">Seksi</div>
                            <select class="select2 col-sm-12" id="id_seksi" name="id_seksi"></select>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="nip">Role</label>
                                <select class="select2 col-sm-12" id="id_role" name="id_role"></select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="tanggal_mutasi">Tanggal Aktif</label>
                                <input type="date" placeholder="" class="form-control" id="tanggal_mutasi" name="tanggal_mutasi" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="jabatan">Jabatan</label>
                                <input type="text" placeholder="Kepala Keuangan" class="form-control" id="jabatan" name="jabatan">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="pangkat_golongan">Pangkat/Golongan </label>
                                <input class="form-control mr-sm-2" name="pangkat_golongan" id="pangkat_golongan">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="status_mutasi">Status</label>
                                <select class="form-control mr-sm-2" name="status_mutasi" id="status_mutasi">
                                    <option value="Y">Active</option>
                                    <option value="N">Non Active</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button class="btn btn-primary" type="submit" id="add_btn" data-loading-text="Loading..."><strong>Tambah Data</strong></button>
                    <button class="btn btn-primary" type="submit" id="save_edit_btn" data-loading-text="Loading..."><strong>Simpan Perubahan</strong></button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>


<script>
    // $(".js-example-basic-single").select2();


    $(document).ready(function() {

        $('#menu_1').addClass('active');
        $('#opmenu_1').show();
        $('#submenu_1').addClass('active');
        var new_riwayat = $('#new_riwayat');
        var FDataTable = $('#FDataTable').DataTable({
            "searching": false,
            "paging": false,
            "ordering": false,
            "info": false
        });

        var dataMutasi = [];

        // var MutasiModal = {
        //     'self': $('#riwayat_modal'),
        //     'info': $('#riwayat_modal').find('.info'),
        //     'form': $('#riwayat_modal').find('#user_form'),
        //     'addBtn': $('#riwayat_modal').find('#add_btn'),
        //     'saveEditBtn': $('#riwayat_modal').find('#save_edit_btn'),
        //     'idUser': $('#riwayat_modal').find('#id'),
        //     'username': $('#riwayat_modal').find('#username'),
        //     'nama': $('#riwayat_modal').find('#nama'),
        //     'nip': $('#riwayat_modal').find('#nip'),
        //     'email': $('#riwayat_modal').find('#email'),
        //     'no_hp': $('#riwayat_modal').find('#no_hp'),
        //     'status': $('#riwayat_modal').find('#status'),
        //     'password': $('#riwayat_modal').find('#password'),
        //     'jabatan': $('#riwayat_modal').find('#jabatan'),
        //     'pangkat_gol': $('#riwayat_modal').find('#pangkat_gol'),
        //     'id_role': $('#riwayat_modal').find('#id_role'),
        //     'id_bagian': $('#riwayat_modal').find('#id_bagian'),
        //     'id_seksi': $('#riwayat_modal').find('#id_seksi'),
        //     'id_satuan': $('#riwayat_modal').find('#id_satuan'),
        //     'ppk': $('#riwayat_modal').find('#ppk'),
        //     'nik': $('#riwayat_modal').find('#nik'),
        //     'pend_jenjang': $('#riwayat_modal').find('#pend_jenjang'),
        //     'pend_jurusan': $('#riwayat_modal').find('#pend_jurusan'),
        //     'tanggal_lahir': $('#riwayat_modal').find('#tanggal_lahir'),
        //     'tempat_lahir': $('#riwayat_modal').find('#tempat_lahir'),
        //     'tmt_kerja': $('#riwayat_modal').find('#tmt_kerja'),
        //     'jenis_pegawai': $('#riwayat_modal').find('#jenis_pegawai'),
        //     'j_k': $('#riwayat_modal').find('#j_k'),
        // }
        $("#id_satuan").select2({
            dropdownParent: $('#riwayat_modal .modal-content'),
            ajax: {
                url: '<?= base_url() ?>Search/satuan_kerja',
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

        $("#id_bagian").select2({
            dropdownParent: $('#riwayat_modal .modal-content'),
            ajax: {
                url: '<?= base_url() ?>Search/bagian',
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

        $("#id_role").select2({
            dropdownParent: $('#riwayat_modal .modal-content'),
            ajax: {
                url: '<?= base_url() ?>Search/role',
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

        $("#id_seksi").select2({
            dropdownParent: $('#riwayat_modal .modal-content'),
            ajax: {
                url: '<?= base_url() ?>search/seksi',
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


        var MutasiModal = {
            'self': $('#riwayat_modal'),
            'info': $('#riwayat_modal').find('.info'),
            'form': $('#riwayat_modal').find('#user_form'),
            'addBtn': $('#riwayat_modal').find('#add_btn'),
            'saveEditBtn': $('#riwayat_modal').find('#save_edit_btn'),
            'id_riwayat': $('#riwayat_modal').find('#id_riwayat'),
            'idUser': $('#riwayat_modal').find('#id_user'),
            'id_mutasi': $('#riwayat_modal').find('#id_mutasi'),
            'id_role': $('#riwayat_modal').find('#id_role'),
            'pangkat_golongan': $('#riwayat_modal').find('#pangkat_golongan'),
            'jabatan': $('#riwayat_modal').find('#jabatan'),
            'id_satuan': $('#riwayat_modal').find('#id_satuan'),
            // 'id_role': $('#riwayat_modal').find('#id_role'),
            'id_seksi': $('#riwayat_modal').find('#id_seksi'),
            'id_bagian': $('#riwayat_modal').find('#id_bagian'),
            'tanggal_mutasi': $('#riwayat_modal').find('#tanggal_mutasi'),
            'status_mutasi': $('#riwayat_modal').find('#status_mutasi'),
        }

        function resetModal() {
            MutasiModal.form.trigger('reset');
            MutasiModal.id_role.val('');
            MutasiModal.id_riwayat.val("");
            MutasiModal.id_satuan.val("");
            MutasiModal.jabatan.val("");
            // MutasiModal.tanggal_mutasi.val("");
        }

        new_riwayat.on('click', (e) => {
            // resetModal();
            console.log('asd')
            MutasiModal.self.modal('show');
            MutasiModal.addBtn.show();
            MutasiModal.saveEditBtn.hide();
        });


        FDataTable.on('click', '.edit', function() {
            // resetMutasiModal();
            MutasiModal.self.modal('show');
            MutasiModal.addBtn.hide();
            MutasiModal.saveEditBtn.show();

            var currentData = dataMutasi[$(this).data('id')];
            console.log(currentData);
            MutasiModal.idUser.val(currentData['id_user']);
            MutasiModal.id_mutasi.val(currentData['id_mutasi']);
            MutasiModal.jabatan.val(currentData['jabatan']);
            MutasiModal.pangkat_golongan.val(currentData['pangkat_golongan']);
            // MutasiModal.nip.val(currentData['nip']);
            // MutasiModal.username.val(currentData['username']);
            // MutasiModal.nik.val(currentData['nik']);
            MutasiModal.tanggal_mutasi.val(currentData['tanggal_mutasi']);
            // MutasiModal.tanggal_mutasi.val('2020-04-05');
            MutasiModal.status_mutasi.val(currentData['status_mutasi']);
            // MutasiModal.id_satuan.val(1);
            <?php
            if ($this->session->userdata()['id_role'] != 1) {
            } ?>
            var $blankOption = $("<option selected='selected'></option>").val('').text('');
            var $newOption = $("<option selected='selected'></option>").val(currentData['id_satuan']).text(currentData['nama_satuan']);
            MutasiModal.id_satuan.append($newOption).trigger('change');
            if (currentData['id_bagian'] != 'null') {
                var $newOption3 = $("<option selected='selected'></option>").val(currentData['id_bagian']).text(currentData['nama_bag']);
                MutasiModal.id_bagian.append($newOption3).trigger('change');
            } else {
                MutasiModal.id_bagian.append($blankOption).trigger('change');
            }
            if (currentData['id_seksi']) {
                var $newOption2 = $("<option selected='selected'></option>").val(currentData['id_seksi']).text(currentData['nama_seksi']);
                MutasiModal.id_seksi.append($newOption2).trigger('change');
            } else {
                MutasiModal.id_seksi.append($blankOption).trigger('change');
            }

            var $newOption4 = $("<option selected='selected'></option>").val(currentData['id_role']).text(currentData['nama_role']);
            MutasiModal.id_role.append($newOption4).trigger('change');

            // if (RefSatker['satuan'][currentData['id_satuan']]['jenis'] != 1) {
            //     $('#layout_bagian , #layout_seksi').hide();
            //     $("#null_bagian , #null_seksi").prop('disabled', false)
            //     $("#id_bagian , #id_seksi").prop('disabled', true)
            // } else {
            //     $('#layout_bagian , #layout_seksi').show();
            //     $("#null_bagian , #null_seksi").prop('disabled', true)
            //     $("#id_bagian , #id_seksi").prop('disabled', false)
            // }
        });


        MutasiModal.form.submit(function(event) {
            event.preventDefault();
            var isAdd = MutasiModal.addBtn.is(':visible');
            var url = "<?= base_url('Master/') ?>";
            url += isAdd ? "addMutasi" : "editMutasi";
            var button = isAdd ? MutasiModal.addBtn : MutasiModal.saveEditBtn;
            console.log('sub')
            Swal.fire({
                title: "Apakah anda Yakin?",
                text: "Data Disimpan!",
                icon: "warning",
                allowOutsideClick: false,
                showCancelButton: true,
                buttons: {
                    cancel: 'Batal !!',
                    catch: {
                        text: "Ya, Saya Simpan !!",
                        value: true,
                    },
                },
            }).then((result) => {
                if (!result.isConfirmed) {
                    return;
                }
                $.ajax({
                    url: url,
                    'type': 'POST',
                    data: MutasiModal.form.serialize(),
                    success: function(data) {
                        // buttonIdle(button);
                        var json = JSON.parse(data);
                        if (json['error']) {
                            Swal.fire("Simpan Gagal", json['message'], "error");
                            return;
                        }
                        var user = json['data']
                        dataUser[user['id']] = user;
                        Swal.fire("Simpan Berhasil", "", "success");
                        renderUser(dataUser);
                        MutasiModal.self.modal('hide');
                    },
                    error: function(e) {}
                });
            });
        });

        getAllPosotion()

        function getAllPosotion() {

            $.ajax({
                url: '<?= base_url() ?>general/getAllMutasi',
                'type': 'get',
                data: {
                    id_user: '<?= $data_profile['id'] ?>'
                },
                success: function(data) {
                    // buttonIdle(button);
                    var json = JSON.parse(data);
                    var pos = json['data']
                    dataMutasi = pos;
                    renderMutasi(dataMutasi);
                },
                error: function(e) {}
            });
        }

        function renderMutasi(data) {
            if (data == null || typeof data != "object") {
                console.log("User::UNKNOWN DATA");
                return;
            }
            var i = 0;

            var renderData = [];
            Object.values(data).forEach((user) => {
                var editButton = `
        <a class="edit dropdown-item" data-id='${user['id_mutasi']}'><i class='fa fa-pencil'></i> Edit</a>
      `;
                var deleteButton = `
        <a class="delete dropdown-item" data-id='${user['id_mutasi']}'><i class='fa fa-trash'></i> Hapus</a>
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
                                    </div>
                                </div>
                            </div>
                        </div>`;

                console.log('nama role ' + user['nama_role'])
                renderData.push([user['id_mutasi'], user['nama_satuan'], user['nama_bag'], user['nama_seksi'], user['nama_role'], user['jabatan'], user['pangkat_golongan'], user['tanggal_mutasi'], (user['status_mutasi'] == 'Y' ? 'Aktif' : 'Tidak Aktif'), button]);
            });
            FDataTable.clear().rows.add(renderData).draw('full-hold');
        }
    });
</script>
<!-- <script>
    $(document).ready(function() {

        // $('#menu_1').addClass('active');
        // $('#opmenu_1').show();
        // $('#submenu_1').addClass('active');
        var new_riwayat = $('#new_riwayat');
        var FDataTable = $('#FDataTable').DataTable({
            "searching": false,
            "paging": false,
            "ordering": false,
            "info": false
        });
        var dataSatuan = [];

        function DataSturcture(data) {
            var newData = [];
            i = 0;
            Object.values(data).forEach((d) => {
                // console.log(i);
                // i++;
                newData[d['id']] = d;
            })
            return newData;
        };

        $("#id_satuan").select2({
            // dropdownParent: $('#formProfile .modal-content'),
            ajax: {
                url: '<?= base_url() ?>Search/satuan_kerja',
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

        RefSatker = <?= json_encode($ref_satker) ?>;
        $("#id_satuan").on('change', function() {
            console.log('change satyab')
            cur_satuan = $("#id_satuan").val();
            // dinkesvar = [1, 2, 3, 4, 5]
            if (RefSatker['satuan'][cur_satuan]['jenis'] != 1) {
                $('#layout_bagian , #layout_seksi').hide();
                $("#null_bagian , #null_seksi").prop('disabled', false)
                $("#id_bagian , #id_seksi").prop('disabled', true)
                // $("#null_seksi").prop('disabled', false)
                // $("#id_seksi").prop('disabled', true)
            } else {
                $('#layout_bagian , #layout_seksi').show();
                $("#null_bagian , #null_seksi").prop('disabled', true)
                $("#id_bagian , #id_seksi").prop('disabled', false)
            }
        });
        $("#id_bagian").on('change', function() {
            cur_bagian = $("#id_bagian").val();
            // dinkesvar = [1, 2, 3, 4, 5]
            if (RefSatker['bagian'][cur_bagian]['jenis'] != 4) {
                $('#layout_seksi').hide();
                $("#id_seksi").prop('disabled', true)
                $("#null_seksi").prop('disabled', false)
            } else {
                $('#layout_seksi').show();
                $("#null_seksi").prop('disabled', true)
                $("#id_seksi").prop('disabled', false)
            }
        })

        $("#id_bagian").select2({
            ajax: {
                url: '<?= base_url() ?>Search/bagian',
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
        $("#id_seksi").select2({
            ajax: {
                url: '<?= base_url() ?>Search/seksi',
                type: "get",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    cur_bagian = $("#id_bagian").val();
                    return {
                        searchTerm: params.term,
                        bagian: cur_bagian
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
        $("#id_role").select2({
            ajax: {
                url: '<?= base_url() ?>Search/role',
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





        var formProfile = {
            'form': $('#formProfile'),
            'saveEditBtn': $('#formProfile').find('#btn_update'),
            'id_riwayat': $('#formProfile').find('#id_riwayat'),
            'jabatan': $('#formProfile').find('#jabatan'),
            'id_satuan': $('#formProfile').find('#id_satuan'),
            'id_role': $('#formProfile').find('#id_role'),
            'tanggal_mutasi': $('#formProfile').find('#tanggal_mutasi'),
            'status_riwayat': $('#formProfile').find('#status_riwayat'),
            'signature': new FileUploader($('#formProfile').find('#signature'), "", "fl_signature", "image/*", false, false),
            'foto_diri': new FileUploader($('#formProfile').find('#foto_diri'), "", "fl_foto_diri", "image/*", false, false),
            // 'dokumen_bp3l_sertifikat_ig_form': $('#bp3l_rek_form').find('#dokumen_bp3l_sertifikat_ig_form'),

        }

        function resetModal() {
            // formProfile.form.trigger('reset');
            // formProfile.id_role.val('');
            // formProfile.id_riwayat.val("");
            // formProfile.id_satuan.val("");
            // formProfile.jabatan.val("");
            // formProfile.tanggal_mutasi.val("");
        }

        // new_riwayat.on('click', (e) => {
        //     resetModal();
        //     formProfile.self.modal('show');
        //     formProfile.addBtn.show();
        //     formProfile.saveEditBtn.hide();
        // });


        formProfile.form.submit(function(event) {
            event.preventDefault();
            var url = "<?= base_url('user/update_my_profil') ?>";
            Swal.fire({
                title: "Apakah anda Yakin?",
                text: "Data Disimpan!",
                icon: "warning",
                allowOutsideClick: false,
                showCancelButton: true,
                buttons: {
                    cancel: 'Batal !!',
                    catch: {
                        text: "Ya, Saya Simpan !!",
                        value: true,
                    },
                },
            }).then((result) => {
                if (!result.isConfirmed) {
                    return;
                }
                swalLoading();

                $.ajax({
                    url: url,
                    'type': 'POST',
                    data:
                        // formProfile.form.serialize(),
                        new FormData(formProfile.form[0]),
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        // buttonIdle(button);
                        var json = JSON.parse(data);
                        if (json['error']) {
                            Swal.fire("Simpan Gagal", json['message'], "error");
                            return;
                        }
                        // var user = json['data']
                        // dataUser[user['id']] = user;
                        Swal.fire("Simpan Berhasil", "", "success");
                        location.reload();
                        // renderUser(dataUser);
                        // formProfile.self.modal('hide');
                    },
                    error: function(e) {}
                });
            });
        });
        getAllPosotion()

        function getAllPosotion() {

            $.ajax({
                url: '<?= base_url() ?>general/getAllMutasi',
                'type': 'get',
                data: {
                    id_user: '<?= $data_profile['id'] ?>'
                },
                success: function(data) {
                    // buttonIdle(button);
                    var json = JSON.parse(data);
                    var pos = json['data']
                    dataMutasi = pos;
                    renderMutasi(dataMutasi);
                },
                error: function(e) {}
            });
        }

        function renderMutasi(data) {
            if (data == null || typeof data != "object") {
                console.log("User::UNKNOWN DATA");
                return;
            }
            var i = 0;

            var renderData = [];
            Object.values(data).forEach((user) => {
                var editButton = `
        <a class="edit dropdown-item" data-id='${user['id_mutasi']}'><i class='fa fa-pencil'></i> Edit</a>
      `;
                var deleteButton = `
        <a class="delete dropdown-item" data-id='${user['id_mutasi']}'><i class='fa fa-trash'></i> Hapus</a>
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
                                    </div>
                                </div>
                            </div>
                        </div>`;

                renderData.push([user['id_mutasi'], user['nama_satuan2'], user['nama_bidang'], user['nama_bag'], user['jabatan'], user['pangkat_gol'], user['status'], button]);
            });
            FDataTable.clear().rows.add(renderData).draw('full-hold');
        }

        $("#id_satuan").trigger('change');
        $("#id_bagian").trigger('change');

    });
</script> -->