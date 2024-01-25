<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>search page</title>

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

            if(isset($_POST['addToCart'])):
                include_once('shared/add_to_cart.php');
            endif;        
        ?>

        <div class="heading">
            <h3>your orders</h3>
            <p> <a href="home.php">home</a> / search </p>
        </div>

        <section class="search-form">
            <form action="" method="post">
                <input type="text" name="keyword" placeholder="search products..." class="box">
                <input type="submit" name="search" value="search" class="btn">
            </form>
        </section>

        <section class="products" style="padding-top: 0;">
            <div class="box-container">
                <?php
                    if(isset($_POST['search'])):
                        $keyword = $_POST['keyword'];
                        $products = mysqli_query($conn, "SELECT * FROM `products` WHERE name LIKE '%{$keyword}%'");
                        if(mysqli_num_rows($products) > 0):
                            while($product = mysqli_fetch_assoc($products)):
                ?>

                <form action="" method="post" class="box">
                    <img src="../uploaded_images/<?php echo $product['image']; ?>" alt="" class="image">
                    <div class="name"><?php echo $product['name']; ?></div>
                    <div class="price">$<?php echo $product['price']; ?>/-</div>
                    <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                    <input type="number"  class="qty" name="quantity" min="1" value="1">
                    <input type="submit" class="btn" value="add to cart" name="addToCart">
                </form>

                <?php
                    endwhile;
                    else:
                        echo '<p class="empty">no result found!</p>';
                    endif;
                    else:
                        echo '<p class="empty">search something!</p>';
                    endif;
                ?>
            </div>
        </section>
        
        <?php include_once('shared/user_footer.php'); ?>
        <script src="../js/user_scripts.js"></script>
    </body>
</html>