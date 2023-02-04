<script src="https://cdn.ckeditor.com/ckeditor5/35.3.1/classic/ckeditor.js"></script>
<style>
    .ck-editor__editable[role="textbox"] {
        /* editing area */
        min-height: 500px;
    }
</style>
<div class="container-fluid">
    <div class="card">
        <form id="user_form" onsubmit="return false;" type="multipart" autocomplete="off">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_title">
                    Form Laporan
                </h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">

                    <input type="" name="id_spt" value="<?= !empty($dataContent['return_data']['id_spt']) ? $dataContent['return_data']['id_spt'] : '' ?>">
                    <input type="" name="id_laporan" value="<?= !empty($dataContent['laporan']['id_laporan']) ? $dataContent['laporan']['id_laporan'] : '' ?>">
                    <div class="col-lg-12">
                        <label for="text_laporan">Laporan </label>
                        <textarea id="text_laporan" name="text_laporan"><?= !empty($dataContent['laporan']['text_laporan']) ? $dataContent['laporan']['text_laporan'] : '' ?></textarea>
                        <script>
                            ClassicEditor
                                .create(document.querySelector('#text_laporan'), {

                                    toolbar: [
                                        'undo', 'redo', '|',
                                        'blockQuote', 'indent', 'link', '|', 'bulletedList',
                                    ],
                                })
                                .catch(error => {
                                    console.error(error);
                                });
                        </script>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="col-lg-12">
                        <div class="col-form-label">Bendahara</div>
                        <select class="select2 col-sm-12" id="id_bendahara" name="id_bendahara">
                            <?php
                            if (!empty($dataContent['laporan']['id_bendahara'])) {
                                echo '<option selected value="' . $dataContent['laporan']['id_bendahara'] . '">' . $dataContent['laporan']['nama_bendahara'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-lg-12" id="layout_honorarium">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="" width="10px">No</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Nominal Honorarium</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td><?= $dataContent['return_data']['nama_pegawai'] ?>
                                    </td>
                                    <td>

                                        <input name="honorarium" value="<?= !empty($dataContent['laporan']['honorarium']) ? $dataContent['laporan']['honorarium'] : '' ?>" class="form-control">
                                    </td>
                                </tr>
                                <?php
                                $i = 2;
                                foreach ($dataContent['return_data']['pengikut'] as $p) { ?>
                                    <tr>
                                        <th> <?= $i  ?>
                                        </th>
                                        <td>
                                            <?= $p['nama']  ?>
                                            <input type="hidden" name="id_pengikut[]" value="<?= $p['id_pengikut']  ?>" class="form-control">
                                        </td>
                                        <td>
                                            <input name="nominal[<?= $p['id_pengikut']  ?>]" value="<?= $p['honorarium'] ?>" class="form-control">
                                        </td>
                                    </tr>
                                <?php
                                    $i++;
                                } ?>
                            <tbody>
                        </table>
                    </div>
                    <div class="hr-line-dashed"></div>



                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit" id="save_edit_btn" data-loading-text="Loading..."><strong>Simpan Perubahan</strong></button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#menu_2').addClass('active');
        $('#opmenu_2').show();
        $('#submenu_6').addClass('active');

        var UserModal = {
            'form': $('#user_form'),
        }
        var swalSaveConfigure = {
            title: "Konfirmasi simpan",
            text: "Yakin akan menyimpan data ini?",
            type: "info",
            showCancelButton: true,
            confirmButtonColor: "#18a689",
            confirmButtonText: "Ya, Simpan!",
        };


        $("#id_bendahara").select2({
            ajax: {
                url: '<?= base_url() ?>Search/ppk',
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


        UserModal.form.submit(function(event) {
            event.preventDefault();
            var url = "<?= base_url() . $dataContent['form_url'] ?>";

            Swal.fire({
                title: "Apakah anda Yakin?",
                text: "Data akan disimpan !",
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
                        Swal.close();
                        Swal.fire({
                            title: "Berhasil !!",
                            text: "",
                            icon: "success",
                            allowOutsideClick: true,
                            buttons: {
                                catch: {
                                    text: "OK",
                                    value: true,
                                },
                            },
                        }).then((result) => {

                            location.href = "<?= base_url('spt/detail/' . $dataContent['return_data']['id_spt']) ?>";
                        });
                    }
                });
            });
        });




    });
</script>