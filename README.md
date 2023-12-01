# zikaoMP

# 项目部署

## 方案一： docker composer 部署

docker 的 windows 安装见： https://www.runoob.com/docker/windows-docker-install.html

已正确完成上述 docker 的安装之后，用命令行切换到项目目录下；执行命令：

```bash
docker compose -f docker/docker-compose.yml up -d
```

(如果是docker 较老的版本需要使用命令：docker-compose -f docker/docker-compose.yml up -d )

等到看到三个服务：`zikaoWeb`、`zikaoPhp`、`zikaoMysql` 全部启动即可。

接下来只需要访问 http://127.0.0.1:8080  即可 。

## 方案二：集成环境 WNMP 部署

WNMP 即： `windows` + `Nginx` + `Mysql` + `PHP` 

作为一个集成环境，其提供了很方便的部署方案，类似的 WNMP 部署项目可以查看文档：https://blog.csdn.net/x506812022/article/details/126730779

其中不同的是我们的网站根目录在：web/

php 版本为7.3

nginx的配置中，请参考（或者直接复制粘贴进去）docker/nginx/default.conf

特别注意：必须存在配置：

```nginx
location / {
    try_files $uri $uri/ /index.php?$query_string;
}
```

该配置主要作用在于：屏蔽路由中的 index.php。如果没有该配置可能会导致路由匹配失败


完成了项目部署之后，我们一起来看项目配置吧！

# 项目配置

项目中所有的配置都在 config 目录下

其中 config目录下的 mysql.config.php 文件中的有配置如下：
````php
<?php
return [
    'servername' => '127.0.0.1', // 数据库服务地址（如果是docker 部署 那这个值为 zikaoMysql）
    'username' => 'root', // 数据库用户
    'password' => '123456', // 数据库密码
    'dbname' => 'zikaoMP', // 数据库名称
];
````

以上配置根据实际项目运行情况配置。

# 数据表的建立

以上都配置完成，服务正常启动之后，这是我们并不能直接使用系统，因为数据表并没有建立。

建立数据表很简单，项目中已经写好了一套数据库迁移的脚本，直接命令行切换到项目目录下运行命令即可：

```shell
php migration_script.php
```

运行之后，在输出中查看到`SUCCESS` 时，即数据表建立成功。

这时可以使用账号：admin 密码：admin123 登录管理员用户

（初始化用户在存储过程中建立，具体逻辑在文件：sql/procedure/InitializeUserTable.sql中，文档之中也有提到）

如果本地无法执行命令，或者未安装 php-cli 也可以直接使用sql 下面的所有.sql文件去数据库中执行执行

# 项目说明

## 项目文件

项目设计在文档内有详细说明，这里只对项目路径做一个简单概括。

1. web 目录为项目入口文件统一配置目录。web 目录存在两个文件：index.php 与 phpinfo.php
    其中index.php 为项目的单一入口，配置网站时，使用该文件。
    phpinfo.php 文件为环境配置查看页面，部署好的项目访问： http://you_domain/phpinfo.php 可以查看当前服务配置
2. config 目录为项目配置目录，详见以上项目配置
3. docker 目录为项目提供容器化部署目录，详见以上项目部署
4. logs 目录为一些系统日志目录，目前主要用于答应一些错误的sql语句
5. public 下的 View 目录为项目的视图，主要存放于各种静态页面，详细设计见文档的 `View视图` 章节
6. sql 目录为项目存放所有初始化数据库的目录，其中所有的脚本都可以随时运行。主要用于环境搭建与数据库迁移使用
7. src 目录为项目的逻辑目录, 以下会有详细说明
8. build-test-data.php 作为生成测试数据的脚本，使用Faker库生成中文用户名
9. composer.json 与 composer.lock 作为 composer 版本控制
10. migration_script.php 作为数据库的迁移脚本，主要作用于初始化数据表。详见上数据表的建立与文档中`数据迁移章节`

### src 逻辑目录

src 目录中都为项目运行的核心目录。所有关于逻辑的处理都在该目录。

Controllers 目录主要用于逻辑的处理与调用 View 视图与 Model 数据库模型，祥见文档中的 `Controller控制器` 章节

Model 目录主要操作数据库。设计详见文档 Model模型层

Kernel 目录主要用于处理一些核心内容，比如引入公共方法的 function.php。数据库单例模式的 MysqlSingleton.php（详见文档中Model模型层的`数据库单例设计`章节）。

App.php 作为处理项目所有请求的核心文件，其主要做了两件事：路由匹配与登录验证逻辑，祥见文档中的`项目设计`章节