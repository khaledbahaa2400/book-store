<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>login</title>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
        <link rel="stylesheet" href="css/style.css">

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
    </head>
    <body>
        <?php
            include_once('shared/check_authorization.php');
            include_once('shared/display_message.php');

            if(isset($_GET['redirected'])):
                setcookie('user', '', time() - 1, '/book%20store/');
                header('Location: login.php');
            endif;

            if(isset($_POST['submit'])):
                include_once 'shared/config.php';
            
                $email = mysqli_real_escape_string($conn, $_POST['email']);
                $password = mysqli_real_escape_string($conn, md5($_POST['password']));

                $query = mysqli_query($conn, "SELECT `id`, `name`, `email`, `type` FROM `users` WHERE `email` = '$email' AND `password` = '$password'") or die('query failed');
                if(mysqli_num_rows($query) > 0):
                    $user = mysqli_fetch_assoc($query);
                    setcookie('user', serialize($user), time() + 60 * 60 * 24 * 30, '/book%20store/');

                    if($user['type'] == 'user'):
                        header('Location: user/home.php');
                        exit;
                    else:
                        header('Location: admin/home.php');
                        exit;
                    endif;
                else:
                    echo '<script>toastr.options.timeOut = 2000;toastr.error("Invalid Email or Password")</script>';
                endif;
            endif;
        ?>

        <div class="form-container">
            <form action="" method="post">
                <h3>Sign In</h3>

                <div class="form-group">
                    <input type="email" name="email" placeholder="Enter Your Email" value="<?php echo isset($email) ? $email : '' ?>" class="box" required>
                    <span class="error"></span>
                </div>

                <div class="form-group">
                    <input type="password" name="password" placeholder="Enter Your Password" class="box" required>
                </div>

                <div class="form-group">
                    <input type="submit" name="submit" value="Sign In" class="btn">
                </div>
                
                <p>doesn't have an account? <a href="register.php">register now</a></p>
            </form>
        </div>
    </body>
</html>