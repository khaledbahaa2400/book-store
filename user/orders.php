<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>orders</title>

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
        ?>

        <div class="heading">
            <h3>your orders</h3>
            <p> <a href="home.php">home</a> / orders </p>
        </div>

        <section class="placed-orders">
            <h1 class="title">placed orders</h1>

            <div class="box-container">
                <?php
                    $userId = unserialize($_COOKIE['user'])['id'];
                    $orders = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id = '$userId'") or die('query failed');
                    if(mysqli_num_rows($orders) > 0):
                        while($order = mysqli_fetch_assoc($orders)):
                        $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT `name`, `email` FROM `users` WHERE `id` = '$id'"));
                ?>

                <div class="box">
                    <p> placed on : <span><?php echo date_format(new DateTime($order['created_on']), 'd-m-Y'); ?></span> </p>
                    <p> name : <span><?php echo $user['name']; ?></span> </p>
                    <p> email : <span><?php echo $user['email']; ?></span> </p>
                    <p> number : <span><?php echo $order['number']; ?></span> </p>
                    <p> address : <span><?php echo $order['address']; ?></span> </p>
                    <p> payment method : <span><?php echo str_replace('_', ' ', $order['payment_method']); ?></span> </p>
                    <p> your orders : <span><?php echo $order['total_products']; ?></span> </p>
                    <p> total price : <span>$<?php echo $order['total_price']; ?>/-</span> </p>
                    <p> payment status : <span style="color:<?php if($order['payment_status'] == 'pending') echo 'red'; else echo 'green'; ?>;"><?php echo $order['payment_status']; ?></span> </p>
                </div>

                <?php
                    endwhile;
                    else:
                        echo '<p class="empty">no orders placed yet!</p>';
                    endif;
                ?>
            </div>
        </section>
        
        <?php include_once('shared/user_footer.php'); ?>
        <script src="../js/user_scripts.js"></script>
    </body>
</html>