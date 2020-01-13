<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Writer\WriterFactory;
use Box\Spout\Writer\Style\StyleBuilder;
use Box\Spout\Writer\Style\Color;
use Box\Spout\Common\Type;

class Excel_spout_lib extends CI_Model
{
    public $data = [];

    function __construct()
    {
        include_once APPPATH . 'third_party/spout/src/Spout/Autoloader/autoload.php';
    }

    public function make_excel_file($headers = [], $datas = [], $location = '')
    {
        $row_header_style = (new StyleBuilder())
            ->setFontBold()
            ->setFontName('Arial')
            ->setFontSize(11)
            ->build();
        $writer = WriterFactory::create(Type::XLSX);
        if (empty($location)) {
            $writer->openToBrowser(date('YmdHis.') . 'xlsx');
        } else {
            $writer->openToFile($location);
        }
        $sheetID = 0;
        foreach ($headers as $productID => $header) {
            if ($sheetID > 0) {
                $sheet = $writer->addNewSheetAndMakeItCurrent();
            } else {
                $sheet = $writer->getCurrentSheet();
            }
            $findProductName = $this->db->query("select * from product where `id` = '{$productID}'")->row();
            $productName = isset($findProductName->fullName) ? $findProductName->fullName : 'Tổng';
            $sheet->setName($productName);
            //Create colName
            foreach ($header as $headerData) {
                $writer->addRowWithStyle($headerData, $row_header_style);
            }

            //Write data
            $sheetData = isset($datas[$productID]) ? $datas[$productID] : [];
            if (!empty($sheetData)) {
                foreach ($sheetData as $data) {
                    if (!empty($data)){
                        $writer->addRow($data);
                    }
                }
            }
            $sheetID++;
        }
        $writer->close();
    }

    public function read_file_multisheet($filePath, $date_time_colunm = [], $limit = -1)
    {
        $return = [
            'status' => true,
            'data' => [],
            'msg' => ''
        ];
        $reader = ReaderFactory::create(Type::XLSX);
        $reader->open($filePath);

        foreach ($reader->getSheetIterator() as $sheet) {
            $count = 0;
            $sheetName = $sheet->getName();
            foreach ($sheet->getRowIterator() as $row) {
                if ($count == 0) {
                    $return['data'][$sheetName]['db_field_name'] = array_map('trim', $row);
                } else {
                    if ($count == $limit) {
                        break;
                    } else {
                        foreach ($row as $k => $v) {
                            if (in_array($return['data'][$sheetName]['db_field_name'][$k], $date_time_colunm[$sheetName])) {
                                if ($v instanceof DateTime) {
                                    $v = $v->format('Y-m-d');
                                } else {
                                    $dateTimeObj = DateTime::createFromFormat('d/m/Y', $v);
                                    if ($dateTimeObj) {
                                        $v = $dateTimeObj->format('Y-m-d');
                                    } else {
                                        $v = null;
                                    }
                                }
                            } else {
                                if ($v instanceof DateTime) {
                                    $v = $v->format('d/m/Y');
                                } else {
                                    $v = is_string($v) ? trim($v) : $v;
                                }
                            }
                            $return['data'][$sheetName]['file_data'][$count][$return['data'][$sheetName]['db_field_name'][$k]] = $v;
                        }
                    }
                }
                if ($count == 3) {
                    dump_exit($return);
                }
                $count++;
            }
        }

        $reader->close();
        return $return;
    }

