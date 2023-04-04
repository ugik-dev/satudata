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

$lang['form_validation_required'] = 'Bidang {field} harus diisi.';
$lang['form_validation_isset'] = 'Bidang {field} harus memiliki nilai.';
$lang['form_validation_valid_email'] = 'Bidang {field} harus berisi alamat email yang valid.';
$lang['form_validation_valid_emails'] = 'Bidang {field} harus berisi semua alamat email yang valid.';
$lang['form_validation_valid_url'] = 'Bidang {field} harus berisi URL yang valid.';
$lang['form_validation_valid_ip'] = 'Bidang {field} harus berisi IP yang valid.';
$lang['form_validation_min_length'] = 'Panjang kolom {field} harus minimal {param} karakter.';
$lang['form_validation_max_length'] = 'Panjang kolom {field} tidak boleh melebihi {param} karakter.';
$lang['form_validation_exact_length'] = 'Panjang kolom {field} harus persis {param} karakter.';
$lang['form_validation_alpha'] = 'Bidang {field} hanya boleh berisi karakter abjad.';
$lang['form_validation_alpha_numeric'] = 'Bidang {field} hanya boleh berisi karakter alfa-numerik.';
$lang['form_validation_alpha_numeric_spaces'] = 'Bidang {field} hanya boleh berisi karakter alfanumerik dan spasi.';
$lang['form_validation_alpha_dash'] = 'Bidang {field} hanya boleh berisi karakter alfanumerik, garis bawah, dan tanda hubung.';
$lang['form_validation_numeric'] = 'Bidang {field} hanya boleh berisi angka.';
$lang['form_validation_is_numeric'] = 'Bidang {field} hanya boleh berisi karakter angka.';
$lang['form_validation_integer'] = 'Bidang {field} harus berisi bilangan bulat.';
$lang['form_validation_regex_match'] = 'Bidang {field} tidak dalam format yang benar.';
$lang['form_validation_matches'] = 'Bidang {field} tidak cocok dengan bidang {param}.';
$lang['form_validation_differs'] = 'Bidang {field} harus berbeda dari bidang {param}.';
$lang['form_validation_is_unique'] = 'Bidang {field} harus berisi nilai yang unik.';
$lang['form_validation_is_natural'] = 'Bidang {field} hanya boleh berisi angka.';
$lang['form_validation_is_natural_no_zero'] = 'Bidang {field} hanya boleh berisi angka dan harus lebih besar dari nol.';
$lang['form_validation_decimal'] = 'Bidang {field} harus berisi angka desimal.';
$lang['form_validation_less_than'] = 'Bidang {field} harus berisi angka kurang dari {param}.';
$lang['form_validation_less_than_equal_to'] = 'Bidang {field} harus berisi angka kurang dari atau sama dengan {param}.';
$lang['form_validation_greater_than'] = 'Bidang {field} harus berisi angka lebih besar dari {param}.';
$lang['form_validation_greater_than_equal_to'] = 'Bidang {field} harus berisi angka lebih besar dari atau sama dengan {param}.';
$lang['form_validation_error_message_not_set'] = 'Tidak dapat mengakses pesan kesalahan yang sesuai dengan nama field Anda {field}.';
$lang['form_validation_in_list'] = 'Bidang {field} harus salah satu dari: {param}.';
