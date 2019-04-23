<?php
session_start();
require_once("dbcontroller.php");
$db_handle = new DBController();
if(!empty($_GET["action"])) {
switch($_GET["action"]) {
	case "add":
		if(!empty($_POST["quantity"])) {
			$productByCode = $db_handle->runQuery("SELECT * FROM tblproduct WHERE code='" . $_GET["code"] . "'");
			$itemArray = array($productByCode[0]["code"]=>array('name'=>$productByCode[0]["name"], 'code'=>$productByCode[0]["code"], 'quantity'=>$_POST["quantity"], 'price'=>$productByCode[0]["price"], 'image'=>$productByCode[0]["image"]));
			
			if(!empty($_SESSION["cart_item"])) {
				if(in_array($productByCode[0]["code"],array_keys($_SESSION["cart_item"]))) {
					foreach($_SESSION["cart_item"] as $k => $v) {
							if($productByCode[0]["code"] == $k) {
								if(empty($_SESSION["cart_item"][$k]["quantity"])) {
									$_SESSION["cart_item"][$k]["quantity"] = 0;
								}
								$_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
							}
					}
				} else {
					$_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
				}
			} else {
				$_SESSION["cart_item"] = $itemArray;
			}
		}
	break;
	case "remove":
		if(!empty($_SESSION["cart_item"])) {
			foreach($_SESSION["cart_item"] as $k => $v) {
					if($_GET["code"] == $k)
						unset($_SESSION["cart_item"][$k]);				
					if(empty($_SESSION["cart_item"]))
						unset($_SESSION["cart_item"]);
			}
		}
	break;
	case "empty":
		unset($_SESSION["cart_item"]);
	break;	
}
}
?>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Shopping Cart - IT 3133 - E-Commerce</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
            integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link href="css/style.css" type="text/css" rel="stylesheet" />
        <link href="css/cart.css" type="text/css" rel="stylesheet" />
        <!-- Internal CSS -->
        <style>
        
        </style>
    </head>

    <body>

        <div class="content-wrapper">
            <div class="title-container">
                <img src="assets/Ecart_logo-white.svg" alt="Ecart Logo" width="100px">
                <h3 class="page-title">IT 3133 - E-Commerce</h3>
            </div>
            <div class="container">


                <div id="shopping-cart">
                    <div class="txt-heading">
                        <h5>SHOPPING CART</h5>
                    </div>
                    <?php
            if(isset($_SESSION["cart_item"])) {
                $total_quantity = 0;
                $total_price = 0;
            ?>
                    <table class="tbl-cart" cellpadding="20" cellspacing="1">
                        <tbody>
                            <tr>
                                <th style="text-align:left;">Name</th>
                                <th style="text-align:right;">Code</th>
                                <th style="text-align:right;" width="5%">Quantity</th>
                                <th style="text-align:right;" width="10%">Unit Price</th>
                                <th style="text-align:right;" width="10%">Price</th>
                                <th style="text-align:center;" width="5%">Remove</th>
                            </tr>
                            <?php		
                        foreach ($_SESSION["cart_item"] as $item) {
                            $item_price = $item["quantity"]*$item["price"];
                    ?>
                            <tr>
                                <td><img src="<?php echo $item["image"]; ?>"
                                        class="cart-item-image" /><?php echo $item["name"]; ?></td>
                                <td style="text-align:right;"><?php echo $item["code"]; ?></td>
                                <td style="text-align:right;"><?php echo $item["quantity"]; ?></td>
                                <td style="text-align:right;"><?php echo "$".$item["price"]; ?></td>
                                <td style="text-align:right;"><?php echo "$". number_format($item_price,2); ?></td>
                                <td style="text-align:center;"><a
                                        href="cart.php?action=remove&code=<?php echo $item["code"]; ?>"
                                        class="btnRemoveAction"><img src="assets/icon-delete.png" alt="Remove Item" /></a></td>
                            </tr>
                            <?php
                            $total_quantity += $item["quantity"];
                            $total_price += ($item["price"]*$item["quantity"]);
		                }
		                ?>

                            <tr>
                                <td colspan="2" align="right"><strong>TOTAL:</strong></td>
                                <td align="right"><strong><?php echo $total_quantity; ?></strong></td>
                                <td align="right" colspan="2">
                                    <strong><?php echo "$".number_format($total_price, 2); ?></strong></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="6" align="right">
                                    <a class="btn" href="cart.php?action=empty">Empty Cart</a>
                                    <a class="btn" href="checkout.php">Check Out</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <?php
            } else {
            ?>
                    <div class="no-records">
                        <i class="fas fa-shopping-cart fa-5x"></i>
                        <p>YOUR CART IS EMPTY</p>
                    </div>
                    <?php 
            }
            ?>
                    <a class="btn" href="products.php">
                        < Back To Product Page</a> </div> </div> <footer>
                            <p class="copyright">Copyright <i class="fa fa-copyright" aria-hidden="true"></i> 2019
                                ECart.com. All Right Reserved</p>
                            </footer>
                </div>


                <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    </body>

</html>
