<?php
    require_once 'connection.php';

    // ADD FOODS (DATA)
    function add_food($request) {
        global $cn;
        session_start();

        // var_dump($request);
        // die();

        // var_dump($_FILES);
        // die();

        $name = $request['food_name'];
        $description = $request['description'];
        $price = $request['price'];
        $isAvailable = $request['isAvailable'];
        $category_id = $request['category_id'];

        $extensions = ['jpg', 'png', 'jpeg', 'gif'];
        $upload_dir = '/Public/';
        $image = '';

        $errors = 0;

        if(strlen($name) < 1) {
            $_SESSION['class'] = 'red lighten-4';
            $_SESSION['message'] = 'Please input a food name';
            $errors++;
            header('Location: /');
        }
        if(strlen($description) < 1) {
            $_SESSION['class'] = 'red lighten-4';
            $_SESSION['message'] = 'Please input a food description';
            $errors++;
            header('Location: /');
        }
        if(intval($price) < 1) {
            $_SESSION['class'] = 'red lighten-4';
            $_SESSION['message'] = 'Please input a price at least RM 1';
            $errors++;
            header('Location: /');
        }
        if(!isset($isAvailable)) {
            $_SESSION['class'] = 'red lighten-4';
            $_SESSION['message'] = 'Please set whether food is available or not';
            $errors++;
            header('Location: /');
        }
        if(!isset($category_id)) {
            $_SESSION['class'] = 'red lighten-4';
            $_SESSION['message'] = 'Please input the food type';
            $errors++;
            header('Location: /');
        }
        if(isset($_FILES['imgUpload']['name'])) {
            $image = $upload_dir.$_FILES['imgUpload']['name'][0];
            $img_name = $_FILES['imgUpload']['name'][0];
            $temp_name = $_FILES['imgUpload']['tmp_name'][0];
            $img_type = pathinfo($img_name, PATHINFO_EXTENSION);

            // var_dump($image);
            // var_dump($img_type);
            // die();

            if(in_array($img_type, $extensions)) {
                move_uploaded_file($temp_name, $_SERVER['DOCUMENT_ROOT'].$upload_dir.$img_name);
            } 
        }
        if($errors === 0) {
            $query = "INSERT INTO foods (name, description, image, price, category_id, is_available)
            VALUES ('$name', '$description', '$image', $price, $category_id, $isAvailable)";

            mysqli_query($cn, $query);
            mysqli_close($cn);

            $_SESSION['class'] = 'light-green lighten-3';
            $_SESSION['message'] = 'Food Successfully Added';
            header('Location: /');
        }
    }

    // GET FOODS (GET)
    function get_foods() {
        global $cn;
        
        $query = "SELECT * FROM foods";
        $result = mysqli_query($cn, $query);
        $foods = mysqli_fetch_all($result, MYSQLI_ASSOC);

        return $foods;
    }

    // SEARCH FOOD (GET)**
    function search_food() {
        global $cn;

        if(isset($_POST['search'])) {
            $keyword = $_POST['search'];
            $search_query = "SELECT * FROM foods WHERE name LIKE '%$keyword%'";
            $result2 = mysqli_query($GLOBALS['cn'], $search_query);
            $find_foods = mysqli_fetch_all($result2, MYSQLI_ASSOC);

            return $find_foods;

            header('Location: ../Views/search_food.php');
        } 
    }

    // DELETE FOOD (DATA)
    function delete_food() {
        global $cn;
        session_start();

        $id = $_GET['id'];

        // var_dump($id);
        // die();

        $query = "UPDATE foods SET is_deleted = 1 WHERE id = $id";
        mysqli_query($cn, $query);
        mysqli_close($cn);

        $_SESSION['class'] = "light-green lighten-3";
        $_SESSION['message'] = "Food Successfully Deleted";
        header('Location: /');
    }

    // EDIT FOOD (DATA)
    function edit_food($request) {
        global $cn;
        session_start();

        // var_dump($request);
        // die();

        $name = $request['food_name'];
        $description = $request['description'];
        $price = $request['price'];
        $isAvailable = $request['isAvailable'];
        $category_id = $request['category_id'];
        $id = $request['id'];
     
        $extensions = ['jpg', 'png', 'jpeg', 'gif'];
        $upload_dir = '/Public/';
        $image = '';

        $errors = 0;

        if(strlen($name) < 1) {
            $_SESSION['class'] = 'red lighten-4';
            $_SESSION['message'] = 'Please input a food name';
            $errors++;
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
        if(strlen($description) < 1) {
            $_SESSION['class'] = 'red lighten-4';
            $_SESSION['message'] = 'Please input a food description';
            $errors++;
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
        if(intval($price) < 1) {
            $_SESSION['class'] = 'red lighten-4';
            $_SESSION['message'] = 'Please input a price more than 1';
            $errors++;
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
        if(!isset($isAvailable)) {
            $_SESSION['class'] = 'red lighten-4';
            $_SESSION['message'] = 'Please set whether food is available or not';
            $errors++;
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
        if(!isset($category_id)) {
            $_SESSION['class'] = 'red lighten-4';
            $_SESSION['message'] = 'Please input the food type';
            $errors++;
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
        if(isset($_FILES['imgUpload']['name'])) {
            $image = $upload_dir.$_FILES['imgUpload']['name'][0];
            $img_name = $_FILES['imgUpload']['name'][0];
            $temp_name = $_FILES['imgUpload']['tmp_name'][0];
            $img_type = pathinfo($img_name, PATHINFO_EXTENSION);

            // var_dump($image);
            // var_dump($img_type);
            // die();

            if(in_array($img_type, $extensions)) {
                move_uploaded_file($temp_name, $_SERVER['DOCUMENT_ROOT'].$upload_dir.$img_name);
            } else {
                $image = $request['image'];
            }
        }
        if($errors === 0) {
            $query = "UPDATE foods SET name = '$name', description = '$description', image = '$image', price = $price, category_id = $category_id WHERE id = $id";
            mysqli_query($cn, $query);

            $query2 = "SELECT * FROM cart WHERE food_id = $id";
            $result2 = mysqli_query($cn, $query2);
            $carts = mysqli_fetch_all($result2, MYSQLI_ASSOC);

            foreach($carts as $cart) {
                $query3 = "UPDATE cart SET total_payment = {$cart['quantity']} * $price WHERE food_id = $id";
                mysqli_query($cn, $query3);
            }
            // var_dump($query3);

            mysqli_close($cn);

            $_SESSION['class'] = 'light-green lighten-3';
            $_SESSION['message'] = 'Food Successfully Updated';
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }

    // DELETE FOOD IMG (DATA)
    function delete_img() {
        global $cn;
        session_start();

        $id = $_GET['id'];
        // var_dump($id);

        $query = "UPDATE foods SET image = '/Public/' WHERE id = $id";
        mysqli_query($cn, $query);

        $_SESSION['class'] = 'light-green lighten-3';
        $_SESSION['message'] = 'Food Image Deleted';
        mysqli_close($cn);
        header('Location:' . $_SERVER['HTTP_REFERER']);
    }

    // SET FOOD AVAILABLE OR NOT (DATA)
    function isAvailable($request) {
        global $cn;
        session_start(); 

        var_dump($request);
        $id = $request['id'];
        // $isAvailable = $request['isAvailable']; // on(Available)

        if(!isset($request['isAvailable'])){
            $query = "UPDATE foods SET is_available = 0 WHERE id = $id";
            mysqli_query($cn, $query);
            mysqli_close($cn);
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
        if(isset($request['isAvailable'])) {
            $query = "UPDATE foods SET is_available = 1 WHERE id = $id";
            mysqli_query($cn, $query);
            mysqli_close($cn);
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } 
    }
?>