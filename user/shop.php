<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>shop</title>

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

            if(isset($_POST['addToCart'])):
                include_once('shared/add_to_cart.php');
            endif;
            include_once('shared/user_header.php');
        ?>

        <div class="heading">
            <h3>our shop</h3>
            <p> <a href="home.php">home</a> / shop </p>
        </div>

        <section class="products">
            <h1 class="title">latest products</h1>
            <div class="box-container">
                <?php
                    $products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
                    if(mysqli_num_rows($products) > 0):
                        while($product = mysqli_fetch_assoc($products)):
                ?>

                <form action="" method="post" class="box">
                    <img class="image" src="../uploaded_images/<?php echo $product['image']; ?>" alt="">
                    <div class="name"><?php echo $product['name']; ?></div>
                    <div class="price">$<?php echo $product['price']; ?>/-</div>
                    <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                    <input type="number" name="quantity" min="1" value="1" class="qty">
                    <input type="submit" name="addToCart" value="add to cart" class="btn">
                </form>
                <?php
                    endwhile;
                    else:
                        echo '<p class="empty">no products added yet!</p>';
                    endif;
                ?>
            </div>
        </section>
        
        <?php include_once('shared/user_footer.php'); ?>
        <script src="../js/user_scripts.js"></script>
    </body>
</html>