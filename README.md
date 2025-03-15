<h3 align="center">TEST THE PROJECT</h3>
<li>Clone the repository:</li>    

    git clone "git-repo" project-name
    cd /project-name


<li>Build</li>

    mkdir log log/apache log/db log/php
    docker compose build  
    docker compose up -d
    docker exec -it php bash
    composer install
    exit


<li>Import SQL file "my_database.sql"</li>

    I do it accessing to phpMyAdmin in local host:
        http://localhost:8080/
        user: admin
        passw: admin
    
        Import "autogest.sql" file from MariaDB directory.

<li>Accessing the application</li>

    type "http://localhost " in the url in the browser

<li>Login as admin user</li>

    user: admin
    passw: adminadmin
