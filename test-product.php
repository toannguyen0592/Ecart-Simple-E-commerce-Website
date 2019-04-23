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
        <title>Product Page - IT 3133 - E-Commerce</title>
        <link href="style.css" type="text/css" rel="stylesheet" />
    </head>

    <body>
        <div id="product-grid">
            <div class="txt-heading">Products</div>
            <?php
	            $product_array = $db_handle->runQuery("SELECT * FROM tblproduct ORDER BY id ASC");
	            if (!empty($product_array)) { 
		            foreach($product_array as $key=>$value){
	        ?>
                    <div class="product-item">
                        <form method="post" action="index.php?action=add&code=<?php echo $product_array[$key]["code"]; ?>">
                            <div class="product-image"><img src="<?php echo $product_array[$key]["image"]; ?>"></div>
                            <div class="product-tile-footer">
                            <div class="product-title"><?php echo $product_array[$key]["name"]; ?></div>
                            <div class="product-price"><?php echo "$".$product_array[$key]["price"]; ?></div>
                            <div class="cart-action"><input type="text" class="product-quantity" name="quantity" value="1"
                                    size="2" /><input type="submit" value="Add to Cart" class="btnAddAction" /></div>
                            </div>
                        </form>
                    </div>
            <?php
		            }
	            }
	        ?>
        </div>
    </body>
</html>