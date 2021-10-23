<?php
    $title = "Food Category";

    function get_content() {
        require_once  '../Controllers/connection.php';
        $query = "SELECT foods.*, categories.types, categories.id AS category_id
        FROM foods
        JOIN categories ON foods.category_id = categories.id
        WHERE category_id = {$_GET['id']}";
        $result = mysqli_query($cn, $query);
        $food_categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

        // var_dump($food_categories);
        // die();

        if(isset($_SESSION['user_data'])) {
            $query2 = "SELECT * FROM favorite WHERE user_id = {$_SESSION['user_data']['id']}";
            $result2 = mysqli_query($cn, $query2);
            $favs = mysqli_fetch_all($result2, MYSQLI_ASSOC);  

            // var_dump($favs);
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

    <div class="row" 
    style="margin-bottom: 50px">
        <?php foreach($food_categories as $food_category): ?>
            <div class="col s12">

                <div class="divider"></div>

                <div class="section">
                    <div class="col m7">
                        <h5 style="display: inline">
                            <?php echo $food_category['name'] ;?>
                        </h5>
                      
                        <!-- ADD TO FAV (USER) -->
                        <?php if(isset($_SESSION['user_data']) && !$_SESSION['user_data']['isAdmin'] == 1): ?>

                            <a href="/web.php?action=favorite&id=<?php echo $food['id']?>">
                                <i class="tiny material-icons">favorite_border</i>
                            </a> 
                            
                            <?php foreach($favs as $fav): ?>
                                <?php if($fav['food_id'] == $food_category['id']): ?>
                                    <?php if($fav['isDeleted'] == 1): ?>
                                        <a href="/web.php?action=favorite&id=<?php echo $food_category['id']?>">
                                            <i class="material-icons">favorite_border</i>
                                        </a>    
                                    <?php else: ?>

                                        <a href="/web.php?action=remove_fav&id=<?php echo $food_category['id']?>">
                                            <i class="material-icons">favorite</i>
                                        </a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <!-- VIEW FOOD DETAILS AND COMMENTS (ALL) -->
                        <a href="food_details.php?id=<?php echo $food_category['id']?>">View Details</a>
                        
                        <p style="margin: 2px;">
                            <?php echo $food_category['description']; ?>
                        </p>

                        <small style="display: block">
                            Price: RM <?php echo $food_category['price']; ?>
                        </small>

                        <!-- QUANTITY -->
                        <?php if(isset($_SESSION['user_data']) && !$_SESSION['user_data']['isAdmin']): ?>
                        <form action="/web.php" 
                        method="POST">
                            <input type="hidden" 
                            name="action" 
                            value="add_to_cart">

                            <input type="hidden" 
                            name="id" 
                            value="<?php echo $food_category['id']; ?>">

                            <input type="hidden" 
                            name="price" 
                            value="<?php echo $food_category['price'];?>">
                            
                            <div class="input-field col s3" 
                            style="margin-bottom: 0">
                                <input type="number"
                                name="quantity"
                                id="quantity"
                                min="1"
                                max="10"
                                value="1">
                                <label for="quantity"
                                class="purple-text">Quantity</label>         
                            </div>
                            
                            <button style=" font-size: 2px; border: none; background-color: transparent; color: blue;" 
                            class="right">
                            Add to Cart
                                <i class="tiny material-icons">
                                    add_shopping_cart
                                </i>
                            </button>                    
                        </form>
                        <?php endif; ?>
                    </div>

                    <div class="right">
                        <?php if($food_category['image'] != '/Public/'): ?>
                            <img src="<?php echo $food_category['image']; ?>" 
                            style="width: 100px; height: 100px; margin: 0"
                            class="right">
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php if($food_categories == NULL): ?>
    <div class="center-align">
        <h4>No Food Found in this Category</h4>
        <a href="/"> << Go Back to Homepage</a>
    </div>
<?php endif; ?>

<?php
    }
    require_once 'layout.php';
?>

<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function() {
        let card = document.querySelector('.card-panel');
        setTimeout(() => {
            <?php unset($_SESSION['message']); ?>
            <?php unset($_SESSION['class']); ?>
            card.classList.toggle('hide');
        }, 2000)
    })
</script>
