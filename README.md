# *DBLTR* Playbook

In this playbook, we go over the steps to debloat and serve a web application using *DBLTR*.
At a high level, first we use the *[Less is More](https://lessismore.debloating.com/)* platform to generate a baseline usage profile of the web application users in the form of line coverage information. Next, we import the code coverage data into the *DBLTR* Jupyter notebook and use the classifier to group users with similar behavior together under the same role (*i.e.,* cluster). 
Finally, we deploy the outputted docker compose environment with the produced configurations to serve the debloated web applications to the users.

### LIM Setup
Less is More can be setup using the following guide: https://lessismore.debloating.com/. More details and playbook available at: https://playground.debloating.com/
After this step is done, we export the code coverage of each user into the CSV format. *sql_to_csv.py* script can help automate this process. 

 - files.csv: includes the "filename" of covered files in the csv file.
 - lines.csv: is in "filename, line_number" format.

The output of LIM line coverage data from our original user study is available under code_coverage_data/phpMyAdmin/ and code_coverage_data/WordPress directories. 

### Generating Roles and Debloating Web Applications
Now we switch our focus to the jupter notebook "*rbd_dataanalysis*". This notebook can be setup using the provided docker-compose environment through: `docker compose up -d` and then navigating to http://localhost:8888/lab/tree/work/rbd_dataanalysis.ipynb. The token to access this notebook is set in the docker-compose env variable and is currently set to "`jupytersecrettokenabhsyd68ay`".
We can follow the cells in the notebook. Certain steps can take a long time from 30 minutes to couple of hours to complete. Therefore, we have also provided the output of lengthy steps in the form of Python pickled objects. At the end of each section, the pickle files are restored. This would be an alternative to running individual cells in the notebook for that section.

#### Jupyter notebook sections
For the sections where pickle file is available, you can jump to the end of the section and quickly restore the data from the pickle file. For new web applications outside of our dataset, the whole process needs to be followed instead of restoring pickle files.

 - **Lib Imports**: Prepares the packages required for the debloating and analysis of the results.
 - Import CSV Files [Pickle file available]: Import the CSV files for file and line coverage information of web application users.
 - **Add Source Code Features** [Pickle file available]: Extracts features from the code coverage data used to identify similar usage patterns in the clustering. This includes files, functions, classes, and namespaces used by each user's code coverage.
 - **Clustering** [Pickle file available]: We incorporate the spectral clustering algorithm in combination with Jaccards similarity metric to perform the clustering. 
 - **Evaluate Clusters:** This step compares the debloating of various clusters to identify the optimal number of clusters (i.e., roles) for the web applications. The slope of the lines plotting the reduction of remaining functions after debloating based on the total number of roles can be used to optimize the total number of roles. We want the minimal number of roles that provide the best debloating, that is also referred to as the [elbow method](https://en.wikipedia.org/wiki/Elbow_method_%28clustering%29#:~:text=In%20cluster%20analysis,%20the%20elbow,number%20of%20clusters%20to%20use.). 
 - **Optimal Cluster Size**: Includes the number of roles determined by the previous step. In our example, 6, and 7 roles for phpMyAdmin and WordPress respectively. 
 - **Generate Artifacts** [Pickle file available]: The output of clustering is the roles and mapping of users to roles. Based on this information, we merge the code coverage of users assigned to each role, debloat the copies of web applications specific to each role and generate the docker-compose file to serve these applications. Finally, we provide the user to role mapping information the our reverse-proxy to route user traffic towards their specially debloated web applications. 
 - **Generate Docker Environment Files**: This step generates the docker files. This is the last step required to produce debloated web applications. We can now use the provided user-to-role mappings and docker-compose configuration to serve the web applications.
 - **Attack Surface Reduction Analysis**: This step is extra and can be used to extract and analyze the information about the reduced lines of code, removed CVEs, and gadget chains after debloating.

  ### Serving the debloated web applications
  In order to serve the debloated web applications, we need to copy the user-to-role mappings under `dockerfiles/bootstrap/mappings.txt`. Next, we use `docker-compose up -d` under docker-compose directory after renaming the desired docker-compose file (phpMyAdmin or WordPress in this example) to docker-compose.yml.
  The web applications will be served under localhost:8080.
  Upon logging in, each the authentication cookie of each user is extracted by our OpenResty Lua modules and stored in the Redis datastore. Subsequent requests from users containing the authentication cookie will instruct the reverse-proxy to transparently route their requests towards their custom debloated web applications. 
  
A Demo is available here at: https://vimeo.com/manage/videos/652161913

### Adding new web applications to *DBLTR* 

 1. Setup the web application under a LIM-like setup to collect the code-coverage data from web application users for a period of time.
 2. Import the code-coverage data into the debloating pipeline (Jupyter notebook) to produce the debloating roles. 
 3. Create the user authentication detection logic as a new OpenResty Lua module.
 4. Use the provided configuration to host the debloated web applications.

#### OpenResty Authentication Detection Lua Module
The files for this module are located under `docker/reverse-proxy/lua/`. The skeleton of this code is available under *common.lua* as well as application specific files under *pma* and *wp*. 
default.conf file which is an Nginx/OpenResty config file is used to activate the Lua module. 
At a high level:

 - **login_handler.lua**: Detects a successful login request, in the example of phpMyAdmin, this consists of a POST request towards the root of the web application and should result in a 302 HTTP response code. This module then extracts the authentication cookie value under "phpmyadmin" cookie. This mapping is stored in the redis datastore for future use.
 - **login_username_extractor.lua**: Extracts the provided username from the login request. In the example of phpMyAdmin, we look for "/" or "index.php" POST requests containing "pma_username" POST parameter containing the username. 
 - **redirect_to_proxy.lua**: Looks for the presence of authentication cookies (e.g., "phpmyadmin"), it then tries to extract the username from the datastore based on the authentication cookie value. Next, we find the mapping of user to role and instruct the reverse-proxy to route user traffic to their debloated web application.

