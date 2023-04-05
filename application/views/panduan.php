<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h3>Panduan</h3>
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html" data-bs-original-title="" title=""> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg></a></li>
                    <li class="breadcrumb-item">Sistem Informasi Administrasi dan Umum</li>
                    <!-- <li class="breadcrumb-item active">Calender Basic</li> -->
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="col-lg-12">
        <div class="row default-according style-1 faq-accordion" id="accordionoc">
            <div class="col-lg-12">
                <div class="faq-title">
                    <h6>Panduan Data Diri</h6>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed ps-0" data-bs-toggle="collapse" data-bs-target="#collapseicon" aria-expanded="false" aria-controls="collapseicon">
                                <i data-feather="help-circle"></i> Pengaturan Data Diri / Update Data Diri
                            </button>
                        </h5>
                    </div>
                    <div class="collapse" id="collapseicon" aria-labelledby="collapseicon" data-bs-parent="#accordionoc">
                        <div class="card-body">
                            Untuk melakukan update data diri sangat dianjurkan, terutama pada saat pertama kali login yang bertujuan untuk pengkinian data yang uptodate,
                            Untuk melakukan hal tersebut user data mengklik icon foto diri pada pojok kanan atas, lalu klik pada menu "Profile"
                            <img width=100% src="<?= base_url() ?>assets/img/panduan/1.png" />
                            <br>
                            <ol>
                                <li>
                                    Selanjutnya untuk melalukakan perubahan username, user dapat mengisi field username sesuai keinginan user agar memudahkan user untuk login,
                                </li>
                                <li>
                                    Email dan No HP diinput agar jika sewaktu-waktu user lupa password / username maka sistem akan melalukan reset password melalui email / no hp,
                                </li>
                                <li>
                                    Untuk melakukan perubahan pada password silahkan mengisi pada field Password dan Re-Password, jika tidak diganti maka kosongkan saja.
                                </li>
                                <li>
                                    Selanjutnya dilanjutkan dengan menginput data profile untuk kepentian penggunaan aplikasi dengan data yang benar.
                                </li>
                                <li>Setelah yakin semua sudah benar maka user dapat menekan tombol "Simpan" dan data akan terupdate.</li>
                            </ol>
                            <img width=100% src="<?= base_url() ?>assets/img/panduan/2.png" />
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed ps-0" data-bs-toggle="collapse" data-bs-target="#collapseicon3" aria-expanded="false" aria-controls="collapseicon2">
                                <i data-feather="help-circle"></i>Bagaimana tanda tangan yang baik dan benar untuk diupload ?
                            </button>
                        </h5>
                    </div>
                    <div class="collapse" id="collapseicon3" data-bs-parent="#accordionoc">
                        <div class="card-body">
                            Tanda tangan yang baik dan benar untuk diupload yaitu dengan :
                            <ol>
                                <li>Berformat / extensi PNG (.png)</li>
                                <li>Gambar dengan ukuran lebar 600px dan tinggi 300px atau dengan perbandingan lebar x tinggi : 6x3</li>
                                <li>Tanda tangan discan menggunakan alat scan</li>
                                <li>Tanda tangan ditulis dengan bolpoin berwarna biru</li>
                                <li>Tanda tangan tidak menggunakan latar belakar / transparan, atau dapat menggunakan fitur pada website <a href="https://www.remove.bg/upload">https://www.remove.bg/upload</a> untuk membantu user agar lebih mudah menghapus background agar transparan</li>
                            </ol>
                            Berikut Video Tutorialnya
                            <br>
                            <video width="100%" height="auto" controls>
                                <source src="<?= base_url() ?>assets/video/remove_bg.mp4" type="video/mp4">
                                <!-- <source src="movie.ogg" type="video/ogg"> -->
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    </div>
                </div>


                <div class="faq-title">
                    <h6>Panduan Surat Tugas / SPPD / Lembur</h6>
                </div>
                <!-- Master Dasar SPPD -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed ps-0" data-bs-toggle="collapse" data-bs-target="#collapseicon2" aria-expanded="false" aria-controls="collapseicon2">
                                <i data-feather="help-circle"></i> Input Dasar SPPD / Lembur
                            </button>
                        </h5>
                    </div>
                    <div class="collapse" id="collapseicon2" data-bs-parent="#accordionoc">
                        <div class="card-body">
                            <ol>
                                <li>
                                    Untuk input data dasar surat SPPD terdapat pada menu "Master" - "Dasar Surat"
                                </li>
                                <li>
                                    Klik Tombol "+ Tambah Dasar Baru"
                                </li>
                                <li>
                                    Untuk melakukan perubahan atau menghapus dasar dapat mengklik tombol pada kolom "Action"
                                </li>
                            </ol>
                            <img width="100%" src="<?= base_url() ?>assets/img/panduan/5.png" />
                            Saat user menekan tombol "+ Tambah Dasar Baru" atau edit, maka akan muncul form dasar seperti pada gambar dibawah, jika data sudah benar maka user dapat menekan tombol "Simpan" untuk menyimpan dasar.
                            <img width="100%" src="<?= base_url() ?>assets/img/panduan/6.png" />
                        </div>
                    </div>
                </div>
                <!-- SPT -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed ps-0" data-bs-toggle="collapse" data-bs-target="#collapseicon5" aria-expanded="false" aria-controls="collapseicon2">
                                <i data-feather="help-circle"></i> Input SPT tanpa SPPD
                            </button>
                        </h5>
                    </div>
                    <div class="collapse" id="collapseicon5" data-bs-parent="#accordionoc">
                        <div class="card-body">
                            <ol>
                                <li>
                                    Untuk input data dasar Surat Perintah Tugas tanpa SPPD terdapat pada menu "SPT / SPPD" - "Entri SPT"
                                </li>
                                <li>
                                    Maka akan muncul form SPT
                                </li>
                                <li>Setelah yakin data yang diisi benar maka user dapat menekan tombol "Simpan" dan menungu approval sesuai dengan ketentuan yang berlaku.</li>
                            </ol>
                            <img width="100%" src="<?= base_url() ?>assets/img/panduan/8.png" />

                        </div>
                    </div>
                </div>
                <!-- SPT SPPD -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed ps-0" data-bs-toggle="collapse" data-bs-target="#collapseicon4" aria-expanded="false" aria-controls="collapseicon2">
                                <i data-feather="help-circle"></i> Input SPT beserta SPPD
                            </button>
                        </h5>
                    </div>
                    <div class="collapse" id="collapseicon4" data-bs-parent="#accordionoc">
                        <div class="card-body">
                            <ol>
                                <li>
                                    Untuk input data dasar Surat Perintah Tugas beserta SPPD terdapat pada menu "SPT / SPPD" - "Entri SPPD"
                                </li>
                                <li>
                                    Maka akan muncul form SPT & SPPD
                                </li>
                                <li>
                                    User dapat memilih dasar sesuai dasar yang telah diinput pada menu "Master" - "Dasar Surat"
                                </li>
                                <li>
                                    Sistem akan memblokir jika terjadi bentrokan jadwal perjalanan dinas.
                                </li>
                                <li>Setelah yakin data yang diisi benar maka user dapat menekan tombol "Simpan" dan menungu approval sesuai dengan ketentuan yang berlaku.</li>
                            </ol>
                            <img width="100%" src="<?= base_url() ?>assets/img/panduan/7.png" />

                        </div>
                    </div>
                </div>

                <!-- Lembur -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed ps-0" data-bs-toggle="collapse" data-bs-target="#collapseicon6" aria-expanded="false" aria-controls="collapseicon2">
                                <i data-feather="help-circle"></i> Input SPT Lembur
                            </button>
                        </h5>
                    </div>
                    <div class="collapse" id="collapseicon6" data-bs-parent="#accordionoc">
                        <div class="card-body">
                            <ol>
                                <li>
                                    Untuk input data Lembur terdapat pada menu "SPT / SPPD" - "Entri Lembur"
                                </li>
                                <li>
                                    Maka akan muncul form Lembur
                                </li>
                                <li>
                                    User dapat memilih dasar sesuai dasar yang telah diinput pada menu "Master" - "Dasar Surat"
                                </li>

                                <li>Setelah yakin data yang diisi benar maka user dapat menekan tombol "Simpan" dan menungu approval sesuai dengan ketentuan yang berlaku.</li>
                            </ol>
                            <img width="100%" src="<?= base_url() ?>assets/img/panduan/9.png" />

                        </div>
                    </div>
                </div>
                <!-- Daftar Pengajuan -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed ps-0" data-bs-toggle="collapse" data-bs-target="#collapseicon7" aria-expanded="false" aria-controls="collapseicon2">
                                <i data-feather="help-circle"></i> Daftar Pengajuan
                            </button>
                        </h5>
                    </div>
                    <div class="collapse" id="collapseicon7" data-bs-parent="#accordionoc">
                        <div class="card-body">
                            <ol>
                                <li>
                                    Untuk input data Lembur terdapat pada menu "SPT / SPPD" - "Daftar Pengajuan"
                                </li>
                                <li>
                                    Maka akan muncuncul data SPT / SPPD / Lembur yang di entri oleh user, beserta status
                                </li>
                            </ol>
                            <img width="100%" src="<?= base_url() ?>assets/img/panduan/10.png" />

                        </div>
                    </div>
                </div>
                <!-- Detail SPT -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed ps-0" data-bs-toggle="collapse" data-bs-target="#collapseicon8" aria-expanded="false" aria-controls="collapseicon2">
                                <i data-feather="help-circle"></i> Halaman Detail SPT / SPPD / Lembur
                            </button>
                        </h5>
                    </div>
                    <div class="collapse" id="collapseicon8" data-bs-parent="#accordionoc">
                        <div class="card-body">
                            <ol>
                                <li>
                                    Saat Menekan Tombol Aksi -> Lihat Detail pada halaman Daftar Pengajuan / Halaman Permohonan Approval, user akan diarahkan ke halaman detail </li>
                                <li>
                                    Maka akan muncuncul lengkap mengenai Surat Tugas Tersebut, termasuk Riwayat Approval, Dokumen (SPT, SPPD, Cetak Kwitansi, Draft Absensi Lembur dan Laporan)
                                </li>
                            </ol>
                            <img width="100%" src="<?= base_url() ?>assets/img/panduan/11.png" />

                        </div>
                    </div>
                </div>

                <div class="faq-title">
                    <h6>Panduan Surat Izin / Surat Cuti</h6>
                </div>
                <!-- Surat Izin -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed ps-0" data-bs-toggle="collapse" data-bs-target="#collapseicon_surat_izin" aria-expanded="false" aria-controls="collapseicon2">
                                <i data-feather="help-circle"></i> Entri Surat Izin
                            </button>
                        </h5>
                    </div>
                    <div class="collapse" id="collapseicon_surat_izin" data-bs-parent="#accordionoc">
                        <div class="card-body">
                            <ol>
                                <li>
                                    Untuk melihat daftar Surat Izin terdapat pada menu "Surat Izin"
                                </li>
                                <li>
                                    Untuk menambahkan surat izin baru user dapat menekan tombol "+ Tambah"
                                    <img width="100%" src="<?= base_url() ?>assets/img/panduan/12.png" />
                                </li>
                                <li>
                                    Lalu akan muncul form Surat Izin, jika sudah yakin benar tekan "Simpan".
                                    <img width="100%" src="<?= base_url() ?>assets/img/panduan/13.png" />
                                </li>
                            </ol>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>