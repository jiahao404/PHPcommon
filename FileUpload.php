<?php

class FileUpload {
  /**
   * 需要事先在项目可访问跟目录下创建upload文件夹，并开放最大权限
   */
  public function fileUpload(){
    $DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];  #获取当前项目的根目录
    $type = ['image/gif', 'image/jpeg', 'text/plain'];  #定义文件上传的类型
    if($_FILES['file']['error'] > 0){
      return ['state'=>0, 'notice'=>'文件上传失败，请重试！'];
    }
    if($_FILES['file']['size'] >= 100 * 1024){  #定义文件上传大小，100k
      return ['state'=>0, 'notice'=>'文件过大！'];
    }
    if(in_array($_FILES['file']['type'], $type)){
      $suffix = explode('.', $_FILES['file']['name'])[1];
      $name = time();
      $tmp_name = $_FILES['file']['tmp_name'];
      $dir = $DOCUMENT_ROOT . '/upload';
      $path = $dir . '/' . $name . '.' . $suffix;
      move_uploaded_file($tmp_name, $path);
      return ['state'=>1, 'data'=>$path];
    }
    else{
      return ['state'=>0, 'notice'=>'上传格式错误！'];
    }
  }
}




# html的两种文件上传方式

// <form action="/testFileUpload" method="post" enctype="multipart/form-data">
//         <input type="file" name="file" />
//         <input type="text" name="time" />
//         <input type="submit" value="上传文件" />
//     </form>


// <div>
//     <input type="file" id="file" name="file" />
//     <input type="button" onclick="upload()" value="上传文件"></input>
// </div>
// <script>
//     function upload(){
//         var formData = new FormData();
//         formData.append('fileefwew',$('#file')[0].files[0]);
//         formData.append('time','23534654');
//         $.ajax({
//             url: "/testFileUpload",
//             type: "POST",
//             data: formData,
//             processData: false,  // 告诉jQuery不要去处理发送的数据
//             contentType: false,   // 告诉jQuery不要去设置Content-Type请求头
//             success: function(res_data){
//                 console.log(res_data)
//             }

//         });
//     }
// </script>