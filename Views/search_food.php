<?php
    $title = "Your search";
    require_once '../Controllers/FoodControllers.php';
    require_once '../Controllers/FavoriteControllers.php';
    
    function get_content() {

        if(isset($_POST['search'])) {
            $keyword = $_POST['search'];
            $search_query = "SELECT * FROM foods WHERE name LIKE '%$keyword%' 
            AND isDeleted = 0";
            $result = mysqli_query($GLOBALS['cn'], $search_query);
            $find_foods = mysqli_fetch_all($result, MYSQLI_ASSOC);

            // var_dump($find_foods);
            // die();
        }

        if(isset($_SESSION['user_data'])) {
            $query2 = "SELECT * FROM favorite WHERE user_id = {$_SESSION['user_data']['id']}";
            $result2 = mysqli_query($GLOBALS['cn'], $query2);
            $favs = mysqli_fetch_all($result2, MYSQLI_ASSOC);  
        }

?>

<div class="container" 
style="margin-bottom: 30px">
    <form action="" 
    method="POST">
        <div class="row">
            <div class="input-field offset-s2 col s7">
                <input type="text" 
                name="search" 
                placeholder="Search here...">
            </div>

            <button class="btn">
                <i class="material-icons">search</i>
            </button>
        </div>
    </form>
</div>

<div class="container">
    <?php if(isset($_POST['search'])): ?>
        <?php foreach($find_foods as $find): ?>
            <div class="col s12">
                    <div class="divider"></div>

                    <!-- SHOW SEARCH -->
                    <div class="section" 
                    style="margin-bottom: 20px">
                        <div class="col m7" 
                        style="padding: 20px">
                            
                                <?php if($find['image'] != '/Public/'): ?>
                                    <img src="<?php echo $find['image']; ?>" 
                                    style="width: 100px; height: 100px; margin: 10px" 
                                    class="right">
                                <?php endif; ?>

                            <h5 style="display: inline"><?php echo $find['name'] ;?></h5>
                            
                            <!-- ADD TO FAV (USER) -->
                            <?php if(isset($_SESSION['user_data']) && !$_SESSION['user_data']['isAdmin']): ?>
    
                                <a href="/web.php?action=favorite&id=<?php echo $find['id']?>">
                                    <i class="tiny material-icons">favorite_border</i>
                                </a> 
                                
                                <?php foreach($favs as $fav): ?>
                                    <?php if($fav['food_id'] == $find['id'] && $fav['user_id'] == $_SESSION['user_data']['id']) : ?>
                                        <?php if($fav['isDeleted'] == 1): ?>
                                        <a href="/web.php?action=favorite&id=<?php echo $find['id']?>">
                                            <i class="material-icons">favorite_border</i>
                                        </a> 
    
                                    <?php else: ?>
                                        <a href="/web.php?action=remove_fav&id=<?php echo $find['id']?>">
                                            <i class="material-icons">favorite</i>
                                        </a>
    
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
    
                            <?php endif; ?>
    
                            <!-- VIEW FOOD DETAILS AND COMMENTS (ALL) -->
                            <?php if(isset($_SESSION['user_data'])): ?>
                            <a href="food_details.php?id=<?php echo $find['id']?>">
                                View Details
                            </a>
                            <?php endif; ?>
                            
                            <p style="margin: 2px;">
                                <?php echo $find['description']; ?>
                            </p>
    
                            <small style="display: block">
                                Price: RM <?php echo $find['price']; ?>
                            </small>
                        </div>
                    </div>
                </div>
        <?php endforeach; ?>
    
    <?php else:?>
        <h4 class="center-align"
        style="margin: 90px">Oh no, item search not found! Please search for something else...</h4>
    <?php endif; ?>

    <?php if(isset($find_foods)): ?>
        <?php if($find_foods == NULL): ?>
            <h4 class="center-align"
            style="margin: 90px">Oh no, item search not found! Please search for something else...</h4>
        <?php endif; ?>
    <?php endif; ?>
</div>

<?php
    }
    require_once 'layout.php';
?>