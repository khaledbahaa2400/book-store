<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>register</title>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
        <link rel="stylesheet" href="css/style.css">

        <style>
            .error {
                color: red;
                font-size: 150%;
                display: none;
            }
        </style>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="js/register_validation.js"></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
    </head>
    <body>
        <?php
            include_once('shared/check_authorization.php');

            if(isset($_GET['redirected'])):
                setcookie('user', '', time() - 1, '/book%20store/');
                header('Location: register.php');
            endif;

            if(isset($_POST['submit'])):
                include_once 'shared/config.php';
            
                $name = mysqli_real_escape_string($conn, $_POST['name']);
                $email = mysqli_real_escape_string($conn, $_POST['email']);
                $password = mysqli_real_escape_string($conn, md5($_POST['password']));

                $user = mysqli_query($conn, "SELECT * FROM `users` WHERE `email` = '$email'") or die('query failed');
                if(mysqli_num_rows($user) > 0):
                    echo '<script>toastr.options.timeOut = 2000;toastr.error("Email Already Exist")</script>';
                else:
                    mysqli_query($conn, "INSERT INTO `users` (name, email, password) VALUES ('$name', '$email', '$password')") or die("query failed");
                    setcookie('message', '.success("User Created Successfully")', path: '/book%20store/');
                    header('Location: login.php');
                    exit();
                endif;
            endif;
        ?>

        <div class="form-container">
            <form action="" method="post">
                <h3>Register Now</h3>

                <div class="form-group">
                    <input type="text" name="name" placeholder="Enter Your Name" value="<?php echo isset($name) ? $name : '' ?>" class="box" required>
                    <span class="error"></span>
                </div>

                <div class="form-group">
                    <input type="email" name="email" placeholder="Enter Your Email" value="<?php echo isset($email) ? $email : '' ?>" class="box" required>
                    <span class="error"></span>
                </div>

                <div class="form-group">
                    <input type="password" name="password" placeholder="Enter Your Password" class="box" required>
                </div>

                <div class="form-group">
                    <input type="password" name="confirmPassword" placeholder="Confirm Your Password" class="box" required>
                    <span class="error"></span>
                </div>

                <div class="form-group">
                    <input type="submit" name="submit" value="Register Now" class="btn">
                </div>
                
                <p>already have an account? <a href="login.php">login now</a></p>
            </form>
        </div>
    </body>
</html>