<?php

// include 'PHPExcel/PHPExcel.php';
// include 'PHPExcel/PHPExcel/Writer/Excel2007.php';

require_once 'PHPExcel/PHPExcel.php';
// require_once 'PHPExcel/PHPExcel/Writer/Excel2007.php';


$datas = array(
    array('name'=>'王城', 'sex'=>'男', 'age'=>'18', 'birthday'=>'1997-03-13', 'ID'=>'18948348924'),
    array('name'=>'李飞虹', 'sex'=>'男', 'age'=>'21', 'birthday'=>'1994-06-13', 'ID'=>'159481838924'),
    array('name'=>'王芸', 'sex'=>'女', 'age'=>'18', 'birthday'=>'1997-03-13', 'ID'=>'18648313924'),
    array('name'=>'郭瑞', 'sex'=>'男', 'age'=>'17', 'birthday'=>'1998-04-13', 'ID'=>'15543248924'),
    array('name'=>'李晓霞', 'sex'=>'女', 'age'=>'19', 'birthday'=>'1996-06-13', 'ID'=>'18748348924'),
);

$excel = new PHPExcel();

$excel->setActiveSheetIndex(0);

$activeSheet = $excel->getActiveSheet();

$tableheader = ['姓名', '性别', '年龄', '出生日期', '编号'];
for ($i = 0; $i < count($tableheader); $i++) {
    $str = '';
    if (floor($i / 26) > 0) {
        $str .= IntToChr(floor($i / 26)-1);
    }
    $str = $str . chr($i % 26 + 65);
    $letter[] = $str;
    $activeSheet->setCellValue($str.'1', $tableheader[$i]);
}

//设置当前sheet的标题
$activeSheet->settitle('student');

$count = count($datas);
$baserow = 2;  //指定插入到第二行后
for ($i = 0; $i < $count; $i++) {
    $row = $i + $baserow;
    $element = $datas[$i];
    $activeSheet->setCellValue($letter[0] . $row, $element['name'])->getstyle('A'.$i)->getAlignment()->setHorizontal(PHPExcel_style_Alignment::VERTICAL_CENTER);
    $activeSheet->setCellValue($letter[1] . $row, $element['sex']);
    $activeSheet->setCellValue($letter[2] . $row, $element['age']);
    $activeSheet->setCellValueExplicit($letter[3] . $row, $element['birthday'],PHPExcel_Cell_DataType::TYPE_STRING);
    $activeSheet->getstyle($letter[3] . $row)->getNumberFormat()->setFormatCode("@");
    // $activeSheet->setCellValue($letter[4] . $row, $element['ID']);
    $activeSheet->setCellValueExplicit($letter[4] . $row, $element['ID'], PHPExcel_Cell_DataType::TYPE_STRING);
    // $activeSheet->getstyle($letter[4] . $row)->getAlignment()->setWrapText(true);

}

$filename = '20190927';

/**
 * header()配置注意点：
 * 发送头之前不能有任何输出，空格也不行,文件的开头不能有空行
 * 前面不能有任何的输出，如果他上面include其他文件了，你还要检查其他文件里是否有输出。
 */
header("Pragma: public");
header("Expires: 0");
header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
header("Content-Type:application/force-download");
header("Content-Type:application/vnd.ms-execl");
header("Content-Type:application/octet-stream");
header("Content-Type:application/download");
header('Content-Disposition:attachment;filename="testdata.xls"');
header("Content-Transfer-Encoding:binary");
$objWriter = new PHPExcel_Writer_Excel5($excel);
$objWriter->save($filename . '.xls');


/**
 * 序号转化为excel的列名
 */
function IntToChr($index, $start = 65){
    $str = '';
    if (floor($index / 26) > 0) {
        $str .= IntToChr(floor($index / 26)-1);
    }
    return $str . chr($index % 26 + $start);
}


/**
 * 参考文档
 * https://blog.csdn.net/chenlix/article/details/82853698
 * https://blog.csdn.net/liuxin_0725/article/details/78779459
 * https://blog.csdn.net/xifeijian/article/details/39341195
 */