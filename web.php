<?php
    require_once 'Controllers/AuthControllers.php';
    require_once 'Controllers/FoodControllers.php';
    require_once 'Controllers/ProfileControllers.php';
    require_once 'Controllers/FavoriteControllers.php';
    require_once 'Controllers/CartControllers.php';
    require_once 'Controllers/TransactionControllers.php';
    require_once 'Controllers/OrdersControllers.php';
    require_once 'Controllers/ReviewControllers.php';
    require_once 'Controllers/ShopControllers.php';
    require_once 'Controllers/FeedbackControllers.php';

    if($_SERVER['REQUEST_METHOD'] == 'GET') {
        $uri = basename($_SERVER['REQUEST_URI']);
        switch($uri) {
            case 'logout':
                logout();
                break;
        }

        $action = $_GET['action'];
        switch($action) {
            // USER
            case 'favorite':
                favorite();
                break;
            case 'remove_fav':
                remove_fav();
                break;

            // ADMIN
            case 'delete_food':
                delete_food();
                break;
            case 'delete_img':
                delete_img();
                break;

            // USER
            case 'delete_cart_item':
                delete_cart_item();
                break;

            // USER
            case 'delete_transaction':
                delete_transaction();
                break;

            // ADMIN
            case 'complete':
                complete();
                break;
            
            // ADMIN
            case 'shop_status':
                shop_status();
                break;

            // ADMIN
            case 'read';
                read();
                break;
        }
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $action = $_POST['action'];
        switch($action) {
            case 'register':
                register($_POST);
                break;
            case 'login':
                login($_POST);
                break;

            // ADMIN
            case 'add_food':
                add_food($_POST);
                break;
            case 'edit_food':
                edit_food($_POST);
                break;
            case 'isAvailable':
                isAvailable($_POST);
                break;
            
            // BOTH
            case 'edit_profile':
                edit_profile($_POST);
                break;

            // USER
            case 'add_to_cart':
                add_to_cart($_POST);
                break;
            case 'checkout_cart':
                checkout($_POST);
                break;

            // USER
            case 'transaction':
                transaction($_POST);
                break;

            // BOTH
            case 'search':
                search_food($_POST);
                break;
           
            // BOTH
            case 'comment':
                comment($_POST);
                break;
            case 'edit_comment':
                edit_comment($_POST);
                break;
            
            // ADMIN
            case 'update_status':
                update_status($_POST);
                break;
            
            // USER
            case 'feedback':
                feedback($_POST);
                break;
        }
    }

?>