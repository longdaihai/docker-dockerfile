FROM centos:centos7

ENV NGINXVERSION=1.18.0 TIME_ZOME=Asia/Shanghai packages="gcc gcc-c++ openssl openssl-devel pcre pcre-devel"

RUN yum update -y \
    && yum -y install ${packages} \
    && echo "${TIME_ZOME}" > /etc/timezone \
    && ln -sf /usr/share/zoneinfo/${TIME_ZOME} /etc/localtime
COPY tar/ /home
RUN cd /home \
    #安装nginx
    && tar -xvf nginx-${NGINXVERSION}.tar.gz \
    && cd nginx-${NGINXVERSION} \
    && ./configure \
    && make \
    && make install \
    && rm -rf /tmp/nginx* \
    && ln -s /usr/local/nginx/sbin/nginx /usr/sbin/nginx \
    #ngxin 安装完成
    #最后删除不要的文件
    && rm -rf /home/*
   
#声明nginx端口
EXPOSE 80
#执行脚本
CMD nginx -g "daemon off;"
