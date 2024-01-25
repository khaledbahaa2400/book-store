<?php
    setcookie('user', '', time() - 1, '/book%20store/');
    header('Location: login.php');