# webci
bash on 3.1.0
codeigniter3.1框架学习,用于app webservice 和 web 端

尽量区分 `system` 和 `application` 两大块，属于 system 的功能就尽量在 system 下进行，不再 application 下扩展，保证两大块相对简洁和独立。

以下列出修改内容：

>1

修改目录 system 为 `sys`
修改目录 application 为 `app`

------------------------------------------------------

>2

删除所有目录下的 `index.html` 和 `.htaccess`，要防止用户访问相关文件，手段有很多，但极力不喜欢用index.html 和 .htaccess这种方式，使得目录下无端端多了很多冗余，对于有简洁
洁癖的我来接受不了

------------------------------------------------------

>3

app/views 目录移到app相同目录结构下，允许用户之间访问view目录

------------------------------------------------------

>4

添加service层，把本来的MVC模式 改为现在的 SMVC模式。


	sys/core/Service.php
	app/services/*_service.php


随着业务越来越复杂，controller越来越臃肿，举一个简单的例子，比如说用户下订单，这必然会有一系列的操作：更新购物车、添加订单记录、会员添加积分等等，且下订单的过程可能在多种场景出现，
如果这样的代码放controller中则很臃肿难以复用，如果放model会让持久层和业务层耦合。很多人将一些业务逻辑写到model中去了，model中又调其它model，也就是业务层和持久层相互耦合。
这是极其不合理的，会让model难以维护，且方法难以复用。

可以考虑在controller和model中加一个业务层service，由它来负责业务逻辑，封装好的调用接口可以被controller复用。这样各层的任务就明确了：

`Model`: 数据持久层的工作，对数据库的操作都封装在这。

`Service`: 业务逻辑层，负责业务模块的逻辑应用设计，controller中就可以调用service的接口实现业务逻辑处理，提高了通用的业务逻辑的复用性，设计到具体业务实现会调用Model的接口。

`Controller`: 控制层，负责具体业务流程控制，这里调用service层，将数据返回到视图

`View`: 负责前端页面展示，与Controller紧密联系。

------------------------------------------------------


nginx简单配置

server {
    listen 80;
    server_name localhost;
    root /data/ci/web;
    index index.html index.php index.htm;
    
    location / {
        try_files $uri $uri/ /index.php;
    }

    location ~ .php$ {
        try_files $uri = 404;
        include fastcgi_params;
        fastcgi_pass unix:/var/run/php5-fpm.sock;
    }

}
