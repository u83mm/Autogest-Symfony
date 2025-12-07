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

<li>Accessing the application</li>

    type "http://localhost " in the url in the browser

<li>Login as admin user</li>

    user: admin
    passw: adminadmin
