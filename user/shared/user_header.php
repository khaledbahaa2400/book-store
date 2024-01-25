<header class="header">
   <div class="header-1">
      <div class="flex">
         <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
            <a href="#" class="fab fa-twitter"></a>
            <a href="#" class="fab fa-instagram"></a>
            <a href="#" class="fab fa-linkedin"></a>
         </div>
         <a href="../logout.php" class="delete-btn">logout</a>
      </div>
   </div>

   <div class="header-2">
      <div class="flex">
         <a href="home.php" class="logo">Bookly</a>

         <nav class="navbar">
            <a href="home.php">home</a>
            <a href="about.php">about</a>
            <a href="shop.php">shop</a>
            <a href="contact.php">contact</a>
            <a href="orders.php">orders</a>
         </nav>

         <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <a href="search.php" class="fas fa-search"></a>
            <div id="user-btn" class="fas fa-user"></div>
            <?php
               include_once('../shared/config.php');
               $id = unserialize($_COOKIE['user'])['id'];
               $cartItems = mysqli_query($conn, "SELECT * FROM `cart` WHERE `user_id` = '$id'") or die('query failed');
               $numberOfItems = mysqli_num_rows($cartItems); 
            ?>
            <a href="cart.php"> <i class="fas fa-shopping-cart"></i> <span>(<?php echo $numberOfItems; ?>)</span> </a>
         </div>;

         <div class="user-box">
            <p>username : <span><?php echo unserialize($_COOKIE['user'])['name']; ?></span></p>
            <p>email : <span><?php echo unserialize($_COOKIE['user'])['email']; ?></span></p>
            <a href="../update_profile.php" class="update-btn">update profile</a>
         </div>
      </div>
   </div>
</header>