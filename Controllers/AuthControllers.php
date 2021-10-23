<?php
    require_once 'connection.php';
    
    // REGISTER (DATA)
    function register($request) {
        global $cn;
        session_start();

        // var_dump($request);
        // die();

        $errors = 0;
        $fullname = $request['fullname'];
        $username = $request['username'];
        $password = $request['password'];
        $password2 = $request['password2'];

        if(strlen($username) < 8) {
            $_SESSION['class'] = 'red lighten-4';
            $_SESSION['message'] = 'Username must be greater than 8 characters';
            $errors++;
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
        if(strlen($password) < 8) {
            $_SESSION['class'] = 'red lighten-4';
            $_SESSION['message'] = 'Password must be greater than 8 characters';
            $errors++;
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
        if($password != $password2) {
            $_SESSION['class'] = 'red lighten-4';
            $_SESSION['message'] = 'Password do not match';
            $errors++;
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
        if($username) {
            $query = "SELECT username FROM users WHERE username = '$username'";
            $result = mysqli_fetch_assoc(mysqli_query($cn, $query), );
            if($result) {
                $_SESSION['class'] = 'red lighten-4';
                $_SESSION['message'] = 'Username is already taken. Please insert another username';
                $errors++;
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
        }
        if($errors === 0) {
            $password = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO users (fullname, username, password)
            VALUES ('$fullname', '$username', '$password')";
            mysqli_query($cn, $query);
            mysqli_close($cn);
            header('Location: ./Views/login.php');
        }
    }

    // LOGIN (DATA)
    function login($request) {
        global $cn;
        session_start();

        // var_dump($request);
        // die();

        $username = $request['username'];
        $password = $request['password'];

        $query = "SELECT * FROM users WHERE username = '$username'";
        $user = mysqli_fetch_assoc(mysqli_query($cn, $query));

        if($user && password_verify($password, $user['password'])) {
            $_SESSION['user_data'] = $user;
            $_SESSION['class'] = 'light-green lighten-3';
            $_SESSION['message'] = 'Successfully Login!';
            mysqli_close($cn);
            header('Location: /');
        } else {
            $_SESSION['class'] = 'red lighten-4';
            $_SESSION['message'] = 'Invalide Credentials!';
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }

    // LOGOUT
    function logout() {
        session_start();
        session_unset();
        session_destroy();
        header('Location: /');
    }

    // GET USER INFO (GET)
    function user_info() {
        global $cn;

        $query = "SELECT * FROM users WHERE id = {$_SESSION['user_data']['id']}";
        $result = mysqli_query($cn, $query);
        $user_info = mysqli_fetch_assoc($result);

        return $user_info;
    }
?>