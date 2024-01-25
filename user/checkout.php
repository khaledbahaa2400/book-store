<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>checkout</title>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
        <link rel="stylesheet" href="../css/style.css">

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
    </head>
    <body>
        <?php
            include_once('../shared/config.php');
            include_once('../shared/check_authorization.php');
            include_once('shared/user_header.php');

            $userId =unserialize($_COOKIE['user'])['id'];
            if(isset($_POST['placeOrder'])):
                $number = $_POST['number'];
                $method = $_POST['method'];
                $price = $_POST['price'];
                $products = $_POST['products'];
                $address = mysqli_real_escape_string($conn, 'building no. '. $_POST['building'].', '. $_POST['street'].', '. $_POST['governorate'].', '. $_POST['country'].' - '. $_POST['postal']);

                mysqli_query($conn, "INSERT INTO `orders`(`user_id`, `number`, `payment_method`, `address`, `total_products`, `total_price`) VALUES('$userId', '$number', '$method', '$address', '$products', '$price')") or die('query failed');
                mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$userId'") or die('query failed');
                header('Location: orders.php');
            endif;
        ?>

        <div class="heading">
            <h3>shopping cart</h3>
            <p> <a href="home.php">home</a> / checkout </p>
        </div>

        <section class="display-order">
            <?php  
                $totalPrice = 0;
                $totalProducts = '';
                $cartItems = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$userId'") or die('query failed');
                if(mysqli_num_rows($cartItems) > 0):
                    while($cartItem = mysqli_fetch_assoc($cartItems)):
                        $productId = $cartItem['product_id'];
                        $product = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `products` WHERE `id` = '$productId'"));

                        $totalItemPrice = ($product['price'] * $cartItem['quantity']);
                        $totalPrice += $totalItemPrice;
                        $item = $product['name'] . ' (' . $cartItem['quantity'] . ')';
                        $totalProducts == '' ? $totalProducts .= $item : $totalProducts .= ', ' . $item ;
            ?>

            <p><?php echo $product['name']; ?><span>(<?php echo '$' . $product['price'] . '/- x ' .  $cartItem['quantity']; ?>)</span></p>

            <?php
                endwhile;
                else:
            ?>
                <p class="empty">your cart is empty</p>
                <div class="grand-total"> grand total : <span>$<?php echo $totalPrice; ?>/-</span></div>
                
                <div class="flex">
                    <a href="shop.php" class="option-btn" style="margin: 2.5rem;">continue shopping</a>
                </div>
                <?php endif; ?>
        </section>

        <?php if($totalPrice != 0): ?>
        <section class="checkout">
            <form action="" method="post">
                <h3>place your order</h3>

                <input type="hidden" name="price" value="<?php echo $totalPrice; ?>">
                <input type="hidden" name="products" value="<?php echo $totalProducts; ?>">

                <div class="flex">
                    <div class="inputBox">
                        <span>your number :</span>
                        <input type="number" name="number" placeholder="enter your number" required>
                    </div>

                    <div class="inputBox">
                        <span>payment method :</span>

                        <select name="method">
                            <option value="cash_on_delivery">cash on delivery</option>
                            <option value="credit_card">credit card</option>
                            <option value="paypal">paypal</option>
                        </select>
                    </div>

                    <div class="inputBox">
                        <span>address line 01 :</span>
                        <input type="number" name="building" placeholder="e.g. building no." min="1" required>
                    </div>

                    <div class="inputBox">
                        <span>address line 02 :</span>
                        <input type="text" name="street" placeholder="e.g. street name" required>
                    </div>

                    <div class="inputBox">
                        <span>city :</span>
                        <input type="text" name="city" placeholder="e.g. Dokki" required>
                    </div>

                    <div class="inputBox">
                        <span>governorate :</span>
                        <input type="text" name="governorate" placeholder="e.g. Giza" required>
                    </div>

                    <div class="inputBox">
                        <span>country :</span>
                        <input type="text" name="country" placeholder="e.g. Egypt" required>
                    </div>

                    <div class="inputBox">
                        <span>postal code :</span>
                        <input type="number" name="postal" placeholder="e.g. 123456" min="0" required>
                    </div>
                </div>

                <input type="submit" name="placeOrder" value="order now" class="btn">
            </form>
        </section>
        <?php endif; ?>
        
        <?php include_once('shared/user_footer.php'); ?>
        <script src="../js/user_scripts.js"></script>
    </body>
</html>