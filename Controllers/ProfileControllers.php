<?php 
    require_once 'connection.php';
    
    // EDIT PROFILE (DATA)
    function edit_profile($request) {
        global $cn;
        session_start();

        // var_dump($request);
        // die();

        $username = $request['username'];
        $address = $request['address'];
        $contact = $request['contact'];
        $birthday = $request['birthday'];
        
        $extensions = ['jpg', 'png', 'jpeg', 'gif'];
        $upload_dir = '/Profile/';
        $image = '';

        $errors = 0;

        if(strlen($username) < 8) {
            $_SESSION['class'] = 'red lighten-4';
            $_SESSION['message'] = 'Username must be greater than 8 characters';
            $errors++;
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
        if(strlen($address) < 10) {
            $_SESSION['class'] = 'red lighten-4';
            $_SESSION['message'] = 'Address Unavailable';
            $errors++;
            header('Location:' . $_SERVER['HTTP_REFERER']);
        }
        if(strlen(intval($contact)) == 10) {
            $_SESSION['class'] = 'red lighten-4';
            $_SESSION['message'] = 'Incorrect Contact Number';
            $errors++;
            header('Location:' . $_SERVER['HTTP_REFERER']);
        }
        if(isset($_FILES['image']['name'])) {
            $image = $upload_dir.$_FILES['image']['name'];
            $img_name = $_FILES['image']['name'];
            $temp_name = $_FILES['image']['tmp_name'];
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
            $query = "UPDATE users SET username = '$username', image = '$image', address = '$address', contact = $contact, birthday = '$birthday' WHERE id = {$_SESSION['user_data']['id']}";
            mysqli_query($cn, $query);


            $query2 = "SELECT * FROM users WHERE username = '$username'";
            $user = mysqli_fetch_assoc(mysqli_query($cn, $query2));

            // var_dump($user);
            // die();

            $_SESSION['user_data'] = $user;
            $_SESSION['class'] = 'light-green lighten-3';
            $_SESSION['message'] = 'Profile Successfully Updated';

            mysqli_close($cn);
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }
?>