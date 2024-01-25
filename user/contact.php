<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>contact</title>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
        <link rel="stylesheet" href="../css/style.css">

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
    </head>
    <body>
        <?php
            include_once('../shared/check_authorization.php');
            include_once '../shared/config.php';
            include_once('shared/user_header.php');

            $userId = unserialize($_COOKIE['user'])['id'];
            $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT `name`, `email` FROM `users` WHERE `id` = '$userId'"));
            if(isset($_POST['send'])):
                $number = mysqli_real_escape_string($conn, $_POST['number']);
                $message = mysqli_real_escape_string($conn, $_POST['message']);
                
                mysqli_query($conn, "INSERT INTO `messages` (`user_id`, `number`, `message`) VALUES ('$userId', '$number', '$message')");
                echo '<script>toastr.options.timeOut = 2000;toastr.success("Message Sent Successfully")</script>';
            endif;
        ?>

        <div class="heading">
            <h3>contact us</h3>
            <p> <a href="home.php">home</a> / contact </p>
        </div>

        <section class="contact">
            <form action="" method="post">
                <h3>say something!</h3>
                <input readonly name="name" value="<?php echo $user['name']; ?>" class="box" required>
                <input readonly name="email" value="<?php echo $user['email']; ?>" class="box" required>
                <input type="number" name="number" placeholder="enter your number" class="box" required>
                <textarea name="message" placeholder="enter your message" id="" cols="30" rows="10" class="box"></textarea>
                <input type="submit" name="send" value="send message" class="btn">
            </form>
        </section>

        <?php include_once('shared/user_footer.php'); ?>
        <script src="../js/user_scripts.js"></script>
    </body>
</html>