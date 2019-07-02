<?php 
header("Content-Type:text/html;charset=utf-8");
$apikey = "b5cd*************17e6"; //修改为您的apikey(https://www.yunpian.com)登录官网后获取
$mobile = "18*****24"; //请用自己的手机号代替
$text="【云片网】您的验证码是1234";
$ch = curl_init();

/* 设置验证方式 */
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept:text/plain;charset=utf-8',
    'Content-Type:application/x-www-form-urlencoded', 'charset=utf-8'));
/* 设置返回结果为流 */
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

/* 设置超时时间*/
curl_setopt($ch, CURLOPT_TIMEOUT, 10);

/* 设置通信方式 */
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

// 取得用户信息
$json_data = get_user($ch,$apikey);
$array = json_decode($json_data,true);
echo '<pre>';print_r($array);

// 发送短信
$data=array('text'=>$text,'apikey'=>$apikey,'mobile'=>$mobile);
$json_data = send($ch,$data);
$array = json_decode($json_data,true);
echo '<pre>';print_r($array);

function get_user($ch,$apikey){
    curl_setopt ($ch, CURLOPT_URL, 'https://sms.yunpian.com/v2/user/get.json');
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('apikey' => $apikey)));
    $result = curl_exec($ch);
    $error = curl_error($ch);
    checkErr($result,$error);
    return $result;
}

function send($ch,$data){
    curl_setopt ($ch, CURLOPT_URL, 'https://sms.yunpian.com/v2/sms/single_send.json');
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    $result = curl_exec($ch);
    $error = curl_error($ch);
    checkErr($result,$error);
    return $result;
}

function checkErr($result,$error) {
    if($result === false)
    {
        echo 'Curl error: ' . $error;
    }
    else
    {
        //echo '操作完成没有任何错误';
    }
}

/*打印内容
<pre>Array
(
    [nick] => 王先生
    [gmt_created] => 2018-11-16 14:36:53
    [mobile] => 18367170624
    [email] => 
    [ip_whitelist] => 
    [api_version] => v2
    [alarm_balance] => 0
    [emergency_contact] => 
    [emergency_mobile] => 
    [balance] => 0.5
)
<pre>Array
(
    [code] => 0
    [msg] => 发送成功
    [count] => 1
    [fee] => 0.05
    [unit] => RMB
    [mobile] => 18367170624
    [sid] => 32518444096
)
 */

?>