# create databases
CREATE DATABASE IF NOT EXISTS `qst_db`;
CREATE DATABASE IF NOT EXISTS `qst_testing_db`;

# create root user and grant rights
GRANT ALL PRIVILEGES ON *.* TO 'root'@'localhost' WITH GRANT OPTION;
GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' WITH GRANT OPTION;