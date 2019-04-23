<?php
    session_start();
    // require_once("dbcontroller.php");
    $host = "localhost";
	$user = "tn04662";
	$password = "sZncjy3u";
	$database = "tn04662";
        

     // Create connection
     $conn = mysqli_connect($host, $user, $password, $database);

     // Check connection
     if (!$conn) {
         die("Connection failed: " . mysqli_connect_error());
     }

     mysqli_autocommit($conn, false);

     $flag = true;
     
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
     

    $query1 = "INSERT INTO Customers (FirstName, LastName, Address, City, State, ZipCode, Email, Phone)
            VALUES ('$fname','$lname','$address','$city','$state','$zip','$email','$phone')";
            
    // $query2 = "INSERT INTO Orders (CustomerID) SELECT CustomerID FROM Customers WHERE FirstName='$fname' AND LastName='$lname'";            
            
    $query3  = "INSERT INTO Orders (CustomerID, ShippingAddress, ShippingCity, ShippingState, ShippingZipCode, OrderDate)
    SELECT CustomerID,'$shipaddress','$shipcity','$shipstate','$shipzip',CURDATE()
    FROM Customers WHERE FirstName='$fname' AND LastName='$lname'
    ";

     $result = mysqli_query($conn, $query1);
     if (!$result) {
             $flag = false;
             echo "Error details: ". mysqli_error($conn) . ".";
     }

    //  $result = mysqli_query($conn, $query2);
    //  if (!$result) {
    //          $flah = false;
    //          echo "Error details: ". mysqli_error($conn) . ".";
    //  }

     $result = mysqli_query($conn, $query3);
     if (!$result) {
             $flag = false;
             echo "Error details: ". mysqli_error($conn) . ".";
     }

     if ($flag) {
             mysqli_commit($conn);
             echo "<script type='text/javascript'>alert('Your information are successfully submitted');</script>";
     } else {
            mysqli_rollback($conn);
            echo "<script type='text/javascript'>alert('We could not successfully submit your information due to errors');</script>";
     }

     
?>
<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Order Submission</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous"> -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/submit.css">
        <style>
        
        </style>
    </head>

    <body>
        <div class="title-container">
            <img src="assets/Ecart_logo-white.svg" alt="Ecart Logo" width="100px">
            <h3 class="page-title">IT 3133 - E-Commerce</h3>
        </div>

        <div class="order-summary">
            <div class="heading">
                <h3>THANK YOU FOR ORDERING, <?php echo $_POST["fname"]; ?></h3>
                <h4>Your order is successfully submitted</h4>
            </div>


            <h5>Order Details</h5>
            <table class="order-detail">
                <tr>
                    <th>Order Date:</th> 
                    <td><?php date_default_timezone_set("America/New_York"); echo date("m/d/Y");?></td>
                </tr>
                <tr>
                    <th>Name:</th> 
                    <td><?php echo $_POST["fname"]." ".$_POST["lname"]; ?></td>
                </tr>
                <tr>
                    <th>Email:</th> 
                    <td><?php echo $_POST["email"]; ?></td>
                </tr>
                <tr>
                    <th>Shipping Address:</th> 
                    <td> <?php echo $_POST["mailaddress"].",&nbsp".$_POST["mailcity"].",&nbsp".$_POST["mailstate"]."&nbsp".$_POST["mailzip"]; ?>
                </td>
                </tr>
                <tr>
                    <th>Shipping Method:</th> 
                    <td><?php echo $_POST["shipping"];?></td>
                </tr>
            </table>
            <h5>Items Purchased</h5>
            <div class="cart-container">
                <table class="cart" width="100%">
                    <tr>
                        <th style="text-align: left;">Item</th>
                        <th style="text-align: right;">Qty</th>
                        <th style="text-align: right;">Uni. Price</th>
                    </tr>
                    <?php
                   if (isset($_SESSION["cart_item"])) {
                       foreach($_SESSION["cart_item"] as $itemArray) {
                    ?>
                    <tr class="cart-item">
                        <td style="text-align: left;"><?php echo $itemArray['name'];?></td>
                        <td style="text-align: right;"><?php echo $itemArray['quantity'];?></td>
                        <td style="text-align: right;"><?php echo "$".$itemArray['price'];?></td>
                    </tr>
                    <?php
                           $total_quantity += $itemArray['quantity'];
                            $total_price += $itemArray['price']*$itemArray['quantity'];        
                       }
                       
                   }  ?>
                </table>
            </div>
            <div class="total-field">
                <table class="total-value" width="100%">
                    <tr>
                        <?php
                    if (isset($_SESSION["cart_item"])) {
                        echo "<td><strong>TOTAL:</td>";
                        echo "<td><strong>$".number_format($total_price, 2)."</strong></td>";
                    }    
                    ?>
                    </tr>
                </table>
                
            </div>
            <a class="btn" href="products.php">CONTINUE SHOPPING</a>
                <?php session_destroy();?>

        </div>

        <footer>
            <p class="copyright">
                Copyright <i class="fa fa-copyright" aria-hidden="true"></i> 2019 ECart.com. All Right Reserved
            </p>
        </footer>


        <script src="" async defer></script>
    </body>

</html>
