# 使用官方 PHP 镜像作为基础镜像
FROM php:7.4-fpm

# 安装系统依赖
RUN apt-get update && apt-get install -y \
    nginx \
    vim \
    git \
    && rm -rf /var/lib/apt/lists/*

# 设置工作目录
WORKDIR /var/www/html

# 复制项目文件到容器
COPY . /var/www/html

# 安装 Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# 安装项目依赖
RUN composer install --no-dev --optimize-autoloader

# 安装 MySQL 客户端
RUN apt-get update && apt-get install -y default-mysql-client

# 配置 Nginx
COPY nginx/default.conf /etc/nginx/sites-available/default

# 启动服务
CMD ["nginx", "-g", "daemon off;"]
