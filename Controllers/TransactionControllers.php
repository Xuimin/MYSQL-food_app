<?php 
    require_once 'connection.php';
    date_default_timezone_set('Asia/Kuala_Lumpur');

    // TRANSACTIONS (DATA)
    function transaction($request) {
        global $cn; 
        session_start();

        $id = $request['id'];
        $date = date('Y-m-d');
        $time = date('H:i:s');
        $user_id = $_SESSION['user_data']['id'];

        $query = "UPDATE transactions SET isPaid = 1, date = '$date', time = '$time' WHERE id = $id";
        mysqli_query($cn, $query);

        $query2 = "INSERT INTO orders (transaction_id, user_id) VALUES ($id, $user_id)";
        mysqli_query($cn, $query2);

        mysqli_close($cn);
        $_SESSION['class'] = 'light-green lighten-3';
        $_SESSION['message'] = 'Payment Done!';
        header('Location:' . $_SERVER['HTTP_REFERER']);
    }

    // DELETE TRANSACTION (DATA)
    function delete_transaction() {
        global $cn;
        session_start();

        $id = $_GET['id'];

        $query = "UPDATE transactions SET isDeleted = 1 WHERE id = $id";
        mysqli_query($cn, $query);

        mysqli_close($cn);
        $_SESSION['class'] = 'light-green lighten-3';
        $_SESSION['message'] = 'Transaction Successfully Deleted';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
?>