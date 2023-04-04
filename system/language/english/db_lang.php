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

$lang['db_invalid_connection_str'] = 'Tidak dapat menentukan pengaturan basis data berdasarkan string koneksi yang Anda kirimkan.';
$lang['db_unable_to_connect'] = 'Tidak dapat terhubung ke server basis data Anda menggunakan pengaturan yang disediakan.';
$lang['db_unable_to_select'] = 'Tidak dapat memilih database yang ditentukan: %s';
$lang['db_unable_to_create'] = 'Tidak dapat membuat database yang ditentukan: %s';
$lang['db_invalid_query'] = 'Kueri yang Anda kirimkan tidak valid.';
$lang['db_must_set_table'] = 'Anda harus menyetel tabel database untuk digunakan dengan kueri Anda.';
$lang['db_must_use_set'] = 'Anda harus menggunakan metode "set" untuk memperbarui entri.';
$lang['db_must_use_index'] = 'Anda harus menentukan indeks yang cocok untuk pembaruan batch.';
$lang['db_batch_missing_index'] = 'Satu atau lebih baris yang dikirimkan untuk pemutakhiran batch tidak memiliki indeks yang ditentukan.';
$lang['db_must_use_where'] = 'Pembaruan tidak diperbolehkan kecuali mengandung klausa "di mana".';
$lang['db_del_must_use_where'] = 'Penghapusan tidak diperbolehkan kecuali mengandung klausa "di mana" atau "suka".';
$lang['db_field_param_missing'] = 'Untuk mengambil bidang memerlukan nama tabel sebagai parameter.';
$lang['db_unsupported_function'] = 'Fitur ini tidak tersedia untuk database yang Anda gunakan.';
$lang['db_transaction_failure'] = 'Transaksi gagal: Pembalikan dilakukan.';
$lang['db_unable_to_drop'] = 'Tidak dapat membuang database yang ditentukan.';
$lang['db_unsupported_feature'] = 'Fitur platform database yang Anda gunakan tidak didukung.';
$lang['db_unsupported_compression'] = 'Format kompresi berkas yang Anda pilih tidak didukung oleh server Anda.';
$lang['db_filepath_error'] = 'Tidak dapat menulis data ke path file yang telah Anda kirimkan.';
$lang['db_invalid_cache_path'] = 'Jalur cache yang Anda kirim tidak valid atau tidak dapat ditulis.';
$lang['db_table_name_required'] = 'Nama tabel diperlukan untuk operasi tersebut.';
$lang['db_column_name_required'] = 'Nama kolom diperlukan untuk operasi tersebut.';
$lang['db_column_definition_required'] = 'Definisi kolom diperlukan untuk operasi tersebut.';
$lang['db_unable_to_set_charset'] = 'Tidak dapat menyetel rangkaian karakter koneksi klien: %s';
$lang['db_error_heading'] = 'Terjadi kesalahan database';
