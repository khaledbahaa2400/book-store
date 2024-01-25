<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>products</title>

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

            if(isset($_POST['addProduct'])):
                $name = mysqli_escape_string($conn, $_POST['name']);
                $price = $_POST['price'];
                $image = $_FILES['image']['name'];
                $imageSize = $_FILES['image']['size'];
                $imageTmpName = $_FILES['image']['tmp_name'];
                $imagePath = '../uploaded_images/' . $image;

                $product = mysqli_query($conn, "SELECT * FROM `products` WHERE `name` = '$name'") or die("query failed");
                if(mysqli_num_rows($product) > 0):
                    echo '<script>toastr.options.timeOut = 2000;toastr.error("Product Already Exist")</script>';
                else:
                    if($imageSize > 2000000):
                        echo '<script>toastr.options.timeOut = 2000;toastr.error("Image size is too large")</script>';
                    else:
                        mysqli_query($conn, "INSERT INTO `products`(`name`, `price`, `image`) VALUES('$name', '$price', '$image')") or die('query failed');
                        move_uploaded_file($imageTmpName, $imagePath);
                        echo '<script>toastr.options.timeOut = 2000;toastr.success("Product Added Successfully")</script>';
                    endif;
                endif;
            endif;

            if(isset($_GET['delete'])):
                $id = $_GET['delete'];
                $query = mysqli_query($conn, "SELECT image FROM `products` WHERE `id` = '$id'") or die('query failed');
                $image = mysqli_fetch_assoc($query);
                unlink('../uploaded_images/'.$image['image']);
                mysqli_query($conn, "DELETE FROM `products` WHERE `id` = '$id'") or die('query failed');
                setcookie('message', '.success("Product Deleted Successfully")', path: '/book%20store/');
                header('Location: products.php');
            endif;

            if(isset($_POST['updateProduct'])):
                $id = $_POST['id'];
                $name = $_POST['name'];
                $price = $_POST['price'];

                $image = $_FILES['image']['name'];
                $imageSize = $_FILES['image']['size'];
                $imageTmpName = $_FILES['image']['tmp_name'];
                $imagePath = '../uploaded_images/' . $image;
                $oldImage = $_POST['oldImage'];

                if(!empty($image)):
                    if($update_image_size > 2000000):
                        setcookie('message', '.error("Image size is too large")', path: '/book%20store/');
                    else:
                        mysqli_query($conn, "UPDATE `products` SET `name` = '$name', `price` = '$price', image = '$image' WHERE `id` = '$id'") or die('query failed');
                        move_uploaded_file($imageTmpName, $imagePath);
                        unlink('../uploaded_images/' . $oldImage);
                        setcookie('message', '.success("Product Updated Successfully")', path: '/book%20store/');
                    endif;
                endif;
                header('Location: products.php');
            endif;
        ?>

        <section class="add-products">
            <h1 class="title">shop products</h1>

            <form action="" method="post" enctype="multipart/form-data">
                <h3>add product</h3>
                <input type="text" name="name" class="box" placeholder="enter product name" required>
                <input type="number" name="price" class="box" placeholder="enter product price" min="0" required>
                <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png" required>
                <input type="submit" name="addProduct" class="btn" value="add product">
            </form>
        </section>

        <section class="show-products">
            <div class="box-container">
                <?php
                    $products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
                    if(mysqli_num_rows($products) > 0):
                        while($product = mysqli_fetch_assoc($products)):
                ?>

                <div class="box">
                    <img src="../uploaded_images/<?php echo $product['image']; ?>" alt="">
                    <div class="name"><?php echo $product['name']; ?></div>
                    <div class="price">$<?php echo $product['price']; ?>/-</div>
                    <a href="products.php?update=<?php echo $product['id']; ?>" class="option-btn">update</a>
                    <a href="products.php?delete=<?php echo $product['id']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">delete</a>
                </div>

                <?php
                    endwhile;
                    else:
                        echo '<p class="empty">no products added yet!</p>';
                    endif;
                ?>
            </div>
        </section>

        <section class="edit-product-form">
            <?php
                if(isset($_GET['update'])):
                    $updateId = $_GET['update'];
                    $query = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$updateId'") or die('query failed');
                    if(mysqli_num_rows($query) > 0):
                        $product = mysqli_fetch_assoc($query)
            ?>

            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                <input type="hidden" name="oldImage" value="<?php echo $product['image']; ?>">
                <img src="../uploaded_images/<?php echo $product['image']; ?>" alt="">
                <input type="text" name="name" value="<?php echo $product['name']; ?>" class="box" required placeholder="enter product name">
                <input type="number" name="price" value="<?php echo $product['price']; ?>" min="0" class="box" required placeholder="enter product price">
                <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box">
                <input type="submit" name="updateProduct" value="update" class="btn">
                <input type="reset" id="stop-update" value="cancel" class="option-btn">
            </form>

            <?php
                endif;
                else:
                    echo '<script>document.querySelector(".edit-product-form").style.display = "none";</script>';
                endif;
            ?>
        </section>

        <script src="../js/admin_scripts.js"></script>
    </body>
</html>