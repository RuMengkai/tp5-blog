### 起源
博客源于廖雪峰老师的[python3教程](http://www.liaoxuefeng.com/wiki/0014316089557264a6b348958f449949df42a6d3a2e542c000)最后的实战项目。

目前UI部分还保留了原来的样式，其余部分都已重写。前端用vue重写成单页，后端也用thinkphp5重写。

### 主要功能
本地注册登录、第三方登录、发表博客、评论

### 开发

```
$ git clone https://github.com/xwlyy/tp5-blog.git
$ cd tp5-blog
$ composer install
```

### 多站点配置
我用的是ubuntu kylin16.04，这里主要讲下LAMP环境下的多站点配置，WAMP的相关配置还请自行百度或谷歌。
```
$ cd /etc/apache2/sites-available         #进入站点配置目录下
$ sudo cp 000-default.conf tp5-blog.conf  #复制默认配置文件到tp5-blog.conf
$ sudo vim tp5-blog.conf                  #编辑刚才创建的tp5-blog.conf
```
将`DocumentRoot`后面的路径改成tp5-blog的路径

在`DocumentRoot`下面添加一行`ServerName tp5-blog.com`

在`ServerName tp5-blog.com`下面添加如下代码
```
    <Directory /home/djq/www/tp5-blog/public>
                Options Indexes FollowSymLinks MultiViews
                AllowOverride All
                Order allow,deny  
                allow from all  
    </Directory>

```
`/home/djq/www/tp5-blog/public`是我自己的项目目录，你需要改成你自己的。

修改`ErrorLog`和`CustomLog`，把目录都改成自己项目对应的目录
```
ErrorLog /home/djq/www/admin/error.log
CustomLog /home/djq/www/admin/access.log combined

```
保存后退出，然后
```
$ cd ../sites-enabled
$ sudo ln -s ../sites-available/tp5-blog.conf .
$ sudo systemctl restart apache2
$ sudo vim /etc/hosts
```
在hosts文件中添加一行`127.0.0.1   tp5-blog.com`，保存退出

这样就能在浏览器中通过`tp5-blog.com`访问项目了。
