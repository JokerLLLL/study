UAC 管理 regedit  注册表位置
计算机\HKEY_CURRENT_USER\Software\Microsoft\Windows NT\CurrentVersion\AppCompatFlags\Layers


## xshell 破解

https://www.cnblogs.com/soymilk2019/p/11769840.html

## xsftp

https://blog.csdn.net/jiang948/article/details/111173686

XFTP6 要继续使用此程序，您必须应用最新的更新或使用新版本
打开nslicense.dll文件，比如路径 D:\Program Files\NetSarang\Xftp 6\nslicense.dll
ctrl+f，查找7F0C 81F9 8033 E101，将紧随其后的0F86，改为0F83，文件另存为。
把原来的文件备份好，替换成新文件。
重新双击打开xftp6即可。


## windows定时脚步

控制面板>管理工具>计算机管理>任务计划程序

新建>触发器>运行.bat程序
```bat
"D:\wamp\bin\php\php7.2.17\php.exe" -f "D:\demo\zhsSign\auto.php"
```

