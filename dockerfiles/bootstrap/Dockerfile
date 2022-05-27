FROM redis:bullseye

COPY mappings.txt /root/
CMD cat /root/mappings.txt | redis-cli -h redis --pipe