### HTML 超文本标记语言

1993年 1.0发布

### 元素
<p align="left">左对齐</p>
<p align="right">右对齐</p>
<p align="center">中间</p>
<p align="justify">证明</p>
<del>删除</del>
<sup>上</sup><sub>下</sub>

### 列表

<ul type="circle"><li>列表1</li></ul>
<ul type="disc"><li>列表2</li></ul>
<ul type="square"><li>列表3</li></ul>

<ol type="1"><li>test</li><li>test</li></ol>
<ol type="a"><li>test</li><li>test</li></ol>
<ol type="I"><li>test</li><li>test</li></ol>

<dl>
    <dt>标题</dt>
    <dd>列表1</dd>
    <dd>列表2</dd>    
    <dd>列表3</dd>
</dl>


### 图片与连接

<img src="///0002020.jpeg" alt="alt显示" width="=100px" height="50px">

<a href="">本地连接</a>
<a href="" target="_blank" name="name">地址连接</a>


### 表格


<table border="6" width="1000px" bgcolor="#555555">
    <caption>表格标题</caption>
     <thead><tr>
        <th>title1</th>
        <th>title2</th>
        <th>title3</th>
     </tr>
     <tr> 
           <td>aaa</td>
           <td>aaa</td>
           <td>aaa</td>
      </tr></thead>
        <tbody><tr>
           <td>aaa</td>
           <td>aaa</td>
           <td>aaa</td>
        </tr>
        <tr>
          <td>aaa</td>
           <td>aaa</td>
           <td>aaa</td>
        </tr></tbody>
        <tfoot><tr>
           <td>aaa</td>
           <td>aaa</td>
           <td>aaa</td>
        </tr></tfoot>
</table>

## css选择器


##### 标签选择器
h1{
    
}
div{
    
}

##### 类选择器
.class{
    
}
h1.class{
    
}

##### id选择器
#id{
    
}

##### 群体选择器

p,span,div{
    
}

##### 后代选择器

p em{
    
}


## 伪类

```text
:link    未访问
:visited 以防访问
:hover  鼠标在行
:active  点击后

执行顺序 否则无效
link > visited > hover > active
```

## 继承 和 层叠

## 优先级

内行样式 > 内部样式 > 外部样式


## font字体 默认(16px)
font-size:
(绝对单位)
in 1英寸 = 2.54cm
cm 厘米
mm 毫秒
pt 72磅 = 1 英寸
pc 1pc = 12磅

(相对大小)
px 像素
em 
% 百分比

```css

 text-align 块级元素文本对齐

 vertical-align:sub|super|top|百分比  行内元素垂直对齐(对行内元素和单元格起作用)
 
 
 /* 块级元素中上下居中 */
 display:table;
 display:table-cell;vertical-align:middle;
 
 
 text-align:块级文本
 vertical-algin:行内垂直对齐
 
 line-height:行间距
 word-spacing:单词间距
 letter-spacing:字母间距
 
 下划线
 text-decoratino:overline|underline|none


```

# css列表 背景图片

background-color:#333333; 背景色
background-image:url(abc.jpeg);背景图
background-position:百分比|xy|left|right|...
background-attachment：fix; 固定不动
bakcground-repeat:no-repat; 不重复
background


list-style-type:none|decimal|lower-alpha|circle
list-style-image:url('img.png');
list-style-position
list-style



rgb(0,0,0,0) == transparent


### 盒子模型

width max-width min-width
height max-height min-width

border-with:thin;
border-color:
border-style:solid|dotted;


display:

inline;变成内联元素
block; 变成块级元素
inline-block; 同时具有内联和块级特性
none; 不被展示

去盒化:
```html

<style>
    .inline p{
        display:inline;
        font-size:10px;
    }
</style>

<div class="inline" style="font-size:0">
    <p>test1</p>
    <p>test2</p>
    <p>test3</p>
</div>

```


### 浮动 float

浮动：脱离了标致流 变成浮动块 但依然占据文本流的文本空间

造成父元素塌陷 而兄弟元素错位被覆盖
float:left;

### 清除浮动
clear：left|right|both; //跳过左右边的浮动对象

一个块元素左右含有float元素的可以使用clear属性

eg：
clear:left; 左边不会有float块;
clear:both; 左右都不有float块


### 父元素属性

overfloat: 对子元素超出的部分进行hidden 或 auto 


overfloat:hidden; //清除异常的块
zoom:1;

float:left; //父元素也浮动 兄弟元素清除浮动
clear:both; 

:before 伪类清除浮动


### positon 位置

标准流：

div ol ul il table p 块级元素 独占一行

a img span input 内联元素 可同站一行


定位流：

//关联的left top bottom right进行定位
postion:relative; 
left:100px
top:100px 

//绝对定位
postions:absolute;


//固定定位 (相对)
postions:fixed;

### 所有定位元素都有层级  z-index依赖定位属性

z-index大的元素会覆盖z-index小的元素

z-index auto元素不参与层级比较
z-index为负数 被普通流元素覆盖

父元素的z-index 比其他大 则 子元素的z-index无论多小都比其他的大 先继承父元素的z-index进行比较 在比较同时子元素的z-index


## 居中原理

//居中块实例
.div{
    width:360px;
    height:360px;
    backround:red;
    position:fixed;
    margin-top:-180px;
    margin-left:-180px;
}


