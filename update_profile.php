<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>update</title>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
        <link rel="stylesheet" href="css/style.css">

        <style>
            .error {
                color: red;
                font-size: 150%;
                display: none;
            }

            .arrow {
                display: inline-block;
                width: 25px;
                height: 25px;
                border: solid black;
                border-width: 0 2px 2px 0;
                transform: rotate(135deg);
                margin-right: 10px;
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

            if(isset($_POST['update'])):
                include_once 'shared/config.php';
                
                $id = unserialize($_COOKIE['user'])['id'];
                $name = mysqli_real_escape_string($conn, $_POST['name']);
                $email = mysqli_real_escape_string($conn, $_POST['email']);

                $user = mysqli_query($conn, "SELECT * FROM `users` WHERE `email` = '$email' AND `id` != '$id'") or die('query failed');
                if(mysqli_num_rows($user) > 0):
                    echo '<script>toastr.options.timeOut = 2000;toastr.error("Email Already Exist")</script>';
                else:
                    mysqli_query($conn, "UPDATE `users` SET `name` = '$name', `email` = '$email' WHERE `id` = '$id'");
                    echo '<script>toastr.options.timeOut = 2000;toastr.success("Updated Successfully")</script>';
                endif;
            endif;
        ?>

        <header class="header">
            <div class="header-2">
                <div class="flex">
                    <a href="<?php echo $_COOKIE['redirector']; ?>" class="arrow"></a>
                    <a href="<?php echo explode("/", $_COOKIE['redirector'])[2]; ?>/home.php" class="logo">Bookly</a>
                    <a href="../logout.php" class="delete-btn">logout</a>
                </div>
            </div>
        </header>

        <div class="form-container">
            <form action="" method="post">
                <h3>Update Your Profile</h3>

                <div class="form-group">
                    <input type="text" name="name" placeholder="Enter Your Name" value="<?php echo isset($name) ? $name : unserialize($_COOKIE['user'])['name'] ?>" class="box" required>
                    <span class="error"></span>
                </div>

                <div class="form-group">
                    <input type="email" name="email" placeholder="Enter Your Email" value="<?php echo isset($email) ? $email : unserialize($_COOKIE['user'])['email'] ?>" class="box" required>
                    <span class="error"></span>
                </div>

                <div class="form-group">
                    <input type="submit" name="update" value="Update Profile" class="btn">
                </div>

                <div class="form-group">
                    <a href="" style="font-size: large; text-decoration: underline;">change password</a>
                </div>
            </form>
        </div>
    </body>
</html>