    public function read_file($filePath, $date_time_colunm = [], $limit = -1)
    {
        $return = [
            'status' => true,
            'data' => [],
            'msg' => ''
        ];
        $reader = ReaderFactory::create(Type::XLSX);
        $reader->open($filePath);

        foreach ($reader->getSheetIterator() as $sheet) {
            $count = 0;
            foreach ($sheet->getRowIterator() as $row) {
                if ($count == 0) {
                    $return['data']['db_field_name'] = array_map('trim', $row);
                } else {
                    if ($count == $limit) {
                        break;
                    } else {
                        foreach ($row as $k => $v) {
                            if (in_array($return['data']['db_field_name'][$k], $date_time_colunm)) {
                                if ($v instanceof DateTime) {
                                    $v = $v->format('Y-m-d');
                                } else {
                                    $dateTimeObj = DateTime::createFromFormat('d/m/Y', $v);
                                    if ($dateTimeObj) {
                                        $v = $dateTimeObj->format('Y-m-d');
                                    } else {
                                        $v = null;
                                    }
                                }
                            } else {
                                if ($v instanceof DateTime) {
                                    $v = $v->format('d/m/Y');
                                } else {
                                    $v = is_string($v) ? trim($v) : $v;
                                }
                            }
                            $return['data']['file_data'][$count][$return['data']['db_field_name'][$k]] = $v;
                        }
                    }
                }
                $count++;
            }
            break;
        }

        $reader->close();
        return $return;
    }

    public function get_header($filePath, $limit = 1)
    {
        $headers = [];
        $reader = ReaderFactory::create(Type::XLSX);
        $reader->open($filePath);

        foreach ($reader->getSheetIterator() as $sheet) {
            $count = 0;
            $sheetName = $sheet->getName();
            foreach ($sheet->getRowIterator() as $row) {
                if ($count == $limit) {
                    break;
                }
                $headers[$sheetName][] = array_map('trim', $row);
                $count++;
            }
        }
        $reader->close();
        return $headers;
    }

    public function export_file($header = [], $datas = [], $location = '')
    {
        $writer = WriterFactory::create(Type::XLSX);
        if (empty($location)) {
            $writer->openToBrowser(date('YmdHis.') . 'xlsx');
        } else {
            $writer->openToFile($location);
        }
        $row_header_style = (new StyleBuilder())
            ->setFontBold()
            ->setFontName('Arial')
            ->setFontSize(11)
            ->build();
        $writer->addRowsWithStyle($header, $row_header_style);
        $writer->addRows($datas);

        $writer->close();

    }

    public function export_case_line($header = [], $datas = [], $location = '')
    {
        $writer = WriterFactory::create(Type::XLSX);
        if (empty($location)) {
            $writer->openToBrowser(date('YmdHis.') . 'xlsx');
        } else {
            $writer->openToFile($location);
        }
        $row_header_style = (new StyleBuilder())
            ->setFontBold()
            ->setFontName('Arial')
            ->setFontSize(11)
            ->setBackgroundColor('fcf403')
            ->build();
        $rsm_style = (new StyleBuilder())
            ->setFontBold()
            ->setFontName('Arial')
            ->setFontSize(11)
            ->setFontColor('fc0b03')
            ->build();
        $asm_style = (new StyleBuilder())
            ->setFontBold()
            ->setFontName('Arial')
            ->setFontSize(11)
            ->setFontColor('036ffc')
            ->build();
        $ss_style = (new StyleBuilder())
            ->setFontBold()
            ->setFontName('Arial')
            ->setFontSize(11)
            ->setFontColor('fc03db')
            ->build();
        $sup_style = (new StyleBuilder())
            ->setFontBold()
            ->setFontName('Arial')
            ->setFontSize(11)
            ->build();
        $leader_style = (new StyleBuilder())
            ->setFontName('Arial')
            ->setFontSize(11)
            ->build();
        $writer->addRowsWithStyle($header, $row_header_style);
        foreach ($datas as $data){
            $positon = $data[0];
            if ($positon == 'RSM'){
                $style = $rsm_style;
            } elseif ($positon == 'ASM'){
                $style = $asm_style;
            } elseif ($positon == 'SS'){
                $style = $ss_style;
            } elseif ($positon == 'SUP'){
                $style = $sup_style;
            } elseif ($positon == 'TL'){
                $style = $leader_style;
            } elseif ($positon == 'Tổng'){
                $style = $row_header_style;
            } else {
                $style = $leader_style;
            }
            $writer->addRowWithStyle($data, $style);
        }

        $writer->close();

    }

}