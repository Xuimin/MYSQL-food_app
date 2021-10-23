<?php 
    require_once 'connection.php';

    // ADD TO FAV (DATA)
    function favorite() {
        global $cn;
        session_start();

        $id = $_GET['id'];

        if($id) {
            $query = "SELECT food_id, isDeleted FROM favorite WHERE food_id = $id AND user_id = {$_SESSION['user_data']['id']}";
            $result = mysqli_fetch_assoc(mysqli_query($cn, $query));

            // var_dump($result);
            // die();

            if($result['food_id'] && $result['isDeleted'] == 0) {
                $_SESSION['message'] = 'Food Already Added to Favorite';
                $_SESSION['class'] = 'yellow lighten-3';

                mysqli_close($cn);
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            } 
            if($result['food_id'] && $result['isDeleted'] == 1) {
                $query = "UPDATE favorite SET isDeleted = 0 WHERE food_id = $id";

                $_SESSION['message'] = 'Food Successfully Added to Favorite';
                $_SESSION['class'] = 'light-green lighten-3';

                mysqli_query($cn, $query);
                mysqli_close($cn);
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
            if(!$result['food_id']) {
                $query = "INSERT INTO favorite (user_id, food_id)
                VALUES ({$_SESSION['user_data']['id']}, '$id')";

                mysqli_query($cn, $query);
                mysqli_close($cn);
        
                $_SESSION['message'] = 'Food Successfully Added to Favourite';
                $_SESSION['class'] = 'light-green lighten-3';
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
        }
    }

    // GET FAV (GET)
    function get_fav() {
        global $cn;

        $query = "SELECT * FROM favorite WHERE user_id = {$_SESSION['user_data']['id']}";
        $fav_food = mysqli_fetch_all(mysqli_query($cn, $query));

        return $fav_food;
    }

    // REMOVE FAV (DATA)
    function remove_fav() {
        global $cn;
        session_start();

        $id = $_GET['id'];

        $query = "UPDATE favorite SET isDeleted = 1 WHERE food_id = $id";
        mysqli_query($cn, $query);
        mysqli_close($cn);

        $_SESSION['class'] = "light-green lighten-3";
        $_SESSION['message'] = "Food Remove from Favorite";
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
?>