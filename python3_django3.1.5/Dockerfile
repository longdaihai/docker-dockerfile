# 基于镜像基础
FROM ubuntu

#安装环境
RUN apt-get update && \
    apt-get install -y python3 && python=python3 \
    apt install -y python3-pip

#安装应用所需的包
RUN pip3 install Django && \
    pip3 install requests
