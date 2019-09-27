<?php

class DataOperate {

    /**
     * 根据数组的多个键值进行分组
     * flag为true返回的是json格式的数组，false返回的是数组格式的数组
     */
    public function groupingByColumn($data, $columnList=[], $flag=true)
    {
        if(empty($columnList)){
            return $data;
        }
        $arr = array();
        for ($i = 0; $i < count($data); $i++) {
            $element = $data[$i];
            $key = array();
            foreach ($columnList as $value) {
                $key[] = $element[$value];
            }
            $str = implode(",", $key);
            if (!array_key_exists($str, $arr)) {
                $arr[$str] = array();
            }
            $arr[$str][] = $element;
        }
        if(!$flag){
            $arr_new = array();
            foreach ($arr as $value) {
                $arr_new[] = $value;
            }
            $arr = $arr_new;
            unset($arr_new);
        }
        return $arr;
    }

    public function isKeyExist($data, $key){
        if(array_key_exists($key, $data)){
            return $data[$key];
        }
        return '';
    }


    /**
     * 前提：$data1,$data2需先做过统计，$common_key中的键值组合唯一
     * $data1 原数据数组1
     * $data2 原数据数组2
     * $common_key 原数据数组中共有的字段。$common_key中的字段两原数组中必须有
     * $data1_keys 返回的数组中需要从$data1中获取的字段
     * $data2_keys 返回的数组中需要从$data2中获取的字段
     */
    public function arrayFieldMerge(array $data1, array $data2, array $common_key, array $data1_keys, array $data2_keys){

        $arr_value_str1 = self::getKeyValueStr($data1, $common_key);
        $arr_value_str2 = self::getKeyValueStr($data2, $common_key);
        
        $array = array();
        foreach ($arr_value_str1 as $key => $value) {
            $arr = array();
            $elem1 = $data1[$key];
            $keys1 = array_merge($common_key, $data1_keys);
            foreach ($keys1 as $v) {
                $arr[$v] = $elem1[$v];
            }
            //获取数组中元素的下标
            $index_arr = array_keys($arr_value_str2, $value, false);
            if(!empty($index_arr)){
                $index = $index_arr[0];
                $elem2 = $data2[$index];
                foreach ($data2_keys as $vv) {
                    $arr[$vv] = $elem2[$vv];
                }
            }
            else{
                foreach ($data2_keys as $vv) {
                    $arr[$vv] = '';
                }
            }
            $array[] = $arr;
        }

        $diff_arr = array_diff($arr_value_str2, $arr_value_str1);
        foreach ($diff_arr as $value) {
            $arr = array();
            $index_arr = array_keys($arr_value_str2, $value, false);
            $index = $index_arr[0];
            $elem2 = $data2[$index];
            foreach ($data1_keys as $v) {
                $arr[$v] = '';
            }
            foreach ($data2_keys as $v) {
                $arr[$v] = $elem2[$v];
                $value_arr = explode(',', $value);
                foreach ($common_key as $key => $vv) {
                   $arr[$vv] = $value_arr[$key];
                }
            }
            $array[] = $arr;
        }
        return $array;
    }

    public function getKeyValueStr($data, $common_key){
        $arr = array();
        foreach ($data as $key => $value) {
            $str = '';
            foreach ($common_key as $v) {
                $str .= $value[$v] . ',';
            }
            $str = substr($str,0,strlen($str)-1); 
            $arr[$key] = $str;
        }
        return $arr;
    }
}


$data1 = [
    ['k'=>1, 'v1'=>'q' ],
    ['k'=>2, 'v1'=>'w'],
    ['k'=>3, 'v1'=>'e'],
];
$data2 = [
    ['k'=>1, 'v2'=>'v'],
    ['k'=>2, 'v2'=>'b'],
    ['k'=>3, 'v2'=>'n'],
    ['k'=>4, 'v2'=>'n'],
];
print_r( DataOperate::arrayFieldMerge($data1, $data2, ['k'], ['v1'], ['v2']));