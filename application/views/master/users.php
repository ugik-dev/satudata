<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-header">

                    <form class="form-inline" id="toolbar_form" onsubmit="return false;">
                        <div class="col-lg-2">
                            <select class="form-control mr-sm-2" name="id_jenis_bank_data" id="id_jenis_bank_data"></select>
                        </div>
                        <button type="button" class="btn btn-success my-1 mr-sm-2" id="new_btn" disabled="disabled"><i class="fa fa-plus"></i> Tambah Data</button>
                    </form>
                </div>

                <div class="card-body">
                    <!-- <div class="col-lg-12"> -->
                    <!-- <div class="ibox"> -->
                    <!-- <div class="ibox-content"> -->
                    <div class="table-responsive">
                        <table id="FDataTable" class="table table-bordered table-hover" style="padding-bottom: 100px">
                            <thead>
                                <tr>
                                    <th style="width: 2%; text-align:center!important">ID</th>
                                    <th style="width: 24%; text-align:center!important">Username</th>
                                    <th style="width: 24%; text-align:center!important">Nama</th>
                                    <th style="width: 24%; text-align:center!important">NIP</th>
                                    <th style="width: 24%; text-align:center!important">Bagian</th>
                                    <th style="width: 10%; text-align:center!important">Role</th>
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


