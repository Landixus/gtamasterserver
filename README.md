# GTAmasterServer
a GTAcoop MasterServer PHP alternative

#Info
This is a PHP alternative of https://github.com/Bluscream/GTACoop/tree/master/gtamasterserver using mysql

#How to setup
1. Clone the repository
2. upload the index.php to your webhost or webserver.
3. Create mysql database and import the gtamasterserver.sql
4. Goto your index.php and set your database 
```php
$this->db = mysqli_connect('host', 'username', 'password', 'databasename');
```

#How to use (Client)
1. Open you're menu using F9
2. Goto "Client settings"
3. Scroll down and set "Master server" to your website address

#How to use (Server)
1. Open Settings.xml
2. Change ```<MasterServer>http:/http://46.101.1.92/</MasterServer>``` to your website address
