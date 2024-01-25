<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>users</title>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
        <link rel="stylesheet" href="../css/admin_style.css">

        <style>
            .error {
                color: red;
                font-size: 150%;
                display: none;
            }
        </style>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="../js/register_validation.js"></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
    </head>
    <body>
        <?php
            include_once('../shared/check_authorization.php');
            include_once('../shared/config.php');
            include_once('../shared/display_message.php');
            include_once('shared/admin_header.php');

            if(isset($_POST['addUser'])):
                $name = mysqli_real_escape_string($conn, $_POST['name']);
                $email = mysqli_real_escape_string($conn, $_POST['email']);
                $password = mysqli_real_escape_string($conn, md5($_POST['password']));
                $type = $_POST['type'];

                $user = mysqli_query($conn, "SELECT * FROM `users` WHERE `email` = '$email'") or die('query failed');
                if(mysqli_num_rows($user) > 0):
                    echo '<script>toastr.options.timeOut = 2000;toastr.error("Email Already Exist")</script>';
                else:
                    mysqli_query($conn, "INSERT INTO `users` (`name`, `email`, `password`, `type`) VALUES ('$name', '$email', '$password', '$type')") or die("query failed");
                    echo '<script>toastr.options.timeOut = 2000;toastr.success("User Added Succesfully")</script>';
                endif;
            endif;

            if(isset($_GET['delete'])):
                $id = $_GET['delete'];
                if($id == unserialize($_COOKIE['user'])['id']):
                    setcookie('message', '.error("Cannot Delete the Current User")', path: '/book%20store/');
                    header('Location: users.php');
                else:
                    mysqli_query($conn, "DELETE FROM `users` WHERE `id` = '$id'") or die('query failed');
                    setcookie('message', '.success("User Deleted Successfully")', path: '/book%20store/');
                    header('Location: users.php');
                endif;
            endif;
        ?>

        <section class="add-products">
            <h1 class="title"> user accounts </h1>

            <form action="" method="post">
                <h3>add user</h3>
                <div class="form-group">
                    <input type="text" name="name" placeholder="Enter Your Name" class="box" required>
                    <span class="error"></span>
                </div>

                <div class="form-group">
                    <input type="email" name="email" placeholder="Enter Your Email" class="box" required>
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
                    <select name="type" class="box">
                        <option value="user">user</option>
                        <?php if(unserialize($_COOKIE['user'])['type'] == 'super_admin'): ?>
                        <option value="admin">admin</option>
                        <option value="super_admin">super admin</option>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="form-group">
                    <input type="submit" name="addUser" value="Add User" class="btn">
                </div>
            </form>
        </section>

        <section class="users">
            <div class="box-container">
                <?php
                    $query = "SELECT * FROM `users`";
                    if(unserialize($_COOKIE['user'])['type'] == 'admin'):
                        $query .= "WHERE `type` = 'user'";
                    endif;
                    $users = mysqli_query($conn, $query) or die('query failed');
                    if(mysqli_num_rows($users) > 1):
                        while($user = mysqli_fetch_assoc($users)):
                ?>

                <div class="box">
                    <p> username : <span><?php echo $user['name']; ?></span> </p>
                    <p> email : <span><?php echo $user['email']; ?></span> </p>
                    <p> user type : <span style="color:<?php if($user['type'] != 'user') echo 'var(--orange)'; ?>"><?php echo str_replace('_', ' ', $user['type']); ?></span> </p>
                    <a href="users.php?delete=<?php echo $user['id']; ?>" onclick="return confirm('delete this user?');" class="delete-btn">delete user</a>
                </div>

                <?php
                    endwhile;
                    else:
                        echo '<p class="empty">No Users to Display</p>';
                    endif;
                ?>
            </div>
        </section>

        <script src="../js/admin_scripts.js"></script>
    </body>
</html>