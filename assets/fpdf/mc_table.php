<?php
require('fpdf.php');

class PDF_MC_Table extends FPDF
{
	var $widths;
	var $aligns;

	function SetWidths($w)
	{
		//Set the array of column widths
		$this->widths = $w;
	}

	function SetAligns($a)
	{
		//Set the array of column alignments
		$this->aligns = $a;
	}

	function RowAktifitasHarian($no, $data)
	{
		// $this->cell(30, 4, '23', 1, 1);

		$x_origin = $this->GetX();
		$y_origin = $this->GetY();
		// echo json_encode($data);
		// die();
		//Calculate the height of the row
		// $nb = 0;
		// for ($i = 0; $i < count($dt_width); $i++)
		$i = 0;
		$total_hight = 0;
		foreach ($data['child'] as $child) {
			$nb[$i] = 0;
			$nb[$i] = max($nb[$i], $this->NbLines(40, $child['kegiatan_skp']));
			$nb[$i] = max($nb[$i], $this->NbLines(40, $child['kegiatan_aktifitas']));
			$nb[$i] = max($nb[$i], $this->NbLines(40, $child['satuan']));
			$nb[$i] = max($nb[$i], $this->NbLines(40, $child['vol']));
			$h[$i] = 4 * $nb[$i];
			// echo $h[$i];
			$total_hight = $total_hight + $nb[$i];
			$i++;
			// $nb_iki = $this->NbLines(35, $data['iki_kuantitas']);
			// echo json_encode($child);
			// die();
		}
		$this->CheckPageBreak($total_hight * 4);
		$this->Cell(7, $total_hight * 4, $no, 1, 'C');
		$this->Cell(30, $total_hight * 4, $this->tgl_indo($data['date']), 1, 'C');
		$this->SetX($this->getX() - 37);
		// $nb = max($nb, $this->NbLines(30, $data['kegiatan']));
		// $nb = max($nb, $this->NbLines(60, $data['kegiatan_atasan']));
		// $nb_iki = $this->NbLines(35, $data['iki_kuantitas']);
		// $nb_iki2 = $this->NbLines(35, $data['iki_kualitas']);
		// $nb_iki3 = $this->NbLines(35, $data['iki_waktu']);
		// $nb_iki_final = $nb_iki + $nb_iki2 + $nb_iki3;
		// $nb = max($nb, $nb_iki_final);

		// print_r('iki = ' . $nb_iki3 . "<br>");
		// if ($nb_iki_final < $nb) {
		// 	$nb_iki3 = $nb - $nb_iki - $nb_iki2;
		// }
		// print_r('iki = ' . $nb_iki3 . "<br>");
		// print_r($nb);
		// die();
		// $h_2 = 4 * $nb_iki;
		// $h_3 = 4 * $nb_iki2;
		// $h_4 = 4 * $nb_iki3;
		// print_r($nb);
		// die();
		//Issue a page break first if needed
		// $this->CheckPageBreak($h);
		// if ($new_page) {
		$x_origin = $this->GetX();
		$y_origin = $this->GetY();
		// }
		// $this->cell(30, 4, '23', 1, 1);
		// 
		$j = 0;
		$row_2 = 40;
		$row_3 = 40;
		$row_4 = 13;
		$row_5 = 13;
		$row_6 = 15;
		$row_7 = 15;
		$row_8 = 22;
		foreach ($data['child'] as $child) {
			$cur_x = $this->GetX() + 37;
			$this->SetX($cur_x);
			$cur_y = $this->GetY();
			// $this->SetX($cur_x + 38);
			// $this->cell(30, 4, '23', 1, 1);
			$this->Rect($cur_x, $cur_y, $row_2, $h[$j]);
			$this->Rect($cur_x + $row_2, $cur_y, $row_3, $h[$j]);
			$this->Rect($cur_x + $row_2 + $row_3, $cur_y, $row_4, $h[$j]);
			$this->Rect($cur_x + $row_2 + $row_3 + $row_4, $cur_y, $row_5, $h[$j]);
			$this->Rect($cur_x + $row_2 + $row_3 + $row_4 + $row_5, $cur_y, $row_6, $h[$j]);
			$this->Rect($cur_x + $row_2 + $row_3 + $row_4 + $row_5 + $row_6, $cur_y, $row_7, $h[$j]);
			$this->Rect($cur_x + $row_2 + $row_3 + $row_4 + $row_5 + $row_6 + $row_7, $cur_y, $row_8, $h[$j]);
			$this->MultiCell($row_2, 4, $child['kegiatan_skp'], 0, 'L');
			$this->SetXY($cur_x + $row_2, $cur_y);
			$this->MultiCell($row_3, 4, $child['kegiatan_aktifitas'], 0, 'L');
			if ($child['jenis_keg'] == 'KU') {
				$this->SetXY($cur_x + $row_2 + $row_3, $cur_y);
				$this->MultiCell($row_4, 4, 'v', 0, 'C');
			} else if ($child['jenis_keg'] == 'KT') {
				$this->SetXY($cur_x + $row_2 + $row_3 + $row_4, $cur_y);
				$this->MultiCell($row_5, 4, 'v', 0, 'C');
			} else {
				$this->SetXY($cur_x + $row_2 + $row_3 + $row_4 + $row_5, $cur_y);
				$this->MultiCell($row_6, 4, 'v', 0, 'C');
			}

			$this->SetXY($cur_x + $row_2 + $row_3 + $row_4 + $row_5 + $row_6, $cur_y);
			$this->MultiCell($row_7, 4, $child['vol'], 0, 'C');
			$this->SetXY($cur_x + $row_2 + $row_3 + $row_4 + $row_5 + $row_6 + $row_7, $cur_y);
			$this->MultiCell($row_8, 4, $child['satuan'], 0, 'C');
			// $this->SetXY($cur_x + $h[$j], $cur_y);
			$this->SetX($cur_x - 37);
			$this->SetY($cur_y + $h[$j]);

			// if ($j == 3)
			// 	return;
			$j++;
			// return;
		}
		// 

		// $this->Ln($h);

		// print_r($h);
		// $this->Cell($w, 4, 'xxxxxxxx', 0, 'C');
	}
	function row_cuti_head($label, $str_1, $label_2 = null, $str_2 = null)
	{
		if ($label_2 != null)
			$r = [30, 65, 30, 65];
		else
			$r = [30, 160, 0, 0];
		$nb = 1;
		$nb = max($nb, $this->NbLines($r[1], $str_1));
		$nb = max($nb, $this->NbLines($r[3], $str_2));
		$h = 6 * $nb;
		$this->CheckPageBreak($h);



		$w = $r[0];
		$x = $this->GetX();
		$y = $this->GetY();
		$this->Rect($x, $y, $w, $h);
		$this->MultiCell($w, 5, $label, 0, 'L');
		$this->SetXY($x + $w, $y);

		$w = $r[1];
		$x = $this->GetX();
		$y = $this->GetY();
		$this->Rect($x, $y, $w, $h);
		$this->MultiCell($w, 5, $str_1, 0, 'L');
		$this->SetXY($x + $w, $y);

		$w = $r[2];
		$x = $this->GetX();
		$y = $this->GetY();
		$this->Rect($x, $y, $w, $h,);
		$this->MultiCell($w, 5, $label_2, 0, 'L');
		$this->SetXY($x + $w, $y);
		$w = $r[3];
		$x = $this->GetX();
		$y = $this->GetY();
		$this->Rect($x, $y, $w, $h);
		$this->MultiCell($w, 5, $str_2, 0, 'L');
		$this->SetXY($x + $w, $y);
		$this->Ln($h);
	}
	function RowSPPD($no, $text1, $text2, $text3 = null)
	{
		// $i = 0;
		$total_hight = 0;
		$nb = 0;
		$nb = max($nb, $this->NbLines(76, $text1));
		if (!empty($text3)) {
			$nb = max($nb, $this->NbLines(50, $text2));
			$nb = max($nb, $this->NbLines(57, $text3));
		} else {
			$nb = max($nb, $this->NbLines(107, $text2));
		}

		// if (!empty($text3));
		// echo $nb;
		// die();
		$h_font = 7;
		$h = $h_font * $nb;
		$total_hight = $total_hight + $nb;
		$this->CheckPageBreak($h);
		$cur_x = $this->GetX() + 4;
		$cur_y = $this->GetY();

		$this->Rect($cur_x, $cur_y, 8, $h);
		$this->Rect($cur_x + 8, $cur_y, 76, $h);
		if (!empty($text3)) {
			$this->Rect($cur_x + 8 + 76, $cur_y, 50, $h);
			$this->Rect($cur_x + 8 + 76 + 50, $cur_y, 57, $h);
		} else {
			$this->Rect($cur_x + 8 + 76, $cur_y, 107, $h);
		}

		$this->SetX($cur_x);
		$this->MultiCell(8, $h_font, $no, 0, 'L');
		$this->SetXY($cur_x + 8, $cur_y);
		$this->MultiCell(76, $h_font, $text1, 0, 'L');
		$this->SetXY($cur_x + 8 + 76, $cur_y);
		if (!empty($text3)) {
			$this->MultiCell(50, $h_font, $text2, 1, 'L');
			$this->SetY($cur_y + $h);
			$this->SetXY($cur_x + 8 + 76 + 50, $cur_y);
			$this->MultiCell(57, $h_font, $text3, 0, 'L');
			$this->SetY($cur_y + $h);
		} else {
			$this->MultiCell(107, $h_font, $text2, 0, 'L');
			$this->SetY($cur_y + $h);
		}
	}

