<?php

require_once 'PHPExcel/PHPExcel.php';

class PHPExcel_common
{

    /**
     * 纯导出，没有任何excel格式
     * $data是索引数组，值的顺序跟$header的顺序一样
     * $path是文件保存路径
     */
    public function common($data, $header = array(), $filename, $path='./')
    {
        $excel = new PHPExcel();
        $excel->setActiveSheetIndex(0);
        $activeSheet = $excel->getActiveSheet();
        //设置当前sheet的标题
        $activeSheet->settitle($filename);

        $col = count($header);
        for ($i = 0; $i < $col; $i++) {
            $str = self::IntToChr($i);
            $letter[] = $str;
            $activeSheet->setCellValue($str . '1', $header[$i]);
        }

        $count = count($data);
        $baserow = 2;  //指定插入到第二行后

        for ($i = 0; $i < $count; $i++) {
            $row = $i + $baserow;
            $element = $data[$i];
            for ($j = 0; $j < $col; $j++) {
                if(strlen($element[$j]) > 11){
                    $activeSheet->setCellValueExplicit($letter[$j] . $row, $element[$j], PHPExcel_Cell_DataType::TYPE_STRING);
                }
                else{
                    $activeSheet->setCellValue($letter[$j] . $row, $element[$j]);
                }
            }
        }

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
        header('Content-Disposition:attachment;filename=' . $filename . '.xls');
        header("Content-Transfer-Encoding:binary");
        $objWriter = new PHPExcel_Writer_Excel5($excel);
        $objWriter->save($path . $filename . '.xls');
    }

    /**
     * 自定义样式1
     */
    public function style1(){
        #code...
    }


    /**
     * 序号转化为excel的列名
     */
    function IntToChr($index, $start = 65)
    {
        $str = '';
        if (floor($index / 26) > 0) {
            $str .= IntToChr(floor($index / 26) - 1);
        }
        return $str . chr($index % 26 + $start);
    }
}


$datas = array(
    array('name'=>'王城', 'sex'=>'男', 'age'=>'18', 'birthday'=>'1997-03-13', 'ID'=>'18948348924'),
    array('name'=>'李飞虹', 'sex'=>'男', 'age'=>'21', 'birthday'=>'1994-06-13', 'ID'=>'159481838924'),
    array('name'=>'王芸', 'sex'=>'女', 'age'=>'18', 'birthday'=>'1997-03-13', 'ID'=>'18648313924'),
    array('name'=>'郭瑞', 'sex'=>'男', 'age'=>'17', 'birthday'=>'1998-04-13', 'ID'=>'15543248924'),
    array('name'=>'李晓霞', 'sex'=>'女', 'age'=>'19', 'birthday'=>'1996-06-13', 'ID'=>'18748348924'),
);

$data_new = array();
foreach ($datas as $value) {
    $element = array();
    foreach ($value as $v) {
        $element[] = $v;
    }
    $data_new[] = $element;
}

$header = ['姓名', '性别', '年龄', '出生日期', '编号'];

PHPExcel_common::common($data_new, $header, 'student');