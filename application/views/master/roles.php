<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-header">

                    <form class="form-inline" id="toolbar_form" onsubmit="return false;">
                        <!-- <div class="col-lg-2"> -->
                        <input type="hidden" id="key_id" name="key_id" value="1">
                        <!-- </div> -->
                        <div class="col-lg-2" hidden>
                            <select class="form-control mr-sm-2" name="id_role" id="id_role"></select>
                        </div>
                        <a href="<?= base_url() ?>Master/tambah_role" class="btn btn-success my-1 mr-sm-2" id="new_btn" disabled="disabled"><i class="fa fa-plus"></i> Tambah Role Baru</a>
                    </form>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="FDataTable" class="table table-bordered table-hover" style="padding-bottom: 100px">
                            <thead>
                                <tr>
                                    <th style="width: 2%; text-align:center!important">ID</th>
                                    <th style="width: 24%; text-align:center!important">Nama Role</th>
                                    <th style="width: 24%; text-align:center!important">Level</th>
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



<script>
    $(document).ready(function() {
        $('#menu_1').addClass('active');
        $('#opmenu_1').show();
        $('#submenu_4').addClass('active');

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
            'idUser': $('#user_modal').find('#id_user'),
            'username': $('#user_modal').find('#username'),
            'nama': $('#user_modal').find('#nama'),
            'nip': $('#user_modal').find('#nip'),
            'email': $('#user_modal').find('#email'),
            'no_hp': $('#user_modal').find('#no_hp'),
            'status': $('#user_modal').find('#status'),
            'password': $('#user_modal').find('#password'),
            'id_role': $('#user_modal').find('#id_role'),
        }

        var dataRole = {}
        var dataUser = {}
        var dataLevel = [
            '',
            'KEPALA DINAS',
            'Sekretaris',
            'Kepala Sub Bagian',
            'Kepala Bidang',
            'Kepala Seksi',
            'Pegawai',
            'Kepala Puskesmas / Direktur Rumah Sakit',
            'Kasubag Puskesmas / Rumah Sakit',
            'Pegawai Puskesmas',
        ]
        var dataSatKer = [
            'Semua',
            'Dinas Kesehatan',
            'Puskesmas',
            'Rumah Sakit',
            'UPT'
        ]
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

        $.when(getAllRole()).then((e) => {
            toolbar.newBtn.prop('disabled', false);
        }).fail((e) => {
            console.log(e)
        });

        function getAllRole() {
            return $.ajax({
                url: `<?php echo base_url('General/getAllRole/') ?>`,
                'type': 'GET',
                data: toolbar.form.serialize(),
                success: function(data) {
                    var json = JSON.parse(data);
                    if (json['error']) {
                        return;
                    }
                    dataRole = json['data'];
                    renderUser(dataRole);
                    // renderRoleSelectionFilter(dataRole);
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

        function renderRoleSelectionAdd(data) {
            UserModal.id_role.empty();
            UserModal.id_role.append($('<option>', {
                value: "",
                text: "-- Pilih Role --"
            }));
            Object.values(data).forEach((d) => {
                UserModal.id_role.append($('<option>', {
                    value: d['id_role'],
                    text: d['id_role'] + ' :: ' + d['nama_role'],
                }));
            });
        }

        toolbar.id_role.on('change', (e) => {
            UserModal.id_role.attr('readonly', !empty(toolbar.id_role.val()));
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
            console.log(data);
            if (data == null || typeof data != "object") {
                console.log("User::UNKNOWN DATA");
                return;
            }
            var i = 0;

            var renderData = [];
            Object.values(data).forEach((user) => {
                var editButton = `
        <a class="edit dropdown-item" href='<?= base_url() ?>Master/role_edit/${user['id_role']}'><i class='fa fa-pencil'></i> Edit Role</a>
      `;
                var lihatButton = `
        <a class="dropdown-item" href='<?= base_url() ?>Master/detail_pegawai/${user['id_role']}'><i class='fa fa-eye'></i> </a>
      `;
                var deleteButton = `
        <a class="delete dropdown-item" data-id='${user['id_role']}'><i class='fa fa-trash'></i> Hapus Role</a>
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

                renderData.push([user['id_role'], user['nama_role'], user['level'] + '. ' + dataLevel[user['level']], button]);
            });
            FDataTable.clear().rows.add(renderData).draw('full-hold');
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
            UserModal.idUser.val(currentData['id_user']);
            UserModal.email.val(currentData['email']);
            UserModal.no_hp.val(currentData['no_hp']);
            UserModal.nip.val(currentData['nip']);
            UserModal.username.val(currentData['username']);
            UserModal.nama.val(currentData['nama']);
        });

        UserModal.form.submit(function(event) {
            event.preventDefault();
            var isAdd = UserModal.addBtn.is(':visible');
            var url = "<?= site_url('UserController/') ?>";
            url += isAdd ? "addUser" : "editUser";
            var button = isAdd ? UserModal.addBtn : UserModal.saveEditBtn;

            Swal.fire(swalSaveConfigure).then((result) => {
                if (!result.value) {
                    return;
                }
                buttonLoading(button);
                $.ajax({
                    url: url,
                    'type': 'POST',
                    data: UserModal.form.serialize(),
                    success: function(data) {
                        buttonIdle(button);
                        var json = JSON.parse(data);
                        if (json['error']) {
                            Swal.fire("Simpan Gagal", json['message'], "error");
                            return;
                        }
                        var user = json['data']
                        dataUser[user['id_user']] = user;
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
            Swal.fire(swalDeleteConfigure).then((result) => {
                if (!result.value) {
                    return;
                }
                $.ajax({
                    url: "<?= site_url('UserController/deleteUser') ?>",
                    'type': 'POST',
                    data: {
                        'id_user': id
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