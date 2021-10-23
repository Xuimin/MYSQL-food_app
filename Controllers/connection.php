<?php
    $cn = mysqli_connect('localhost', 'root', '', 'food_order');

    if(mysqli_connect_errno()) {
        echo 'Failed to coonnct to MYSQL' . mysqli_connect_error();
        die();
    }
?>