	function row_skp_head($label, $str_1, $label_2, $str_2)
	{
		$r = [60, 40, 51, 42];
		$nb = 1;
		$nb = max($nb, $this->NbLines($r[1], $str_1));
		$nb = max($nb, $this->NbLines($r[3], $str_2));
		$h = 5 * $nb;
		$this->CheckPageBreak($h);



		$w = $r[0];
		$x = $this->GetX();
		$y = $this->GetY();
		$this->Rect($x, $y, $w, $h, 'DF');
		$this->MultiCell($w, 5, $label, 0, 'L');
		$this->SetXY($x + $w, $y);

		$w = $r[1];
		$x = $this->GetX();
		$y = $this->GetY();
		$this->Rect($x, $y, $w, $h);
		$this->MultiCell($w, 5, $str_1, 0, 'L');
		$this->SetXY($x + $w, $y);

		$w = $r[2];
		$x = $this->GetX();
		$y = $this->GetY();
		$this->Rect($x, $y, $w, $h, 'DF');
		$this->MultiCell($w, 5, $label_2, 0, 'L');
		$this->SetXY($x + $w, $y);
		$w = $r[3];
		$x = $this->GetX();
		$y = $this->GetY();
		$this->Rect($x, $y, $w, $h);
		$this->MultiCell($w, 5, $str_2, 0, 'L');
		$this->SetXY($x + $w, $y);
		$this->Ln($h);
	}
	function Row($no, $data)
	{
		$x_origin = $this->GetX();
		$y_origin = $this->GetY();

		//Calculate the height of the row
		$nb = 0;
		// for ($i = 0; $i < count($dt_width); $i++)
		$nb = max($nb, $this->NbLines(40, $data['kegiatan']));
		$nb = max($nb, $this->NbLines(50, $data['kegiatan_atasan']));
		$nb_iki = $this->NbLines(35, $data['iki_kuantitas']);
		$nb_iki2 = $this->NbLines(35, $data['iki_kualitas']);
		$nb_iki3 = $this->NbLines(35, $data['iki_waktu']);
		$nb_iki_final = $nb_iki + $nb_iki2 + $nb_iki3;
		$nb = max($nb, $nb_iki_final);

		// print_r('iki = ' . $nb_iki3 . "<br>");
		if ($nb_iki_final < $nb) {
			$nb_iki3 = $nb - $nb_iki - $nb_iki2;
		}
		// print_r('iki = ' . $nb_iki3 . "<br>");
		// print_r($nb);
		// die();
		$h = 4 * $nb;
		$h_2 = 4 * $nb_iki;
		$h_3 = 4 * $nb_iki2;
		$h_4 = 4 * $nb_iki3;
		// print_r($nb);
		// die();
		//Issue a page break first if needed
		$this->CheckPageBreak($h);
		// if ($new_page) {
		$x_origin = $this->GetX();
		$y_origin = $this->GetY();
		// }
		// 
		{
			$w = 10;
			$a = isset($this->aligns[0]) ? $this->aligns[0] : 'L';
			$x = $this->GetX();
			$y = $this->GetY();
			$this->Rect($x, $y, $w, $h);
			$this->MultiCell($w, 4, $no, 0, $a);
			$this->SetXY($x + $w, $y);

			// kg atasan
			$w = 50;
			$a = isset($this->aligns[0]) ? $this->aligns[0] : 'L';
			$x = $this->GetX();
			$y = $this->GetY();
			$this->Rect($x, $y, $w, $h);
			$this->MultiCell($w, 4, $data['kegiatan_atasan'], 0, $a);
			$this->SetXY($x + $w, $y);

			// keg
			$w = 40;
			$a = isset($this->aligns[0]) ? $this->aligns[0] : 'L';
			$x = $this->GetX();
			$y = $this->GetY();
			$this->Rect($x, $y, $w, $h);
			$this->MultiCell($w, 4, $data['kegiatan'], 0, $a);
			$this->SetXY($x + $w, $y);
		}
		// kuant 
		{
			$w = 16;
			$a = isset($this->aligns[0]) ? $this->aligns[0] : 'L';
			$x = $this->GetX();
			$x2 = $x;
			$y = $this->GetY();
			$this->Rect($x, $y, $w, $h_2);
			$this->MultiCell($w, 4, "Kuantitas", 0, $a);
			$this->SetXY($x + $w, $y);

			$w = 35;
			$a = isset($this->aligns[0]) ? $this->aligns[0] : 'L';
			$x = $this->GetX();
			$y = $this->GetY();
			$this->Rect($x, $y, $w, $h_2);
			$this->MultiCell($w, 4, $data['iki_kuantitas'], 0, $a);
			$this->SetXY($x + $w, $y);

			$w = 10;
			$a = isset($this->aligns[0]) ? $this->aligns[0] : 'L';
			$x = $this->GetX();
			$y = $this->GetY();
			$this->Rect($x, $y, $w, $h_2);
			$this->MultiCell($w, 4, (empty($data['min_kuantitas']) ? '-' : $data['min_kuantitas']), 0, 'C');
			$this->SetXY($x + $w, $y);

			$w = 11;
			$a = isset($this->aligns[0]) ? $this->aligns[0] : 'L';
			$x = $this->GetX();
			$y = $this->GetY();
			$this->Rect(
				$x,
				$y,
				$w,
				$h_2
			);
			$this->MultiCell($w, 4, $data['max_kuantitas'], 0, 'C');
			$this->SetXY($x + $w, $y);

			$w = 21;
			$x = $this->GetX();
			$y = $this->GetY();
			$this->Rect($x, $y, $w, $h_2);
			$this->MultiCell($w, 4, $data['ket_kuantitas'], 0, 'C');
			$this->SetXY($x2, $y + $h_2);
		}

		// kuant 
		{
			$w = 16;
			$a = isset($this->aligns[0]) ? $this->aligns[0] : 'L';
			$x = $this->GetX();
			$y = $this->GetY();
			$this->Rect($x, $y, $w, $h_3);
			$this->MultiCell(
				$w,
				4,
				"Kualitas",
				0,
				$a
			);
			$this->SetXY($x + $w, $y);

			$w = 35;
			$a = isset($this->aligns[0]) ? $this->aligns[0] : 'L';
			$x = $this->GetX();
			$y = $this->GetY();
			$this->Rect($x, $y, $w, $h_3);
			$this->MultiCell($w, 4, $data['iki_kualitas'], 0, $a);
			$this->SetXY($x + $w, $y);

			$w = 10;
			$a = isset($this->aligns[0]) ? $this->aligns[0] : 'L';
			$x = $this->GetX();
			$y = $this->GetY();
			$this->Rect($x, $y, $w, $h_3);
			$this->MultiCell($w, 4, (empty($data['min_kualitas']) ? '-' : $data['min_kualitas']), 0, 'C');
			$this->SetXY($x + $w, $y);

			$w = 11;
			$a = isset($this->aligns[0]) ? $this->aligns[0] : 'L';
			$x = $this->GetX();
			$y = $this->GetY();
			$this->Rect(
				$x,
				$y,
				$w,
				$h_3
			);
			$this->MultiCell(
				$w,
				4,
				$data['max_kualitas'],
				0,
				'C'
			);
			$this->SetXY($x + $w, $y);

			$w = 21;
			$x = $this->GetX();
			$y = $this->GetY();
			$this->Rect($x, $y, $w, $h_3);
			$this->MultiCell($w, 4, $data['ket_kualitas'], 0, 'C');
			// $this->SetXY($x + $w, $y);
			$this->SetXY($x2, $y + $h_3);
		}
		// WAKTU
		{
			$w = 16;
			$a = isset($this->aligns[0]) ? $this->aligns[0] : 'L';
			$x = $this->GetX();
			$y = $this->GetY();
			$this->Rect($x, $y, $w, $h_4);
			$this->MultiCell(
				$w,
				4,
				"Waktu",
				0,
				$a
			);
			$this->SetXY($x + $w, $y);

			$w = 35;
			$a = isset($this->aligns[0]) ? $this->aligns[0] : 'L';
			$x = $this->GetX();
			$y = $this->GetY();
			$this->Rect($x, $y, $w, $h_4);
			$this->MultiCell($w, 4, $data['iki_waktu'], 0, $a);
			$this->SetXY($x + $w, $y);

			$w = 10;
			$a = isset($this->aligns[0]) ? $this->aligns[0] : 'L';
			$x = $this->GetX();
			$y = $this->GetY();
			$this->Rect($x, $y, $w, $h_4);
			$this->MultiCell($w, 4, (empty($data['min_waktu']) ? '-' : $data['min_waktu']), 0, 'C');
			$this->SetXY($x + $w, $y);

			$w = 11;
			$a = isset($this->aligns[0]) ? $this->aligns[0] : 'L';
			$x = $this->GetX();
			$y = $this->GetY();
			$this->Rect(
				$x,
				$y,
				$w,
				$h_4
			);
			$this->MultiCell(
				$w,
				4,
				$data['max_waktu'],
				0,
				'C'
			);
			$this->SetXY($x + $w, $y);

			$w = 21;
			$x = $this->GetX();
			$y = $this->GetY();
			$this->Rect($x, $y, $w, $h_4);
			$this->MultiCell($w, 4, $data['ket_waktu'], 0, 'C');
			// if ($h == 12)
			// 	$this->cell(20, 2, 'xxx' . $h, 1);
			$this->SetXY($x_origin, $y_origin);
		}
		$this->Ln($h);

		// print_r($h);
		// $this->Cell($w, 4, 'xxxxxxxx', 0, 'C');
	}

