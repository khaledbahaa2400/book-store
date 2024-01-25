<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>messages</title>

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

            if(isset($_GET['delete'])):
                $id = $_GET['delete'];
                mysqli_query($conn, "DELETE FROM `messages` WHERE `id` = '$id'") or die('query failed');
                setcookie('message', '.success("Message Deleted Successfully")', path: '/book%20store/');
                header('Location: contacts.php');
            endif;
        ?>

        <section class="messages">
        <h1 class="title"> messages </h1>

            <div class="box-container">
                <?php
                    $messages = mysqli_query($conn, "SELECT * FROM `messages`") or die('query failed');
                    if(mysqli_num_rows($messages) > 0):
                        while($message = mysqli_fetch_assoc($messages)):
                            $id = $message['user_id'];
                            $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT `name`, `email` FROM `users` WHERE `id` = '$id'"));
                ?>

                <div class="box">
                    <p> name : <span><?php echo $user['name']; ?></span> </p>
                    <p> email : <span><?php echo $user['email']; ?></span> </p>
                    <p> number : <span><?php echo $message['number']; ?></span> </p>
                    <p> message : <span><?php echo $message['message']; ?></span> </p>
                    <a href="contacts.php?delete=<?php echo $message['id']; ?>" onclick="return confirm('delete this message?');" class="delete-btn">delete message</a>
                </div>

                <?php
                    endwhile;
                    else:
                        echo '<p class="empty">No Messages to Display</p>';
                    endif;
                ?>
            </div>
        </section>

        <script src="../js/admin_scripts.js"></script>
    </body>
</html>