<?php
    require_once 'connection.php';

    // ADD TO CART (DATA)
    function add_to_cart($request) {
        global $cn;
        session_start();
        
        // var_dump($request);
        // die();

        $quantity = $request['quantity'];
        $food_id = $request['id'];
        $user_id = $_SESSION['user_data']['id'];
        $price = $request['price'];
        $payment = intval($price) * intval($quantity);

        // var_dump($_SESSION);
        // die();
        
        $errors = 0;
        
        if(intval($quantity) < 1) {
            $_SESSION['class'] = 'red lighten-4';
            $_SESSION['message'] = 'Please input amount at least one';
            $errors++;
            header('Location: /');
        }
        if($errors === 0) {
            $query = "INSERT INTO cart (user_id, food_id, quantity, totalPayment)
            VALUES ($user_id, $food_id, $quantity, $payment)";
            mysqli_query($cn, $query);
            mysqli_close($cn);

            $_SESSION['class'] = 'light-green lighten-3';
            $_SESSION['message'] = "Food Successfully Added to Cart";
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }

    // GET CART ITEM (GET)
    function get_cart_food() {
        global $cn;
        
        $query = "SELECT * FROM foods";
        $result = mysqli_query($cn, $query);
        $foods = mysqli_fetch_all($result, MYSQLI_ASSOC);

        $query2 = "SELECT * FROM cart";
        $result2 = mysqli_query($cn, $query2);
        $carts = mysqli_fetch_all($result2, MYSQLI_ASSOC);

        return $carts + $foods;
    }

    // DELETE CART ITEM (DATA)
    function delete_cart_item() {
        global $cn;
        session_start();

        $id = $_GET['id'];

        // var_dump($id);
        // die();

        $query = "UPDATE cart SET isDeleted = 1 WHERE id = $id";
        mysqli_query($cn, $query);
        mysqli_close($cn);
        
        $_SESSION['class'] = 'light-green lighten-3';
        $_SESSION['message'] = "Item is Deleted";
        header('Location:' . $_SERVER['HTTP_REFERER']);
    }

    // CHECKOUT (DATA)
    function checkout($request) {
        global $cn; 
        session_start();

        // var_dump($request);
        // die();

        $name = $request['name'];
        $total = $request['total'];
        $payment = intval($total);
        $namestring = implode(", ", $name);
        $id = $_SESSION['user_data']['id'];

        // var_dump($namestring);
        // var_dump($payment);
        // die();

        $query = "UPDATE transactions SET isDeleted = 1 WHERE user_id = {$_SESSION['user_data']['id']} ";
        mysqli_query($cn, $query);

        $query2 = "INSERT INTO transactions (user_id, item, payment) 
        VALUES ($id,'$namestring', $payment)";
        mysqli_query($cn, $query2);

        $query3 = "UPDATE cart SET toPay = 1 WHERE user_id = {$_SESSION['user_data']['id']}";
        mysqli_query($cn, $query3);

        mysqli_close($cn);
        header('Location: /Views/transactions.php');
    }
?>