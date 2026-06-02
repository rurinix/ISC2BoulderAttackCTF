USE ctf_db;

LOAD DATA INFILE '/var/lib/mysql-files/flags.csv'
INTO TABLE flags
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS
(flag, points);
