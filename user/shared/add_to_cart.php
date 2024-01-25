<?php
    $userId = unserialize($_COOKIE['user'])['id'];
    $productId = $_POST['id'];
    $quantity = $_POST['quantity'];

    $cartItem = mysqli_query($conn, "SELECT `quantity` FROM `cart` WHERE `user_id` = '$userId' AND `product_id` = '$productId'");
    if(mysqli_num_rows($cartItem) > 0):
        $newQuantity = mysqli_fetch_assoc($cartItem)['quantity'] + $quantity;
        mysqli_query($conn, "UPDATE `cart` SET `quantity` = '$newQuantity' WHERE `user_id` = '$userId' AND `product_id` = '$productId'");
        echo '<script>toastr.options.timeOut = 2000;toastr.success("Item Updated Successfully")</script>';
    else:
        mysqli_query($conn, "INSERT INTO `cart` (`user_id`, `product_id`, `quantity`) VALUES ('$userId', '$productId', '$quantity')");
        echo '<script>toastr.options.timeOut = 2000;toastr.success("Item Added Successfully")</script>';
    endif;
?>