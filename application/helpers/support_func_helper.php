<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


if (!function_exists('tanggal_indonesia')) {
	function tanggal_indonesia($tanggal)
	{
		if (empty($tanggal)) return '';
		$BULAN = [
			0, 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
		];
		$t = explode('-', $tanggal);
		$tg = intval($t[2]);
		return "{$tg} {$BULAN[intval($t[1])]} {$t[0]}";
	}
}

if (!function_exists('format_nip')) {
	function format_nip($nip)
	{
		if (empty($nip)) return '-';
		return substr($nip, 0, 8) . ' ' . substr($nip, 8, 6) . ' ' . substr($nip, 14, 1) . ' ' . substr($nip, 15, 3);
		// return $res;
	}
}

if (!function_exists('to_romawi')) {
	function to_romawi($integer)
	{
		// Convert the integer into an integer (just to make sure)
		$integer = intval($integer);
		$result = '';

		// Create a lookup array that contains all of the Roman numerals.
		$lookup = array(
			'M' => 1000,
			'CM' => 900,
			'D' => 500,
			'CD' => 400,
			'C' => 100,
			'XC' => 90,
			'L' => 50,
			'XL' => 40,
			'X' => 10,
			'IX' => 9,
			'V' => 5,
			'IV' => 4,
			'I' => 1
		);

		foreach ($lookup as $roman => $value) {
			// Determine the number of matches
			$matches = intval($integer / $value);

			// Add the same number of characters to the string
			$result .= str_repeat($roman, $matches);

			// Set the integer to be the remainder of the integer and the value
			$integer = $integer % $value;
		}

		// The Roman numeral should be built, return it
		return $result;
	}
}
if (!function_exists('terbilang')) {
	function terbilang($nilai)
	{
		$nilai = abs($nilai);
		$huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " " . $huruf[$nilai];
		} else if ($nilai < 20) {
			$temp = terbilang($nilai - 10) . " Belas";
		} else if ($nilai < 100) {
			$temp = terbilang($nilai / 10) . " Puluh" . terbilang($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " Seratus" . terbilang($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = terbilang($nilai / 100) . " Ratus" . terbilang($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " seribu" . terbilang($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = terbilang($nilai / 1000) . " Ribu" . terbilang($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = terbilang($nilai / 1000000) . " Juta" . terbilang($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = terbilang($nilai / 1000000000) . " Milyar" . terbilang(fmod($nilai, 1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = terbilang($nilai / 1000000000000) . " Trilyun" . terbilang(fmod($nilai, 1000000000000));
		}
		return $temp;
	}
}


if (!function_exists('romawi_bulan')) {
	function romawi_bulan($bln)
	{
		// echo $bln;
		switch ($bln) {
			case 1:
				return "I";
				break;
			case 2:
				return "II";
				break;
			case 3:
				return "III";
				break;
			case 4:
				return "IV";
				break;
			case 5:
				return "V";
				break;
			case 6:
				return "VI";
				break;
			case 7:
				return "VII";
				break;
			case 8:
				return "VIII";
				break;
			case 9:
				return "IX";
				break;
			case 10:
				return "X";
				break;
			case 11:
				return "XI";
				break;
			case 12:
				return "XII";
				break;
		}
	}
}





// ------------------------------------------------------------------------
/* End of file helper.php */
/* Location: ./system/helpers/Side_Menu_helper.php */