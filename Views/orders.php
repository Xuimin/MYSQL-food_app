<?php 
    $title = "Track Order";
    require_once '../Controllers/connection.php';

    function get_content() {
        
        $query = "SELECT orders.*, orders.id AS order_id, transactions.*, status.id AS status_id, status.food_status, users.id, users.username
        FROM orders
        JOIN users ON orders.user_id = users.id
        JOIN transactions ON orders.transaction_id = transactions.id
        JOIN status ON orders.food_status_id = status.id
        WHERE users.id = {$_SESSION['user_data']['id']}
        ORDER BY orders.id DESC";
        $result = mysqli_query($GLOBALS['cn'], $query);
        $items = mysqli_fetch_all($result, MYSQLI_ASSOC);

        // var_dump($items);
        // die();

        $query2 = "SELECT * FROM status";
        $result2 = mysqli_query($GLOBALS['cn'], $query2);
        $statuss = mysqli_fetch_all($result2, MYSQLI_ASSOC);

        // var_dump($statuss);
        // die();

?>



<div class="container">
    <!-- SHOW ERROR MESSAGE -->
    <?php if(isset($_SESSION['message'])): ?>
        <div class="card-panel pulse <?php echo $_SESSION['class'] ?>">
            <?php echo $_SESSION['message']; ?>
        </div>
    <?php endif; ?>

    <!-- SHOW ORDERED ITEM -->
    <div class="row">
        <div class="collection">
            <?php foreach($items as $item): ?>
            <div class="row">
                <div class="col s6">
                    <h6><b><?php echo $item['username']; ?></b></h6>
                    <p style="margin: 0 0 0 10px"><?php echo $item['item']; ?></p> <small style="margin: 10px 0 0 10px">RM <?php echo $item['payment']; ?></small>
                </div>
                
                <div class="col s4 right">
                    <!-- SEE STATUS (USER) -->
                    <div style="margin: 20px">
                        <p class="center-align 
                        <?php 
                        if($item['food_status_id'] == 1) {
                            echo 'red lighten-3';
                        } elseif($item['food_status_id'] == 2) {
                            echo 'orange lighten-3';
                        } elseif($item['food_status_id'] == 3) {
                            echo 'yellow lighten-3';
                        } else {
                            echo 'green lighten-3';
                        }
                        ?>" 
                        style="border: 1px dotted black; margin: 0 0 10px 0; padding: 5px"><?php echo $item['food_status'] ?></p>
                    </div>
                </div>
            </div>
            
            <div class="divider"></div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php if($items == NULL): ?>
    <div class="center-align"
    style="margin: 70px">
        <h4>You have no orders to track...</h4>
        <a href="/"> << Go Back to Homepage</a>
    </div>
<?php endif; ?>

<?php
    }
    require_once 'layout.php';
?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let elems = document.querySelectorAll('.scrollspy');
        let instances = M.ScrollSpy.init(elems, {});

        let select = document.querySelectorAll('select');
        let selectInstances = M.FormSelect.init(select, {});

        let card = document.querySelector('.card-panel');
        setTimeout(() => {
            <?php unset($_SESSION['message']); ?>
            <?php unset($_SESSION['class']); ?>
            card.classList.toggle('hide');
        }, 2000)
    });
</script>
