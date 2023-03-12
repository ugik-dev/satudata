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
        $data = $this->SPPDModel->getAllSPPD(['id_spt' => $id]);
        echo json_encode($data);
        $filter = $this->input->get();

        $filename = 'Absensi';

        $spreadsheet = new Spreadsheet();
        $styleArray = array(
            'font'  => array(
                'size'  => 12,
                'name'  => 'Arial'
            )
        );

        $spreadsheet->getActiveSheet()->getProtection()->setPassword('sugi_pramana');
        $spreadsheet->getActiveSheet()->getProtection()->setSheet(true);
        $spreadsheet->getActiveSheet()->getProtection()->setSort(true);
        $spreadsheet->getActiveSheet()->getProtection()->setInsertRows(true);
        $spreadsheet->getActiveSheet()->getProtection()->setFormatCells(true);

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
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setVisible(false);
        $sheet->getColumnDimension('A')->setWidth(12);
        $sheet->getColumnDimension('B')->setWidth(2);
        $sheet->getColumnDimension('C')->setWidth(2);
        $sheet->getColumnDimension('D')->setWidth(2);
        $sheet->getColumnDimension('E')->setWidth(35);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(20);
        $spreadsheet->getActiveSheet()->getStyle('A6:H6')->getAlignment()->setVertical('center')->setHorizontal('center')->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle('A1:A5')->getAlignment()->setVertical('center')->setHorizontal('center')->setWrapText(true);

        $sheet->getStyle('F:H')->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
        $sheet->mergeCells("A1:H1");
        $sheet->mergeCells("A2:H2");
        $sheet->mergeCells("A3:H3");
        $sheet->mergeCells("A4:H4");
        $sheet->mergeCells("A5:H5");

        $sheet->setCellValue('A1', 'Absensi Lembur');
        $sheet->setCellValue('A2', 'Dinas Kesehatan Kabupaten Bangka');
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

        // $sheet->getStyle('A6:H6')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
        // $sheet->getStyle('A6:H6')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
        // $data['accounts_records'] = $this->Statement_model->xls_neraca_saldo($filter, $sheet);
        $writer = new Xlsx($spreadsheet);

        ob_end_clean();

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); // download file 
    }
}
