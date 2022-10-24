<?php
    require_once 'connection.php';
    date_default_timezone_set('Asia/Kuala_Lumpur');

    // POST COMMENT (DATA)
    function comment($request) {
        global $cn;
        session_start();

        // var_dump($request);
        // die();

        $food_id = $request['id'];
        $user_name = $_SESSION['user_data']['username'];
        $comment = $request['comment'];
        $errors = 0;

        $date = date('Y-m-d');
        $time = date('H:i:s');

        if($errors === 0) {
            $query = "INSERT INTO review (user_name, food_id, date, time, comment) 
            VALUES ('$user_name', $food_id, '$date', '$time', '$comment')";
            mysqli_query($cn, $query);

            mysqli_close($cn);
            $_SESSION['class'] = 'light-green lighten-3';
            $_SESSION['message'] = 'Comment Successfully Posted';
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }

    // EDIT COMMENT (DATA)
    function edit_comment($request) {
        global $cn;
        session_start(); 

        // var_dump($request);
        // die();

        $date = date('Y-m-d');
        $time = date('H:i:s');
        $comment = $request['comment'];
        $id = $request['id'];

        $query = "UPDATE review SET date = '$date', time = '$time', comment = '$comment', is_edited = 1 WHERE id = $id";
        var_dump($query);
        // die();
        mysqli_query($cn, $query);

        mysqli_close($cn);
        $_SESSION['class'] = 'light-green lighten-3';
        $_SESSION['message'] = 'Comment Successfully Updated';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }    
?>