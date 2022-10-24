<?php 
    $title = "All Orders";
    require_once '../Controllers/connection.php';

    function get_content() {
        if(!isset($_SESSION['user_data'])) {
            header('Location: /');
        }
        
        $query = "SELECT orders.*, orders.id AS order_id, transactions.*, transactions.id AS transaction_id, status.id AS status_id, status.food_status, users.id, users.username
        FROM orders
        JOIN users ON orders.user_id = users.id
        JOIN transactions ON orders.transaction_id = transactions.id
        JOIN status ON orders.food_status_id = status.id
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
        <?php foreach($items as $item): ?>
        <div class="collection">
            <div class="row valign-wrapper"
            style="height: 250px; margin-left:20px">
                <div class="col s6">
                    <h6><b><?php echo $item['username']; ?></b></h6>
                    <p style="margin: 0 0 0 10px"><?php echo $item['item']; ?></p> <small style="margin: 10px 0 0 10px">RM <?php echo $item['payment']; ?></small>
                </div>
                
                <div class="col s6">
                    <!-- UPDATE STATUS (ADMIN) -->
                    <?php if(isset($_SESSION['user_data']) && $_SESSION['user_data']['is_admin']): ?>
                        <form action="../web.php" method="POST">
                            <?php if($item['is_done'] == 0): ?>
                                <button class="btn right" style="margin-top: 20px"><i class="material-icons">autorenew</i></button>
                            <?php endif; ?>
        
                            <input type="hidden" name="action" value="update_status">
        
                            <input type="hidden" name="id" value="<?php echo $item['order_id']?>">
        
                            <?php if($item['is_done'] == 0): ?>
                            <div class="input-field col s8 right">
                                <select name="status_id">
                                    <option value="<?php echo $item['status_id']?>" disabled selected><?php echo $item['food_status']; ?></option>
            
                                    <?php foreach($statuss as $status): ?>
                                    <option value="<?php echo $status['id'];?>"><?php echo $status['food_status']?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <?php endif; ?>
                        </form>
                    <?php endif; ?>

                    <!-- SEE STATUS (BOTH) -->
                    <div style="margin: 20px">
                        <p class="center-align right
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
                        style="border: 1px dotted black; margin: 0 0 10px 0;padding: 5px"><?php echo $item['food_status'] ?></p>
                    </div>
                </div>

                <!-- SET ORDER COMPLETED (ADMIN) -->
                <?php if($item['food_status_id'] == 4 && $item['is_done'] == 0): ?>
                    <a href="../web.php?id=<?php echo $item['transaction_id']?>&action=complete"
                    class="right btn red-text" 
                    style="margin: 0 10px 10px 0">
                        Complete
                        <i class="material-icons">check</i>
                    </a>
                <?php endif; ?>

            </div>
            <div class="divider"></div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

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
