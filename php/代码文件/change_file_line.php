<?php

function searchDir($path, &$files){

    if(is_dir($path)){

        $opendir = opendir($path);

        while ($file = readdir($opendir)){
            if($file != '.' && $file != '..'){
                searchDir($path. DIRECTORY_SEPARATOR . $file, $files);
            }
        }
        closedir($opendir);
    }
    if(!is_dir($path)){
        $files[] = $path;
    }
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


$path = 'D:\vm\uco\demo\oms\src\Uco';

$searchAndReplace = [
	['use' => 'use TraitBarcode;', 'insert' => "use Mahone\Doctrine\Traits\Legacy\TraitBarcode;" . PHP_EOL, 'delete' => 'use Uco\OmsBundle\Entity\TraitBarcode;' ],
	
	['use' => 'use TraitBatchNumber;', 'insert' => "use Mahone\Doctrine\Traits\Legacy\TraitBatchNumber;" . PHP_EOL, 'delete' => 'use Uco\OmsBundle\Entity\TraitBatchNumber;' ],
	
	['use' => 'use TraitErrMsg;', 'insert' => "use Mahone\Doctrine\Traits\Legacy\TraitErrMsg;" . PHP_EOL, 'delete' => 'use Uco\OmsBundle\Entity\TraitErrMsg;' ],
	
	['use' => 'use TraitFlavor;', 'insert' => "use Mahone\Doctrine\Traits\Legacy\TraitFlavor;" . PHP_EOL, 'delete' => 'use Uco\OmsBundle\Entity\TraitFlavor;' ],
	
	['use' => 'use TraitBppMonitor;', 'insert' => "use Mahone\Doctrine\Traits\Legacy\TraitInOutMonitor;" . PHP_EOL, 'delete' => 'use Uco\OmsBundle\Entity\TraitBppMonitor;' ],
	
	['use' => 'use TraitIsDeleted;', 'insert' => "use Mahone\Doctrine\Traits\Legacy\TraitIsDeleted;" . PHP_EOL, 'delete' => 'use Uco\OmsBundle\Entity\TraitIsDeleted;' ],

	['use' => 'use TraitIsDeletedUseNegativeId;', 'insert' => "use Mahone\Doctrine\Traits\Legacy\TraitIsDeletedUseNegativeId;" . PHP_EOL, 'delete' => 'use Uco\OmsBundle\Entity\TraitIsDeletedUseNegativeId;' ],
	
	['use' => 'use TraitPlatformOrderId;', 'insert' => "use Mahone\Doctrine\Traits\Legacy\TraitPlatformOrderId;" . PHP_EOL, 'delete' => 'use Uco\OmsBundle\Entity\TraitPlatformOrderId;' ],

	['use' => 'use TraitProductCode;', 'insert' => "use Mahone\Doctrine\Traits\Legacy\TraitProductCode;" . PHP_EOL, 'delete' => 'use Uco\OmsBundle\Entity\TraitProductCode;' ],

	['use' => 'use TraitProductName;', 'insert' => "use Mahone\Doctrine\Traits\Legacy\TraitProductName;" . PHP_EOL, 'delete' => 'use Uco\OmsBundle\Entity\TraitProductName;' ],

	['use' => 'use TraitRepeatable;', 'insert' => "use Mahone\Doctrine\Traits\Legacy\TraitRepeatable;" . PHP_EOL, 'delete' => 'use Uco\OmsBundle\Entity\TraitRepeatable;' ],

	['use' => 'use TraitRepeatableWithErrMsg;', 'insert' => "use Mahone\Doctrine\Traits\Legacy\TraitRepeatableWithErrMsg;" . PHP_EOL, 'delete' => 'use Uco\OmsBundle\Entity\TraitRepeatableWithErrMsg;' ],
];


$f = [];
searchDir($path,$f);


foreach ($searchAndReplace as $key => $value) {
	echo $value['use'] . PHP_EOL;
	$n = 0;
	foreach ($f as $file) {
	    // 判断存在
	    if(preg_match( '/' . $value['use'] . '/i', file_get_contents($file))) {
	       	insertFile($file, 5, $value['insert']);
	       	$n ++;
	       	echo 'insert:' . $n . PHP_EOL;
	    }

	    delTargetLine($file, $value['delete']);
	}
}




#删除内容所在的某一行
function delTargetLine($filePath, $target) {
	$result = null;
	$fileCont = file_get_contents($filePath);
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