<div class="modal fade" id="user_modal" aria-labelledby="exampleModalLongTitle">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form opd="form" id="user_form" onsubmit="return false;" type="multipart" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_title">
                        Form Kepegawaian
                    </h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id" name="id">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" placeholder="ex. Abdul Rahmad, A.Md" class="form-control" id="nama" name="nama" required="required">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="nip">NIP</label>
                                <input type="text" placeholder="ex. 1986XX XXXXXX X XXX" class="form-control" id="nip" name="nip">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="nik">NIK</label>
                                <input type="text" placeholder="ex. 1986XX XXXXXX X XXX" class="form-control" id="nik" name="nik" required="required">
                            </div>
                        </div>
                        <!-- </div>
                    <div class="row"> -->
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Jenis Pegawai</label>
                                <select class="form-control" name="jenis_pegawai" id="jenis_pegawai" require>
                                    <option value="">-</option>
                                    <option value="1">PNS</option>
                                    <option value="3">PPPK</option>
                                    <option value="2">Honorer</option>
                                    <option value="4">Kader</option>
                                    <!-- <option value="3">Out Sourcing</option> -->
                                </select>
                                <!-- <input class="form-control" name="jenis_pegawai" type="text" value="<?= $data_profile['tempat_lahir'] ?>" /> -->
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="nama">Jabatan</label>
                                <input type="text" placeholder="" class="form-control" id="jabatan" name="jabatan" required="required">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="nip">Pangkat / Golongan</label>
                                <input type="text" placeholder="" class="form-control" id="pangkat_gol" name="pangkat_gol">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="pend_jenjang">Pendidikan Jenjang</label>
                                <select class="col-sm-12 form-control" id="pend_jenjang" name="pend_jenjang">
                                    <option value="">--</option>
                                    <option value="S3">S 3</option>
                                    <option value="S2">S 2</option>
                                    <option value="S1">S 1</option>
                                    <option value="D4">D 4</option>
                                    <option value="D3">D 3</option>
                                    <option value="D2">D 2</option>
                                    <option value="D1">D 1</option>
                                    <option value="SMA">SMA Sederajat</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="pend_jurusan">Pendidikan Jurusan</label>
                                <input type="text" placeholder="" class="form-control" id="pend_jurusan" name="pend_jurusan">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="tmt_kerja">TMT Kerja</label>
                                <input type="date" placeholder="" class="form-control" id="tmt_kerja" name="tmt_kerja">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="tempat_lahir">Tempat Lahir</label>
                                <input type="text" placeholder="" class="form-control" id="tempat_lahir" name="tempat_lahir">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="tanggal_lahir">Tanggal Lahir</label>
                                <input type="date" placeholder="" class="form-control" id="tanggal_lahir" name="tanggal_lahir">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="col-form-label">Jenis Kelamin</div>
                            <select class="col-sm-12 form-control" id="j_k" name="j_k">
                                <option value="">--</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <hr style="height:5px;border:none;color:#000000;background-color:#000000;">
                    <div class="row">
                        <h6>Hak Aksess</h6>
                        <div class="col-lg-4">
                            <div class="col-form-label">Instansi</div>
                            <select class="select2 col-sm-12" id="id_satuan" name="id_satuan" <?= $this->session->userdata()['id_role'] != 1 ? '' : '' ?>>
                            </select>
                            <!-- 
                            HIDDEN    
                            <select class="select2 col-sm-12" id="id_satuan" name="id_satuan" <?= $this->session->userdata()['id_role'] != 1 ? 'disabled' : '' ?>>
                            </select> -->
                        </div>
                        <div class="col-lg-4" <?= $this->session->userdata()['id_satuan'] != 1 ? 'hidden' : '' ?>>
                            <div class="col-form-label"> Bagian
                            </div>
                            <input type="hidden" id="null_bagian" name="null_bagian" value="true" disabled>
                            <select class="select2 col-sm-12" id="id_bagian" name="id_bagian"></select>
                        </div>
                        <div class="col-lg-4" <?= $this->session->userdata()['id_satuan'] != 1 ? 'hidden' : '' ?>>
                            <div class="col-form-label">Seksi</div>
                            <input type="hidden" id="null_seksi" name="null_seksi" value="true" disabled>
                            <select class="select2 col-sm-12" id="id_seksi" name="id_seksi"></select>
                        </div>
                        <div class="col-lg-4" <?= $this->session->userdata()['id_satuan'] != 1 ? 'hidden' : '' ?>>
                            <div class="col-form-label">PPK</div>
                            <select class="col-sm-12 form-control" id="ppk" name="ppk">
                                <option value="">--</option>
                                <option value="1">Ya</option>
                                <option value="2">Tidak</option>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <div class="col-form-label"> Role </div>
                            <select class="select2 col-sm-12" id="id_role" name="id_role"></select>
                        </div>
                    </div>

                    <hr style="height:5px;border:none;color:#000000;background-color:#000000;">
                    <h6>Data Login</h6>
                    <!-- <hr style="height:10px;border:none;color:#333;background-color:#333;"> -->
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" placeholder="ex. abdulrahmadabas" class="form-control" id="username" name="username" required="required">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="email">e-Mail</label>
                                <input type="email" placeholder="ex. user@gmail.com" class="form-control" id="email" name="email">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="no_hp">No HP</label>
                                <input type="text" placeholder="ex. 0812797223XXX" class="form-control" id="no_hp" name="no_hp" required="required">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" placeholder="Password" class="form-control" id="password" name="password">
                            </div>
                        </div>
                        <!-- </div> -->
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="judul">Status</label>
                                <select class="form-control mr-sm-2" name="status" id="status" required="required">
                                    <option value="1"> Aktif</option>
                                    <option value="2"> NON Aktif</option>
                                </select>
                            </div>
                        </div>

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


