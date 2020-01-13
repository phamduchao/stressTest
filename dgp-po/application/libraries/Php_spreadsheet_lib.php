<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Php_spreadsheet_lib extends CI_Model
{
    public $data = array();

    function __construct()
    {
        include_once APPPATH . 'third_party/spreadsheet/autoload.php';
    }

    public function make_excel_file($headers = [], $datas = [], $location=''){
        //WriteTileColunm
        $styleHeader = [
            'font' => [
                'bold' => true,
            ]
        ];

        $spreadsheet = new Spreadsheet();

        $sheetNum = 0;
        foreach ($headers as $productID => $header){
            if ($sheetNum > 0){
                $spreadsheet->createSheet();
            }
            $startRow = 1;
            foreach ($header as $headerData){
                $heardCol = 'A';
                foreach ($headerData as $title){
                    $spreadsheet->setActiveSheetIndex($sheetNum)->setCellValue($heardCol.$startRow, $title);
                    $spreadsheet->setActiveSheetIndex($sheetNum)->getColumnDimension($heardCol)->setAutoSize(true);
                    $heardCol++;
                }
                $spreadsheet->setActiveSheetIndex($sheetNum)->getStyle("A{$startRow}:{$heardCol}{$startRow}" )->applyFromArray($styleHeader);
                $startRow++;
            }
            $sheetData = isset($datas[$productID]) ? $datas[$productID] : [];
            if (!empty($sheetData)){
                foreach ($sheetData as $data){
                    $startCol = 'A';
                    foreach ($data as $key=>$cell){
                        $coordinate = $startCol.$startRow;
                        $spreadsheet->setActiveSheetIndex($sheetNum)->setCellValue($coordinate, $cell);
                        $startCol++;
                    }
                    $startRow++;
                }
            }
            $spreadsheet->getActiveSheet()->setTitle($this->db->query("select * from product where `id` = '{$productID}'")->row()->fullName);
            $sheetNum++;
        }

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Export.xlsx"');
        if (empty($location)){
            $writer->save("php://output");
        } else {
            $writer->save($location);
        }
    }

}