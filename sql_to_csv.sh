#!/bin/bash

if [ "$#" -ne 1 ]; then
    echo "USAGE: ./sql_to_csv.sh sql_backup.sql"
    exit 1
fi

chmod 777 /var/lib/mysql-files
mysql -e "CREATE DATABASE IF NOT EXISTS code_coverage;" -u root -proot
echo "[+] Importing code_coverage database."
mysql -u root -proot code_coverage < $1

echo "[+] Exporting file coverage CSV."
mysql -e "USE code_coverage; SELECT file_name FROM covered_files INTO OUTFILE '/var/lib/mysql-files/files.csv' FIELDS TERMINATED BY ',' ENCLOSED BY '\"' LINES TERMINATED BY '\n';" -u root -proot code_coverage
echo "[+] Exporting line coverage CSV."
mysql -e "USE code_coverage; SELECT file_name, line_number FROM covered_lines JOIN covered_files ON covered_lines.fk_file_id = covered_files.id INTO OUTFILE '/var/lib/mysql-files/lines.csv' FIELDS TERMINATED BY ',' ENCLOSED BY '\"' LINES TERMINATED BY '\n';" -u root -proot code_coverage

echo "[+] Cleaning up."
mysql -e "DROP DATABASE code_coverage;" -u root -proot