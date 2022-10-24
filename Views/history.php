<?php 
    $title = "My history";
    
    function get_content() { 
        if(!isset($_SESSION['user_data'])) {
            header('Location: /');
        }
        
        require_once '../Controllers/connection.php';
        $query = "SELECT orders.*, users.*, transactions.*
        FROM orders 
        JOIN users ON orders.user_id = users.id
        JOIN transactions ON orders.transaction_id = transactions.id
        WHERE is_done = 1
        AND users.id = {$_SESSION['user_data']['id']}";
        $result = mysqli_query($cn, $query);
        $items = mysqli_fetch_all($result, MYSQLI_ASSOC);

        // var_dump($items);
        // die();
?>

<div class="container">
    <div class="row">
        <div class="col s12">
            <div class="card">
                <?php foreach($items as $item): ?>
                <div class="card-content">
                    <p style="font-size: 18px; font-weight: bold"><?php echo $item['item']; ?></p>
                    <p>Date Purchase: <?php echo $item['date'] . ' ' . $item['time']; ?></p>
                    <span>Price: RM <?php echo $item['payment'] ?></span>
                    <i class="material-icons right">check</i>
                </div>
                <div class="divider"></div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<?php if($items == NULL): ?>
    <div class="center-align"
    style="margin: 70px">
        <h4>You have not purchase anything before...</h4>
        <a href="/"> << Go Back to Homepage</a>
    </div>
<?php endif; ?>

<?php
    }
    require_once 'layout.php';
?>