<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-header">

                    <form class="form-inline" id="toolbar_form" onsubmit="return false;">
                        <!-- <div class="col-lg-2"> -->
                        <input type="hidden" id="is_not_self" name="is_not_self" value="1">
                        <!-- </div> -->
                        <div class="col-lg-2">
                            <select class="form-control mr-sm-2" name="tool_id_role" id="tool_id_role"></select>
                        </div>
                        <button type="button" class="btn btn-success my-1 mr-sm-2" id="new_btn" disabled="disabled"><i class="fal fa-plus"></i> Tambah User Baru</button>
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
                        <div class="col-lg-6">
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
                    </div>
                    <div class="row">
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
                    </div>
                    <div class="row">

                        <div class="col-lg-6">
                            <div class="col-form-label">OPD</div>
                            <select class="select2 col-sm-12" id="id_satuan" name="id_satuan">
                            </select>
                            <!-- </div> -->
                        </div>
                        <div class="col-lg-6">
                            <div class="col-form-label">Bidang</div>
                            <select class="select2 col-sm-12" id="id_bidang" name="id_bidang"></select>
                        </div>
                        <div class="col-lg-6">
                            <div class="col-form-label"> Bagian
                            </div>
                            <select class="select2 col-sm-12" id="id_bagian" name="id_bagian"></select>
                        </div>
                        <div class="col-lg-6">
                            <div class="col-form-label"> Role </div>
                            <select class="select2 col-sm-12" id="id_role" name="id_role"></select>
                        </div>
                    </div>

                    <hr style="height:5px;border:none;color:#000000;background-color:#000000;">
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
            'id_bidang': $('#user_modal').find('#id_bidang'),
            'id_satuan': $('#user_modal').find('#id_satuan'),
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

        $("#id_bidang").select2({
            dropdownParent: $('#user_modal .modal-content'),
            ajax: {
                url: '<?= base_url() ?>Search/bidang',
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


        // function renderRoleSelectionAdd(data) {
        //     UserModal.id_role.empty();
        //     UserModal.id_role.append($('<option>', {
        //         value: "",
        //         text: "-- Pilih Role --"
        //     }));
        //     Object.values(data).forEach((d) => {
        //         UserModal.id_role.append($('<option>', {
        //             value: d['id_role'],
        //             text: d['id_role'] + ' :: ' + d['nama_role'],
        //         }));
        //     });
        // }

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

                renderData.push([user['id'], user['username'], user['nama'], user['nip'], user['nama_role'], button]);
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
        });

        FDataTable.on('click', '.edit', function() {
            resetUserModal();
            UserModal.self.modal('show');
            UserModal.addBtn.hide();
            UserModal.saveEditBtn.show();
            UserModal.password.prop('placeholder', '(Unchanged)')
            UserModal.password.prop('required', false);

            var currentData = dataUser[$(this).data('id')];
            UserModal.idUser.val(currentData['id']);
            UserModal.jabatan.val(currentData['jabatan']);
            UserModal.pangkat_gol.val(currentData['pangkat_gol']);
            UserModal.email.val(currentData['email']);
            UserModal.no_hp.val(currentData['no_hp']);
            UserModal.nip.val(currentData['nip']);
            UserModal.username.val(currentData['username']);
            UserModal.nama.val(currentData['nama']);
            UserModal.id_satuan.val(1);

            var $newOption = $("<option selected='selected'></option>").val(currentData['id_satuan']).text(currentData['nama_satuan']);
            UserModal.id_satuan.append($newOption).trigger('change');

            var $newOption2 = $("<option selected='selected'></option>").val(currentData['id_bidang']).text(currentData['nama_bidang']);
            UserModal.id_bidang.append($newOption2).trigger('change');

            var $newOption3 = $("<option selected='selected'></option>").val(currentData['id_bagian']).text(currentData['nama_bag']);
            UserModal.id_bagian.append($newOption3).trigger('change');

            var $newOption4 = $("<option selected='selected'></option>").val(currentData['id_role']).text(currentData['nama_role']);
            UserModal.id_role.append($newOption4).trigger('change');
        });

        UserModal.form.submit(function(event) {
            event.preventDefault();
            var isAdd = UserModal.addBtn.is(':visible');
            var url = "<?= base_url('Master/') ?>";
            url += isAdd ? "addUser" : "editUser";
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