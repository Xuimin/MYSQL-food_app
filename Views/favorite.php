<?php 
    $title = "My favorite";
    
    function get_content() { 
        if(!isset($_SESSION['user_data'])) {
            header('Location: /');
        }
        
        require_once '../Controllers/connection.php';
        $query = "SELECT favorite.*, users.id, foods.id AS food_id, foods.name, foods.price, foods.category_id, categories.types, categories.id AS category_id
        FROM favorite
        JOIN users ON favorite.user_id = users.id
        JOIN foods ON favorite.food_id = foods.id
        JOIN categories ON foods.category_id = categories.id
        WHERE favorite.user_id = {$_SESSION['user_data']['id']} 
        AND favorite.is_deleted = 0";
        $result = mysqli_query($cn, $query);
        $fav_foods = mysqli_fetch_all($result, MYSQLI_ASSOC);

        // var_dump($fav_foods);
        // die();

        if(count($fav_foods) == 0) {
            return "
            <div class='center-align' 
            style='margin: 110px'>
                <h4>Oh no, there is no Favorite<i class='material-icons red-text'>favorite</i> here</h4>
                <a href='/'> << Go Back to Homepage </a>
            </div>
            ";
        } else {
            
        }
?>



<div class="container">
    <!-- SHOW ERROR MESSAGE -->
    <?php if(isset($_SESSION['message'])): ?>
        <div class="card-panel pulse <?php echo $_SESSION['class'] ?>">
            <?php echo $_SESSION['message']; ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <?php foreach($fav_foods as $fav): ?>
            <?php if($fav['is_deleted'] == 0): ?>
                <div class="col s6 l4">
                    <!-- SHOW FAVORITE -->
                    <div class="card" 
                    id="heart-bg">
                        <div class="card-content">
                            <h5 style="display: inline"><?php echo $fav['name']; ?></h5>
                            <a href="../web.php?id=<?php echo $fav['food_id'] ?>&action=remove_fav">
                                <i class="material-icons">favorite</i>
                            </a>
                            <br>
                            <span class="badge yellow lighten-1"><?php echo $fav['types']; ?></span>
                            <span>Price: RM <?php echo $fav['price']; ?></span>
                        </div>
                        <div class="card-action">
                            <!-- VIEW DETAILS AND REVIEW -->
                            <a href="food_details.php?id=<?php echo $fav['food_id'];?>">View more</a>
                        </div>
                    </div>
                </div>
            <?php endif;?>
        <?php endforeach; ?>
    </div>
</div>

<?php
    }
    require_once 'layout.php';
?>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', () => {
        let card = document.querySelector('.card-panel');
        setTimeout(() => {
            <?php unset($_SESSION['message']); ?>
            <?php unset($_SESSION['class']); ?>
            card.classList.toggle('hide');
        }, 2000)
    })
</script>