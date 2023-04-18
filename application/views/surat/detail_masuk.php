<div class="container-fluid">
    <div class="card">
        <!-- <ul class="nav nav-tabs border-tab" id="top-tab" role="tablist"> -->
        <!-- <ul class="nav nav-tabs" id="icon-tab" role="tablist"> -->
        <ul class="nav nav-tabs nav-primary" id="pills-warningtab" role="tablist">
            <li class="nav-item"><a class="nav-link active" id="top-home-tab" data-bs-toggle="tab" href="#top-home" role="tab" aria-controls="top-home" aria-selected="true"><i class="icofont icofont-ui-note"></i>Infomrasi</a></li>
            <li class="nav-item"><a class="nav-link" id="profile-top-tab" data-bs-toggle="tab" href="#top-profile" role="tab" aria-controls="top-profile" aria-selected="false"><i class="icofont icofont-man-in-glasses"></i>Riwayat Disposisi</a></li>
        </ul>
        <div class="card-body">
            <div class="tab-content" id="top-tabContent">
                <div class="tab-pane fade  show active" id="top-home" role="tabpanel" aria-labelledby="top-home-tab">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="row">
                                    <label class="col-sm-3 col-form-label"><strong>No Surat</strong></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="no_surat" required="" value="<?= !empty($dataContent['nomor_surat']) ? $dataContent['nomor_surat'] : '' ?>" readonly="">
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="hr-line-dashed"></div> -->
                            <div class="col-lg-4">
                                <div class="row">
                                    <label class="col-sm-3 col-form-label"><strong>Tanggal</strong></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="no_sppd" required="" readonly="" value="<?= !empty($dataContent['tanggal_surat']) ? tanggal_indonesia($dataContent['tanggal_surat']) : '' ?>">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <br>
                            <br>
                            <hr>
                            <!-- <div class="hr-line-dashed"></div> -->
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="col-form-label"><strong>Dari</strong></div>
                                        <?= $dataContent['dari'] ?>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="col-form-label"><strong>Untuk</strong></div>
                                        <?= $dataContent['kepada'] ?>
                                    </div>
                                </div>
                                <hr>
                            </div>
                            <div class="col-lg-12">
                                <object width="100%" height="700px" data="<?= base_url('uploads/surat_masuk/' . $dataContent['file_surat']) ?>" type="application/pdf">
                                    <iframe src="<?= base_url('uploads/surat_masuk/' . $dataContent['file_surat']) ?>"></iframe>
                                </object>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="top-profile" role="tabpanel" aria-labelledby="profile-top-tab">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Aksi</th>
                                <th>Nama</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Mengajukan</td>
                                <td><?= $dataContent['nama_input'] ?></td>
                                <td><?= $dataContent['tgl_pengajuan'] ?></td>
                            </tr>
                            <?php
                            foreach ($dataContent['logs'] as $log) {
                                echo "<tr>
                                    <td> {$log['deskripsi']}</td>
                                    <td> {$log['nama']}</td>
                                    <td> {$log['time_logs']}</td>
                                </tr>";
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="tap-dokumen" role="tabpanel" aria-labelledby="contact-top-tab">

                </div>
                <!-- </div>
                </div> -->
                <!-- </div> -->
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="foto_modal" aria-labelledby="exampleModalLongTitle">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form opd="form" id="foto_form" onsubmit="return false;" type="multipart" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_title">
                        Form Foto
                    </h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id_spt" name="id_spt" value="<?= $dataContent['id_spt'] ?>">
                    <input type="" id="id_foto" name="id_foto">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="nama">File</label>
                                <!-- <p class="no-margins"><span id="file_foto">-</span></p> -->
                                <input type="file" placeholder="" class="form-control" id="file_foto" name="file_foto">
                            </div>
                            <div class="form-group">
                                <label for="nama">Deskripsi</label>
                                <textarea type="text" placeholder="" class="form-control" id="deskripsi" name="deskripsi"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit" id="add_btn" data-loading-text="Loading..."><strong>Tambah</strong></button>
                        <button class="btn btn-primary" type="submit" id="save_edit_btn" data-loading-text="Loading..."><strong>Simpan Perubahan</strong></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#menu_2').addClass('active');
        $('#opmenu_2').show();
        $('#submenu_5').addClass('active');
        $('#ajukan_btn').on('click', (ev) => {
            event.preventDefault();
            Swal.fire({
                title: "Data ini akan di  Ajukan?",
                icon: "warning",
                allowOutsideClick: false,
                showCancelButton: true,
                buttons: {
                    cancel: 'Batal !!',
                    catch: {
                        text: "Ya, Ajukan !!",
                        value: true,
                    },
                },
            }).then((result) => {
                if (!result.isConfirmed) {
                    return;
                }
                swalLoading();

                $.ajax({
                    url: '<?= base_url('spt/action/ajukan/' . $dataContent['id_spt']) ?>',
                    'type': 'get',
                    data: {

                    },
                    success: function(data) {
                        var json = JSON.parse(data);
                        if (json['error']) {
                            Swal.fire(" <?= ($cur_user['id'] == $dataContent['user_input'] && $dataContent['status'] == 0) ? ' Pengajuan' : 'Approv' ?> Gagal", json['message'], "error");
                            return;
                        }
                        Swal.close();
                        Swal.fire({
                            title: "Berhasil !!",
                            text: "Data telah <?= ($cur_user['id'] == $dataContent['user_input'] && $dataContent['status'] == 0) ? ' diajukan' : 'diapprov' ?>",
                            icon: "success",
                            allowOutsideClick: true,
                            buttons: {
                                catch: {
                                    text: "OK",
                                    value: true,
                                },
                            },
                        }).then((result) => {
                            location.reload();
                        });
                    }
                });

            });
        })
        $('#approv_btn').on('click', (ev) => {
            event.preventDefault();
            Swal.fire({
                title: "Data ini akan di  <?= ($cur_user['id'] == $dataContent['user_input'] && $dataContent['status'] == 0) ? ' diajukan' : 'diapprov' ?>?",
                // text: "Data Role akan dirubah dan hak aksess user terkait akan berubah juga!",
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
                swalLoading();

                $.ajax({
                    url: '<?= base_url('spt/action/approv/' . $dataContent['id_spt']) ?>',
                    'type': 'get',
                    data: {

                    },
                    success: function(data) {
                        var json = JSON.parse(data);
                        if (json['error']) {
                            Swal.fire(" <?= ($cur_user['id'] == $dataContent['user_input'] && $dataContent['status'] == 0) ? ' Pengajuan' : 'Approv' ?> Gagal", json['message'], "error");
                            return;
                        }
                        Swal.close();
                        Swal.fire({
                            title: "Berhasil !!",
                            text: "Data telah <?= ($cur_user['id'] == $dataContent['user_input'] && $dataContent['status'] == 0) ? ' diajukan' : 'diapprov' ?>",
                            icon: "success",
                            allowOutsideClick: true,
                            buttons: {
                                catch: {
                                    text: "OK",
                                    value: true,
                                },
                            },
                        }).then((result) => {
                            location.reload();
                        });
                    }
                });

            });
        })
        var FotoModal = {
            'self': $('#foto_modal'),
            'info': $('#foto_modal').find('.info'),
            'form': $('#foto_modal').find('#foto_form'),
            'deskripsi': $('#foto_modal').find('#deskripsi'),
            'addBtn': $('#foto_modal').find('#add_btn'),
            'id_foto': $('#foto_modal').find('#id_foto'),
            'saveEditBtn': $('#foto_modal').find('#save_edit_btn'),
            'file_foto': $('#foto_modal').find('#file_foto'),

        };
        $('#addFoto').on('click', (ev) => {
            FotoModal.self.modal('show');
            FotoModal.file_foto.prop('required', true);
            FotoModal.addBtn.show();
            FotoModal.saveEditBtn.hide();
            FotoModal.form.trigger('reset');

        })

        dataFoto = [];
        getFotoSppd();


        function getFotoSppd() {
            Swal.fire({
                title: 'Loading Pegawai!',
                allowOutsideClick: false,
            });
            Swal.showLoading()
            return $.ajax({
                url: `<?php echo site_url('Spt/getFoto/') ?>`,
                'type': 'get',
                data: {
                    'id_spt': '<?= $dataContent['id_spt'] ?>'
                },
                success: function(data) {
                    Swal.close();
                    var json = JSON.parse(data);
                    if (json['error']) {
                        return;
                    }
                    dataFoto = json['data'];
                    renderFoto(dataFoto);
                },
                error: function(e) {}
            });
        }

        function renderFoto(data) {
            if (data == null || typeof data != "object") {
                console.log("User::UNKNOWN DATA");
                return;
            }
            var i = 0;

            $('#layout_foto').html('');
            var renderData = [];
            Object.values(data).forEach((d) => {
                template_foto = `
                <div class="col-xl-3 col-md-4 col-6 mb-2">
                <div class="mb-0">
                <figure class="col-12 mb-0" itemprop="associatedMedia" itemscope="">
                    <a href="<?= base_url() ?>uploads/foto_sppd/${d['file_foto']}" itemprop="contentUrl" data-size="1600x950">
                     <img class="img-thumbnail" style="height : 12rem !important" src="<?= base_url() ?>uploads/foto_sppd/${d['file_foto']}" itemprop="thumbnail" alt="Image description"></a>
                            <figcaption itemprop="caption description">${d['deskripsi']}</figcaption>
                            </figure>
                            </div>
                            <div class="row col-12 icon-lists">
                                 <div class="col"><i class="fa fa-trash delete_foto pl-2 pr-2" data-id="${d['id_foto']}"></i>  <i class="fa fa-pencil edit_foto mr-2" data-id="${d['id_foto']}"></i></div>
                        
                       
                    </div>
                            </div>
                        `
                $('#layout_foto').append(template_foto);
            })

            $('.edit_foto').on('click', function(event) {
                console.log('sad')
                // resetUserModal();
                FotoModal.self.modal('show');
                FotoModal.addBtn.hide();
                FotoModal.saveEditBtn.show();
                FotoModal.form.trigger('reset');

                var currentData = dataFoto[$(this).data('id')];
                console.log(currentData);
                FotoModal.id_foto.val(currentData['id_foto']);
                FotoModal.deskripsi.val(currentData['deskripsi']);
            });

            $('.delete_foto').on('click', function(event) {
                event.preventDefault();
                var currentData = dataFoto[$(this).data('id')];
                console.log(currentData);
                var url = "<?= base_url('Spt/deleteFoto') ?>";
                Swal.fire({
                    title: "Konfirmasi?",
                    text: "Foto akan dihapus?",
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
                    swalLoading();
                    if (!result.isConfirmed) {
                        return;
                    }
                    $.ajax({
                        url: url,
                        'type': 'get',
                        data: {
                            'id_foto': currentData['id_foto'],
                            'id_spt': currentData['id_spt'],
                        },
                        //     // formProfile.form.serialize(),
                        //     new FormData(FotoModal.form[0]),
                        // contentType: false,
                        // processData: false,
                        success: function(data) {
                            // buttonIdle(button);
                            var json = JSON.parse(data);
                            if (json['error']) {
                                Swal.fire("Simpan Gagal", json['message'], "error");
                                return;
                            }
                            var res = json['data']
                            delete dataFoto[currentData['id_foto']];
                            renderFoto(dataFoto);
                            Swal.fire("Simpan Berhasil", "", "success");
                            // location.reload();
                            // renderUser(dataUser);
                            // formProfile.self.modal('hide');
                        },
                        error: function(e) {}
                    });
                });
            });
        }

        FotoModal.form.submit(function(event) {
            console.log('submit');
            event.preventDefault();
            var url = "<?= base_url('Spt/addFoto') ?>";
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
                swalLoading();
                if (!result.isConfirmed) {
                    return;
                }
                $.ajax({
                    url: url,
                    'type': 'POST',
                    data:
                        // formProfile.form.serialize(),
                        new FormData(FotoModal.form[0]),
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        // buttonIdle(button);
                        var json = JSON.parse(data);
                        if (json['error']) {
                            Swal.fire("Simpan Gagal", json['message'], "error");
                            return;
                        }
                        var res = json['data']
                        dataFoto[res['id_foto']] = res;
                        renderFoto(dataFoto);
                        Swal.fire("Simpan Berhasil", "", "success");
                        FotoModal.self.modal('hide')
                        // location.reload();
                        // renderUser(dataUser);
                        // formProfile.self.modal('hide');
                    },
                    error: function(e) {}
                });
            });
        });

        $('#deapprov_btn').on('click', (ev) => {
            console.log('de')
            event.preventDefault();
            Swal.fire({
                title: "Data ini akan di tolak?",
                // text: "Data Role akan dirubah dan hak aksess user terkait akan berubah juga!",
                icon: "danger",
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
                swalLoading();

                $.ajax({
                    url: '<?= base_url('spt/action/unapprov/' . $dataContent['id_spt']) ?>',
                    'type': 'get',
                    data: {

                    },
                    success: function(data) {
                        var json = JSON.parse(data);
                        if (json['error']) {
                            Swal.fire("Gagal", json['message'], "error");
                            return;
                        }
                        Swal.close();
                        Swal.fire({
                            title: "Berhasil !!",
                            text: "Data telah ditolak.",
                            icon: "success",
                            allowOutsideClick: true,
                            buttons: {
                                catch: {
                                    text: "OK",
                                    value: true,
                                },
                            },
                        }).then((result) => {
                            location.reload();
                        });
                    }
                });

            });
        })

        $('#batal_aksi').on('click', (ev) => {
            event.preventDefault();
            Swal.fire({
                title: "Batalkan Approval data?",
                // text: "Data Role akan dirubah dan hak aksess user terkait akan berubah juga!",
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
                    title: 'Loading ..',
                    html: 'Harap Tunggu !!',
                    allowOutsideClick: false,
                    buttons: false,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                })

                $.ajax({
                    url: '<?= base_url('spt/action/undo/' . $dataContent['id_spt']) ?>',
                    'type': 'get',
                    data: {

                    },
                    success: function(data) {
                        var json = JSON.parse(data);
                        if (json['error']) {
                            Swal.fire("Gagal", json['message'], "error");
                            return;
                        }
                        Swal.close();
                        Swal.fire({
                            title: "Berhasil !!",
                            text: "Aksi telah dibatalkan.",
                            icon: "success",
                            allowOutsideClick: true,
                            buttons: {
                                catch: {
                                    text: "OK",
                                    value: true,
                                },
                            },
                        }).then((result) => {
                            location.reload();
                        });
                    }
                });

            });
        })
        console.log('ss');
        renderButtonSPT()

        function renderButtonSPT() {
            spt = <?= json_encode($dataContent) ?>;
            currentUser = <?= json_encode($this->session->userdata()) ?>;
            console.log(spt);
            var aksiBtn = '';
            <?php if ($this->session->userdata()['level'] == 3 or $this->session->userdata()['level'] == 4) { ?>
                console.log('ini level 3 KASUBAG / KABID');
                if (spt['status'] == 2) {
                    var aksiBtn = `
                    <a class="approv dropdown-item"  data-jenis='spt' data-id='${spt['id_spt']}' ><i class='fa fa-check'></i> Approv</a>
                    <a class="deapprov dropdown-item " data-jenis='spt' data-id='${spt['id_spt']}' ><i class='fa fa-times'></i> Tolak Approv</a>
                    `;
                } else if (spt['status'] == 10) {
                    var aksiBtn = `
                    <a class="batal_aksi dropdown-item"  data-jenis='spt'  data-id='${spt['id_spt']}' ><i class='fa fa-check'></i> Batal Aksi</a>
                    `;
                }
            <?php } else if ($this->session->userdata()['level'] == 2) { ?>
                if (spt['status'] == 11) {
                    var aksiBtn = `
                    <a class="approv dropdown-item"  data-jenis='spt' data-id='${spt['id_spt']}' ><i class='fa fa-check'></i> Approv</a>
                    <a class="deapprov dropdown-item " data-jenis='spt' data-id='${spt['id_spt']}' ><i class='fa fa-times'></i> Tolak Approv</a>
                    `;
                } else if (spt['status'] == 12 || spt['unapprove_oleh'] == '<?= $this->session->userdata()['id'] ?>') {
                    var aksiBtn = `
                        <a class="batal_aksi dropdown-item"  data-jenis='spt'  data-id='${spt['id_spt']}' ><i class='fa fa-check'></i> Batal Aksi</a>
                        `;
                }
            <?php  } else if ($this->session->userdata()['level'] == 1) { ?>
                if (spt['status'] == 12) {
                    var aksiBtn = `
                    <a class="approv dropdown-item"  data-jenis='spt' data-id='${spt['id_spt']}' ><i class='fa fa-check'></i> Approv</a>
                    <a class="deapprov dropdown-item " data-jenis='spt' data-id='${spt['id_spt']}' ><i class='fa fa-times'></i> Tolak Approv</a>
                    `;
                } else if (spt['status'] == 99 || spt['unapprove_oleh'] == '<?= $this->session->userdata()['id'] ?>') {
                    var aksiBtn = `
                        <a class="batal_aksi dropdown-item"  data-jenis='spt'  data-id='${spt['id_spt']}' ><i class='fa fa-check'></i> Batal Aksi</a>
                        `;
                }
            <?php  } else if ($this->session->userdata()['level'] == 5) { ?>
                console.log(spt['status'])
                if (spt['status'] == 1 && spt['id_seksi'] == currentUser['id_seksi']) {
                    var aksiBtn = `
                    <a class="approv dropdown-item"  data-jenis='spt' data-id='${spt['id_spt']}' ><i class='fa fa-check'></i> Approv</a>
                    <a class="deapprov dropdown-item " data-jenis='spt' data-id='${spt['id_spt']}' ><i class='fa fa-times'></i> Tolak Approv</a>
                    `;
                } else if ((spt['status'] == 2 || spt['unapprove_oleh'] == currentUser['id']) && spt['id_seksi'] == currentUser['id_seksi']) {
                    var aksiBtn = `
                        <a class="batal_aksi dropdown-item"  data-jenis='spt'  data-id='${spt['id_spt']}' ><i class='fa fa-check'></i> Batal Aksi</a>
                        `;
                }
            <?php  } else if ($this->session->userdata()['level'] == 8) { ?>
                console.log(spt['id_satuan'])
                if (spt['status'] == 50 && spt['id_satuan'] == currentUser['id_satuan']) {
                    console.log("hereess23")
                    var aksiBtn = `
                    <a class="approv dropdown-item"  data-jenis='spt' data-id='${spt['id_spt']}' ><i class='fa fa-check'></i> Approv</a>
                    <a class="deapprov dropdown-item " data-jenis='spt' data-id='${spt['id_spt']}' ><i class='fa fa-times'></i> Tolak Approv</a>
                    `;
                } else if ((spt['status'] == 51 || spt['unapprove_oleh'] == currentUser['id']) && spt['id_satuan'] == currentUser['id_satuan']) {
                    var aksiBtn = `
                        <a class="batal_aksi dropdown-item"  data-jenis='spt'  data-id='${spt['id_spt']}' ><i class='fa fa-check'></i> Batal Aksi</a>
                        `;
                }
            <?php  } else if ($this->session->userdata()['level'] == 7) { ?>
                console.log(spt['id_satuan'])
                if (spt['status'] == 59 && spt['id_satuan'] == currentUser['id_satuan']) {
                    console.log("hereess23")
                    var aksiBtn = `
                    <a class="approv dropdown-item"  data-jenis='spt' data-id='${spt['id_spt']}' ><i class='fa fa-check'></i> Approv</a>
                    <a class="deapprov dropdown-item " data-jenis='spt' data-id='${spt['id_spt']}' ><i class='fa fa-times'></i> Tolak Approv</a>
                    `;
                } else if ((spt['status'] == 51 || spt['unapprove_oleh'] == currentUser['id']) && spt['id_satuan'] == currentUser['id_satuan']) {
                    var aksiBtn = `
                        <a class="batal_aksi dropdown-item"  data-jenis='spt'  data-id='${spt['id_spt']}' ><i class='fa fa-check'></i> Batal Aksi</a>
                        `;
                }
            <?php  } else if ($this->session->userdata()['penomoran'] == 1) { ?>
                console.log('here')
                if (spt['status'] == 99) {
                    var aksiBtn = `
                    <a class="approv dropdown-item"  data-jenis='spt' data-id='${spt['id_spt']}' ><i class='fa fa-check'></i> Approv</a>
                    <a class="deapprov dropdown-item " data-jenis='spt' data-id='${spt['id_spt']}' ><i class='fa fa-times'></i> Tolak Approv</a>
                    `;
                }
                // } else if (spt['status'] == 99 || spt['unapprove_oleh'] == '<?= $this->session->userdata()['id'] ?>') {
                //     var aksiBtn = `
                //     <a class="batal_aksi dropdown-item"  data-jenis='spt'  data-id='${spt['id_spt']}' ><i class='fa fa-check'></i> Batal Aksi</a>
                //     `;
            <?php  } ?>
            if (spt['status'] == 6 && spt['id_ppk2'] == '<?= $this->session->userdata()['id'] ?>' && spt['id_ppk2'] != '') {
                var aksiBtn = `
                    <a class="approv dropdown-item"  data-jenis='spt' data-id='${spt['id_spt']}' ><i class='fa fa-check'></i> Approv</a>
                    <a class="deapprov dropdown-item " data-jenis='spt' data-id='${spt['id_spt']}' ><i class='fa fa-times'></i> Tolak Approv</a>
                    `;
            } else if ((spt['status'] == 11 || spt['unapprove_oleh'] == '<?= $this->session->userdata()['id'] ?>') && spt['id_ppk'] == '<?= $this->session->userdata()['id'] ?>' && spt['id_ppk'] != '') {
                var aksiBtn = `
                        <a class="batal_aksi dropdown-item"  data-jenis='spt'  data-id='${spt['id_spt']}' ><i class='fa fa-check'></i> Batal Aksi</a>
                        `;
            } else if (
                (spt['status'] == 51 && spt['id_pptk'] == '<?= $this->session->userdata()['id'] ?>' && spt['id_pptk'] != '') ||
                (spt['status'] == 52 && spt['id_ppk2'] == '<?= $this->session->userdata()['id'] ?>' && spt['id_ppk'] != '')
            ) {
                var aksiBtn = `
                    <a class="approv dropdown-item"  data-jenis='spt' data-id='${spt['id_spt']}' ><i class='fa fa-check'></i> Approv</a>
                    <a class="deapprov dropdown-item " data-jenis='spt' data-id='${spt['id_spt']}' ><i class='fa fa-times'></i> Tolak Approv</a>
                    `;
            };
            if ((spt['unapprove_oleh'] == '<?= $this->session->userdata()['id'] ?>')) {
                var aksiBtn = `
                        <a class="batal_aksi dropdown-item"  data-jenis='spt'  data-id='${spt['id_spt']}' ><i class='fa fa-check'></i> Batal Aksi</a>
                        `;
            }
            var lihatButton = `
          
                      <a class="dropdown-item" target="_blank" style="width: 110px" href='<?= base_url() ?>spt/print/${spt['id_spt']}/1/2'><i class='fa fa-eye'></i> PDF SPT  </a>
                     <a class="dropdown-item" target="_blank" style="width: 110px" href='<?= base_url() ?>spt/print/${spt['id_spt']}/1'><i class='fa fa-eye'></i> PDF SPT  </a>
                     <a class="dropdown-item" target="_blank" style="width: 110px" href='<?= base_url() ?>spt/print/${spt['id_spt']}/2'><i class='fa fa-eye'></i> PDF SPPD </a>
                     <a class="dropdown-item" target="_blank" style="width: 110px" href='<?= base_url() ?>spt/print/${spt['id_spt']}/3'><i class='fa fa-eye'></i> PDF SPT Barcode </a>
                     <a class="dropdown-item" target="_blank" style="width: 110px" href='<?= base_url() ?>spt/print/${spt['id_spt']}/barcode'><i class='fa fa-eye'></i> PDF Barcode </a>
                      <a class="dropdown-item" style="width: 110px" href='<?= base_url() ?>spt/detail/${spt['id_spt']}'><i class='fa fa-eye'></i> Lihat </a>
                 `;

            var aprvButton = `
                                `;
            var deaprvButton = `
                                `;
            var button = `
                           <div class="dropdown-basic mb-2">
                            <div class="dropdown">
                                <div class="btn-group mb-1">
                                    <button class="dropbtn btn-square btn-sm btn-primary" style="width : 120px"  type="button">
                                        Aksi
                                        <span><i class="icofont icofont-arrow-down"> </i></span>
                                    </button>
                                    <div class="dropdown-content">
                                        ${aksiBtn}
                                        ${lihatButton}
                                    </div>
                                </div>
                            </div>
                        </div>`;
            // $('#layout_aksi_btn').append(button);
            console.log('sad');
            // console.log(button)
        }


    })
</script>