<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Panel</title>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
        <link rel="stylesheet" href="../css/admin_style.css">
    </head>
    <body>
        <?php
            include_once('../shared/check_authorization.php');
            include_once('../shared/config.php');
            include_once('shared/admin_header.php');
        ?>

        <section class="dashboard">
            <h1 class="title">dashboard</h1>

            <div class="box-container">
                <div class="box">
                    <?php
                        $totalPendings = 0;
                        $pendingOrders = mysqli_query($conn, "SELECT total_price FROM `orders` WHERE `payment_status` = 'pending'") or die('query failed');

                        if(mysqli_num_rows($pendingOrders) > 0):
                            while($pendingOrder = mysqli_fetch_assoc($pendingOrders)):
                                $totalPendings += $pendingOrder['total_price'];
                            endwhile;
                        endif;
                    ?>

                    <h3>$<?php echo $totalPendings; ?>/-</h3>
                    <p>total pendings</p>
                </div>

                <div class="box">
                    <?php
                        $totalCompleted = 0;
                        $completedOrders = mysqli_query($conn, "SELECT total_price FROM `orders` WHERE `payment_status` = 'completed'") or die('query failed');

                        if(mysqli_num_rows($completedOrders) > 0):
                            while($completedOrder = mysqli_fetch_assoc($completedOrders)):
                                $totalCompleted += $completedOrder['total_price'];
                            endwhile;
                        endif;
                    ?>

                    <h3>$<?php echo $totalCompleted; ?>/-</h3>
                    <p>completed payments</p>
                </div>

                <div class="box">
                    <?php 
                        $orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');
                        $numberOfOrders = mysqli_num_rows($orders);
                    ?>
                    <h3><?php echo $numberOfOrders; ?></h3>
                    <p>order placed</p>
                </div>

                <div class="box">
                    <?php 
                        $products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
                        $numberOfProducts = mysqli_num_rows($products);
                    ?>
                    <h3><?php echo $numberOfProducts; ?></h3>
                    <p>products added</p>
                </div>

                <div class="box">
                    <?php 
                        $users = mysqli_query($conn, "SELECT * FROM `users` WHERE `type` = 'user'") or die('query failed');
                        $numberOfUsers = mysqli_num_rows($users);
                    ?>
                    <h3><?php echo $numberOfUsers; ?></h3>
                    <p>normal users</p>
                </div>

                <div class="box">
                    <?php 
                        $admins = mysqli_query($conn, "SELECT * FROM `users` WHERE `type` = 'admin'") or die('query failed');
                        $numberOfAdmins = mysqli_num_rows($admins);
                    ?>
                    <h3><?php echo $numberOfAdmins; ?></h3>
                    <p>admin users</p>
                </div>

                <div class="box">
                    <?php 
                        $superAdmins = mysqli_query($conn, "SELECT * FROM `users` WHERE `type` = 'super_admin'") or die('query failed');
                        $numberOfSupers = mysqli_num_rows($superAdmins);
                    ?>
                    <h3><?php echo $numberOfSupers; ?></h3>
                    <p>super admin</p>
                </div>

                <div class="box">
                    <?php 
                        $messages = mysqli_query($conn, "SELECT * FROM `messages`") or die('query failed');
                        $numberOfMessages = mysqli_num_rows($messages);
                    ?>
                    <h3><?php echo $numberOfMessages; ?></h3>
                    <p>new messages</p>
                </div>
            </div>
        </section>

        <script src="../js/admin_scripts.js"></script>
    </body>
</html>