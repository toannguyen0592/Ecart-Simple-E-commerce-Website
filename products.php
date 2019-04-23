<?php
session_start();
require_once "dbcontroller.php";
$db_handle = new DBController();
if (!empty($_GET["action"])) {
    switch ($_GET["action"]) {
        case "add":
            if (!empty($_POST["quantity"])) {
                $productByCode = $db_handle->runQuery("SELECT * FROM tblproduct WHERE code='" . $_GET["code"] . "'");
                $itemArray = array($productByCode[0]["code"] => array('name' => $productByCode[0]["name"], 'code' => $productByCode[0]["code"], 'quantity' => $_POST["quantity"], 'price' => $productByCode[0]["price"], 'image' => $productByCode[0]["image"]));

                if (!empty($_SESSION["cart_item"])) {
                    if (in_array($productByCode[0]["code"], array_keys($_SESSION["cart_item"]))) {
                        foreach ($_SESSION["cart_item"] as $k => $v) {
                            if ($productByCode[0]["code"] == $k) {
                                if (empty($_SESSION["cart_item"][$k]["quantity"])) {
                                    $_SESSION["cart_item"][$k]["quantity"] = 0;
                                }
                                $_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
                            }
                        }
                    } else {
                        $_SESSION["cart_item"] = array_merge($_SESSION["cart_item"], $itemArray);
                    }
                } else {
                    $_SESSION["cart_item"] = $itemArray;
                }
            }
            break;
        case "remove":
            if (!empty($_SESSION["cart_item"])) {
                foreach ($_SESSION["cart_item"] as $k => $v) {
                    if ($_GET["code"] == $k) {
                        unset($_SESSION["cart_item"][$k]);
                    }

                    if (empty($_SESSION["cart_item"])) {
                        unset($_SESSION["cart_item"]);
                    }

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
        <title>Product Page</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
            integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"> -->
        <link rel="stylesheet" href="/~tn04662/sc/css/style.css" type="text/css">
        <link rel="stylesheet" href="/~tn04662/sc/css/products.css" type="text/css">
        <!-- Internal CSS -->
        <style>
        
        }
        </style>
    </head>

    <body>
        <div class="title-container">
            <div class="title-content">
                <img src="assets/Ecart_logo-white.svg" alt="Ecart Logo" width="100px">
                <h3 class="page-title">IT 3133 - E-Commerce</h3>
            </div>
        </div>

        <div class="banner-ad">
            <div class="container">
                <img src="assets/E-CommerceWebAd.png" alt="E-Commerce Web Add">
                <a href="https://my.georgiasouthern.edu/">REGISTER NOW</a>
            </div>
        </div>

        <div class="container">

            <div class="cart-preview" id="cart-preview">
                <div id="shopping-cart">
                    <?php
if (isset($_SESSION["cart_item"])) {
    $total_quantity = 0;
    $total_price = 0;
    ?>
                    <table class="tbl-cart">
                        <tbody>
                            <tr>
                                <th style="text-align:left;">Name</th>
                                <th style="text-align:left;" width="5%">Quantity</th>
                                <th style="text-align:left;" width="10%">Unit Price</th>
                                <th style="text-align:left;" width="10%">Price</th>
                                <th style="text-align:center;" width="5%">Remove</th>
                            </tr>
                            <?php
foreach ($_SESSION["cart_item"] as $item) {
        $item_price = $item["quantity"] * $item["price"];
        ?>
                            <tr>
                                <td><img src="<?php echo $item["image"]; ?>"
                                        class="cart-item-image" /><?php echo $item["name"]; ?></td>
                                <td style="text-align:left;"><?php echo $item["quantity"]; ?></td>
                                <td style="text-align:left;"><?php echo "$" . $item["price"]; ?></td>
                                <td style="text-align:left;"><?php echo "$" . number_format($item_price, 2); ?>
                                </td>
                                <td style="text-align:center;"><a
                                        href="products.php?action=remove&code=<?php echo $item["code"]; ?>"
                                        class="btnRemoveAction"><img src="icon-delete.png" alt="Remove Item" /></a></td>
                            </tr>
                            <?php
$total_quantity += $item["quantity"];
        $total_price += ($item["price"] * $item["quantity"]);
    }
    ?>

                            <tr>
                                <td colspan="3" align="right"><strong>TOTAL:</strong></td>
                                <td align="right"><strong><?php echo $total_quantity; ?></strong></td>
                                <td align="right">
                                    <strong><?php echo "$" . number_format($total_price, 2); ?></strong></td>

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
                <div class="go-to-cart-btn">
                    <a href="cart.php">GO TO CART</a>
                </div>
            </div>



            <div id="product-grid">
                <div class="txt-heading">
                    <h5>PRODUCTS</h5>
                    <div class="dropdown dropleft float-right">
                        <button class="cart-btn" onclick="hideShow()">
                            <i class="cart-icon fas fa-shopping-cart fa-1x"></i>
                            <p><?php echo 0 + $total_quantity; ?> Items</p>
                            <span class="tooltiptext">Click to preview cart</span>
                        </button>
                    </div>

                </div>

                <div class="product-content">
                    <!-- CATEGORY/SUBCATEGORY MENU -->
                    <div class="category-menu">
                        <div class="panel-group" id="accordionMenu" role="tablist" aria-multiselectable="true">
                            <div class="panel panel-default" style="background: #f15a29; color: #fff;">
                                <h4 style="text-align: center;">CATEGORIES</h4>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading">
                                    <h4 class="panel-title">
                                        <a class="collapsed tablinks" id="defaultOpen" role="button"
                                            data-parent="#accordionMenu" href=""
                                            onclick="productFilter(event, 'showall')">
                                            Show All
                                        </a>
                                    </h4>
                                </div>
                                <!-- <div id=" collapseOne" class="panel-collapse collapse in" role="tabpanel"
                                        aria-labelledby="headingOne">
                                        <div class="panel-body">
                                            <ul class="nav">
                                                <li><a href="#">item 1</a></li>
                                                <li><a href="#">item 2</a></li>
                                                <li><a href="#">item 3</a></li>
                                            </ul>
                                        </div>
                            </div> -->
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingOne">
                                    <h4 class="panel-title">
                                        <a class="collapsed tablinks" role="button" data-toggle="collapse"
                                            data-parent="#accordionMenu" href="#collapseOne" aria-expanded="false"
                                            aria-controls="collapseOne" onclick="productFilter(event, 'accessories')">
                                            Accessories
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseOne" class="panel-collapse collapse" role="tabpanel"
                                    aria-labelledby="headingOne">
                                    <div class="panel-body">
                                        <ul class="nav">
                                            <li><a class="tablinks" href="#"
                                                    onclick="productFilter(event, 'glasses')">Glasses</a></li>
                                            <li><a class="tablinks" href="#"
                                                    onclick="productFilter(event, 'watches')">Watches</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingTwo">
                                    <h4 class="panel-title">
                                        <a class="collapsed tablinks" role="button" data-toggle="collapse"
                                            data-parent="#accordionMenu" href="#collapseTwo" aria-expanded="false"
                                            href="" aria-controls="collapseTwo"
                                            onclick="productFilter(event, 'clothing')">
                                            Clothing
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel"
                                    aria-labelledby="headingTwo">
                                    <div class="panel-body">
                                        <ul class="nav">
                                            <li><a class="tablinks" href="#"
                                                    onclick="productFilter(event, 'clothingmen')">Men</a></li>
                                            <li><a class="tablinks" href="#"
                                                    onclick="productFilter(event, 'clothingwomen')">Women</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>


                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingThree">
                                    <h4 class="panel-title">
                                        <a class="collapsed tablinks" role="button" data-toggle="collapse"
                                            data-parent="#accordionMenu" href="#collapseThree" aria-expanded="false"
                                            aria-controls="collapseThree" onclick="productFilter(event, 'electronics')">
                                            Electronics
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseThree" class="panel-collapse collapse" role="tabpanel"
                                    aria-labelledby="headingThree">
                                    <div class="panel-body">
                                        <ul class="nav">
                                            <li><a class="tablinks" href="#"
                                                    onclick="productFilter(event, 'cameras')">Cameras</a></li>
                                            <li><a class="tablinks" href="#"
                                                    onclick="productFilter(event, 'drones')">Drones</a></li>
                                            <li><a class="tablinks" href="#"
                                                    onclick="productFilter(event, 'gaming')">Gaming</a></li>
                                            <li><a class="tablinks" href="#"
                                                    onclick="productFilter(event, 'headphones')">Headphones</a></li>
                                            <li><a class="tablinks" href="#"
                                                    onclick="productFilter(event, 'laptops')">Laptops</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingFour">
                                    <h4 class="panel-title">
                                        <a class="collapsed tablinks" role="button" data-toggle="collapse"
                                            data-parent="#accordionMenu" href="#collapseFour" aria-expanded="false"
                                            aria-controls="collapseFour" onclick="productFilter(event, 'shoes')">
                                            Shoes
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseFour" class="panel-collapse collapse" role="tabpanel"
                                    aria-labelledby="headingThree">
                                    <div class="panel-body">
                                        <ul class="nav">
                                            <li><a class="tablinks" href="#"
                                                    onclick="productFilter(event, 'shoesmen')">Men</a></li>
                                            <li><a class="tablinks" href="#"
                                                    onclick="productFilter(event, 'shoeswomen')">Women</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingFive">
                                    <h4 class="panel-title">
                                        <a class="collapsed tablinks" role="button" data-toggle="collapse"
                                            data-parent="#accordionMenu" href="#collapseFive" aria-expanded="false"
                                            aria-controls="collapseFive" onclick="productFilter(event, 'sports')">
                                            Sports
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseFive" class="panel-collapse collapse" role="tabpanel"
                                    aria-labelledby="headingFive">
                                    <div class="panel-body">
                                        <ul class="nav">
                                            <li><a class="tablinks" href="#"
                                                    onclick="productFilter(event, 'bikes')">Bikes</a></li>
                                            <li><a class="tablinks" href="#"
                                                    onclick="productFilter(event, 'equipment')">Equipments</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="grid-container">

                        <!-- CATEGORIES -->
                        <!-- Show All Start-->
                        <div class="products-holder tabcontent" id="showall">

                            <?php
$product_array = $db_handle->runQuery("SELECT * FROM tblproduct ORDER BY category ASC;");
if (!empty($product_array)) {
    foreach ($product_array as $key => $value) {
        ?>

                            <div class="product-container">
                                <div class="product-item">
                                    <form method="post"
                                        action="products.php?action=add&code=<?php echo $product_array[$key]["code"]; ?>">
                                        <div class="product-image"><img
                                                src="<?php echo $product_array[$key]["image"]; ?>">
                                        </div>
                                        <div class="product-tile-footer">
                                            <div class="product-title"><?php echo $product_array[$key]["name"]; ?></div>
                                            <div class="product-price">
                                                <?php echo "$" . $product_array[$key]["price"]; ?>
                                            </div>
                                            <div class="cart-action">
                                                <input type="number" class="product-quantity" name="quantity" value="1"
                                                    min="1" pattern="[1-9]+" required />
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
                        <!-- Show All End -->

                        <div class="products-holder tabcontent" id="accessories" style="display:none;">

                            <?php
$product_array = $db_handle->runQuery("SELECT * FROM tblproduct WHERE category='Accessories';");
if (!empty($product_array)) {
    foreach ($product_array as $key => $value) {
        ?>

                            <div class="product-container">
                                <div class="product-item">
                                    <form method="post"
                                        action="products.php?action=add&code=<?php echo $product_array[$key]["code"]; ?>">
                                        <div class="product-image"><img
                                                src="<?php echo $product_array[$key]["image"]; ?>">
                                        </div>
                                        <div class="product-tile-footer">
                                            <div class="product-title"><?php echo $product_array[$key]["name"]; ?></div>
                                            <div class="product-price">
                                                <?php echo "$" . $product_array[$key]["price"]; ?>
                                            </div>
                                            <div class="cart-action">
                                                <input type="number" class="product-quantity" name="quantity" value="1"
                                                    min="1" pattern="[1-9]+" required />
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

                        <div class="products-holder tabcontent" id="clothing" style="display:none;">

                            <?php
$product_array = $db_handle->runQuery("SELECT * FROM tblproduct WHERE category='Clothing';");
if (!empty($product_array)) {
    foreach ($product_array as $key => $value) {
        ?>

                            <div class="product-container">
                                <div class="product-item">
                                    <form method="post"
                                        action="products.php?action=add&code=<?php echo $product_array[$key]["code"]; ?>">
                                        <div class="product-image"><img
                                                src="<?php echo $product_array[$key]["image"]; ?>">
                                        </div>
                                        <div class="product-tile-footer">
                                            <div class="product-title"><?php echo $product_array[$key]["name"]; ?></div>
                                            <div class="product-price">
                                                <?php echo "$" . $product_array[$key]["price"]; ?>
                                            </div>
                                            <div class="cart-action">
                                                <input type="number" class="product-quantity" name="quantity" value="1"
                                                    min="1" pattern="[1-9]+" required />
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

                        <div class="products-holder tabcontent" id="electronics" style="display:none;">

                            <?php
$product_array = $db_handle->runQuery("SELECT * FROM tblproduct WHERE category='Electronics';");
if (!empty($product_array)) {
    foreach ($product_array as $key => $value) {
        ?>

                            <div class="product-container">
                                <div class="product-item">
                                    <form method="post"
                                        action="products.php?action=add&code=<?php echo $product_array[$key]["code"]; ?>">
                                        <div class="product-image"><img
                                                src="<?php echo $product_array[$key]["image"]; ?>">
                                        </div>
                                        <div class="product-tile-footer">
                                            <div class="product-title"><?php echo $product_array[$key]["name"]; ?></div>
                                            <div class="product-price">
                                                <?php echo "$" . $product_array[$key]["price"]; ?>
                                            </div>
                                            <div class="cart-action">
                                                <input type="number" class="product-quantity" name="quantity" value="1"
                                                    min="1" pattern="[1-9]+" required />
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

                        <div class="products-holder tabcontent" id="shoes" style="display:none;">

                            <?php
$product_array = $db_handle->runQuery("SELECT * FROM tblproduct WHERE category='Shoes';");
if (!empty($product_array)) {
    foreach ($product_array as $key => $value) {
        ?>

                            <div class="product-container">
                                <div class="product-item">
                                    <form method="post"
                                        action="products.php?action=add&code=<?php echo $product_array[$key]["code"]; ?>">
                                        <div class="product-image"><img
                                                src="<?php echo $product_array[$key]["image"]; ?>">
                                        </div>
                                        <div class="product-tile-footer">
                                            <div class="product-title"><?php echo $product_array[$key]["name"]; ?></div>
                                            <div class="product-price">
                                                <?php echo "$" . $product_array[$key]["price"]; ?>
                                            </div>
                                            <div class="cart-action">
                                                <input type="number" class="product-quantity" name="quantity" value="1"
                                                    min="1" pattern="[1-9]+" required />
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

                        <div class="products-holder tabcontent" id="sports" style="display:none;">

                            <?php
$product_array = $db_handle->runQuery("SELECT * FROM tblproduct WHERE category='Sports';");
if (!empty($product_array)) {
    foreach ($product_array as $key => $value) {
        ?>

                            <div class="product-container">
                                <div class="product-item">
                                    <form method="post"
                                        action="products.php?action=add&code=<?php echo $product_array[$key]["code"]; ?>">
                                        <div class="product-image"><img
                                                src="<?php echo $product_array[$key]["image"]; ?>">
                                        </div>
                                        <div class="product-tile-footer">
                                            <div class="product-title"><?php echo $product_array[$key]["name"]; ?></div>
                                            <div class="product-price">
                                                <?php echo "$" . $product_array[$key]["price"]; ?>
                                            </div>
                                            <div class="cart-action">
                                                <input type="number" class="product-quantity" name="quantity" value="1"
                                                    min="1" pattern="[1-9]+" required />
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

                        <!-- SUBCATEGORIES -->
                        <!-- Accessories Start-->
                        <div class="products-holder tabcontent" id="glasses" style="display:none;">

                            <?php
$product_array = $db_handle->runQuery("SELECT DISTINCT * FROM tblproduct WHERE category='Accessories' AND subcategory='Glasses';");
if (!empty($product_array)) {
    foreach ($product_array as $key => $value) {
        ?>

                            <div class="product-container">
                                <div class="product-item">
                                    <form method="post"
                                        action="products.php?action=add&code=<?php echo $product_array[$key]["code"]; ?>">
                                        <div class="product-image"><img
                                                src="<?php echo $product_array[$key]["image"]; ?>">
                                        </div>
                                        <div class="product-tile-footer">
                                            <div class="product-title"><?php echo $product_array[$key]["name"]; ?></div>
                                            <div class="product-price">
                                                <?php echo "$" . $product_array[$key]["price"]; ?>
                                            </div>
                                            <div class="cart-action">
                                                <input type="number" class="product-quantity" name="quantity" value="1"
                                                    min="1" pattern="[1-9]+" required />
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

                        <div class="products-holder tabcontent" id="watches" style="display:none;">

                            <?php
$product_array = $db_handle->runQuery("SELECT DISTINCT * FROM tblproduct WHERE category='Accessories' AND subcategory='Watches';");
if (!empty($product_array)) {
    foreach ($product_array as $key => $value) {
        ?>

                            <div class="product-container">
                                <div class="product-item">
                                    <form method="post"
                                        action="products.php?action=add&code=<?php echo $product_array[$key]["code"]; ?>">
                                        <div class="product-image"><img
                                                src="<?php echo $product_array[$key]["image"]; ?>">
                                        </div>
                                        <div class="product-tile-footer">
                                            <div class="product-title"><?php echo $product_array[$key]["name"]; ?></div>
                                            <div class="product-price">
                                                <?php echo "$" . $product_array[$key]["price"]; ?>
                                            </div>
                                            <div class="cart-action">
                                                <input type="number" class="product-quantity" name="quantity" value="1"
                                                    min="1" pattern="[1-9]+" required />
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
                        <!-- Accessories End -->

                        <!-- Clothing Start -->
                        <div class="products-holder tabcontent" id="clothingmen" style="display:none;">

                            <?php
$product_array = $db_handle->runQuery("SELECT DISTINCT * FROM tblproduct WHERE category='Clothing' AND subcategory='Men';");
if (!empty($product_array)) {
    foreach ($product_array as $key => $value) {
        ?>

                            <div class="product-container">
                                <div class="product-item">
                                    <form method="post"
                                        action="products.php?action=add&code=<?php echo $product_array[$key]["code"]; ?>">
                                        <div class="product-image"><img
                                                src="<?php echo $product_array[$key]["image"]; ?>">
                                        </div>
                                        <div class="product-tile-footer">
                                            <div class="product-title"><?php echo $product_array[$key]["name"]; ?></div>
                                            <div class="product-price">
                                                <?php echo "$" . $product_array[$key]["price"]; ?>
                                            </div>
                                            <div class="cart-action">
                                                <input type="number" class="product-quantity" name="quantity" value="1"
                                                    min="1" pattern="[1-9]+" required />
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

                        <div class="products-holder tabcontent" id="clothingwomen" style="display:none;">

                            <?php
$product_array = $db_handle->runQuery("SELECT DISTINCT * FROM tblproduct WHERE category='Clothing' AND subcategory='Women';");
if (!empty($product_array)) {
    foreach ($product_array as $key => $value) {
        ?>

                            <div class="product-container">
                                <div class="product-item">
                                    <form method="post"
                                        action="products.php?action=add&code=<?php echo $product_array[$key]["code"]; ?>">
                                        <div class="product-image"><img
                                                src="<?php echo $product_array[$key]["image"]; ?>">
                                        </div>
                                        <div class="product-tile-footer">
                                            <div class="product-title"><?php echo $product_array[$key]["name"]; ?></div>
                                            <div class="product-price">
                                                <?php echo "$" . $product_array[$key]["price"]; ?>
                                            </div>
                                            <div class="cart-action">
                                                <input type="number" class="product-quantity" name="quantity" value="1"
                                                    min="1" pattern="[1-9]+" required />
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
                        <!-- Clothing End -->

                        <!-- Electronics Start -->
                        <div class="products-holder tabcontent" id="cameras" style="display:none;">

                            <?php
$product_array = $db_handle->runQuery("SELECT DISTINCT * FROM tblproduct WHERE category='Electronics' AND subcategory='Cameras';");
if (!empty($product_array)) {
    foreach ($product_array as $key => $value) {
        ?>

                            <div class="product-container">
                                <div class="product-item">
                                    <form method="post"
                                        action="products.php?action=add&code=<?php echo $product_array[$key]["code"]; ?>">
                                        <div class="product-image"><img
                                                src="<?php echo $product_array[$key]["image"]; ?>">
                                        </div>
                                        <div class="product-tile-footer">
                                            <div class="product-title"><?php echo $product_array[$key]["name"]; ?></div>
                                            <div class="product-price">
                                                <?php echo "$" . $product_array[$key]["price"]; ?>
                                            </div>
                                            <div class="cart-action">
                                                <input type="number" class="product-quantity" name="quantity" value="1"
                                                    min="1" pattern="[1-9]+" required />
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

                        <div class="products-holder tabcontent" id="drones" style="display:none;">

                            <?php
$product_array = $db_handle->runQuery("SELECT DISTINCT * FROM tblproduct WHERE category='Electronics' AND subcategory='Drones';");
if (!empty($product_array)) {
    foreach ($product_array as $key => $value) {
        ?>

                            <div class="product-container">
                                <div class="product-item">
                                    <form method="post"
                                        action="products.php?action=add&code=<?php echo $product_array[$key]["code"]; ?>">
                                        <div class="product-image"><img
                                                src="<?php echo $product_array[$key]["image"]; ?>">
                                        </div>
                                        <div class="product-tile-footer">
                                            <div class="product-title"><?php echo $product_array[$key]["name"]; ?></div>
                                            <div class="product-price">
                                                <?php echo "$" . $product_array[$key]["price"]; ?>
                                            </div>
                                            <div class="cart-action">
                                                <input type="number" class="product-quantity" name="quantity" value="1"
                                                    min="1" pattern="[1-9]+" required />
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

                        <div class="products-holder tabcontent" id="gaming" style="display:none;">

                            <?php
$product_array = $db_handle->runQuery("SELECT DISTINCT * FROM tblproduct WHERE category='Electronics' AND subcategory='Gaming';");
if (!empty($product_array)) {
    foreach ($product_array as $key => $value) {
        ?>

                            <div class="product-container">
                                <div class="product-item">
                                    <form method="post"
                                        action="products.php?action=add&code=<?php echo $product_array[$key]["code"]; ?>">
                                        <div class="product-image"><img
                                                src="<?php echo $product_array[$key]["image"]; ?>">
                                        </div>
                                        <div class="product-tile-footer">
                                            <div class="product-title"><?php echo $product_array[$key]["name"]; ?></div>
                                            <div class="product-price">
                                                <?php echo "$" . $product_array[$key]["price"]; ?>
                                            </div>
                                            <div class="cart-action">
                                                <input type="number" class="product-quantity" name="quantity" value="1"
                                                    min="1" pattern="[1-9]+" required />
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

                        <div class="products-holder tabcontent" id="headphones" style="display:none;">

                            <?php
$product_array = $db_handle->runQuery("SELECT DISTINCT * FROM tblproduct WHERE category='Electronics' AND subcategory='Headphones';");
if (!empty($product_array)) {
    foreach ($product_array as $key => $value) {
        ?>

                            <div class="product-container">
                                <div class="product-item">
                                    <form method="post"
                                        action="products.php?action=add&code=<?php echo $product_array[$key]["code"]; ?>">
                                        <div class="product-image"><img
                                                src="<?php echo $product_array[$key]["image"]; ?>">
                                        </div>
                                        <div class="product-tile-footer">
                                            <div class="product-title"><?php echo $product_array[$key]["name"]; ?></div>
                                            <div class="product-price">
                                                <?php echo "$" . $product_array[$key]["price"]; ?>
                                            </div>
                                            <div class="cart-action">
                                                <input type="number" class="product-quantity" name="quantity" value="1"
                                                    min="1" pattern="[1-9]+" required />
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

                        <div class="products-holder tabcontent" id="laptops" style="display:none;">

                            <?php
$product_array = $db_handle->runQuery("SELECT DISTINCT * FROM tblproduct WHERE category='Electronics' AND subcategory='Laptop';");
if (!empty($product_array)) {
    foreach ($product_array as $key => $value) {
        ?>

                            <div class="product-container">
                                <div class="product-item">
                                    <form method="post"
                                        action="products.php?action=add&code=<?php echo $product_array[$key]["code"]; ?>">
                                        <div class="product-image"><img
                                                src="<?php echo $product_array[$key]["image"]; ?>">
                                        </div>
                                        <div class="product-tile-footer">
                                            <div class="product-title"><?php echo $product_array[$key]["name"]; ?></div>
                                            <div class="product-price">
                                                <?php echo "$" . $product_array[$key]["price"]; ?>
                                            </div>
                                            <div class="cart-action">
                                                <input type="number" class="product-quantity" name="quantity" value="1"
                                                    min="1" pattern="[1-9]+" required />
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
                        <!-- Electronics End -->

                        <!-- Shoes Start -->
                        <div class="products-holder tabcontent" id="shoesmen" style="display:none;">

                            <?php
$product_array = $db_handle->runQuery("SELECT DISTINCT * FROM tblproduct WHERE category='Shoes' AND subcategory='Men';");
if (!empty($product_array)) {
    foreach ($product_array as $key => $value) {
        ?>

                            <div class="product-container">
                                <div class="product-item">
                                    <form method="post"
                                        action="products.php?action=add&code=<?php echo $product_array[$key]["code"]; ?>">
                                        <div class="product-image"><img
                                                src="<?php echo $product_array[$key]["image"]; ?>">
                                        </div>
                                        <div class="product-tile-footer">
                                            <div class="product-title"><?php echo $product_array[$key]["name"]; ?></div>
                                            <div class="product-price">
                                                <?php echo "$" . $product_array[$key]["price"]; ?>
                                            </div>
                                            <div class="cart-action">
                                                <input type="number" class="product-quantity" name="quantity" value="1"
                                                    min="1" pattern="[1-9]+" required />
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

                        <div class="products-holder tabcontent" id="shoeswomen" style="display:none;">

                            <?php
$product_array = $db_handle->runQuery("SELECT DISTINCT * FROM tblproduct WHERE category='Shoes' AND subcategory='Women';");
if (!empty($product_array)) {
    foreach ($product_array as $key => $value) {
        ?>

                            <div class="product-container">
                                <div class="product-item">
                                    <form method="post"
                                        action="products.php?action=add&code=<?php echo $product_array[$key]["code"]; ?>">
                                        <div class="product-image"><img
                                                src="<?php echo $product_array[$key]["image"]; ?>">
                                        </div>
                                        <div class="product-tile-footer">
                                            <div class="product-title"><?php echo $product_array[$key]["name"]; ?></div>
                                            <div class="product-price">
                                                <?php echo "$" . $product_array[$key]["price"]; ?>
                                            </div>
                                            <div class="cart-action">
                                                <input type="number" class="product-quantity" name="quantity" value="1"
                                                    min="1" pattern="[1-9]+" required />
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
                        <!-- Shoes End -->

                        <!-- Sports Start -->
                        <div class="products-holder tabcontent" id="bikes" style="display:none;">

                            <?php
$product_array = $db_handle->runQuery("SELECT DISTINCT * FROM tblproduct WHERE category='Sports' AND subcategory='Bikes';");
if (!empty($product_array)) {
    foreach ($product_array as $key => $value) {
        ?>

                            <div class="product-container">
                                <div class="product-item">
                                    <form method="post"
                                        action="products.php?action=add&code=<?php echo $product_array[$key]["code"]; ?>">
                                        <div class="product-image"><img
                                                src="<?php echo $product_array[$key]["image"]; ?>">
                                        </div>
                                        <div class="product-tile-footer">
                                            <div class="product-title"><?php echo $product_array[$key]["name"]; ?></div>
                                            <div class="product-price">
                                                <?php echo "$" . $product_array[$key]["price"]; ?>
                                            </div>
                                            <div class="cart-action">
                                                <input type="number" class="product-quantity" name="quantity" value="1"
                                                    min="1" pattern="[1-9]+" required />
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

                        <div class="products-holder tabcontent" id="equipment" style="display:none;">

                            <?php
$product_array = $db_handle->runQuery("SELECT DISTINCT * FROM tblproduct WHERE category='Sports' AND subcategory='Equipment';");
if (!empty($product_array)) {
    foreach ($product_array as $key => $value) {
        ?>

                            <div class="product-container">
                                <div class="product-item">
                                    <form method="post"
                                        action="products.php?action=add&code=<?php echo $product_array[$key]["code"]; ?>">
                                        <div class="product-image"><img
                                                src="<?php echo $product_array[$key]["image"]; ?>">
                                        </div>
                                        <div class="product-tile-footer">
                                            <div class="product-title"><?php echo $product_array[$key]["name"]; ?></div>
                                            <div class="product-price">
                                                <?php echo "$" . $product_array[$key]["price"]; ?>
                                            </div>
                                            <div class="cart-action">
                                                <input type="number" class="product-quantity" name="quantity" value="1"
                                                    min="1" pattern="[1-9]+" required />
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
                        <!-- Sports End -->

                    </div>


                </div>


            </div>
        </div>
        </div>

        <footer>
            <p class="copyright">
                Copyright <i class="fa fa-copyright" aria-hidden="true"></i> 2019 ECart.com. All Right Reserved
            </p>
        </footer>

        <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
        </script> -->
        <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script>
        function hideShow() {
            var cartPreview = document.getElementById("cart-preview");
            if (cartPreview.style.display === "flex") {
                cartPreview.style.display = "none";
            } else {
                cartPreview.style.display = "flex";
            }
        }

        function productFilter(evt, category) {
            // Declare all variables
            var i, tabcontent, tablinks;

            // Get all elements with class="tabcontent" and hide them
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }

            // Get all elements with class="tablinks" and remove the class "active"
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }

            // Show the current tab, and add an "active" class to the link that opened the tab
            document.getElementById(category).style.display = "grid";
            evt.currentTarget.className += " active";
        }

        // Get the element with id="defaultOpen" and click on it
        // document.getElementById("defaultOpen").click();

        // function filter(category) {
        //     var category = document.querySelector(category);
        //     if (category.style.display === "none") {
        //         category.style.display = "grid";
        //     } else {
        //         category.style.display = "none";
        //     }
        // }
        // $(".cart-icon").on("mouseenter", function() {
        //         $(".cart-preview").show();
        //     })
        //     .on("mouseleave", function() {
        //         $(".cart-preview").hide();
        //     });
        </script>

    </body>

</html>