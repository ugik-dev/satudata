            <form id="user_form" onsubmit="return false;" type="multipart" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_title">
                        Form Role
                    </h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_role" value="<?= !empty($dataContent['users']['id_role']) ? $dataContent['users']['id_role'] : '' ?>">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class=" form-group">
                                <label for="nama">Nama Role</label>
                                <input type="text" placeholder="" class="form-control" value="<?= !empty($dataContent['users']['nama_role']) ? $dataContent['users']['nama_role'] : '' ?>" name="nama_role" required>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="nama">Level</label>
                                <select class="form-control" name="level">
                                    <option value="">-</option>
                                    <?php
                                    $name_level = [
                                        '',
                                        'Dinas Kesehatan',
                                        'Sekretaris',
                                        'Kepala Sub Bagian',
                                        'Kepala Bidang',
                                        'Kepala Seksi',
                                        'Pegawai',
                                        'Kepala Puskesmas / Direktur Rumah Sakit',
                                        'Kasubag Puskesmas / Rumah Sakit',
                                        'Pegawai Puskesmas',
                                    ];

                                    for ($i = 1; $i <= 9; $i++) {
                                        if (!empty($dataContent['users']['level'])) {
                                            if ($dataContent['users']['level'] == $i)
                                                echo "<option value='" . $i . "' selected>" . $i . '. ' . $name_level[$i] . " </option>";
                                            else
                                                echo "<option value='" . $i . "'>" . $i . '. ' . $name_level[$i] . " </option>";
                                        } else
                                            echo "<option value='" . $i . "'>" . $i . '. ' . $name_level[$i] . " </option>";
                                    }
                                    ?>
                                </select>
                                <!-- <input type="text" placeholder="" class="form-control" value="<?= !empty($dataContent['users']['nama_role']) ? $dataContent['users']['nama_role'] : '' ?>" name="nama_role" required> -->
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="nama">Jenis Satuan Kerja</label>
                                <select class="form-control" name="jen_satker">
                                    <?php

                                    $dataSatKer = [
                                        'Semua',
                                        'Dinas Kesehatan',
                                        'Puskesmas',
                                        'Rumah Sakit',
                                        'UPT'
                                    ];
                                    for ($i = 0; $i <= 4; $i++) {
                                        if (!empty($dataContent['users']['jen_satker'])) {
                                            if ($dataContent['users']['jen_satker'] == $i)
                                                echo "<option value='" . $i . "' selected>" . $i . '. ' . $dataSatKer[$i] . " </option>";
                                            else
                                                echo "<option value='" . $i . "'>" . $i . '. ' . $dataSatKer[$i] . " </option>";
                                        } else
                                            echo "<option value='" . $i . "'>" . $i . '. ' . $dataSatKer[$i] . " </option>";
                                    }
                                    ?>
                                </select>
                                <!-- <input type="text" placeholder="" class="form-control" value="<?= !empty($dataContent['users']['nama_role']) ? $dataContent['users']['nama_role'] : '' ?>" name="nama_role" required> -->
                            </div>
                        </div>
                    </div>
                    <?php foreach ($dataContent['roles'] as $dc) { ?>
                        <div class="row">
                            <div class="col-lg-12">
                                <label><b><?= $dc['label_menu'] ?></b></label>
                            </div>
                            <?php foreach ($dc['child'] as $dcs) { ?>
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <label class="mr-3 ml-10">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<?= $dcs['label_menulist'] ?></label>
                                        </div>
                                        <div class="col-lg-9">
                                            <!-- <div class="col"> -->
                                            <div class="mt-0 m-checkbox-inline">
                                                <div class="form-check form-check-inline checkbox checkbox-dark mb-10">
                                                    <input class="form-check-input" id="view_<?= $dcs['id_menulist'] ?>" type="checkbox" name="view_<?= $dcs['id_menulist'] ?>" <?= $dcs['view'] == 1 ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="view_<?= $dcs['id_menulist'] ?>">Lihat</label>
                                                </div>
                                                <div class="form-check form-check-inline checkbox checkbox-dark mb-10">
                                                    <input class="form-check-input" id="create_<?= $dcs['id_menulist'] ?>" type="checkbox" name="create_<?= $dcs['id_menulist'] ?>" <?= $dcs['hk_create'] == 1 ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="create_<?= $dcs['id_menulist'] ?>">Tambah</label>
                                                </div>
                                                <div class="form-check form-check-inline checkbox checkbox-dark mb-10">
                                                    <input class="form-check-input" id="update_<?= $dcs['id_menulist'] ?>" type="checkbox" name="update_<?= $dcs['id_menulist'] ?>" <?= $dcs['hk_update'] == 1 ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="update_<?= $dcs['id_menulist'] ?>">Edit</label>
                                                </div>
                                                <div class="form-check form-check-inline checkbox checkbox-dark mb-10">
                                                    <input class="form-check-input" id="delete_<?= $dcs['id_menulist'] ?>" type="checkbox" name="delete_<?= $dcs['id_menulist'] ?>" <?= $dcs['hk_delete'] == 1 ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="delete_<?= $dcs['id_menulist'] ?>">Delete</label>
                                                </div>
                                            </div>
                                            <!-- </div> -->
                                        </div>
                                        <hr>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit" id="save_edit_btn" data-loading-text="Loading..."><strong>Simpan Perubahan</strong></button>
                </div>
            </form>

            <script>
                $(document).ready(function() {
                    $('#menu_1').addClass('active');
                    $('#opmenu_1').show();
                    $('#submenu_4').addClass('active');

                    var UserModal = {
                        'form': $('#user_form'),
                        'addBtn': $('#add_btn'),
                        'saveEditBtn': $('#save_edit_btn'),
                        'idUser': $('#id_user'),
                        'username': $('#username'),
                        'nama': $('#nama'),
                        'nip': $('#nip'),
                        'email': $('#email'),
                        'no_hp': $('#no_hp'),
                        'status': $('#status'),
                        'password': $('#password'),
                        'id_role': $('#id_role'),
                    }
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
                    };

                    $.when().then((e) => {}).fail((e) => {
                        console.log(e)
                    });

                    UserModal.form.submit(function(event) {
                        event.preventDefault();
                        var url = "<?= base_url() . $dataContent['form_url'] ?>";

                        Swal.fire({
                            title: "Apakah anda Yakin?",
                            text: "Data Role akan dirubah dan hak aksess user terkait akan berubah juga!",
                            icon: "warning",
                            allowOutsideClick: false,
                            showCancelButton: true,
                            buttons: {
                                cancel: 'Batal !!',
                                catch: {
                                    text: "Ya, Saya Yakin !!",
                                    value: true,
                                },
                            },
                        }).then((result) => {
                            if (!result.isConfirmed) {
                                return;
                            }
                            Swal.fire({
                                title: 'Loading ..',
                                html: 'Harap Tunggu !!',
                                allowOutsideClick: false,
                                buttons: false,
                                didOpen: () => {
                                    Swal.showLoading()
                                }
                            })
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
                                    Swal.close();
                                    Swal.fire({
                                        title: "Berhasil !!",
                                        text: "Hak Aksess Berhasil Diperbaharui",
                                        icon: "success",
                                        allowOutsideClick: true,
                                        buttons: {
                                            catch: {
                                                text: "OK",
                                                value: true,
                                            },
                                        },
                                    }).then((result) => {
                                        location.href = "<?= base_url('master/roles') ?>";
                                    });
                                }
                            });
                        });
                    });
                    // });


                });
            </script>