<?php
    // session_start();
//     require_once('dbconnect.php');
// //     require_once('dbcontroller.php');
//     databaseConnect();
// //     $db_handle = new DBController();

$host = "localhost";
	$user = "tn04662";
	$password = "sZncjy3u";
	$database = "tn04662";
        date_default_timezone_set("America/New_York");

     // Create connection
     $conn = mysqli_connect($host, $user, $password, $database);

     // Check connection
     if (!$conn) {
         die("Connection failed: " . mysqli_connect_error());
     }

     mysqli_autocommit($conn, false);

     $flat = true;
     
     $fname = mysqli_real_escape_string($conn, $_POST['fname']);
     $lname = mysqli_real_escape_string($conn, $_POST['lname']);
     $address = mysqli_real_escape_string($conn, $_POST['address']);
     $city = mysqli_real_escape_string($conn, $_POST['city']);
     $state = mysqli_real_escape_string($conn, $_POST['state']);
     $zip = mysqli_real_escape_string($conn, $_POST['zip']);
     $email = mysqli_real_escape_string($conn, $_POST['email']);
     $phone = mysqli_real_escape_string($conn, $_POST['phone']);
     
     $shipaddress = mysqli_real_escape_string($conn, $_POST['mailaddress']);
     $shipcity = mysqli_real_escape_string($conn, $_POST['mailcity']);
     $shipstate = mysqli_real_escape_string($conn, $_POST['mailstate']);
     $shipzip = mysqli_real_escape_string($conn, $_POST['mailzip']);
     $orderdate = date("m/d/Y");

    $query1 = "INSERT INTO Customers (FirstName, LastName, Address, City, State, ZipCode, Email, Phone)
            VALUES ('$fname','$lname','$address','$city','$state','$zip','$email','$phone')";
            
     $query2 = "INSERT INTO Orders (CustomerID) SELECT CustomerID FROM Customers WHERE (FirstName = '$fname' AND LastName = '$lname')";            
            
    $query3  = "INSERT INTO Orders (ShippingAddress, ShippingCity, ShippingState, ShippingZipCode, OrderDate)
    VALUES ('$shipaddress','$shipcity','$shipstate','$shipzip','$orderdate')";

     $result = mysqli_query($conn, $query1);
     if (!$result) {
             $flah = false;
             echo "Error details: ". mysqli_error($conn) . ".";
     }

     $result = mysqli_query($conn, $query2);
     if (!$result) {
             $flah = false;
             echo "Error details: ". mysqli_error($conn) . ".";
     }

     $result = mysqli_query($conn, $query3);
     if (!$result) {
             $flah = false;
             echo "Error details: ". mysqli_error($conn) . ".";
     }

     if ($flag) {
             mysqli_commit($conn);
             echo "All queries were executed successfully";
     } else {
        mysqli_rollback($conn);
        echo "All queries were rolled back";
     }

     mysqli_close($conn);

//     $sql = "INSERT INTO Orders (CustomerID) SELECT CustomerID FROM Customers";

//     $sql = "INSERT INTO Orders (ShippingAddress, ShippingCity, ShippingState, ShippingZipCode, OrderDate)
//             VALUES ('$_POST[mailaddress]','$_POST[mailcity]','$_POST[mailstate]','$_POST[mailzip]')";
 
    // if (isset$_SESSION["cart_items"]) {
    //     foreach($_SESSION["cart_item"] as $itemArray) {
    //         $sql = "INSERT INTO Order_Products ( 
    //     }
    // }
    // if (!mysqli_query($conn,$sql)) { 
    //     die('Error: ' . mysqli_error($conn));
    // }

    // mysqli_close($conn);
?>