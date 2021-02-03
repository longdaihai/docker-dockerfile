FROM centos:centos7

ENV PHPVERSION=7.1.29 TIME_ZOME=Asia/Shanghai packages="gcc gcc-c++ openssl openssl-devel pcre pcre-devel zlib zlib-devel automake autoconf libtool make" unpackages="automake autoconf libtool make" phpPackages="libxml2 libxml2-devel bzip2 bzip2-devel libcurl libcurl-devel libjpeg libjpeg-devel libpng libpng-devel freetype freetype-devel gmp gmp-devel libmcrypt libmcrypt-devel readline readline-devel libxslt libxslt-devel glibc glibc-devel glib2 glib2-devel ncurses curl gdbm-devel db4-devel libXpm-devel libX11-devel gd-devel gmp-devel expat-devel xmlrpc-c xmlrpc-c-devel libicu-devel libmcrypt-devel libmemcached-devel krb5-devel sqlite-devel autoconf"

RUN yum update -y \
    && yum -y install ${packages} \
    && echo "${TIME_ZOME}" > /etc/timezone \
    && ln -sf /usr/share/zoneinfo/${TIME_ZOME} /etc/localtime
COPY tar/ /home
RUN cd /home \
    #安装nginx
    && tar -xvf nginx-1.18.0.tar.gz \
    && cd nginx-1.18.0 \
    && ./configure \
    && make \
    && make install \
    && rm -rf /tmp/nginx* \
    && ln -s /usr/local/nginx/sbin/nginx /usr/sbin/nginx \
    #ngxin 安装完成
    #安装 oniguruma
    && cd /home && tar -xvf oniguruma-6.9.5.tar.gz \
    && cd oniguruma-6.9.5 \
    && ./autogen.sh \
    && ./configure --prefix=/usr --libdir=/lib64 \
    && make && make install \
    #安装php
    && cd /home && tar -xvf php-${PHPVERSION}.tar.gz \
    && cd php-${PHPVERSION} \
    && yum -y install ${phpPackages} \
    && ./configure --prefix=/usr/local/php --with-curl --with-freetype-dir --with-gettext  --with-iconv-dir --with-kerberos --with-libdir=lib64 --with-libxml-dir --with-mysqli --with-openssl --with-pcre-regex --with-pdo-mysql --with-pdo-sqlite --with-pear --with-png-dir --with-jpeg-dir --with-xmlrpc --with-xsl --with-zlib --with-bz2 --with-mhash --enable-fpm --enable-bcmath --enable-libxml --enable-inline-optimization --enable-mbregex --enable-mbstring --enable-opcache --enable-pcntl --enable-shmop --enable-soap --enable-sockets --enable-sysvsem --enable-sysvshm --enable-xml --enable-zip --enable-fpm \
    && make && make install \
    && cp php.ini-production /usr/local/php/lib/php.ini && cp /usr/local/php/etc/php-fpm.conf.default /usr/local/php/etc/php-fpm.conf && cp sapi/fpm/init.d.php-fpm /etc/init.d/php-fpm && cp /usr/local/php/etc/php-fpm.d/www.conf.default /usr/local/php/etc/php-fpm.d/www.conf \
    && chmod +x /etc/init.d/php-fpm \
    #安装redis扩展
    && cd /home && tar -xvf redis-5.3.1.tgz \
    && cd redis-5.3.1 && /usr/local/php/bin/phpize \
    && ./configure --with-php-config=/usr/local/php/bin/php-config \
    && make && make install \
    && echo "extension=redis.so" >> /usr/local/php/lib/php.ini \
    #安装amqp扩展(消息列队使用)
    && yum -y install librabbitmq-devel \
    && cd /home && tar -xvf amqp-1.10.2.tgz \
    && cd amqp-1.10.2 && /usr/local/php/bin/phpize \
    && ./configure --with-php-config=/usr/local/php/bin/php-config \
    && make && make install \
    && echo "extension=amqp.so" >> /usr/local/php/lib/php.ini \
    #最后删除不要的文件
    && rm -rf /home/*
   
#声明nginx端口
EXPOSE 80
#执行脚本
CMD /etc/init.d/php-fpm start && nginx -g "daemon off;"
