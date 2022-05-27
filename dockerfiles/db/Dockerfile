FROM mysql/mysql-server:5.7
RUN yum --disablerepo=mysql57-server-minimal install -y python3
ADD ./mysqld.cnf /etc/my.cnf
ADD ./entrypoint/* /docker-entrypoint-initdb.d/
RUN chmod 600 /etc/my.cnf
