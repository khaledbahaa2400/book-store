<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home page</title>

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

        <section class="home">
            <div class="content">
                <h3>Hand Picked Book to your door.</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi, quod? Reiciendis ut porro iste totam.</p>
                <a href="about.php" class="white-btn">discover more</a>
            </div>
        </section>

        <section class="products">
            <h1 class="title">latest products</h1>
            <div class="box-container">
                <?php
                    $products = mysqli_query($conn, "SELECT * FROM `products` LIMIT 6") or die('query failed');
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

            <div class="load-more" style="margin-top: 2rem; text-align:center">
                <a href="shop.php" class="option-btn">load more</a>
            </div>
        </section>

        <section class="about">
            <div class="flex">
                <div class="image">
                    <img src="../images/about-img.jpg" alt="">
                </div>

                <div class="content">
                    <h3>about us</h3>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Impedit quos enim minima ipsa dicta officia corporis ratione saepe sed adipisci?</p>
                    <a href="about.php" class="btn">read more</a>
                </div>
            </div>
        </section>

        <section class="home-contact">
            <div class="content">
                <h3>have any questions?</h3>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Atque cumque exercitationem repellendus, amet ullam voluptatibus?</p>
                <a href="contact.php" class="white-btn">contact us</a>
            </div>
        </section>
        
        <?php include_once('shared/user_footer.php'); ?>
        <script src="../js/user_scripts.js"></script>
    </body>
</html>