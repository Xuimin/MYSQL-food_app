<?php 
    $title = 'Cart';
    date_default_timezone_set('Asia/Kuala_Lumpur');
    
    require_once '../Controllers/connection.php';
    require_once '../Controllers/FoodControllers.php';
    require_once '../Controllers/CartControllers.php';

    function get_content() {
        if(!isset($_SESSION['user_data'])) {
            header('Location: /');
        }
        
        $query = "SELECT users.username, foods.id AS food_id, foods.name, foods.category_id, foods.isAvailable, cart.quantity, cart.totalPayment, cart.toPay , cart.id, cart.isDeleted
        FROM cart 
        JOIN users ON cart.user_id = users.id
        JOIN foods ON cart.food_id = foods.id
        WHERE user_id = {$_SESSION['user_data']['id']}
        AND toPay = 0
        AND foods.isAvailable = 1 
        AND foods.isDeleted = 0";

        $cart_items = mysqli_fetch_all(mysqli_query($GLOBALS['cn'], $query), MYSQLI_ASSOC);

        // var_dump($cart_items);
        // die();

        $total = 0;

        if(isset($_SESSION['user_data'])) {
            $query3 = "SELECT * FROM openclose";
            $result3 = mysqli_query($GLOBALS['cn'], $query3);
            $shop = mysqli_fetch_assoc($result3);  
            
            // var_dump($shop);
            // die();
        }
?>

<div class="container">
    <!-- SHOW ERROR MESSAGE -->
    <?php if(isset($_SESSION['message'])): ?>
        <div class="card-panel pulse <?php echo $_SESSION['class'] ?>">
            <?php echo $_SESSION['message']; ?>
        </div>
    <?php endif; ?>
    
    <!-- ITEM IN CART -->
    <form action="../web.php"
    method="POST">
        <ul class="collection">
            <?php foreach($cart_items as $cart_item): ?>
                <?php if($cart_item['isDeleted'] == 0 && $cart_item['toPay'] == 0): ?>
                    <li class="collection-item col s11">

                        <input type="hidden" 
                        name="action" 
                        value="checkout_cart">

                        <input type="hidden" 
                        name="name[]" 
                        value="<?php echo $cart_item['name'];?> x <?php echo $cart_item['quantity']?>">


                        <?php 
                            if(isset($cart_item)) {
                                $total += $cart_item['totalPayment']; 
                            }
                        ?>

                        <input type="hidden" 
                        name="total" 
                        value="<?php echo $total; ?>">
                
                        <p>
                            <?php echo $cart_item['name']; ?> x <?php echo $cart_item['quantity']; ?>
                        </p>

                        <small> 
                            Price: RM<?php echo $cart_item['totalPayment']; ?>
                        </small>
                
                        <div class="right">
                            <a href="food_details.php?id=<?php echo $cart_item['food_id']?>">
                                View item
                            </a>
                
                            <!-- DELETE BUTTON -->
                            <a href="#modalDel-<?php echo $cart_item['id']?>" 
                            class="modal-trigger ">
                                <i class="material-icons">delete</i>
                            </a>
                        </div>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>

        <!-- CHECKOUT BUTTON -->
        <?php if($total !== 0): ?>
            <button class="btn"
            style="margin-bottom: 20px"
            <?php if($shop['shop_status'] == 0) {
                echo 'disabled';
            }?>>Checkout</button>
        <?php endif; ?>
    </form>

    <?php foreach($cart_items as $cart_item): ?>
        <?php if($cart_item['isDeleted'] == 0 && $cart_item['toPay'] == 0): ?>
            <!-- DELETE MODAL -->
            <div class="modal bottom-sheet" 
            id="modalDel-<?php echo $cart_item['id']?>">
                <div class="modal-content" 
                style="padding-bottom: 0">
                    <h4>Delete</h4>
                    <p style="margin: 0">Are you sure you want to remove it from your cart?</p>
                </div>
                <div class="modal-footer">
                    <a href="../web.php?id=<?php echo $cart_item['id']?>&action=delete_cart_item" 
                    class="btn">Delete</a>

                    <a class="modal-close waves-effect btn grey">Close</a>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?> 

    <?php if($total !== 0): ?>
        <h5 style="margin-bottom: 70px">Total: RM <?php echo $total; ?></h5>
    <?php endif; ?>
    
    <?php if($total == 0): ?>
        <div style="margin: 100px" class="center-align">
            <h4>Your Cart is Empty! </h4>
            <h5>Go back to home page to discover more</h5>
                
            <a href="/"> << Go back to homepage</a>
        </div>
    <?php endif; ?>
</div>

<?php
    }
    require_once 'layout.php';
?>

<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function() {
        let elems = document.querySelectorAll('.modal');
        let instances = M.Modal.init(elems, {});

        let card = document.querySelector('.card-panel');
        setTimeout(() => {
            <?php unset($_SESSION['message']); ?>
            <?php unset($_SESSION['class']); ?>
            card.classList.toggle('hide');
        }, 2000)
    })
</script>

