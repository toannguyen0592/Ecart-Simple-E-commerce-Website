<?php 
    $host = "localhost";
	$user = "tn04662";
	$password = "sZncjy3u";
	$database = "tn04662";
    $conn;
    
    function databaseConnect() {
        // Create connection
        $conn = mysqli_connect($host, $user, $password, $database);

        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        echo "Connected successfully";
    }
?>