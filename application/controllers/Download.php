<?php
/*

*/
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Writer\Word2007;


class Download extends CI_Controller
{
    function absensi_lembur($id)
    {
        $this->load->model('SPPDModel');
        $data = $this->SPPDModel->getAllSPPD(['id_spt' => $id])[$id];
        $data_temp = [];
        $i = 0;
        foreach ($data['tujuan'] as $t) {
            $data_temp[$i]['tgl'] = $t['date_berangkat'];
            $data_temp[$i]['jam'] = [];
            $time1 = strtotime($t['dari']);
            $time2 = strtotime($t['sampai']);
            $difference = round(abs($time2 - $time1) / 3600, 2);
            // echo $difference;
            for ($j = 1; $j <= $difference; $j++) {
                $tb = $time1 + (3600 * ($j - 1));
                $ts = $time1 + (3600 * $j);
                $data_temp[$i]['jam'][] = strftime('%H:%M', $tb) . '-' . strftime('%H:%M', $ts);
            }
            $data_temp[$i]['jml'] = $j - 1;
            $i++;
        }

        // echo json_encode($data);
        // die();
        $filter = $this->input->get();

        $filename = 'Absensi No ' . $data['no_spt'];

        $spreadsheet = new Spreadsheet();
        $styleArray = array(
            'font'  => array(
                'size'  => 12,
                'name'  => 'Arial'
            )
        );

        // $spreadsheet->getActiveSheet()->getProtection()->setPassword('sugi_pramana');
        // $spreadsheet->getActiveSheet()->getProtection()->setSheet(true);
        // $spreadsheet->getActiveSheet()->getProtection()->setSort(true);
        // $spreadsheet->getActiveSheet()->getProtection()->setInsertRows(true);
        // $spreadsheet->getActiveSheet()->getProtection()->setFormatCells(true);

        $spreadsheet->getDefaultStyle()
            ->applyFromArray($styleArray);

        $spreadsheet->getActiveSheet()->setPrintGridlines(false);
        $spreadsheet->getActiveSheet()->getProtection()->setSheet(true);
        $sheet = $spreadsheet->getActiveSheet();
        // if (!empty($filter['template'])) {
        //     if ($filter['template'] == '2') {
        //         // $this->xls_neraca_saldo2($filter, $data, $sheet, $spreadsheet, $filename);
        //         return;
        //     }
        // }
        // $spreadsheet->getActiveSheet()->getColumnDimension('A')->setVisible(false);
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
        $lastAlpa = 'C';
        // echo ++$lastAlpa;
        foreach ($data_temp as $d) {
            $j = 0;
            $fa = '';
            foreach ($d['jam'] as $dj) {
                ++$lastAlpa;
                if ($j == 0) {
                    $fa = $lastAlpa;
                }
                $j++;
                $sheet->getColumnDimension($lastAlpa)->setWidth((7));
                $sheet->setCellValue("{$lastAlpa}5",  $dj);
            }
            $sheet->setCellValue("{$fa}4",  $d['tgl']);
            $sheet->mergeCells("{$fa}4:{$lastAlpa}4");
        }
        // $spreadsheet->getActiveSheet()->getStyle('A6:H6')->getAlignment()->setVertical('center')->setHorizontal('center')->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle("A1:{$lastAlpa}5")->getAlignment()->setVertical('center')->setHorizontal('center')->setWrapText(true);

        $sheet->getStyle('F:H')->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
        $sheet->mergeCells("A1:H1");
        $sheet->mergeCells("A2:H2");
        $sheet->mergeCells("A4:A5");
        $sheet->mergeCells("B4:B5");
        $sheet->mergeCells("C4:C5");
        $sheet->setCellValue('A1', 'Absensi Lembur');
        $sheet->setCellValue('A2', 'Dinas Kesehatan Kabupaten Bangka');
        $sheet->setCellValue("A4",  'No');
        $sheet->setCellValue("B4",  'Nama');
        $sheet->setCellValue("C4",  'NIP');
        // $sheet->mergeCells("A4:H4");
        // $sheet->mergeCells("A5:H5");

        $num_row = 6;
        $num = 1;
        $sheet->setCellValue("A$num_row",  $num);
        $sheet->setCellValue("B$num_row",  $data['nama_pegawai']);
        $sheet->setCellValue("C$num_row",  $data['nip_pegawai']);
        foreach ($data['pengikut'] as $p) {
            $num++;
            $num_row++;
            $sheet->setCellValue("A$num_row",  $num);
            $sheet->setCellValue("B$num_row",  $p['nama']);
            $sheet->setCellValue("C$num_row",  $p['nip']);
        }
        // if (!empty($filter['laba_rugi'])) {
        // $sheet->setCellValue('A3', '');
        // } else {
        //     $sheet->setCellValue('A3', 'Neraca Saldo');
        // }

        // $namaBulan = array("Januari", "Februaru", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
        // if ($filter['periode'] == 'bulanan') {
        //     // $sheet->setCellValue('A4', 'Periode : 1 ' . $namaBulan[$filter['bulan'] - 1] . ' ' . $filter['tahun'] . ' s/d ' . date("t", strtotime($filter['tahun'] . '-' . $filter['bulan'] . '-1')) . ' ' . $namaBulan[$filter['bulan'] - 1] . ' ' . $filter['tahun']);
        // } else {
        //     // $sheet->setCellValue('A4', 'Periode : 1 Januari ' . $filter['tahun'] . ' s/d ' . date("t", strtotime($filter['tahun'] . '-12-1')) . ' Desember ' . $filter['tahun']);
        // };
        // $sheet->setCellValue('A6', 'NO AKUN');
        // $sheet->mergeCells("B6:E6")->setCellValue('B6', 'NAMA AKUN');
        // $sheet->setCellValue('F6', 'SALDO PERIODE SEBELUMNYA');
        // $sheet->setCellValue('G6', 'MUTASI');
        // $sheet->setCellValue('H6', 'SALDO');
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    // 'color' => ['argb' => 'FFFF0000'],
                ],
            ],
        ];

        $sheet->getStyle("A4:{$lastAlpa}{$num_row}")->applyFromArray($styleArray);

        // $sheet->getStyle("A4:{$lastAlpa}{$num_row}")->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
        // $spreadsheet
        //     ->getActiveSheet()
        //     ->getStyle("A4:{$lastAlpa}{$num_row}")
        //     ->getBorders()
        //     ->getOutline()
        //     ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK); // $sheet->getStyle('A6:H6')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
        // $data['accounts_records'] = $this->Statement_model->xls_neraca_saldo($filter, $sheet);
        $writer = new Xlsx($spreadsheet);

        ob_end_clean();

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); // download file 
    }
}
