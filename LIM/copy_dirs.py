import sys
from shutil import copytree
# from tqdm import tqdm

if (len(sys.argv) < 3):
    sys.exit('USAGE: python copy_dirs.py source_dir dir_names.txt')

source_dir = sys.argv[1]
dir_names_file = sys.argv[2]

with open(dir_names_file, 'r') as f:
    for dir_name in f:
        print(f"Copying {source_dir} to {dir_name}")
        copytree(source_dir, dir_name.rstrip(), False)