<?php 

require('log.php');

// ignore_user_abort(TRUE);// 设定关闭浏览器也执行程序
// set_time_limit(0);      // 设定响应时间不限制，默认为30秒
 
$count = 0;
while (TRUE)
{
    sleep(10);           // 每5秒钟执行一次
 
    // 写文件操作开始
    $fp = fopen("test".$count.".txt", "w");
    if($fp)
    {
        for($i=0; $i<5; $i++)
        {
            $flag=fwrite($fp,$i."这里是文件内容www.xxtime.comrn");
            if(!$flag)
            {
                echo "写入文件失败";
                break;
            }
        }
    }
    fclose($fp);
    // 写文件操作结束
 
    $count++;
    // 设定定时任务终止条件
    if (file_exists('lock.txt'))
    {
        break;
    }
}