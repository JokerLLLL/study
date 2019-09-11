## 文件

file_put_contents('abc','test');
file_put_contents('test.txt', 'testest', FILE_APPEND);

## 后缀名获取
 $ext=strtolower(pathinfo($filename,PATHINFO_EXTENSION));//获取后缀名在小写化付给变量
  if(!in_array($ext,$file_ext)){  //判断文件后缀名在  file_ext  里吗
    return false;
 }