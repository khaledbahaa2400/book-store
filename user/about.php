<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>about</title>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
        <link rel="stylesheet" href="../css/style.css">

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
    </head>
    <body>
        <?php
            include_once('../shared/check_authorization.php');
            include_once('shared/user_header.php');
        ?>

        <div class="heading">
            <h3>about us</h3>
            <p> <a href="home.php">home</a> / about </p>
        </div>

        <section class="about">
            <div class="flex">
                <div class="image">
                    <img src="../images/about-img.jpg" alt="">
                </div>

                <div class="content">
                    <h3>why choose us?</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eveniet voluptatibus aut hic molestias, reiciendis natus fuga, cumque excepturi veniam ratione iure. Excepturi fugiat placeat iusto facere id officia assumenda temporibus?</p>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Impedit quos enim minima ipsa dicta officia corporis ratione saepe sed adipisci?</p>
                    <a href="contact.php" class="btn">contact us</a>
                </div>
            </div>
        </section>

        <section class="reviews">
            <h1 class="title">client's reviews</h1>

            <div class="box-container">
                <?php
                    $reviewers = 6;
                    while($reviewers > 0):
                        $path = "../images/pic-" . $reviewers . ".png";
                        $reviewMessage = 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt ad, quo labore fugiat nam accusamus quia. Ducimus repudiandae dolore placeat.';
                        $stars = 4;
                        $halfStar = true;
                        $reviewer = 'john deo';
                        include('shared/review.php');
                        $reviewers--;
                    endwhile;
                ?>
            </div>
        </section>

        <section class="authors">
            <h1 class="title">greate authors</h1>

            <div class="box-container">
                <?php
                    $authors = 6;
                    while($authors > 0):
                        $path = "../images/author-" . $authors . ".jpg";
                        $author = 'john deo';
                        include('shared/author.php');
                        $authors--;
                    endwhile;
                ?>
            </div>
        </section>
        
        <?php include_once('shared/user_footer.php'); ?>
        <script src="../js/user_scripts.js"></script>
    </body>
</html>