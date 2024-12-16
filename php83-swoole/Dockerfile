# 使用 php:8.3-cli-alpine 作为基础镜像
FROM php:8.3-cli

# 安装构建工具和其他依赖
RUN apt-get update && apt-get install -y \
    libbrotli-dev \
    && rm -rf /var/cache/apk/*

# 安装 swoole 扩展
RUN pecl install swoole-5.1.6 \
    && echo "extension=swoole.so" > /usr/local/etc/php/conf.d/swoole.ini

# 启用 swoole 扩展
RUN pecl install redis \
    && echo "extension=redis.so" > /usr/local/etc/php/conf.d/redis.ini

# 其他扩展
RUN docker-php-ext-install pcntl

# 设置工作目录
WORKDIR /var/www

