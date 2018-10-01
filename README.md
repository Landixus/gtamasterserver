# GTAmasterServer
a GTAcoop MasterServer PHP alternative

# Info
A [GTA CooP](https://gtacoop.com/) masterserver written in PHP

# How to setup
1. Clone the repository
2. upload the index.php to your webhost or webserver.
3. Create mysql database and import the gtamasterserver.sql
4. Goto your index.php and set your database 
```php
$this->db = mysqli_connect('host', 'username', 'password', 'databasename');
```

# How to use (Client)
1. Open you're menu using F9
2. Goto "Client settings"
3. Scroll down and set "Master server" to your website address

# How to use (Server)
1. Open serverSettings.xml
2. Change ```<MasterServer>http://master.example.com</MasterServer>``` to your website address
