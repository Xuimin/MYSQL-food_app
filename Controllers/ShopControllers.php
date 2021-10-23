<?php
    require_once 'connection.php';

    function shop_status() {
        global $cn;

        // var_dump($_GET);
        // die();

        $id = $_GET['id'];

        if($id == 0) {
            $query = "UPDATE openclose SET shop_status = 1";
            mysqli_query($cn, $query);

            mysqli_close($cn);
            header('Location: /');

        } else {
            $query2 = "UPDATE openclose SET shop_status = 0";
            mysqli_query($cn, $query2);

            mysqli_close($cn);
            header('Location: /');
        }
    }
?>