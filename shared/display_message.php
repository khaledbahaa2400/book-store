<?php
    if(isset($_COOKIE['message'])):
        echo '<script>toastr.options.timeOut = 2000;toastr' . $_COOKIE['message'] . ';</script>';
        setcookie('message', '', time() - 1, '/book%20store/');
    endif;
?>