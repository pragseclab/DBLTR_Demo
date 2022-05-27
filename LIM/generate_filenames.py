web_apps = {'PMA': 'phpMyAdmin', 'WP': 'WordPress', 'MGT': 'Magento'}
num_clusters = 20

for web_app in web_apps:
    with open(web_app + '.txt', 'w') as f:
        for cluster in range(1, num_clusters + 1):
            for variant in range(0, cluster):
                f.write(f"{web_app}_M{cluster}_{variant}\n")