<script>
    $(document).ready(function() {
        $('#menu_1').addClass('active');
        $('#opmenu_1').show();
        $('#submenu_1').addClass('active');
        var toolbar = {
            'form': $('#toolbar_form'),
            'id_role': $('#toolbar_form').find('#id_role'),
            'id_opd': $('#toolbar_form').find('#id_opd'),
            'newBtn': $('#new_btn'),
        }

        var FDataTable = $('#FDataTable').DataTable({
            'columnDefs': [],
            deferRender: true,
            "order": [
                [0, "desc"]
            ]
        });

        var UserModal = {
            'self': $('#user_modal'),
            'info': $('#user_modal').find('.info'),
            'form': $('#user_modal').find('#user_form'),
            'addBtn': $('#user_modal').find('#add_btn'),
            'saveEditBtn': $('#user_modal').find('#save_edit_btn'),
            'idUser': $('#user_modal').find('#id'),
            'username': $('#user_modal').find('#username'),
            'nama': $('#user_modal').find('#nama'),
            'nip': $('#user_modal').find('#nip'),
            'email': $('#user_modal').find('#email'),
            'no_hp': $('#user_modal').find('#no_hp'),
            'status': $('#user_modal').find('#status'),
            'password': $('#user_modal').find('#password'),
            'jabatan': $('#user_modal').find('#jabatan'),
            'pangkat_gol': $('#user_modal').find('#pangkat_gol'),
            'id_role': $('#user_modal').find('#id_role'),
            'id_bagian': $('#user_modal').find('#id_bagian'),
            'id_seksi': $('#user_modal').find('#id_seksi'),
            'id_satuan': $('#user_modal').find('#id_satuan'),
            'ppk': $('#user_modal').find('#ppk'),
            'nik': $('#user_modal').find('#nik'),
            'pend_jenjang': $('#user_modal').find('#pend_jenjang'),
            'pend_jurusan': $('#user_modal').find('#pend_jurusan'),
            'tanggal_lahir': $('#user_modal').find('#tanggal_lahir'),
            'tempat_lahir': $('#user_modal').find('#tempat_lahir'),
            'tmt_kerja': $('#user_modal').find('#tmt_kerja'),
            'jenis_pegawai': $('#user_modal').find('#jenis_pegawai'),

            'j_k': $('#user_modal').find('#j_k'),
        }

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

        $.when(getAllRole(), getAllUser()).then((e) => {
            toolbar.newBtn.prop('disabled', false);
        }).fail((e) => {
            console.log(e)
        });

        function getAllRole() {
            return $.ajax({
                url: `<?php echo base_url('General/getAllRole/') ?>`,
                'type': 'POST',
                data: {},
                success: function(data) {
                    var json = JSON.parse(data);
                    if (json['error']) {
                        return;
                    }
                    dataRole = json['data'];
                    renderRoleSelectionFilter(dataRole);
                    // renderRoleSelectionAdd(dataRole);
                },
                error: function(e) {}
            });
        }

        function renderRoleSelectionFilter(data) {
            toolbar.id_role.empty();
            toolbar.id_role.append($('<option>', {
                value: "",
                text: "-- Semua Role --"
            }));
            Object.values(data).forEach((d) => {
                toolbar.id_role.append($('<option>', {
                    value: d['id_role'],
                    text: d['id_role'] + ' :: ' + d['nama_role'],
                }));
            });
        }

        $("#id_satuan").select2({
            dropdownParent: $('#user_modal .modal-content'),
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
            dropdownParent: $('#user_modal .modal-content'),
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
            dropdownParent: $('#user_modal .modal-content'),
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
            dropdownParent: $('#user_modal .modal-content'),
            ajax: {
                url: '<?= base_url() ?>search/seksi',
                type: "get",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    cur_bagian = $("#id_bagian").val();

                    return {
                        searchTerm: params.term, // search term
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

        toolbar.id_role.on('change', (e) => {
            getAllUser();
        });

        function getAllUser() {
            Swal.fire({
                title: 'Loading Pegawai!',
                allowOutsideClick: false,
            });
            Swal.showLoading()
            return $.ajax({
                url: `<?php echo site_url('General/getAllUser/') ?>`,
                'type': 'POST',
                data: toolbar.form.serialize(),
                success: function(data) {
                    Swal.close();
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

        RefSatker = <?= json_encode($ref_satker) ?>;
        $("#id_satuan").on('change', function() {
            console.log('change satyab')
            cur_satuan = $("#id_satuan").val();
            // dinkesvar = [1, 2, 3, 4, 5]
            if (RefSatker['satuan'][cur_satuan]['jenis'] != 1) {
                $('#layout_bagian , #layout_seksi').hide();
                $("#null_bagian , #null_seksi").prop('disabled', false)
                $("#id_bagian , #id_seksi").prop('disabled', true)
            } else {
                $('#layout_bagian , #layout_seksi').show();
                $("#null_bagian , #null_seksi").prop('disabled', true)
                $("#id_bagian , #id_seksi").prop('disabled', false)
            }
        });
        $("#id_bagian").on('change', function() {
            cur_bagian = $("#id_bagian").val();
            // dinkesvar = [1, 2, 3, 4, 5]
            console.log(RefSatker)
            if (cur_bagian) {
                if (RefSatker['bagian'][cur_bagian]['jenis'] != 4) {
                    $('#layout_seksi').hide();
                    $("#id_seksi").prop('disabled', true)
                    $("#null_seksi").prop('disabled', false)
                } else {
                    $('#layout_seksi').show();
                    $("#null_seksi").prop('disabled', true)
                    $("#id_seksi").prop('disabled', false)
                }
            } else {
                $('#layout_seksi').show();
                $("#null_seksi").prop('disabled', true)
                $("#id_seksi").prop('disabled', false)
            }
        })


        function renderUser(data) {
            if (data == null || typeof data != "object") {
                console.log("User::UNKNOWN DATA");
                return;
            }
            var i = 0;

            var renderData = [];
            Object.values(data).forEach((user) => {
                var editButton = `
        <a class="edit dropdown-item" data-id='${user['id']}'><i class='fa fa-pencil'></i> Edit User</a>
      `;
                var lihatButton = `
        <a class="dropdown-item" href='<?= base_url() ?>Master/detail_pegawai/${user['id']}'><i class='fa fa-eye'></i> Lihat Detail</a>
      `;
                var deleteButton = `
        <a class="delete dropdown-item" data-id='${user['id']}'><i class='fa fa-trash'></i> Hapus User</a>
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

                renderData.push([user['id'], user['username'], user['nama'], user['nip'], user['nama_satuan'] + ',<br>' + (user['nama_bag'] ? user['nama_bag'] : ''), user['nama_role'], button]);
            });
            FDataTable.clear().rows.add(renderData).draw('full-hold');
        }

        function resetUserModal() {
            UserModal.form.trigger('reset');
            UserModal.email.val("");
            UserModal.no_hp.val("");
            UserModal.nip.val("");
        }

        toolbar.newBtn.on('click', (e) => {
            resetUserModal();
            UserModal.self.modal('show');
            UserModal.addBtn.show();
            UserModal.saveEditBtn.hide();
            UserModal.password.prop('placeholder', 'Password');
            UserModal.password.prop('required', true);

            <?php
            if ($this->session->userdata()['id_role'] != 1) {
            } ?>

            var $defOption = $("<option selected='selected'></option>").val('<?= $this->session->userdata()['id_satuan'] ?>').text('<?= $this->session->userdata()['nama_satuan'] ?>');
            UserModal.id_satuan.append($defOption).trigger('change');

            // var $newOption2 = $("<option selected='selected'></option>").val(currentData['id_seksi']).text(currentData['nama_seksi']);
            // UserModal.id_seksi.append($newOption2).trigger('change');

            // var $newOption3 = $("<option selected='selected'></option>").val(currentData['id_bagian']).text(currentData['nama_bag']);
            // UserModal.id_bagian.append($newOption3).trigger('change');

            var $newOption4 = $("<option selected='selected'></option>").val('').text("--");
            UserModal.id_role.append($newOption4).trigger('change');

        });

        FDataTable.on('click', '.edit', function() {
            resetUserModal();
            UserModal.self.modal('show');
            UserModal.addBtn.hide();
            UserModal.saveEditBtn.show();
            UserModal.password.prop('placeholder', '(Unchanged)')
            UserModal.password.prop('required', false);

            var currentData = dataUser[$(this).data('id')];
            console.log(currentData);
            UserModal.idUser.val(currentData['id']);
            UserModal.jabatan.val(currentData['jabatan']);
            UserModal.pangkat_gol.val(currentData['pangkat_gol']);
            UserModal.email.val(currentData['email']);
            UserModal.no_hp.val(currentData['no_hp']);
            UserModal.nip.val(currentData['nip']);
            UserModal.username.val(currentData['username']);
            UserModal.ppk.val(currentData['ppk']);
            UserModal.nik.val(currentData['nik']);
            UserModal.pend_jenjang.val(currentData['pend_jenjang']);
            UserModal.pend_jurusan.val(currentData['pend_jurusan']);
            UserModal.tanggal_lahir.val(currentData['tanggal_lahir']);
            UserModal.tempat_lahir.val(currentData['tempat_lahir']);
            UserModal.tmt_kerja.val(currentData['tmt_kerja']);
            UserModal.nama.val(currentData['nama']);
            UserModal.j_k.val(currentData['j_k']);
            UserModal.jenis_pegawai.val(currentData['jenis_pegawai']);


            UserModal.id_satuan.val(1);
            <?php
            if ($this->session->userdata()['id_role'] != 1) {
            } ?>
            var $blankOption = $("<option selected='selected'></option>").val('').text('');
            var $newOption = $("<option selected='selected'></option>").val(currentData['id_satuan']).text(currentData['nama_satuan']);
            UserModal.id_satuan.append($newOption).trigger('change');
            if (currentData['id_bagian'] != 'null') {
                var $newOption3 = $("<option selected='selected'></option>").val(currentData['id_bagian']).text(currentData['nama_bag']);
                UserModal.id_bagian.append($newOption3).trigger('change');
            } else {
                UserModal.id_bagian.append($blankOption).trigger('change');
            }
            if (currentData['id_seksi']) {
                var $newOption2 = $("<option selected='selected'></option>").val(currentData['id_seksi']).text(currentData['nama_seksi']);
                UserModal.id_seksi.append($newOption2).trigger('change');
            } else {
                UserModal.id_seksi.append($blankOption).trigger('change');
            }

            var $newOption4 = $("<option selected='selected'></option>").val(currentData['id_role']).text(currentData['nama_role']);
            UserModal.id_role.append($newOption4).trigger('change');

            if (RefSatker['satuan'][currentData['id_satuan']]['jenis'] != 1) {
                $('#layout_bagian , #layout_seksi').hide();
                $("#null_bagian , #null_seksi").prop('disabled', false)
                $("#id_bagian , #id_seksi").prop('disabled', true)
            } else {
                $('#layout_bagian , #layout_seksi').show();
                $("#null_bagian , #null_seksi").prop('disabled', true)
                $("#id_bagian , #id_seksi").prop('disabled', false)
            }
        });

        UserModal.form.submit(function(event) {
            event.preventDefault();
            var isAdd = UserModal.addBtn.is(':visible');
            var url = "<?= base_url('Master/') ?>";
            url += isAdd ? "addUser" : "editUser";
            var button = isAdd ? UserModal.addBtn : UserModal.saveEditBtn;
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
                    data: UserModal.form.serialize(),
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
                        UserModal.self.modal('hide');
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
                    url: "<?= site_url('Master/deleteUser') ?>",
                    'type': 'get',
                    data: {
                        'id': id
                    },
                    success: function(data) {
                        var json = JSON.parse(data);
                        if (json['error']) {
                            Swal.fire("Delete Gagal", json['message'], "error");
                            return;
                        }
                        delete dataUser[id];
                        Swal.fire("Delete Berhasil", "", "success");
                        renderUser(dataUser);
                    },
                    error: function(e) {}
                });
            });
        });
    });
</script>