<?php
    $title = 'Home';

    require_once 'Controllers/connection.php';
    require_once 'Controllers/FoodControllers.php';
    require_once 'Controllers/ProfileControllers.php';
   
    date_default_timezone_set('Asia/Kuala_Lumpur');

    function get_content() {
        // GET FOOD
        $foods = get_foods();

        // var_dump($foods);
        // die();

        // GET THE CATEGORIES
        $query = "SELECT * FROM categories";
        $result = mysqli_query($GLOBALS['cn'], $query);
        $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

        // var_dump($categories);
        // die();

        // GET FAVORITE
        if(isset($_SESSION['user_data'])) {
            $query2 = "SELECT * FROM favorite WHERE user_id = {$_SESSION['user_data']['id']}";
            $result2 = mysqli_query($GLOBALS['cn'], $query2);
            $favs = mysqli_fetch_all($result2, MYSQLI_ASSOC);  

            // var_dump($favs);
            // die();
        }

        $query3 = "SELECT * FROM openclose";
        $result3 = mysqli_query($GLOBALS['cn'], $query3);
        $shop = mysqli_fetch_assoc($result3);  
        
        // var_dump($shop);
        // die();
    
?>

<!-- SHOW ERROR MESSAGE -->
<?php if(isset($_SESSION['message'])): ?>
    <div class="card-panel pulse <?php echo $_SESSION['class'] ?> center-align"
    style="margin-top: 90px">
        <div class="fixed-navbar">
            <?php echo $_SESSION['message']; ?>
        </div>
    </div>
<?php endif; ?>
    
<!-- BACKGROUND IMAGE -->
<div id="background-image">
    <div class="container center-align">
        <h2>Welcome to <span class="orange-text">X</span>cellentEat</h2>
        <h4>We hope you are having a good time...</h4> 

        <!-- SEARCH BUTTON -->
        <form action="/Views/search_food.php" 
        method="POST">
            <div class="row col s6">
                <div class="input-field col s7 offset-m2">
                    <input type="text" 
                    name="search" 
                    placeholder="What are you craving for..." 
                    >
                    <label for="search">Search</label>
                </div>
                <button class="btn col s1">
                    <i class="material-icons">search</i>
                </button>
            </div>
        </form>
    </div>
</div>
    
<div class="container">
    <!-- POST FOOD BUTTON (ADMIN) -->
    <?php if(isset($_SESSION['user_data']) && $_SESSION['user_data']['is_admin'] == 1): ?>
    <a href="#add_food" 
    class="btn modal-trigger" 
    style="margin-top: 20px">Add Food</a>

    <!-- POST FOOD MODAL (ADMIN) -->
    <div id="add_food" 
    class="modal">
        <div class="modal-content">
            <form action="/web.php"
            method="POST"
            enctype="multipart/form-data">

                <input type="hidden"
                name="action"
                value="add_food">
        
                <div class="row" 
                style="margin: 0px">
                    <div class="input-field col s12">
                        <input type="text"
                        name="food_name"
                        id=food>
                        <label for="food"
                        class="purple-text">Food Name</label>
                    </div>
                </div>
        
                <div class="row">
                    <div class="input-field col s6">
                        <input type="text"
                        name="description"
                        id=description>
                        <label for="description"
                        class="purple-text">Description</label>
                    </div>
            
                    <div class="input-field col s6">
                        <input type="number"
                        name="price"
                        id=price>
                        <label for="price"
                        class="purple-text">Price</label>
                    </div>
                </div>
        
                <div class="row">
                    <div class="input-field file-field col s12">
                        <div class="btn orange lighten-2">
                            <span>File</span>
                            <input type="file" 
                            name="imgUpload[]" 
                            id="food_img">
                        </div>

                        <div class="file-path-wrapper">
                            <input type="text"
                            class="file-path validate"
                            placeholder="(Optional)"
                            name="image">
                        </div>
                    </div>
                </div>
        
                <div class="row">
                    <div class="input-field col s5">
                        <select name="isAvailable">
                            <option disabled selected>Choose option</option>
                            <option value="0">Not Available</option>
                            <option value="1">Available</option>
                        </select>
                    </div>
            
                    <div class="input-field col s5">
                        <select name="category_id">
                            <option disabled selected>Food type</option>
            
                            <?php foreach($categories as $category): ?>
                                <option value="<?php echo $category['id']?>">
                                    <?php echo $category['types']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
        
                    <button class="btn col s1" 
                    style="margin: 10px 0; padding: 0">
                        <i class="material-icons">add</i>
                    </button>
                </div>
            </form>

            <div class="modal-footer">
                <a href="" 
                class="btn-flat modal-close grey lighten-3">
                    Close
                </a>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- OPEN / CLOSE SHOP (ADMIN) -->
    <?php if(isset($_SESSION['user_data']) && $_SESSION['user_data']['is_admin']): ?>
        <a href="/web.php?action=shop_status&id=<?php echo $shop['shop_status']?>" 
        class="btn"
        style="margin-top: 20px">
            <?php 
                if($shop['shop_status'] == 0) {
                    echo 'Open shop';
                } else {
                    echo 'Close shop';
                }
            ?>
        </a>

        <a href="Views/feedback.php" 
        class="btn"
        style="margin-top: 20px">See User Feedback</a>
    <?php endif; ?>

    <!-- SHOP STATUS (ALL) -->
    <div class="row center-align"
    style="font-size: 20px; margin-top: 20px">
        <?php 
            if($shop['shop_status'] == 0) {
                echo 'SHOP CLOSE <br> Sorry, you are not able to checkout and make transaction';
            } else {
                echo 'SHOP OPEN';
            }
        ?>
    </div>
    
    <!-- SHOW CATEGORY (ALL)-->
    <div class="row card" 
    style="margin: 20px 0 30px 0; padding: 20px; background-color: rgb(250, 213, 143)">
        <h6>What are you up for today?</h6>
        <?php foreach($categories as $category): ?>
            <div class="col s3 card" 
            style="padding: 10px">
                <a href="/Views/category.php?id=<?php echo $category['id']?>"><?php echo $category['types']; ?>
                    <img src="<?php echo $category['food_pic']?>" 
                    style="width: 20px; height: 20px" 
                    class="right">
                </a>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="row">
        <!-- SHOW FOOD (ALL)-->
        <?php $foods = get_foods();
            // var_dump($foods);
            // die();
        ?>

        <?php foreach($foods as $food): ?>
            <?php if($food['is_deleted'] == 0): ?>
            <div class="col s12">
                <div class="divider grey lighten-1"></div>
                <div class="section">
                    <div class="col m7">
                        <h5 style="display: inline"><?php echo $food['name'] ;?></h5>
                        
                        <!-- ADD TO FAV (USER) -->
                        <?php if(isset($_SESSION['user_data']) && !$_SESSION['user_data']['is_admin']): ?>

                            <a href="/web.php?action=favorite&id=<?php echo $food['id']?>">
                                <i class="tiny material-icons">favorite_border</i>
                            </a> 
                            
                            <?php foreach($favs as $fav): ?>
                                <?php if($fav['food_id'] == $food['id'] && $fav['user_id'] == $_SESSION['user_data']['id']) : ?>
                                    <?php if($fav['is_deleted'] == 1): ?>
                                    <a href="/web.php?action=favorite&id=<?php echo $food['id']?>">
                                        <i class="material-icons">favorite_border</i>
                                    </a> 

                                <?php else: ?>
                                    <a href="/web.php?action=remove_fav&id=<?php echo $food['id']?>">
                                        <i class="material-icons">favorite</i>
                                    </a>

                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>

                        <?php endif; ?>

                        <!-- VIEW FOOD DETAILS AND COMMENTS (ALL) -->
                        <?php if(isset($_SESSION['user_data'])): ?>
                        <a href="Views/food_details.php?id=<?php echo $food['id']?>">
                            View Details
                        </a>
                        <?php endif; ?>
                        
                        <p style="margin: 2px;">
                            <?php echo $food['description']; ?>
                        </p>

                        <small style="display: block">
                            Price: RM <?php echo $food['price']; ?>
                        </small>

                        <!-- QUANTITY -->
                        <?php if(isset($_SESSION['user_data']) && !$_SESSION['user_data']['is_admin']): ?>
                        <form action="/web.php" method="POST">

                            <input type="hidden" name="action" value="add_to_cart">

                            <input type="hidden" name="id" value="<?php echo $food['id']; ?>">

                            <input type="hidden" name="price" value="<?php echo $food['price'];?>">
                            
                            <?php if($food['is_available'] == 1): ?>
                                <div class="input-field" style="margin-bottom: 0">
                                    <input type="number"
                                    name="quantity"
                                    id="quantity"
                                    min="1"
                                    max="10"
                                    value="1"
                                    class="col s2">
                                    <label for="quantity"
                                    class="purple-text">Quantity</label>         
                                </div>
                            <?php else: ?>
                                <b style="color: red">Sorry, not available right not!</b>
                            <?php endif; ?>

                            <br>

                            <?php if($food['is_available'] == 1): ?>
                            <button style="font-size: 2px; border: none; background-color: transparent; color: blue; margin-bottom: 10px"
                            class="right">
                            Add to Cart
                                <i class="tiny material-icons">
                                    add_shopping_cart
                                </i>
                            </button>    
                            <?php endif; ?>  

                        </form>
                        <?php endif; ?>
                    </div>

                    <div class="right">

                        <?php if(isset($_SESSION['user_data']) && $_SESSION['user_data']['is_admin']): ?>
                        <div class="switch" style="margin-bottom: 10px">
                            <form action="/web.php"
                            method="POST">
                                <input type="hidden" name="id" value="<?php echo $food['id']?>">

                                <input type="hidden" name="action" value="isAvailable">
                                <?php if($food['is_available'] == 1): ?>
                                <label>
                                    N/Available
                                    <input type="checkbox" name="isAvailable" checked>
                                    <span class="lever"></span>
                                    Available
                                </label>
                                <?php endif; ?>
                                <?php if($food['is_available'] == 0): ?>
                                <label>
                                    N/Available
                                    <input type="checkbox" name="isAvailable">
                                    <span class="lever"></span>
                                    Available
                                </label>
                                <?php endif; ?>
                                <button class="yellow lighten-3" 
                                style="border: 1px solid grey">Save</button>
                            </form>
                        </div>
                        <?php endif; ?>

                        <?php if($food['image'] != '/Public/'): ?>
                            <img src="<?php echo $food['image']; ?>" 
                            style="width: 100px; height: 100px; margin: 10px" 
                            class="right">
                        <?php endif; ?>

                    </div>
                </div>
            </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>

<?php
    }
    require_once 'Views/layout.php'
?>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', () => {
        let card = document.querySelector('.card-panel');
        setTimeout(() => {
            <?php unset($_SESSION['message']); ?>
            <?php unset($_SESSION['class']); ?>
            card.classList.toggle('hide');
        }, 2000)

        let elems = document.querySelectorAll('select');
        let instances = M.FormSelect.init(elems, {});

        let modals = document.querySelectorAll('.modal');
        let modalInstances = M.Modal.init(modals, {});
    })
</script>

