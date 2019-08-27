
## 数组的基本操作 ##

- 键值和键名的操作

`array_values($arr);` 获得数组的值

`array_keys($arr);` 获得数组的键名

`array_flip($arr);` 数组中的值与键名互换（如果有重复前面的会被后面的覆盖）

`in_array("apple",$arr);`  在数组中检索apple

`array_search("apple",$arr);` 在数组中检索apple ，如果存在返回键名

`array_key_exists("apple",$arr);` 检索给定的键名是否存在数组中

`isset($arr[apple]): `检索给定的键名是否存在数组中

- 数组指针操作

`current($arr);` 返回数组中的当前单元

`pos($arr);` current别名

`key($arr);` 返回数组中当前单元的键名

`next($arr);` 将数组中的内部指针向前移动一位，并将单元返回，没有单元返回false

`prev($arr);` 将数组中的内部指针倒回一位，并将单元返回，没有单元返回false

`end($arr);` 指针移到最后，返回最后一个元素的值，或者如果是空数组则返回false。

`reset($arr);` 指针移到最前，返回第一个元素的值，或者如果是空数组则返回false。

`each($arr);` 将返回数组当前元素的一个键名/值的构造数组，并使数组指针向前移动一位

`list($key,$value)=each($arr);` 获得数组当前元素的键名和值

- 变量和数组

`extract($arr);` 用于把数组中的元素转换成变量导入到当前文件中，键名当作变量名，值作为变量值
`compact(var1,var2,var3);` 用给定的变量名创建一个数组

## 数组的分段和填充 ##

`array_slice($arr,0,3);` 可以将数组中的一段取出，截取出来的保留键名

`array_splice($arr,0,3，array("black","maroon"));` 可以将数组中的一段取出，与上个函数不同在于返回的序列从原数组中删除，之后由第四个参数代替。 （array是引用传参）

`array_chunk($arr,3,TRUE);` 可以将一个数组分割成多个，TRUE为保留原数组的键名

`array_pad($arr,5,'x');` 将一个数组填补到指定长度，第三个是填充值

`range(0,100,2);` 以2为步长，形成数组


## 数组队列（array是引用传参）

`array_push($arr,"apple","pear");` 将一个或多个元素压入数组栈的末尾（入栈），返回入栈元素的个数

`array_pop($arr);` 将数组栈的最后一个元素弹出（出栈）

`array_shift($arr);`  数组中的第一个元素移出并作为结果返回（数组长度减1，其他元素向前移动一位，数字键名改为从零技术，文字键名不变）

`array_unshift($arr,"a",array(1,2));`  在数组的开头插入一个或多个元素

## 数组的回调函数 ##

`array_walk($arr,'function_name','words');` 使用用户函数对数组中的每个成员进行处理（第三个参数传递给回调函数function_name($value,$key,$words)） （array是引用传参）

`array_map("function",$arr1,$arr2);` 对数组的每个元素处理，处理后返回给原值，可以处理多个数组（当使用两个或更多数组时，他们的长度应该相同）（返回值）

`array_filter($arr,"function");`  使用回调函数过滤数组中的每个元素，如果回调函数为TRUE，数组的当前元素会被包含在返回的结果数组中，数组的键名保留不变。 （返回值）

`array_reduce($arr,"function","*");` 将回调函数 function($carry,$item）迭代地作用到 array 数组中的每一个单元中，从而将数组简化为单一的值（*为数组的第一个carry值 或 数组为空时的输出值）

## 数组排序  （array是引用传参）

`sort($arr);` 由小到大的顺序排序（第二个参数为按什么方式排序）忽略键名的数组排序

`rsort($arr);` 由大到小的顺序排序（第二个参数为按什么方式排序）忽略键名的数组排序

`usort($arr,"function");` 使用用户自定义的比较函数对数组中的值进行排序（function中有两个参数，0表示相等，正数表示第一个大于第二个，负数表示第一个小于第二个）忽略键名的数组排序

`asort($arr);` 由小到大的顺序排序（第二个参数为按什么方式排序）保留键名的数组排序

`arsort($arr);` 由大到小的顺序排序（第二个参数为按什么方式排序）保留键名的数组排序

`uasort($arr,"function");` 使用用户自定义的比较函数对数组中的值进行排序（function中有两个参数，0表示相等，正数表示第一个大于第二个，负数表示第一个小于第二个）保留键名的数组排序


`ksort($arr);` 按照键名正序排序

`krsort($arr);` 按照键名逆序排序

`uksort($arr,"function");` 使用用户自定义的比较函数对数组中的键名进行排序（function中有两个参数，0表示相等，正数表示第一个大于第二个，负数表示第一个小于第二个）

`shuffle($arr);` 将数组的顺序打乱


## 数组的计算 ##

`count($arr);`  数组大小

`array_sum($arr);` 对数组内部的所有元素做求和运算

`array_merge($arr1,$arr2);` 相同健名，数字键名追加，字符键名覆盖。

`$arr1+$arr2` 相同健名，保留前面健名，舍弃后者。

`array_merge_recursive($arr1,$arr2);`  递归合并操作，如果数组中有相同的字符串键名，这些值将被合并到一个数组中去。如果一个值本身是一个数组，将按照相应的键名把它合并为另一个数组。当数组 具有相同的数组键名时，后一个值将不会覆盖原来的值，而是附加到后面

`array_diff($arr1,$arr2);` 返回差集结果，返回没在arr2中的arr1的元素

`array_diff_assoc($arr1,$arr2);`  返回差集结果数组，键名也做比较

`array_intersect($arr1,$arr2);` 返回交集结果数组，arr1 和 arra2 都有的元素

`array_intersect_assoc($arr1,$arr2);` 返回交集结果数组，键名也做比较

`array_intersect_key` 返回健名的交际、

# 其他数组函数 #

`array_unique($arr);` 移除数组中重复的值，新的数组中会保留原始的键名

`array_rand($arr,2);` 从数组中随机取出一个或 多个元素