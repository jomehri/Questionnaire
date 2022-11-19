# create databases
CREATE DATABASE IF NOT EXISTS `qst_db`;
CREATE DATABASE IF NOT EXISTS `qst_testing_db`;

# create root user and grant rights
CREATE USER 'root'@'localhost' IDENTIFIED BY 'local';
GRANT ALL PRIVILEGES ON *.* TO 'root'@'%';