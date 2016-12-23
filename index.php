<?php

/**
 * Run a gta co op master server
 *
 * Written by TheIndra
 *
 * Website: https://theindra.eu
 * Github: https://github.com/TheIndra55/gtamasterserver
 *
 */

class gtamasterserver
{
    
    private $db;
    
    function _connect()
    {
        //$this->db = mysqli_connect('localhost', 'username', 'password', 'databasename');
        $this->db = mysqli_connect('localhost', 'root', '', 'gtamasterserver');

        if(!$this->db)
        {
            echo 'Failed to connect to database';
            exit();
        }
    }
    
    function _addServer($ip){
        mysqli_query($this->db, "INSERT INTO servers (ip, date) VALUES ('" . mysqli_real_escape_string($this->db, $ip) . "', '" . date("Y-m-d H:i:s") . "') ON DUPLICATE KEY UPDATE date = '" . date("Y-m-d H:i:s") . "'");
    }
    
    function _cleanUp()
    {
        $servers = mysqli_query($this->db, "SELECT * FROM servers");
        
        //Loop through all servers and check if the date is older then 6 minutes
        while($row = mysqli_fetch_array($servers))
        {
            if (time() - strtotime($row[2]) > 6 * 60) {
                mysqli_query($this->db, "DELETE FROM servers WHERE date = '" . $row[2] . "'");
            }
        }
    }
    
    function _getServers()
    {        
    
        $servers = mysqli_query($this->db, "SELECT * FROM servers");
        $server = array();
        
        while($row = mysqli_fetch_array($servers))
        {
            array_push($server, $row[1]);
        }
        
        return $server;
    }
    
}

$gta = new gtamasterserver();
$gta->_connect();

// POST = Server, GET = Client
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $post = file_get_contents("php://input");
    
    if(is_numeric($post))
    {
        $gta->_addServer($_SERVER['REMOTE_ADDR'] . ":" . $post);
    }else
    {
        //fuckoff don't post bullshit
        header('HTTP/1.0 403 Forbidden');
    }
    
}else
{
    
   $gta->_cleanUp();
   echo '{"list":' . json_encode($gta->_getServers()) . '}'; 
    
}


?>