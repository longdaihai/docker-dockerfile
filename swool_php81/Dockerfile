FROM centos:centos7

ENV PHPVERSION=8.1.5 SWOOLVERSION=4.8.9 REDISVERSION=5.3.7 TIME_ZOME=Asia/Shanghai packages="gcc gcc-c++ openssl openssl-devel pcre pcre-devel zlib zlib-devel automake autoconf libtool make" unpackages="automake autoconf libtool make" phpPackages="libxml2 libxml2-devel bzip2 bzip2-devel libcurl libcurl-devel libjpeg libjpeg-devel libpng libpng-devel freetype freetype-devel gmp gmp-devel libmcrypt libmcrypt-devel readline readline-devel libxslt libxslt-devel glibc glibc-devel glib2 glib2-devel ncurses curl gdbm-devel db4-devel libXpm-devel libX11-devel gd-devel gmp-devel expat-devel xmlrpc-c xmlrpc-c-devel libicu-devel libmcrypt-devel libmemcached-devel krb5-devel sqlite-devel autoconf"

RUN yum update -y \
    && yum -y install ${packages} \
    && echo "${TIME_ZOME}" > /etc/timezone \
    && ln -sf /usr/share/zoneinfo/${TIME_ZOME} /etc/localtime
COPY tar/ /home
#安装 oniguruma（安装php需要的组件）
RUN cd /home && tar -xvf oniguruma-6.9.5.tar.gz \
    && cd oniguruma-6.9.5 \
    && ./autogen.sh \
    && ./configure --prefix=/usr --libdir=/lib64 \
    && make && make install \
    #安装php
    && cd /home && tar -xvf php-${PHPVERSION}.tar.gz \
    && cd php-${PHPVERSION} \
    && yum -y install ${phpPackages} \
    && ./configure --prefix=/usr/local/php --with-curl --with-freetype-dir --enable-gd --with-gettext  --with-iconv-dir --with-kerberos --with-libdir=lib64 --with-libxml-dir --with-mysqli --with-openssl --with-pcre-regex --with-pdo-mysql --with-pdo-sqlite --with-pear --with-png-dir --with-jpeg-dir --with-xmlrpc --with-xsl --with-zlib --with-bz2 --with-mhash --enable-bcmath --enable-libxml --enable-inline-optimization --enable-mbregex --enable-mbstring --enable-opcache --enable-pcntl --enable-shmop --enable-soap --enable-sockets --enable-sysvsem --enable-sysvshm --enable-xml --enable-zip \
    && make && make install \
    && cp php.ini-production /usr/local/php/lib/php.ini \
    #安装redis扩展
    && cd /home && tar -xvf redis-${REDISVERSION}.tgz \
    && cd redis-${REDISVERSION} && /usr/local/php/bin/phpize \
    && ./configure --with-php-config=/usr/local/php/bin/php-config \
    && make && make install \
    && echo "extension=redis.so" >> /usr/local/php/lib/php.ini \
    #安装amqp扩展(消息列队使用)
    && yum -y install librabbitmq-devel \
    && cd /home && tar -xvf amqp-1.11.0.tgz \
    && cd amqp-1.11.0 && /usr/local/php/bin/phpize \
    && ./configure --with-php-config=/usr/local/php/bin/php-config \
    && make && make install \
    && echo "extension=amqp.so" >> /usr/local/php/lib/php.ini \
    #安装swoole扩展
    && cd /home && tar -xvf swoole-src-${SWOOLVERSION}.tar.gz \
    && cd swoole-src-${SWOOLVERSION} && /usr/local/php/bin/phpize \
    && ./configure --with-php-config=/usr/local/php/bin/php-config \
    && make && make install \
    && echo "extension=swoole.so" >> /usr/local/php/lib/php.ini \
    #删除不要的文件
    && rm -rf /home/* \
    #设置环境变量
    && echo 'PATH=$PATH:/usr/local/php/bin' >> /etc/profile \
    && source /etc/profile
#声明端口
EXPOSE 9501 9502

