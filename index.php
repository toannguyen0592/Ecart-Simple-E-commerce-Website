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
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link href="style.css" type="text/css" rel="stylesheet" />
        <!-- Internal CSS -->
        <style>
        .title-container {
            width: 100%;
            background: #f15a29;
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            padding: 10px 40px;
        }

        .title-container .page-title {
            margin-bottom: 0;
            color: #fff;
            font-size: 25px;
            font-weight: 600;
            opacity: 0.25;
            margin-left: 40px;
        }

        .txt-heading {
            border-bottom: 1px solid #211a1a;
        }

        .txt-heading h5 {
            color: #f15a29;
            font-weight: 600;
        }

        .no-records {
            min-height: 300px;
            background: lightgrey;
            height: auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .no-records i {
            opacity: .5;
            margin-bottom: 25px;
        }

        .no-records p {
            font-size: 20px;
            letter-spacing: 5px;
            opacity: .5;
        }

        .products-holder {
            margin: 50px auto;
            width: 100%;
            display: grid;
            grid-template-columns: auto auto auto;
            grid-gap: 40px;
            justify-content: center;
        }

        .product-container {
            width: 100%;
            height: auto;
        }

        .product-item {
            width: 100%;
            height: auto;
            margin: 0;
            border: 1px solid #aaa;
        }

        .product-image {
            width: 100%;
            height: auto;
            background: #ddd;
        }

        .product-item img {
            width: 100%;
            height: auto;
        }

        .product-tile-footer {
            display: flex;
            flex-direction: column;
            margin: 25px;
            padding: 0;
        }

        .product-title {
            font-weight: bold;
            text-transform: uppercase;
        }

        .product-price {
            margin-bottom: 20px;
        }

        .cart-action {
            display: flex;
            flex-direction: column;
        }

        .cart-action input {
            width: 100%;
        }

        .btnAddAction {
            margin-top: 10px;
            margin-left: 0;
            background: #f15a29;
            color: #fff;
            text-transform: uppercase;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .btnAddAction:hover {
            background: red;
        }

        .tbl-cart {
            margin: 40px 0;
            width: 100%;
        }

        .tbl-cart tr {
            height: 50px;
            background: lightgrey;
        }

        .tbl-cart tr:not(:first-child) {
            border-bottom: 1px solid #aaa;
        }

        .tbl-cart tr:first-child {
            background: #555;
            color: #fff;
        }

        .tbl-cart th,
        td {
            padding: 0 10px;
        }

        .btn {
            text-decoration: none;
            text-transform: uppercase;
            color: #fff;
            padding: 5px 20px;
            border-radius: 3px;
            background: #f15a29;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 1;
            transition: 0.3s ease;
        }

        .btn:hover {
            background: #fff;
            border: 2px solid #f15a29;
            color: #f15a29;
        }

        footer {
            height: 100px;
            text-align: center;
            color: #aaa;
            background: #555;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        footer p {
            margin: 0;
        }
        </style>
    </head>

    <body>
        <div class="title-container">
            <img src="assets/Ecart_logo-white.svg" alt="Ecart Logo" width="100px">
            <h3 class="page-title">IT 3133 - E-Commerce</h3>
        </div>
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
                                href="index.php?action=remove&code=<?php echo $item["code"]; ?>"
                                class="btnRemoveAction"><img src="icon-delete.png" alt="Remove Item" /></a></td>
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
                            <a class="btn" href="index.php?action=empty">Empty Cart</a>
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
        </div>

        <div id="product-grid">
            <div class="txt-heading">
                <h5>PRODUCTS</h5>
            </div>
            <div class="products-holder">
                <!-- This is the php script that get the product results from the database and display them on the page -->
                <?php
            $product_array = $db_handle->runQuery("SELECT * FROM tblproduct ORDER BY id ASC");
            if (!empty($product_array)) { 
                foreach($product_array as $key=>$value){
	        ?>

                <div class="product-container">
                    <div class="product-item">
                        <form method="post"
                            action="index.php?action=add&code=<?php echo $product_array[$key]["code"]; ?>">
                            <div class="product-image"><img src="<?php echo $product_array[$key]["image"]; ?>"></div>
                            <div class="product-tile-footer">
                                <div class="product-title"><?php echo $product_array[$key]["name"]; ?></div>
                                <div class="product-price"><?php echo "$".$product_array[$key]["price"]; ?></div>
                                <div class="cart-action">
                                    <input type="number" class="product-quantity" name="quantity" value="1" min="1" pattern="[1-9]+" required />
                                    <input type="submit" value="Add to Cart" class="btnAddAction" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
		        }
	        }
	        ?>
            </div>
        </div>

        <footer>
            <p class="copyright">
                Copyright <i class="fa fa-copyright" aria-hidden="true"></i> 2019 ECart.com. All Right Reserved
            </p>
        </footer>
    </body>

</html>