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
}