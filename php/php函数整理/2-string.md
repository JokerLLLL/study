## 类型判断 ##

```php
	is_bool()       //判断是否为布尔型
	is_float()      //判断是否为浮点型
	is_real()       //同上
	is_int()        //判断是否为整型
	is_integer()    //同上
	is_string()     //判断是否为字符串
	is_object()     //判断是否为对象
	is_array()      //判断是否为数组
	is_null()       //判断是否为null
	is_file()       //判断是否为文件
	is_dir()        //判断是否为目录
	is_numeric()    //判断是否为数字
	is_nan()        //判断不是数字
	is_resource()   //判断是否为资源类型
	is_a($obj,$classname) //判断对象是否为类的实例
						  //可用 if($obj instanceof Classname)
```

## 子串

- 获取子串位置

```php
	
	strpos($hs,$nd [,int $offset = 0 ]) //返回nd 在 hs 中首次出现的数字位置。 
	stripos($hs,$nd [,int $offset = 0 ]) //返回nd 在 hs 中首次出现的数字位置, 不区分大小写。
	strrpos($hs,$nd [,int $offset = 0 ]) //返回nd 在 hs 中最后一次出现的数字位置。
	strripos($hs,$nd [,int $offset = 0 ]) //返回nd 在 hs 中最后一次出现的数字位置,不区分大小写
```

- 获取子串

```php

	substr($str,$start [,$length]); //获取子串
	
	substr_compare($main_str,$str,$offset[,$length]); //子串比较 从offset处开始比较
	
	substr_count($hs,$nd [,$offset=0 [,$length]]); //获取子串nd在hs中出现的次数
	
	substr_replace($string,$replacement,$start [,$length]); //字符串子串替换
	//用$replacement替换掉$string从start开始长度为length的子串
	
	strstr($hys,$nd [,bool $before_needle = false ]);
	//返回$nd在$hys 第一次出现的地方开始到字符串结束 为止的字符串
	//第三个参数如果为true 则返回$nd 之前的字符串
	
	stristr($hys,$nd [,bool $before_needle = false ]); //同上，忽略大小写版本
	
	strrchr($hys,$nd); //返回$nd在$hys最后一次出现的地方开始到字符串结束 为止的字符
	//一般和 substr(strrchr($hys,$nd),strlen($nd)); 合用
	
	strpbrk($haystack,$char_list);//从$char_list中依次匹配单个字符在$haystack中第一次出现的地方
	//到字符串结束的地方 的整个字符串

	strtok($str,$token); //第一次使用 将字符串按分隔符$token进行分割
	strtok($token);      //第二次使用
		eg.
		$string = "This is\tan example\nstring";
		/* 使用制表符和换行符作为分界符 */
		$tok = strtok($string, " \n\t");

		while ($tok !== false) {
			echo "Word=$tok<br />";
			$tok = strtok(" \n\t");
		}
```

## str_型

```php

str_getcsv($str); //将csv文件字符串转换成一个数组

str_replace($search,$replace,$subject [,&$count]);//搜索并替换字符串
//第四个参数被指定的话，将会赋值给他替换的次数

str_ireplace($search,$replace,$subject [,&$count]);//搜索并替换字符串
//第四个参数被指定的话，将会赋值给他替换的次数 忽略大小写

str_shuffle(string $str);//随机打乱字符串

str_split($str [,$len=1]);//将字符串转换成一个数组
//，每个数组单元的长度为$len

```

## mb_型

mb_类型字符串与上述字符串函数基本一样，
只是加多一个可选的字符编码参数，用法同上
这里列出一些其他有用函数，使用时最好传入 utf8。
```php
	mb_strlen($str,'uft8');
```


## 基本的str

```php

strlen($str);  //字符串长度

strrev(string $string);// 翻转字符串


strval($str); //转换成字符串类型
floatval($str);//转换成浮点型
intval($str); //转换成整型


strtolower($str); //全部转换成小写
strtoupper($str); //全部转换成大写

strip_tags($str [,$tags]);//去除不含$tags里标签外的所有标签


chr(int $ascii); //数字转换成ascii
ord(string $str); //返回$str第一个字符的ascii值

json_encode($obj/$arr/$str...);//编码成json 格式的字符串
json_decode($jsonstr [,$assoc=true]); //解码成对象

nl2br($str); //字符串 $str 所有新行之前插入'<br/>'


implode($arr,$glue);//将一维数组转换为字符串
explode();//字符串转换为数组


trim(string $str [,string $charlist ]); //去左右字符
ltrim(string $str [,string $charlist ]); //去左字符
rtrim(string $str [,string $charlist ]); //去右字符


sha1($str); //散列
md5($str);

```

