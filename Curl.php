<?php

class Curl{
    public function get($url, $data=[]){
        $url = $url . '?' . http_build_query($data);
        //初始化一个新会话
        $ch = curl_init();
        //设置要请求的URL
        curl_setopt($ch, CURLOPT_URL, $url);
        //跳过SSL证书验证
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
        // 是否将数据已返回值形式返回
        // 1 返回数据
        // 0 直接输出数据 帮你写了: echo $output;
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // 接收数据时超时设置，如果5秒内数据未接收完，直接退出
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        // 执行CURL请求
        $output = curl_exec($ch);
        if (curl_errno($ch)) {
            return ['state'=>0, 'errorMsg'=>curl_error($ch)];
        }
        // 关闭CURL资源
        curl_close($ch);
        $output = json_decode($output,true);
        return ['state'=>1, 'errorMsg'=>'', 'data'=>$output];
    }
    
    
    public function post($url,$data=[]){
        $data = http_build_query($data);
        /**
         * Content-type
         * application/x-www-form-urlencoded： 以字符串的形式发送，使用http_build_query()方法;
         * application/json: 以数组的形式发送
         */
        $headerArray = array("Content-type:application/x-www-form-urlencoded;charset='utf-8'");
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,FALSE);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_HTTPHEADER,$headerArray);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        if (curl_errno($curl)) {
            return ['state'=>0, 'errorMsg'=>curl_error($curl)];
        }
        curl_close($curl);
        $output = json_decode($output, true);
        return ['state'=>1, 'errorMsg'=>'', 'data'=>$output];
    }
}