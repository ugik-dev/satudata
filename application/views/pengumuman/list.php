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
                            <select class="form-control mr-sm-2" name="id_pengumuman" id="id_pengumuman"></select>
                        </div>
                        <a href="<?= base_url() ?>informasi/tambah_pengumuman" class="btn btn-success my-1 mr-sm-2" id="new_btn" disabled="disabled"><i class="fa fa-plus"></i> Tambah Pengumuman Baru</a>
                    </form>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="FDataTable" class="table table-bordered table-hover" style="padding-bottom: 100px">
                            <thead>
                                <tr>
                                    <th style="width: 2%; text-align:center!important">ID</th>
                                    <th style="width: 5%; text-align:center!important">Tanggal</th>
                                    <th style="width: 24%; text-align:center!important">Judul</th>
                                    <th style="width: 24%; text-align:center!important">Satuan</th>
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
            'id_pengumuman': $('#toolbar_form').find('#id_pengumuman'),
            'newBtn': $('#new_btn'),
        }

        var FDataTable = $('#FDataTable').DataTable({
            'columnDefs': [],
            deferRender: true,
            "order": [
                [0, "desc"]
            ]
        });


        var dataRole = {}
        var dataUser = {}
        var swalDeleteConfigure = {
            title: "Konfirmasi hapus",
            text: "Yakin akan menghapus data ini?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, Hapus!",
        };

        $.when(getAllUser()).then((e) => {
            toolbar.newBtn.prop('disabled', false);
        }).fail((e) => {
            console.log(e)
        });


        function getAllUser() {
            Swal.fire({
                title: 'Loading Pengumuman!',
                allowOutsideClick: false,
            });
            Swal.showLoading()
            return $.ajax({
                url: `<?php echo site_url('informasi/getAllPengumuman/') ?>`,
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
        <a class="edit dropdown-item" href='<?= base_url() ?>infomrasi/edit_pengumuman/${user['id_pengumuman']}'><i class='fa fa-pencil'></i> Edit Pengumuman</a>
      `;
                var lihatButton = `
        <a class="dropdown-item" href='<?= base_url() ?>pengumuman/${user['id_pengumuman']}'><i class='fa fa-eye'></i> </a>
      `;
                var deleteButton = `
        <a class="delete dropdown-item" data-id='${user['id_pengumuman']}'><i class='fa fa-trash'></i> Hapus Pengumuman</a>
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

                renderData.push([user['id_pengumuman'], user['tanggal'], user['judul'], user['nama_satuan'], button]);
            });
            FDataTable.clear().rows.add(renderData).draw('full-hold');
        }





        FDataTable.on('click', '.delete', function() {
            event.preventDefault();
            var id = $(this).data('id');
            Swal.fire(swalDeleteConfigure).then((result) => {
                if (!result.value) {
                    return;
                }
                $.ajax({
                    url: "<?= site_url('informasi/delete_pengumuman') ?>",
                    'type': 'POST',
                    data: {
                        'id_pengumuman': id
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