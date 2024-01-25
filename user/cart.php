<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>cart</title>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
        <link rel="stylesheet" href="../css/style.css">

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
    </head>
    <body>
        <?php
            include_once('../shared/check_authorization.php');
            include_once('../shared/display_message.php');
            include_once '../shared/config.php';
            include_once('shared/user_header.php');

            $userId = unserialize($_COOKIE['user'])['id'];
            if(isset($_POST['update'])):
                $id = $_POST['id'];
                $quantity = $_POST['quantity'];
                mysqli_query($conn, "UPDATE `cart` SET `quantity` = '$quantity' WHERE `id` = '$id'");
                echo '<script>toastr.options.timeOut = 2000;toastr.success("Item Updated Successfully")</script>';
            endif;

            if(isset($_GET['delete'])):
                $id = $_GET['delete'];
                mysqli_query($conn, "DELETE FROM `cart` WHERE `id` = '$id'");
                setcookie('message', '.success("Item Deleted Successfully")', path: '/book%20store/');
                header('Location: cart.php');
            endif;

            if(isset($_GET['deleteAll'])):
                mysqli_query($conn, "DELETE FROM `cart` WHERE `user_id` = '$userId'");
                setcookie('message', '.success("Cart Cleared Successfully")', path: '/book%20store/');
                header('Location: cart.php');
            endif;
        ?>

        <div class="heading">
            <h3>shopping cart</h3>
            <p> <a href="home.php">home</a> / cart </p>
        </div>

        <section class="shopping-cart">
            <h1 class="title">products added</h1>

            <div class="box-container">
                <?php
                    $grandTotal = 0;
                    $cartItems = mysqli_query($conn, "SELECT * FROM `cart` WHERE `user_id` = '$userId'") or die('query failed');
                    if(mysqli_num_rows($cartItems) > 0):
                        while($cartItem = mysqli_fetch_assoc($cartItems)):
                            $productId = $cartItem['product_id'];
                            $product = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `products` WHERE `id` = '$productId'"));
                ?>

                <div class="box">
                    <a href="cart.php?delete=<?php echo $cartItem['id']; ?>" class="fas fa-times" onclick="return confirm('delete this from cart?');"></a>
                    <img src="../uploaded_images/<?php echo $product['image']; ?>" alt="">
                    <div class="name"><?php echo $product['name']; ?></div>
                    <div class="price">$<?php echo $product['price']; ?>/-</div>

                    <form action="" method="post">
                        <input type="hidden" name="id" value="<?php echo $cartItem['id']; ?>">
                        <input type="number" min="1" name="quantity" value="<?php echo $cartItem['quantity']; ?>">
                        <input type="submit" name="update" value="update" class="option-btn">
                    </form>

                    <div class="sub-total"> sub total : <span>$<?php echo $subTotal = ($cartItem['quantity'] * $product['price']); ?>/-</span></div>
                </div>

                <?php
                    $grandTotal += $subTotal;
                    endwhile;
                    else:
                        echo '<p class="empty">your cart is empty</p>';
                    endif;
                ?>
            </div>

            <div style="margin-top: 2rem; text-align:center;">
                <a href="cart.php?deleteAll" class="delete-btn <?php echo ($grandTotal > 1)?'':'disabled'; ?>" onclick="return confirm('delete all from cart?');">delete all</a>
            </div>

            <div class="cart-total">
                <p>grand total : <span>$<?php echo $grandTotal; ?>/-</span></p>
                <div class="flex">
                    <a href="shop.php" class="option-btn">continue shopping</a>
                    <a href="checkout.php" class="btn <?php echo ($grandTotal > 1)?'':'disabled'; ?>">proceed to checkout</a>
                </div>
            </div>
        </section>

        <?php include_once('shared/user_footer.php'); ?>
        <script src="../js/user_scripts.js"></script>
    </body>
</html>