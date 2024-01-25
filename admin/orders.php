<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>orders</title>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
        <link rel="stylesheet" href="../css/admin_style.css">

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
    </head>
    <body>
        <?php
            include_once('../shared/check_authorization.php');
            include_once('../shared/config.php');
            include_once('../shared/display_message.php');
            include_once('shared/admin_header.php');

            if(isset($_POST['updateOrder'])):
                $id = $_POST['orderId'];
                $status = $_POST['paymentStatus'];
                mysqli_query($conn, "UPDATE `orders` SET `payment_status` = '$status' WHERE `id` = '$id'");
                echo '<script>toastr.options.timeOut = 2000;toastr.success("Payment Status Has Been Updated")</script>';
            endif;

            if(isset($_GET['delete'])):
                $id = $_GET['delete'];
                mysqli_query($conn, "DELETE FROM `orders` WHERE `id` = '$id'");
                setcookie('message', '.success("Order Deleted Successfully")', path: '/book%20store/');
                header('Location: orders.php');
            endif;
        ?>

        <section class="orders">
            <h1 class="title">placed orders</h1>

            <div class="box-container">
                <?php
                    $orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');
                    if(mysqli_num_rows($orders) > 0):
                        while($order = mysqli_fetch_assoc($orders)):
                            $id = $order['user_id'];
                            $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT `name`, `email` FROM `users` WHERE `id` = '$id'"));
                ?>

                <div class="box">
                    <p> name : <span><?php echo $user['name']; ?></span> </p>
                    <p> email : <span><?php echo $user['email']; ?></span> </p>
                    <p> number : <span><?php echo $order['number']; ?></span> </p>
                    <p> address : <span><?php echo $order['address']; ?></span> </p>
                    <p> placed on : <span><?php echo $order['created_on']; ?></span> </p>
                    <p> total products : <span><?php echo $order['total_products']; ?></span> </p>
                    <p> total price : <span>$<?php echo $order['total_price']; ?>/-</span> </p>
                    <p> payment method : <span><?php echo str_replace('_', ' ', $order['payment_method']); ?></span> </p>

                    <form action="" method="post">
                        <input type="hidden" name="orderId" value="<?php echo $order['id']; ?>">
                        <select name="paymentStatus">
                            <option value="" selected disabled><?php echo $order['payment_status']; ?></option>
                            <option value="pending">pending</option>
                            <option value="completed">completed</option>
                        </select>
                        <input type="submit" name="updateOrder" value="update" class="option-btn">
                        <a href="orders.php?delete=<?php echo $order['id']; ?>" onclick="return confirm('delete this order?');" class="delete-btn">delete</a>
                    </form>
                </div>

                <?php
                    endwhile;
                else:
                    echo '<p class="empty">no orders placed yet!</p>';
                endif;
                ?>
            </div>
        </section>

        <script src="../js/admin_scripts.js"></script>
    </body>
</html>