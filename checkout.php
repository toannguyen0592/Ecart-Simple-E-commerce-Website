<?php
    session_start();
    // require_once("dbcontroller.php");
?>
<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Check Out - IT 3133 - E-Commerce</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Bootstrap CSS -->
        <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous"> -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css" type="text/css" />
        <link rel="stylesheet" href="css/checkout.css" type="text/css" />
        <style>
        
        </style>
    </head>

    <body>
        <div class="title-container">
            <img src="assets/Ecart_logo-white.svg" alt="Ecart Logo" width="100px">
            <h3 class="page-title">IT 3133 - E-Commerce</h3>
        </div>
        <div class="container">
            <div class="txt-heading">
                <h5>CHECK OUT</h5>
            </div>
            
            <div class="grid-container">

                <div class="grid-item" id="cart-summary">
                    <legend>Your Cart</legend>
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

                <div class="grid-item" id="checkout-info">
                    <form name="checkout" action="submit.php" method="post" class="checkout">
                        <div class="row">
                            <fieldset class="form-field col">
                                <legend>Billing Information</legend>
                                <div class="form-row">
                                    <div class="form-group col">
                                        <label for="#fname">First Name</label>
                                        <input class="form-control" id="fname" type="text" name="fname"
                                            pattern="[A-Za-z]+" maxlength="30" title="Letters only" required>
                                    </div>
                                    <div class="form-group col">
                                        <label for="#lname">Last Name</label>
                                        <input class="form-control" id="lname" type="text" name="lname"
                                            pattern="[A-Za-z]+" maxlength="30" title="Letters only" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="#address">Billing Address</label>
                                    <input class="form-control" id="address" type="text" name="address"
                                        pattern="[A-Za-z0-9 ]+" title="123 Example Street" required>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col">
                                        <label for="#city">City</label>
                                        <input class="form-control" id="city" type="text" name="city"
                                            pattern="[A-Za-z ]+" maxlength="30" title="Letters only" required>
                                    </div>
                                    <div class="form-group col">
                                        <label for="#state">State</label>
                                        <select name="state" class="custom-select" id="state" required>
                                            <option selected="selected" value="AL">Alabama</option>
                                            <option value="AK">Alaska</option>
                                            <option value="AZ">Arizona</option>
                                            <option value="AR">Arkansas</option>
                                            <option value="CA">California</option>
                                            <option value="CO">Colorado</option>
                                            <option value="CT">Connecticut</option>
                                            <option value="DE">Delaware</option>
                                            <option value="DC">District Of Columbia</option>
                                            <option value="FL">Florida</option>
                                            <option value="GA">Georgia</option>
                                            <option value="HI">Hawaii</option>
                                            <option value="ID">Idaho</option>
                                            <option value="IL">Illinois</option>
                                            <option value="IN">Indiana</option>
                                            <option value="IA">Iowa</option>
                                            <option value="KS">Kansas</option>
                                            <option value="KY">Kentucky</option>
                                            <option value="LA">Louisiana</option>
                                            <option value="ME">Maine</option>
                                            <option value="MD">Maryland</option>
                                            <option value="MA">Massachusetts</option>
                                            <option value="MI">Michigan</option>
                                            <option value="MN">Minnesota</option>
                                            <option value="MS">Mississippi</option>
                                            <option value="MO">Missouri</option>
                                            <option value="MT">Montana</option>
                                            <option value="NE">Nebraska</option>
                                            <option value="NV">Nevada</option>
                                            <option value="NH">New Hampshire</option>
                                            <option value="NJ">New Jersey</option>
                                            <option value="NM">New Mexico</option>
                                            <option value="NY">New York</option>
                                            <option value="NC">North Carolina</option>
                                            <option value="ND">North Dakota</option>
                                            <option value="OH">Ohio</option>
                                            <option value="OK">Oklahoma</option>
                                            <option value="OR">Oregon</option>
                                            <option value="PA">Pennsylvania</option>
                                            <option value="RI">Rhode Island</option>
                                            <option value="SC">South Carolina</option>
                                            <option value="SD">South Dakota</option>
                                            <option value="TN">Tennessee</option>
                                            <option value="TX">Texas</option>
                                            <option value="UT">Utah</option>
                                            <option value="VT">Vermont</option>
                                            <option value="VA">Virginia</option>
                                            <option value="WA">Washington</option>
                                            <option value="WV">West Virginia</option>
                                            <option value="WI">Wisconsin</option>
                                            <option value="WY">Wyoming</option>
                                        </select>
                                    </div>
                                    <div class="form-group col">
                                        <label for="#zip">Zipcode</label>
                                        <input class="form-control" id="zip" type="text" name="zip" pattern="[0-9]+"
                                            title="nnnnn" maxlength="10" required>
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset class="form-field col">
                                <legend>Shipping & Handling</legend>
                                <div class="form-group">
                                    <div class="form-check col">
                                        <input class="form-check-input" type="radio" name="shipping" id="shipping1"
                                            value="FREE" checked>
                                        <label class="form-check-label" for="shipping1">
                                            FREE
                                        </label>
                                    </div>
                                    <div class="form-check col">
                                        <input class="form-check-input" type="radio" name="shipping" id="shipping2"
                                            value="Standard">
                                        <label class="form-check-label" for="shipping2">
                                            Standard
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">

                                    <div class="form-group">
                                        <label for="#address">Mailing Address</label>&nbsp;&nbsp;&nbsp;<input
                                            type="checkbox" name="sameAddress" onclick="setBilling(this.checked);"> Same
                                        as
                                        billing address
                                        <input class="form-control" id="mailaddress" type="text" name="mailaddress"
                                            pattern="[A-Za-z0-9 ]+" title="123 Example Street" required>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col">
                                            <label for="#city">City</label>
                                            <input class="form-control" id="mailcity" type="text" name="mailcity"
                                                pattern="[A-Za-z ]+" maxlength="30" title="Letters only" required>
                                        </div>
                                        <div class="form-group col">
                                            <label for="#state">State</label>
                                            <select name="mailstate" class="custom-select" id="mailstate" required>
                                                <option selected="selected" value="AL">Alabama</option>
                                                <option value="AK">Alaska</option>
                                                <option value="AZ">Arizona</option>
                                                <option value="AR">Arkansas</option>
                                                <option value="CA">California</option>
                                                <option value="CO">Colorado</option>
                                                <option value="CT">Connecticut</option>
                                                <option value="DE">Delaware</option>
                                                <option value="DC">District Of Columbia</option>
                                                <option value="FL">Florida</option>
                                                <option value="GA">Georgia</option>
                                                <option value="HI">Hawaii</option>
                                                <option value="ID">Idaho</option>
                                                <option value="IL">Illinois</option>
                                                <option value="IN">Indiana</option>
                                                <option value="IA">Iowa</option>
                                                <option value="KS">Kansas</option>
                                                <option value="KY">Kentucky</option>
                                                <option value="LA">Louisiana</option>
                                                <option value="ME">Maine</option>
                                                <option value="MD">Maryland</option>
                                                <option value="MA">Massachusetts</option>
                                                <option value="MI">Michigan</option>
                                                <option value="MN">Minnesota</option>
                                                <option value="MS">Mississippi</option>
                                                <option value="MO">Missouri</option>
                                                <option value="MT">Montana</option>
                                                <option value="NE">Nebraska</option>
                                                <option value="NV">Nevada</option>
                                                <option value="NH">New Hampshire</option>
                                                <option value="NJ">New Jersey</option>
                                                <option value="NM">New Mexico</option>
                                                <option value="NY">New York</option>
                                                <option value="NC">North Carolina</option>
                                                <option value="ND">North Dakota</option>
                                                <option value="OH">Ohio</option>
                                                <option value="OK">Oklahoma</option>
                                                <option value="OR">Oregon</option>
                                                <option value="PA">Pennsylvania</option>
                                                <option value="RI">Rhode Island</option>
                                                <option value="SC">South Carolina</option>
                                                <option value="SD">South Dakota</option>
                                                <option value="TN">Tennessee</option>
                                                <option value="TX">Texas</option>
                                                <option value="UT">Utah</option>
                                                <option value="VT">Vermont</option>
                                                <option value="VA">Virginia</option>
                                                <option value="WA">Washington</option>
                                                <option value="WV">West Virginia</option>
                                                <option value="WI">Wisconsin</option>
                                                <option value="WY">Wyoming</option>
                                            </select>
                                        </div>
                                        <div class="form-group col">
                                            <label for="#zip">Zipcode</label>
                                            <input class="form-control" id="mailzip" type="text" name="mailzip"
                                                pattern="(\d{5}([\-]\d{4})?)" title="nnnnn or nnnnn-nnnn" maxlength="10"
                                                required>
                                        </div>
                                    </div>
                                </div>


                            </fieldset>
                        </div>


                        <div class="row">


                            <fieldset class="form-field col">
                                <legend>Payment Information</legend>
                                <div class="form-group">
                                    <label for="#card-number">Card Number</label>
                                    <input class="form-control" id="card-number" type="text" name="card-number"
                                        pattern="[0-9]{16}" maxlength="16" title="XXXXXXXXXXXXXXXX" required>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col">
                                        <label for="#exp-date">Expire</label>
                                        <div class="form-row">
                                            <select name="month" class="custom-select col" required>
                                                <option value="01">01</option>
                                                <option value="02">02</option>
                                                <option value="03">03</option>
                                                <option value="04">04</option>
                                                <option value="05">05</option>
                                                <option value="06">06</option>
                                                <option value="07">07</option>
                                                <option value="08">08</option>
                                                <option value="09">09</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                            </select>
                                            <select name="year" class="custom-select col" required>
                                                <option value="19">19</option>
                                                <option value="20">20</option>
                                                <option value="21">21</option>
                                                <option value="22">22</option>
                                                <option value="23">23</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col">
                                        <label for="#securecode">CVV</label>
                                        <input class="form-control" id="securecode" type="password" name="securecode"
                                            pattern="[0-9]{3}" title="Three number code (CVV)" maxlength="3" size="3"
                                            required>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="form-field col">
                                <legend>Order Contact</legend>
                                <div class="form-group">
                                    <label for="#email">Email</label>
                                    <input class="form-control" id="email" type="email" name="email" required>
                                </div>
                                <div class="form-group">
                                    <label for="#phone">Phone</label>
                                    <input class="form-control" id="phone" type="text" name="phone" maxlength="12"
                                        pattern="\d{3}[\-]\d{3}[\-]\d{4}" title="123-456-7890"
                                        placeholder="e.g. 123-456-7890">
                                </div>
                            </fieldset>
                            <input type="submit" id="submit" class="btn btn-primary" name="submit"
                                onclick="insertToDb();" value="SUBMIT ORDER">
                        </div>
                    </form>
                </div>

            </div>
        </div>

        <footer>
            <p class="copyright">
                Copyright <i class="fa fa-copyright" aria-hidden="true"></i> 2019 ECart.com. All Right Reserved
            </p>
        </footer>

        <script type="text/javascript">
        function setBilling(checked) {
            if (checked) {
                document.getElementById('mailaddress').value = document.getElementById('address').value;
                document.getElementById('mailcity').value = document.getElementById('city').value;
                document.getElementById('mailstate').value = document.getElementById('state').value;
                document.getElementById('mailzip').value = document.getElementById('zip').value;
            } else {
                document.getElementById('mailaddress').value = '';
                document.getElementById('mailcity').value = '';
                document.getElementById('mailstate').value = '';
                document.getElementById('mailzip').value = '';
            }
        }
        </script>

        <!-- Javascripts for Bootstrap -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
        </script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
        </script>

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    </body>

</html>
