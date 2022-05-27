import sys
import subprocess   
import os
from glob import glob

for dir_name in glob(sys.argv[1]):
    code_coverage_sql_file = dir_name + '/code_coverage.sql'
    if os.path.isfile(code_coverage_sql_file):
        print(f"[+] Converting {code_coverage_sql_file}...")
        subprocess.call(['/var/lib/mysql-files/sql_to_csv.sh', code_coverage_sql_file])
        os.rename('files.csv', dir_name + '/files.csv')
        os.rename('lines.csv', dir_name + '/lines.csv')