	function CheckPageBreak($h)
	{
		if ($this->GetY() + $h > $this->PageBreakTrigger) {
			$this->AddPage($this->CurOrientation);
		}
	}

	function NbLines($w, $txt)
	{
		//Computes the number of lines a MultiCell of width w will take
		$cw = &$this->CurrentFont['cw'];
		if ($w == 0)
			$w = $this->w - $this->rMargin - $this->x;
		$wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
		$s = str_replace("\r", '', $txt);
		$nb = strlen($s);
		if ($nb > 0 and $s[$nb - 1] == "\n")
			$nb--;
		$sep = -1;
		$i = 0;
		$j = 0;
		$l = 0;
		$nl = 1;
		while ($i < $nb) {
			$c = $s[$i];
			if ($c == "\n") {
				$i++;
				$sep = -1;
				$j = $i;
				$l = 0;
				$nl++;
				continue;
			}
			if ($c == ' ')
				$sep = $i;
			$l += $cw[$c];
			if ($l > $wmax) {
				if ($sep == -1) {
					if ($i == $j)
						$i++;
				} else
					$i = $sep + 1;
				$sep = -1;
				$j = $i;
				$l = 0;
				$nl++;
			} else
				$i++;
		}
		return $nl;
	}

	function tgl_indo($tanggal)
	{
		$bulan = array(
			1 =>   'Januari',
			'Februari',
			'Maret',
			'April',
			'Mei',
			'Juni',
			'Juli',
			'Agustus',
			'September',
			'Oktober',
			'November',
			'Desember'
		);
		$pecahkan = explode('-', $tanggal);


		return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
	}

	function SetDash($black = null, $white = null)
	{
		if ($black !== null)
			$s = sprintf('[%.3F %.3F] 0 d', $black * $this->k, $white * $this->k);
		else
			$s = '[] 0 d';
		$this->_out($s);
	}
}
