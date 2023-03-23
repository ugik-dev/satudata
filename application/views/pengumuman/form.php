<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/vendors/dropzone.css" />

<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <h5>Form Pengumuman</h5>
        </div>


        <div class="card-body">
            <form id="pengumuman_form" onsubmit="return false;" type="multipart" autocomplete="off">
                <div class="row mb-3">
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <button class="btn btn-primary" type="submit" data-bs-original-title="" title="">Submit</button>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="judul">Judul</label>
                            <input class="form-control input-air-primary" id="judul" name="judul" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="satuan">Untuk</label>
                            <select class="form-control input-air-primary" id="satuan" name="satuan">
                                <option value="all">-- Semua --</option>
                                <option value="satuan_kerja"> Satuan Kerja Saya</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="file_pdf">Lampiran Pdf</label>
                            <input class="form-control input-air-primary" id="file_pdf" name="file_pdf" type="file" accept="application/pdf" placeholder="" data-bs-original-title="" title="">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="file_sampul">Foto Sampul</label>
                            <input class="form-control input-air-primary" id="file_sampul" name="file_sampul" type="file" placeholder="" data-bs-original-title="" title="">
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <textarea id="ckeditor" name="pengumuman_isi" rows="7"><?= !empty($return_data) ? $return_data['pengumuman_isi'] : ''; ?></textarea>
                    </div>
                </div>
            </form>

            <!-- <form class="dropzone dropzone-info" id="fileTypeValidation" action="<?= base_url() ?>informasi/attachment">
                <div class="dz-message needsclick">
                    <i class="icon-cloud-up"></i>
                    <h6>Letakkan file lampiran pdf disini <small>*jika ada.<small></h6>
                    <span class="note needsclick">(This is just a demo dropzone. Selected files are
                        <strong>not</strong> actually uploaded.)</span>
                </div>
            </form> -->
        </div>


    </div>
</div>

<script src="<?= base_url() ?>assets/js/dropzone/dropzone.js"></script>
<script src="//cdn.ckeditor.com/4.19.1/full/ckeditor.js"></script>

<script src="<?php echo base_url() . 'assets/ckfinder/ckfinder.js' ?>"></script>
<script>
    $(document).ready(function() {
        var PengumumanModal = {
            'form': $('#pengumuman_form'),
            'saveBtn': $('#save_btn'),
            // 'idUser': $('#id_user'),
            // 'username': $('#username'),
            // 'nama': $('#nama'),
            // 'nip': $('#nip'),
            // 'email': $('#email'),
            // 'no_hp': $('#no_hp'),
            // 'status': $('#status'),
            // 'password': $('#password'),
            // 'id_role': $('#id_role'),
            // 'file_pdf': new FileUploader($('#file_pdf'), "", "file_pdf", "image/*", false, false),

        }

        var swalSaveConfigure = {
            title: "Konfirmasi simpan",
            text: "Yakin akan menyimpan data ini?",
            type: "info",
            showCancelButton: true,
            confirmButtonColor: "#18a689",
            confirmButtonText: "Ya, Simpan!",
        };

        PengumumanModal.form.submit(function(event) {
            event.preventDefault();
            var url = "<?= base_url() ?>informasi/action_pengumuman";

            Swal.fire({
                title: "Konfirmasi?",
                text: "Yakin akan posting pengumuman ini!",
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
                    data: new FormData(PengumumanModal.form[0]),
                    contentType: false,
                    processData: false,
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
                            // location.href = "<?= base_url('master/roles') ?>";
                        });
                    }
                });
            });
        });
        // var DropzoneExample = (function() {
        //     var DropzoneDemos = function() {
        //         Dropzone.options.fileTypeValidation = {
        //             paramName: "file",
        //             maxFiles: 10,
        //             maxFilesize: 10,
        //             acceptedFiles: "image/*,application/pdf,.psd",
        //             accept: function(file, res) {
        //                 console.log('selsai')
        //                 console.log(res)
        //                 // console.log(done)
        //                 // if (file.name == "justinbieber.jpg") {
        //                 //     done("Naha, you don't.");
        //                 // } else {
        //                 //     done();
        //                 // }
        //             },
        //         };
        //     };
        //     return {
        //         init: function() {
        //             DropzoneDemos();
        //         },
        //     };
        // })();
        // DropzoneExample.init();

        // Dropzone.options.fileTypeValidation = {
        //     maxFilesize: 2,
        //     addRemoveLinks: true,
        //     uploadMultiple: true,
        //     init: function() {
        //         this.on("addedfile", function(file) {
        //             $.ajax({
        //                 method: 'get'
        //             }).done(function(data, textStatus, xhr) {
        //                 // alert(data);
        //                 console.log('as')
        //                 //Expecting the json objec here

        //             });
        //         });
        //     }
        // };

    });
    $(function() {
        <?php if (!empty($return_data)) { ?>
            $('#kategori').val('<?= $return_data['kategori'] ?>').change()
            $('#status').val('<?= $return_data['status'] ?>').change()
        <?php } ?>
        var editor = CKEDITOR.replace('ckeditor');
        CKFinder.setupCKEditor(editor);

    });
</script>