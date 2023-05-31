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
                                <!-- <form> -->
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
                                            <input class="form-control" name="username" value="<?= $data_profile['username'] ?>" />
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <label class="form-label">Email-Address</label>
                                                <input class="form-control" name="email" value="<?= $data_profile['email'] ?>" />
                                            </div>
                                            <div class="col">
                                                <label class="form-label">No Hp</label>
                                                <input class="form-control" name="no_hp" value="<?= $data_profile['no_hp'] ?>" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <label class="form-label">Password <small><br>* jika tidak diganti biarkan kosong</small></label>
                                                <input class="form-control" name="password" value="" type="password" placeholder="(tidak diganti)" />
                                            </div>
                                            <div class="col">
                                                <label class="form-label">Re-Password <small><br>* jika tidak diganti biarkan kosong</small></label>
                                                <input class="form-control" name="re-password" value="" type="password" placeholder="(tidak diganti)" />
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <!-- <div class="form-footer">
                                <button class="btn btn-primary btn-block">
                                    Save
                                </button>
                            </div> -->
                                <!-- </form> -->
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
                                            <input class="form-control" name="nama" type="text" value="<?= $data_profile['nama'] ?>" />
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">NIP</label>
                                            <input class="form-control" name="nip" type="text" value="<?= $data_profile['nip'] ?>" />
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">NIK</label>
                                            <input class="form-control" name="nik" type="text" value="<?= $data_profile['nik'] ?>" required />
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Alamat</label>
                                            <input class="form-control" name="alamat" type="text" value="<?= $data_profile['alamat'] ?>" />
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Nama Bank</label>
                                            <input class="form-control" name="nama_bank" type="text" value="<?= $data_profile['nama_bank'] ?>" />
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">No Rekening Bank</label>
                                            <input class="form-control" name="no_bank" type="text" value="<?= $data_profile['no_bank'] ?>" />
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Jenjang</label>
                                            <input class="form-control" name="pend_jenjang" type="text" value="<?= $data_profile['pend_jenjang'] ?>" />
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Jurusan</label>
                                            <input class="form-control" name="pend_jurusan" type="text" value="<?= $data_profile['pend_jurusan'] ?>" />
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Tempat Lahir</label>
                                            <input class="form-control" name="tempat_lahir" type="text" value="<?= $data_profile['tempat_lahir'] ?>" />
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Tanggal Lahir</label>
                                            <input class="form-control" name="tanggal_lahir" type="date" value="<?= $data_profile['tanggal_lahir'] ?>" />
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Jenis Pegawai</label>
                                            <select class="form-control" name="jenis_pegawai">
                                                <option value="1" <?= $data_profile['jenis_pegawai'] == '1' ? 'selected' : '' ?>>PNS</option>
                                                <option value="2" <?= $data_profile['jenis_pegawai'] == '2' ? 'selected' : '' ?>>Honorer</option>
                                                <option value="3" <?= $data_profile['jenis_pegawai'] == '3' ? 'selected' : '' ?>>Out Sourcing</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">TMT Awal Kerja</label>
                                            <input class="form-control" name="tmt_kerja" type="date" value="<?= $data_profile['tmt_kerja'] ?>" />
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Jabatan</label>
                                            <input class="form-control" name="jabatan" type="text" value="<?= $data_profile['jabatan'] ?>" />
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Pangkat Golongan</label>
                                            <input class="form-control" name="pangkat_gol" type="text" value="<?= $data_profile['pangkat_gol'] ?>" />
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Satuan</label>
                                            <select class="select2 col-sm-12" id="id_satuan" name="id_satuan" required>
                                                <option value="<?= $data_profile['id_satuan'] ?>" selected><?= $data_profile['nama_satuan'] ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6" id="layout_bagian">
                                        <div class="mb-3">
                                            <label class="form-label">Bagian</label>
                                            <input type="hidden" id="null_bagian" name="null_bagian" value="true" disabled>
                                            <select class="select2 col-sm-12" id="id_bagian" name="id_bagian">
                                                <option value="<?= $data_profile['id_bagian'] ?>" selected><?= $data_profile['nama_bag'] ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6" id="layout_seksi">
                                        <div class="mb-3">
                                            <label class="form-label">Seksi</label>
                                            <input type="hidden" id="null_seksi" name="null_seksi" value="true" disabled>
                                            <select class="select2 col-sm-12" id="id_seksi" name="id_seksi">
                                                <option value="<?= $data_profile['id_seksi'] ?>" selected><?= $data_profile['nama_seksi'] ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- <div class="col-sm-12 col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Satuan</label>
                                    <input class="form-control" type="text" value="<?= $data_profile['pangkat_gol'] ?>"  />
                                </div>
                            </div> -->
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
</div>


<script>
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
            'tanggal_aktif': $('#formProfile').find('#tanggal_aktif'),
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
            // formProfile.tanggal_aktif.val("");
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

                renderData.push([user['id_user_position'], user['nama_satuan2'], user['nama_bidang'], user['nama_bag'], user['jabatan'], user['pangkat_gol'], user['status'], button]);
            });
            FDataTable.clear().rows.add(renderData).draw('full-hold');
        }

        $("#id_satuan").trigger('change');
        $("#id_bagian").trigger('change');

    });
</script>