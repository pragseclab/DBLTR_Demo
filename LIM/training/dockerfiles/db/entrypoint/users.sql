-- demo
CREATE USER 'alice'@'%' IDENTIFIED BY 'alice';
CREATE USER 'bob'@'%' IDENTIFIED BY 'bob';
CREATE USER 'charlie'@'%' IDENTIFIED BY 'charlie';
CREATE USER 'david'@'%' IDENTIFIED BY 'david';
CREATE USER 'eli'@'%' IDENTIFIED BY 'eli';
GRANT ALL PRIVILEGES ON * . * TO 'alice'@'%';
GRANT ALL PRIVILEGES ON * . * TO 'bob'@'%';
GRANT ALL PRIVILEGES ON * . * TO 'charlie'@'%';
GRANT ALL PRIVILEGES ON * . * TO 'david'@'%';
GRANT ALL PRIVILEGES ON * . * TO 'eli'@'%';
flush privileges;