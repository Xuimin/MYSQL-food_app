<?php 
    require_once 'connection.php';

    // UPDATE FOOD STATUS (DATA)
    function update_status($request) {
        global $cn;
        session_start();

        // var_dump($request);
        // die();

        $id = $request['id'];
        $status_id = $request['status_id'];
        $errors = 0;

        if(!isset($status_id)) {
            $_SESSION['class'] = 'red lighten-4';
            $_SESSION['message'] = 'Please update a new status';
            $errors++;
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } 
        if($errors === 0) {
            $query = "UPDATE orders SET food_status_id = $status_id WHERE id = $id";
            mysqli_query($cn, $query);

            mysqli_close($cn);
            $_SESSION['class'] = 'light-green lighten-3';
            $_SESSION['message'] = 'Status Successfully Updated';
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }

    function complete() {
        global $cn;
        session_start();

        $id = $_GET['id'];
        
        $query = "UPDATE orders SET is_done = 1 WHERE transaction_id = $id";
        mysqli_query($cn, $query);

        mysqli_close($cn);
        $_SESSION['class'] = 'light-green lighten-3';
        $_SESSION['message'] = 'Order Completed';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
?>