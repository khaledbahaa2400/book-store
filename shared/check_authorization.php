<?php
    $url = $_SERVER['REQUEST_URI'];
    if(!isset($_COOKIE['user'])):
        if(basename($url) != 'register.php' && basename($url) != 'login.php'):
            header('Location: http://localhost/book%20store/login.php');
            exit();
        endif;
    else:
        if(unserialize($_COOKIE['user'])['type'] == 'user'):
            if(basename($url) == 'register.php' || basename($url) == 'login.php'):
                header('Location: user/home.php');
                exit();
            elseif(strpos($url, '/book%20store/admin') !== false):
                include_once('../access denied.php');
                exit();
            endif;
        else:
            if(basename($url) == 'register.php' || basename($url) == 'login.php'):
                header('Location: admin/home.php');
                exit();
            endif;
        endif;
    endif;