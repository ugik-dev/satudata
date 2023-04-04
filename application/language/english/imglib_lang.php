<?php

/**
 * CodeIgniter
 *
 * Kerangka pengembangan aplikasi open source untuk PHP
 *
 * Konten ini dirilis di bawah Lisensi MIT (MIT)
 *
 * Hak Cipta (c) 2014 - 2017, Institut Teknologi British Columbia
 *
 * Izin dengan ini diberikan, gratis, kepada siapa pun yang mendapatkan salinannya
 * perangkat lunak ini dan file dokumentasi terkait ("Perangkat Lunak"), untuk menangani
 * dalam Perangkat Lunak tanpa batasan, termasuk tanpa batasan hak
 * untuk menggunakan, menyalin, memodifikasi, menggabungkan, menerbitkan, mendistribusikan, mensublisensikan, dan/atau menjual
 * salinan Perangkat Lunak, dan untuk mengizinkan orang yang menerima Perangkat Lunak tersebut
 * diperlengkapi untuk itu, tunduk pada ketentuan-ketentuan berikut:
 *
 * Pemberitahuan hak cipta di atas dan pemberitahuan izin ini harus disertakan
 * semua salinan atau sebagian besar dari Perangkat Lunak.
 *
 * PERANGKAT LUNAK INI DISEDIAKAN "SEBAGAIMANA ADANYA", TANPA JAMINAN APAPUN, TERSURAT ATAU
 * TERSIRAT, TERMASUK NAMUN TIDAK TERBATAS PADA GARANSI DAGANG,
 * KESESUAIAN UNTUK TUJUAN TERTENTU DAN TANPA PELANGGARAN. DALAM HAL APAPUN AKAN
 * PENULIS ATAU PEMEGANG HAK CIPTA BERTANGGUNG JAWAB ATAS KLAIM, KERUSAKAN ATAU LAINNYA
 * TANGGUNG JAWAB, BAIK DALAM PERBUATAN KONTRAK, KERUGIAN ATAU LAINNYA, YANG TIMBUL DARI,
 * KELUAR DARI ATAU SEHUBUNGAN DENGAN PERANGKAT LUNAK ATAU PENGGUNAAN ATAU HUBUNGAN LAIN DALAM
 * PERANGKAT LUNAK.
 *
 * @paket CodeIgniter
 * @penulis EllisLab Dev Team
 * @copyright Hak Cipta (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright Hak Cipta (c) 2014 - 2017, British Columbia Institute of Technology (http://bcit.ca/)
 * @lisensi http://opensource.org/licenses/Lisensi MIT MIT
 * @tautan https://codeigniter.com
 * @sejak Versi 1.0.0
 * @sumber file
 */
defined('BASEPATH') or exit('Tidak ada akses skrip langsung yang diizinkan');

$lang['imglib_source_image_required'] = 'Anda harus menentukan sumber gambar dalam preferensi Anda.';
$lang['imglib_gd_required'] = 'Perpustakaan gambar GD diperlukan untuk fitur ini.';
$lang['imglib_gd_required_for_props'] = 'Server Anda harus mendukung perpustakaan gambar GD untuk menentukan properti gambar.';
$lang['imglib_unsupported_imagecreate'] = 'Server Anda tidak mendukung fungsi GD yang diperlukan untuk memproses jenis gambar ini.';
$lang['imglib_gif_not_supported'] = 'Gambar GIF seringkali tidak didukung karena pembatasan lisensi. Anda mungkin harus menggunakan gambar JPG atau PNG.';
$lang['imglib_jpg_not_supported'] = 'Gambar JPG tidak didukung.';
$lang['imglib_png_not_supported'] = 'Gambar PNG tidak didukung.';
$lang['imglib_jpg_or_png_required'] = 'Protokol pengubahan ukuran gambar yang ditentukan dalam preferensi Anda hanya bekerja dengan jenis gambar JPEG atau PNG.';
$lang['imglib_copy_error'] = 'Terdapat kesalahan saat mencoba mengganti berkas. Pastikan direktori file Anda dapat ditulisi.';
$lang['imglib_rotate_unsupported'] = 'Rotasi gambar tampaknya tidak didukung oleh server Anda.';
$lang['imglib_libpath_invalid'] = 'Jalur ke perpustakaan gambar Anda salah. Harap atur jalur yang benar di preferensi gambar Anda.';
$lang['imglib_image_process_failed'] = 'Pemrosesan gambar gagal. Silakan verifikasi bahwa server Anda mendukung protokol yang dipilih dan jalur ke perpustakaan gambar Anda sudah benar.';
$lang['imglib_rotation_angle_required'] = 'Sudut rotasi diperlukan untuk memutar gambar.';
$lang['imglib_invalid_path'] = 'Jalur ke gambar tidak benar.';
$lang['imglib_invalid_image'] = 'Gambar yang diberikan tidak valid.';
$lang['imglib_copy_failed'] = 'Rutinitas penyalinan gambar gagal.';
$lang['imglib_missing_font'] = 'Tidak dapat menemukan font untuk digunakan.';
$lang['imglib_save_failed'] = 'Tidak dapat menyimpan gambar. Pastikan gambar dan direktori file dapat ditulisi.';
