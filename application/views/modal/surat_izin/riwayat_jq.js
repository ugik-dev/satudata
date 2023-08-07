var TableRiwayat = $("#TableRiwayat").DataTable({
  columnDefs: [],
  responsive: false,
  deferRender: true,
  order: false,
});

var TableRiwayatIzin = $("#TableRiwayatIzin").DataTable({
  columnDefs: [],
  responsive: false,
  deferRender: true,
  order: false,
});

var RiwayatModal = {
  self: $("#riwayat_modal"),
  layer_riwayat: $("#riwayat_modal").find("#layer_riwayat"),
};

var RiwayatIzinModal = {
  self: $("#riwayat_izin_modal"),
  layer_riwayat: $("#riwayat_izin_modal").find("#layer_riwayat"),
};

FDataTable.on("click", ".riwayat_approval", function () {
  var jenis = $(this).data("jenis");
  var link = $(this).data("link");

  Swal.fire({
    title: "Loading!",
    allowOutsideClick: false,
  });
  Swal.showLoading();
  cur_id = $(this).data("id");
  $.ajax({
    url: `<?= base_url() ?>SuratIzin/riwayat_approval/${cur_id}`,
    type: "get",
    data: {
      jenis: jenis,
    },
    success: function (data) {
      Swal.close();
      // buttonIdle(button);
      var json = JSON.parse(data);
      if (json["error"]) {
        Swal.fire("Simpan Gagal", json["message"], "error");
        return;
      }

      var dat = json["data"];
      var dataRiwayat = [];
      RiwayatModal.self.modal("show");
      RiwayatModal.layer_riwayat.html("");
      var htmlRiwayat = "";
      Object.values(dat).forEach((d) => {
        htmlRiwayat += d["nama"] + " " + d["time_logs"] + "<br>";
        dataRiwayat.push([d["time_logs"], d["deskripsi"], d["nama"]]);
      });
      TableRiwayat.clear().rows.add(dataRiwayat).draw("full-hold");
      // console.log(htmlRiwayat)
      // RiwayatModal.layer_riwayat.html(htmlRiwayat)

      // if (jenis == 'spt')
      //     dataSKP[jenis][d['id_spt']] = d;
      // else if (jenis == 'SuratIzin')
      //     dataSKP['surat_izin'][d['id_surat_izin']] = d;
      // Swal.fire("Approv Berhasil", "", "success");
      // renderSKP(dataSKP);
    },
    error: function (e) {},
  });
});

FDataTable.on("click", ".riwayat_izin", function () {
  Swal.fire({
    title: "Loading!",
    allowOutsideClick: false,
  });
  Swal.showLoading();
  cur_id = $(this).data("id");
  $.ajax({
    url: `<?= base_url() ?>SuratIzin/getAll/${cur_id}`,
    type: "get",
    data: { id_pegawai: cur_id },
    success: function (data) {
      Swal.close();
      // buttonIdle(button);
      var json = JSON.parse(data);
      if (json["error"]) {
        Swal.fire("Simpan Gagal", json["message"], "error");
        return;
      }

      var dat = json["data"];
      var dataRiwayat = [];
      RiwayatIzinModal.self.modal("show");
      RiwayatIzinModal.layer_riwayat.html("");
      var htmlRiwayat = "";
      var lama_izin = 0;
      Object.values(dat).forEach((d) => {
        console.log(d);
        if (d["status_izin"] == "99") {
          lama_izin = parseInt(lama_izin) + parseInt(d["lama_izin"]);
        }
        // htmlRiwayat += d["nama"] + " " + d["time_logs"] + "<br>";
        dataRiwayat.push([
          d["periode_start"] +
            (d["periode_start"] == d["periode_end"]
              ? ""
              : " s.d. " + d["periode_end"]),
          d["nama_pengganti"],
          d["nama_izin"],
          statusIzin(d["status_izin"], d["unapprove"]),
          d["lama_izin"],
        ]);
      });

      $("#total_lama_izin").html(lama_izin);
      TableRiwayatIzin.clear().rows.add(dataRiwayat).draw("full-hold");
      // console.log(htmlRiwayat)
      // RiwayatModal.layer_riwayat.html(htmlRiwayat)

      // if (jenis == 'spt')
      //     dataSKP[jenis][d['id_spt']] = d;
      // else if (jenis == 'SuratIzin')
      //     dataSKP['surat_izin'][d['id_surat_izin']] = d;
      // Swal.fire("Approv Berhasil", "", "success");
      // renderSKP(dataSKP);
    },
    error: function (e) {},
  });
});

FDataTable.on("click", ".data_izin", function () {
  var jenis = $(this).data("jenis");

  curData = dataSKP["surat_izin"][$(this).data("id")];
  LihatModal.self.modal("show");
  LihatModal.periode_start.val(curData["periode_start"]);
  LihatModal.periode_end.val(curData["periode_end"]);
  LihatModal.lama_izin.val(curData["lama_izin"]);
  LihatModal.nama_izin.val(curData["nama_izin"]);
  LihatModal.nama_pegawai.val(curData["nama_pegawai"]);
  LihatModal.nama_pengganti.val(curData["nama_pengganti"]);
  LihatModal.alasan.val(curData["alasan"]);
  LihatModal.alamat_izin.val(curData["alamat_izin"]);
  LihatModal.c_n.val(curData["c_n"]);
  LihatModal.c_n1.val(curData["c_n1"]);
  LihatModal.c_n2.val(curData["c_n2"]);
  LihatModal.c_sisa_n.val(curData["c_sisa_n"]);
  LihatModal.c_sisa_n1.val(curData["c_sisa_n1"]);
  LihatModal.c_sisa_n2.val(curData["c_sisa_n2"]);
  cur_tahun = curData["periode_start"].split("-")[0];
  $(".c_label_n").html(cur_tahun);
  $(".c_label_n1").html(cur_tahun - 1);
  $(".c_label_n2").html(cur_tahun - 2);
  LihatModal.status_izin.html(
    statusIzin(curData["status_izin"], curData["unapprove_nama"])
  );
  if (curData["lampiran"] != null && curData["lampiran"] != "") {
    file_lampiran = curData["lampiran"].split(".");
    lampHtml = `<a href='<?= base_url('uploads/lampiran_izin/') ?>${curData["lampiran"]}'> Download </a>
        `;
    lampHtml += `
        <div class="col-lg-12">
        <object width="100%" height="700px"data="<?= base_url('uploads/lampiran_izin/') ?>${curData["lampiran"]}" type="application/pdf">
                        <iframe src="<?= base_url('uploads/lampiran_izin/') ?>${curData["lampiran"]}"></iframe>
                    </object>
                    </div>`;
    LihatModal.layout_lampiran.html(lampHtml);
  } else LihatModal.layout_lampiran.html("<b>tidak ada lampiran</b>");
});
