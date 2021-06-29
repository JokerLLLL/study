<?php
/**
 * Created by PhpStorm.
 * User: JokerL
 * Date: 2019/9/11
 * Time: 22:33
 */

// 重置文件夹 （系统函数）
$f = function($path){
    if(empty($path))
        throw new OmsException('path not exist: ' . $path);
    $cmd = 'rm -rf ' . $path;
    shell_exec($cmd);
    mkdir($path, 0777, true);
};

/**
 * 递归读取文件
 * @param $path
 * @param array $files
 */
function  readFiles($path, array &$files = []) {
    if(is_dir($path)) {
        $handle = opendir($path);
        while (false !== ($item = readdir($handle))) {
            if($item!='.'&&$item!='..'){
                $newPath = $path . DIRECTORY_SEPARATOR . $item;
                readFiles($newPath, $files);
            }
        }
        closedir($handle);
    }
    if(is_file($path)) {
        $files[] = $path;
    }
    return;
}
//$file = [];
//readFiles('D:\demo\html', $file);
//var_dump($file);


/*
下载大文件函数   down_file_big
输入值:文件名 可以指定下载类型
返回值:文件或false
*/
function downFileBig(string $filename,array $file_ext=array('jpeg','jpg','txt','rar','zip','png','gif')){
    if(!file_exists($filename)||!is_readable($filename)){//判断文件存在否或不可读
        return false;
    }
    $ext=strtolower(pathinfo($filename,PATHINFO_EXTENSION));//获取后缀名在小写化付给变量
    if(!in_array($ext,$file_ext)){  //判断文件后缀名在  file_ext  里吗
        return false;
    }
//通过header头发送信息
//告诉浏览器输出的是字节流
    header('content-type:application/octet-stream');

//告诉浏览器文件大小以字节进行计算
    header('Accept-Ranges:bytes');

//告诉浏览器文件大小
    header('Accept-Length:'.filesize($filename));

//告诉浏览器以附件形式处理 并赋予名称
    header('content-disposition:attachment;filename=666'.$filename);

//大文件需要切片下载 每次读文件为  1024字节读取 读取后直接输出数据
    $read_buffer=1024;
    $handle=fopen($filename,'rb');//!!!!!!!!!!fopen(  $filename , $path  )
    $sum='';
    while(!feof($handle)&&$sum<filesize($filename)){//通过指针和文件读取大小判断位置 循环条件
        echo fread($handle,$read_buffer);//每次读取1024
        $sum+=$read_buffer;//累计读取量
    }
    fclose($handle);//关闭资源
    exit;
}


/**
 * 单行读取成数组
 * @param $txtfile
 * @return array|string
 */
function getFileByLine($txtfile)
{
    $handle = @fopen($txtfile, 'r');
    $content = array();
    if ( ! $handle) {
        return 'file open fail';
    } else {
        $i = 0;
        while ( ! feof($handle)) {
            $content[] = fgets($handle);
        }
        fclose($handle);
    }
    return $content;
}

/**
 * 第几行插入 内容
 * @param $file
 * @param $line
 * @param $string
 */
function insertFile($file, $line, $string) {
    $contentLines = getFileByLine($file);
    $fp = fopen($file, 'w');
    foreach ($contentLines as $key => $content) {
        if($key == $line) {
            fwrite($fp, $string);
        }
        fwrite($fp, $content);
    }
    if(count($contentLines) < $line) {
        fwrite($fp, $string);
    }
    fclose($fp);
}

//$file = 'D:\demo\test\dom.html';
//
//insertFile($file, 3, 'hellooooooooooworld!!!!' . PHP_EOL);



#替换指定字符串
function replaceTarget($filePath, $replaceCont, $target)
{
    $result = null;
    $fileCont = file_get_contents($filePath);
    $targetIndex = strpos($fileCont, $target); #查找目标字符串的坐标

    if ($targetIndex !== false) {
        #找到target的前一个换行符
        $preChLineIndex = strrpos(substr($fileCont, 0, $targetIndex + 1), "\n");
        #找到target的后一个换行符
        $AfterChLineIndex = strpos(substr($fileCont, $targetIndex), "\n") + $targetIndex;
        if ($preChLineIndex !== false && $AfterChLineIndex !== false) {
            #删掉指定行，插入新内容
            $result = substr($fileCont, 0, $preChLineIndex + 1) . $replaceCont . "\n" . substr($fileCont, $AfterChLineIndex + 1);
            file_put_contents($filePath, $result);
            //$fp = fopen($filePath, "w+");
            //fwrite($fp, $result);
            //fclose($fp);
        }
    }
}
$ss = "ds\n fdafadsf";
var_dump(strrpos($ss, "\n"));
var_dump(substr($ss, 0, 2 + 1));


#删除内容所在的某一行
function delTargetLine($filePath, $target) {
    $result      = null;
    $fileCont    = file_get_contents($filePath);
    $targetIndex = strpos($fileCont, $target); #查找目标字符串的坐标

    if ($targetIndex !== false) {
        #找到target的前一个换行符
        $preChLineIndex = strrpos(substr($fileCont, 0, $targetIndex + 1), "\n");
        #找到target的后一个换行符
        $AfterChLineIndex = strpos(substr($fileCont, $targetIndex), "\n") + $targetIndex;
        if ($preChLineIndex !== false && $AfterChLineIndex !== false) {
            #重新写入删掉指定行后的内容
            $result = substr($fileCont, 0, $preChLineIndex + 1) . substr($fileCont, $AfterChLineIndex + 1);
            file_put_contents($filePath, $result);
        }
    }
}

##文件暂存内存 后续flush到db
function flushMemoryToHD()
{
    $dataList = [];
    $dataList[] = [
        'a' => 'test',
        'b' => 'test2',
        'c' => 'test3',
        'd' => 'test4',
    ];
    $dataList[] = [
        'a' => 'xxx',
        'b' => 'xxx',
        'c' => 'xxx',
        'd' => 'xxx',
    ];
    $memoryLimit = 5 * 1024 * 1024; //以字节为单位、保留在内存的最大数据量，超过则使用临时文件。
    $fp          = fopen("php://temp/maxmemory:$memoryLimit", 'r+');
    if (false === $fp) {
        throw new Exception(sprintf('[%s] fopen php://temp failed', __METHOD__));
    }
    fputcsv($fp, array_keys($dataList[0])); //写入文件列名
    foreach ($dataList as $fields) {
        fputcsv($fp, $fields);
    }
    rewind($fp);
    $content = stream_get_contents($fp);
    fclose($fp);
    var_dump($content);
    file_put_contents('./q.scv', $content);

}

