详细说明参考：https://woj.app/1439.html

对于本程序任何有关问题请移步至：https://woj.app/3177.html

此版本是默认版本，如果需要全模块(个人觉得默认就可以了，没必要用那么多乱七八糟的东西)请去土司，本人分享在土司论坛了。



【请看完所有的说明再按照步骤操作！】 -- 此版本为免费不含模块版本
程序默认管理员账号：admin
程序默认管理员密码：1234567
以上数据安装后可以在【个人设置】处修改，记得修改邮箱，涉及到超级管理后台发信测试。 

大家需要修改配置文件：config.php

大家还需要修改：authtest.php   把其中的【替换成你的域名】这几个字替换为你的域名例如：www.baidu.com  即可。注意结尾没有/ 开头也没有http//

大家还需要修改文件夹[程序总数据]里面的xss-MYSQL.sql 你需要替换【替换成你的域名】这几个字替换为你的域名例如：www.baidu.com  即可。注意结尾没有/开头也没有http//



程序默认首页是xss.php

如果你要是登录那地址就是： www.xxx.com/xss.php?do=login
(不要问为什么用xss.php 防止空间有俩程序跟别的冲突。可以修改，但是需要替换所有php文件里面的对应名称。)
最后就是伪静态规则已经设置好，后来项目源码处所看到的JS你自己访问一下(如果显示代码了)，那就没问题了。

【数据导入方法】
一般的空间都会带phpmyadmin (如果没有，你可以下载一个然后上传到你空间里面，然后访问你的网站www.xxx.com/phpmyadmin )   大家可以用这个工具导入数据库。。。如果不会。。

那就推荐 Navicat  通过这个工具也可以把数据导入到你的mysql数据库里面。

上面两种方法都特别简单，，，仁兄，，，这个说明已经详细的不能再详细了。。。（如果你弄不明白可以论坛回帖）

一、导入程序总数据  	(需要修改)

【※※※】注意模块都不导入，不影响程序使用！！！【※※※】
---------------------------------------------------------------------------------------------------------------


如果发现任何BUG，欢迎反馈，本人看到了会修复。  欢迎回帖留言BUG，或者去本人博客留言BUG。   http://woj.app/   (除BUG的问题，如果是功能性建议，请回帖留言)

更多问题参考：https://woj.app/3177.html  各种XSS平台问题锦集（如何让XSS平台支持HTTPS等等）
https://woj.app/2894.html   Xss平台详细使用教程


