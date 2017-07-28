<?php

/**
 * Run a gta coop masterserver
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
    
    function connect()
    {
        // $this->db = mysqli_connect("localhost", "username", "password", "databasename");
        $this->db = mysqli_connect("localhost", "root", "", "gtamasterserver");

        if(!$this->db)
        {
            echo "Failed to connect to database";
            exit();
        }
		
		header("X-Powered-By: PHP/" . phpversion() . " & gtamasterserver/1.1");
    }
    
    function addServer($ip){
        mysqli_query($this->db, "INSERT INTO servers (ip, date) VALUES ('" . mysqli_real_escape_string($this->db, $ip) . "', '" . date("Y-m-d H:i:s") . "') ON DUPLICATE KEY UPDATE date = '" . date("Y-m-d H:i:s") . "'");
    }
    
    function cleanUp()
    {
        $servers = mysqli_query($this->db, "SELECT * FROM servers");
        
        // Loop through all servers and check if the date is older then 6 minutes
        while($row = mysqli_fetch_array($servers))
        {
            if (time() - strtotime($row[2]) > 6 * 60) {
                mysqli_query($this->db, "DELETE FROM servers WHERE date = '" . $row[2] . "'");
            }
        }
    }
    
    function getServers()
    {        
    
        $servers = mysqli_query($this->db, "SELECT * FROM servers");
        $server = array();
        
        while($row = mysqli_fetch_array($servers))
        {
            array_push($server, $row[1]);
        }
        
        return $server;
    }
	
	function getCount(){
		$count = mysqli_query($this->db, "SELECT count(*) as count FROM servers");
		
		return mysqli_fetch_assoc($count)['count'];
	}
    
}


$gta = new gtamasterserver();
$gta->connect();

// POST = Server, GET = Client
if ($_SERVER["REQUEST_METHOD"] == 'POST')
{
    $post = file_get_contents("php://input");
    
    if(is_numeric($post))
    {
        $gta->addServer($_SERVER["REMOTE_ADDR"] . ":" . $post);
    }else
    {
        //fuckoff don't post b*llshit
        header("HTTP/1.0 403 Forbidden");
    }
}else
{
   $gta->cleanUp();
   echo json_encode(array("count" => (int) $gta->getCount(), "list" => $gta->getServers()));
}
?>