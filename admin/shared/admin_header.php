<header class="header">
   <div class="flex">
      <a href="home.php" class="logo">Admin<span>Panel</span></a>

      <nav class="navbar">
         <a href="home.php">home</a>
         <a href="products.php">products</a>
         <a href="orders.php">orders</a>
         <a href="users.php">users</a>
         <a href="contacts.php">messages</a>
      </nav>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="account-box">
         <p>username : <span><?php echo unserialize($_COOKIE['user'])['name']; ?></span></p>
         <p>email : <span><?php echo unserialize($_COOKIE['user'])['email']; ?></span></p>
         <a href="../logout.php" class="delete-btn">logout</a>
         <a href="" id="update-profile" class="update-btn">update profile</a>
      </div>
   </div>
</header>