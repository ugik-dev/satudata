<div class="container-fluid">
    <div class="edit-profile">
        <div class="row">
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Detail Pegawai</h4>
                        <div class="card-options">
                            <a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#" data-bs-toggle="card-remove"><i class="fe fe-x"></i></a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="row mb-2">
                                <div class="profile-title">
                                    <div class="media">
                                        <img class="img-70 rounded-circle" alt="" src="<?= base_url() ?>assets/images/user/7.jpg" />
                                        <div class="media-body">
                                            <h5 class="mb-1"><?= $data_profile['nama'] ?></h5>
                                            <p><?= $data_profile['nama_role'] ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email-Address</label>
                                <input class="form-control" value="<?= $data_profile['email'] ?>" disabled style="background-color: white" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">No Hp</label>
                                <input class="form-control" value="<?= $data_profile['no_hp'] ?>" disabled style="background-color: white" />
                            </div>
                            <div class="form-footer">
                                <button class="btn btn-primary btn-block">
                                    Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <form class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Edit Profile</h4>
                        <div class="card-options">
                            <a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#" data-bs-toggle="card-remove"><i class="fe fe-x"></i></a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6 col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">NIP</label>
                                    <input class="form-control" type="text" value="<?= $data_profile['nip'] ?>" disabled style="background-color: white" />
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6">

                                <div class="mb-3">
                                    <label class="form-label">Username</label>
                                    <input class="form-control" type="text" value="<?= $data_profile['username'] ?>" disabled style="background-color: white" />
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Alamat</label>
                                    <input class="form-control" type="text" value="<?= $data_profile['alamat'] ?>" disabled style="background-color: white" />
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Jabatan</label>
                                    <input class="form-control" type="text" value="<?= $data_profile['nip'] ?>" disabled style="background-color: white" />
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12">

                                <div class="mb-3">
                                    <label class="form-label">Satuan</label>
                                    <input class="form-control" type="text" value="<?= $data_profile['username'] ?>" disabled style="background-color: white" />
                                </div>
                            </div>


                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button class="btn btn-primary" type="submit">
                            Update Profile
                        </button>
                    </div>
                </form>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Riwayat Satuan Kerja</h4>
                        <!-- <div class="float-left"> -->
                        <button type="button" style='float: right;' class="btn btn-primary" id="new_riwayat"><i class="fa fa-plus"></i> Tambah User Baru</button>
                        <!-- </div> -->


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
                                    <th>Bidang</th>
                                    <th>Bagian</th>
                                    <th>Jabatan</th>
                                    <th>pangkat / Gol</th>
                                    <!-- <th>Tanggal Aktif</th> -->
                                    <th>Status</th>
                                    <th></th>
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


<div class="modal fade" id="riwayat_modal" style="overflow:hidden;">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form opd="form" id="user_form" onsubmit="return false;" type="multipart" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_title">
                        Form
                    </h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="" id="id_user" name="id_user" value="<?= $data_profile['id'] ?>">
                    <input type="" id="id_user_position" name="id_user_position">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="col-form-label">OPD</div>
                            <select class="select2 col-sm-12" id="id_satuan" name="id_satuan">
                            </select>
                            <!-- </div> -->
                        </div>
                        <div class="col-lg-6">
                            <div class="col-form-label">Bidang</div>
                            <select class="select2 col-sm-12" id="id_seksi" name="id_seksi"></select>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="nip">Bagian</label>
                                <select class="select2 col-sm-12" id="id_bagian" name="id_bagian"></select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="nip">Role</label>
                                <select class="select2 col-sm-12" id="id_role" name="id_role"></select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="nip">Tanggal Aktif</label>
                                <input type="date" placeholder="" class="form-control" id="tanggal_aktif" name="tanggal_aktif" required>
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
                                <label for="id_role">Pangkat/Golongan </label>
                                <input class="form-control mr-sm-2" name="pangkat_gol" id="pangkat_gol">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="id_role">Status</label>
                                <select class="form-control mr-sm-2" name="status" id="status">
                                    <option value="1">Active</option>
                                    <option value="2">Non Active</option>
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

