<?php
    require_once 'connection.php';
    date_default_timezone_set('Asia/Kuala_Lumpur');

    function feedback($request) {
        global $cn;
        session_start();

        // var_dump($request);
        // die();

        $user_id = $_SESSION['user_data']['id'];
        $date = date('Y-m-d');
        $feedback = $request['feedback'];

        $query = "INSERT INTO feedback (user_id, date, feedback)
        VALUES ($user_id, '$date', '$feedback')";
        mysqli_query($cn, $query);

        mysqli_close($cn);
        $_SESSION['class'] = 'light-green lighten-3';
        $_SESSION['message'] = 'Feedback Successfully Submited';
        header('Location: /');
    }

    function read() {
        global $cn;
        session_start();

        $id = $_GET['id'];

        $query = "UPDATE feedback SET isRead = 1 WHERE id = $id";
        mysqli_query($cn, $query);

        mysqli_close($cn);
        $_SESSION['class'] = 'light-green lighten-3';
        $_SESSION['message'] = 'Feedback Marked As Read';
        header('Location: ' . $_SERVER['HTTP_REFERER']);

    }
?>