<script>
    // $(".js-example-basic-single").select2();


    $(document).ready(function() {

        $('#menu_1').addClass('active');
        $('#opmenu_1').show();
        $('#submenu_1').addClass('active');
        var new_riwayat = $('#new_riwayat');


        var UserModal = {
            'self': $('#riwayat_modal'),
            'info': $('#riwayat_modal').find('.info'),
            'form': $('#riwayat_modal').find('#user_form'),
            'addBtn': $('#riwayat_modal').find('#add_btn'),
            'saveEditBtn': $('#riwayat_modal').find('#save_edit_btn'),
            'idUser': $('#riwayat_modal').find('#id'),
            'username': $('#riwayat_modal').find('#username'),
            'nama': $('#riwayat_modal').find('#nama'),
            'nip': $('#riwayat_modal').find('#nip'),
            'email': $('#riwayat_modal').find('#email'),
            'no_hp': $('#riwayat_modal').find('#no_hp'),
            'status': $('#riwayat_modal').find('#status'),
            'password': $('#riwayat_modal').find('#password'),
            'jabatan': $('#riwayat_modal').find('#jabatan'),
            'pangkat_gol': $('#riwayat_modal').find('#pangkat_gol'),
            'id_role': $('#riwayat_modal').find('#id_role'),
            'id_bagian': $('#riwayat_modal').find('#id_bagian'),
            'id_seksi': $('#riwayat_modal').find('#id_seksi'),
            'id_satuan': $('#riwayat_modal').find('#id_satuan'),
            'ppk': $('#riwayat_modal').find('#ppk'),
            'nik': $('#riwayat_modal').find('#nik'),
            'pend_jenjang': $('#riwayat_modal').find('#pend_jenjang'),
            'pend_jurusan': $('#riwayat_modal').find('#pend_jurusan'),
            'tanggal_lahir': $('#riwayat_modal').find('#tanggal_lahir'),
            'tempat_lahir': $('#riwayat_modal').find('#tempat_lahir'),
            'tmt_kerja': $('#riwayat_modal').find('#tmt_kerja'),
            'jenis_pegawai': $('#riwayat_modal').find('#jenis_pegawai'),
            'j_k': $('#riwayat_modal').find('#j_k'),
        }

        var FDataTable = $('#FDataTable').DataTable({
            "searching": false,
            "paging": false,
            "ordering": false,
            "info": false
        });

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


        var UserModal = {
            'self': $('#riwayat_modal'),
            'info': $('#riwayat_modal').find('.info'),
            'form': $('#riwayat_modal').find('#user_form'),
            'addBtn': $('#riwayat_modal').find('#add_btn'),
            'saveEditBtn': $('#riwayat_modal').find('#save_edit_btn'),
            'id_riwayat': $('#riwayat_modal').find('#id_riwayat'),
            'jabatan': $('#riwayat_modal').find('#jabatan'),
            'id_satuan': $('#riwayat_modal').find('#id_satuan'),
            'id_role': $('#riwayat_modal').find('#id_role'),
            'tanggal_aktif': $('#riwayat_modal').find('#tanggal_aktif'),
            'status_riwayat': $('#riwayat_modal').find('#status_riwayat'),
        }

        function resetModal() {
            UserModal.form.trigger('reset');
            UserModal.id_role.val('');
            UserModal.id_riwayat.val("");
            UserModal.id_satuan.val("");
            UserModal.jabatan.val("");
            UserModal.tanggal_aktif.val("");
        }

        new_riwayat.on('click', (e) => {
            // resetModal();
            console.log('modal');
            UserModal.self.modal('show');
            UserModal.addBtn.show();
            UserModal.saveEditBtn.hide();
        });


        UserModal.form.submit(function(event) {
            event.preventDefault();
            var isAdd = UserModal.addBtn.is(':visible');
            var url = "<?= base_url('Master/') ?>";
            url += isAdd ? "addPosition" : "editPosition";
            var button = isAdd ? UserModal.addBtn : UserModal.saveEditBtn;
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
        getAllPosotion()

        function getAllPosotion() {

            $.ajax({
                url: '<?= base_url() ?>general/getAllPosition',
                'type': 'get',
                data: {
                    id_user: '<?= $data_profile['id'] ?>'
                },
                success: function(data) {
                    // buttonIdle(button);
                    var json = JSON.parse(data);
                    var pos = json['data']
                    dataPosition = pos;
                    renderPosition(dataPosition);
                },
                error: function(e) {}
            });
        }

        function renderPosition(data) {
            if (data == null || typeof data != "object") {
                console.log("User::UNKNOWN DATA");
                return;
            }
            var i = 0;

            var renderData = [];
            Object.values(data).forEach((user) => {
                var editButton = `
        <a class="edit dropdown-item" data-id='${user['id_user_position']}'><i class='fa fa-pencil'></i> Edit</a>
      `;
                var deleteButton = `
        <a class="delete dropdown-item" data-id='${user['id_user_position']}'><i class='fa fa-trash'></i> Hapus</a>
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

                renderData.push([user['id_user_position'], user['nama_satuan2'], user['nama_seksi'], user['nama_bag'], user['jabatan'], user['pangkat_gol'], user['status'], button]);
            });
            FDataTable.clear().rows.add(renderData).draw('full-hold');
        }
    });
</script>