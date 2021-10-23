<?php
    $title = "Food Details, Reviews";
    require_once "../Controllers/connection.php";
    
    function get_content() {
        if(!isset($_SESSION['user_data'])) {
            header('Location: /');
        }
        
        $query = "SELECT foods.*, categories.id AS category_id , categories.types
        FROM foods
        JOIN categories ON foods.category_id = categories.id
        WHERE foods.id = {$_GET['id']}";
        $result = mysqli_query($GLOBALS['cn'], $query);
        $food = mysqli_fetch_assoc($result);

        // var_dump($food);
        // die();

        $query2 = "SELECT categories.id, categories.types FROM categories";
        $result2 = mysqli_query($GLOBALS['cn'], $query2);
        $categories = mysqli_fetch_all($result2, MYSQLI_ASSOC);

        // var_dump($categories);
        // die();

        $query3 = "SELECT review.*, users.image, users.username
        FROM review
        JOIN users ON review.user_name = users.username
        WHERE review.food_id = {$_GET['id']}
        ORDER BY date, time DESC";
        $result3 = mysqli_query($GLOBALS['cn'], $query3);
        $reviews = mysqli_fetch_all($result3, MYSQLI_ASSOC);
        
        // var_dump($reviews);
        // die();
?>

<div class="container">
<!-- SHOW ERROR MESSAGE -->
<?php if(isset($_SESSION['message'])): ?>
    <div class="card-panel pulse <?php echo $_SESSION['class'] ?>">
        <?php echo $_SESSION['message']; ?>
    </div>
<?php endif; ?>

    <div class="row">
        <div class="col s12">
            <div class="card">
                <?php if(isset($_SESSION['user_data']) && $_SESSION['user_data']['isAdmin']):?>
                    <div class="card-content" 
                style="padding: 10px; display: flex; justify-content: flex-end">
                        <!-- EDIT AND DELETE BUTTON -->
                        <a href="#modalEdit" 
                        class="modal-trigger btn orange" 
                        style="margin: 0 10px">Edit</a>
                        <a href="#modalDel" 
                        class="modal-trigger btn red">Delete</a>
                    </div>
                <?php endif; ?>

                <!-- DELETE MODAL -->
                <div id="modalDel" 
                class="modal">
                    <div class="modal-content">
                        <h4><?php echo $food['name']; ?></h4>
                        <p>Are you sure you want to delete this product?</p>
                    </div>
                    <div class="modal-footer">
                        <a href="../web.php?id=<?php echo $food['id']?>&action=delete_food" 
                        class="btn">Delete</a>
                        <a href="" 
                        class="modal-close btn-flat grey lighten-2">Close</a>
                    </div>
                </div>

                <!-- EDIT MODAL -->
                <div id="modalEdit" 
                class="modal">
                    <div class="modal-content">
                        <h4>Edit Food</h4>
                        <form action="/web.php"
                        method="POST"
                        enctype="multipart/form-data">

                            <input type="hidden"
                            name="action"
                            value="edit_food">

                            <input type="hidden" 
                            name="id" 
                            value="<?php echo $food['id']?>">
                    
                            <div class="row" 
                            style="margin: 0px">
                                <div class="input-field col s12">
                                    <input type="text"
                                    name="food_name"
                                    id=food
                                    value="<?php echo $food['name']?>">
                                    <label for="food"
                                    class="purple-text">Food Name</label>
                                </div>
                            </div>
                    
                            <div class="row">
                                <div class="input-field col s6">
                                    <input type="text"
                                    name="description"
                                    id=description
                                    value="<?php echo $food['description']?>">
                                    <label for="description"
                                    class="purple-text">Description</label>
                                </div>
                        
                                <div class="input-field col s6">
                                    <input type="number"
                                    name="price"
                                    id=price
                                    value="<?php echo $food['price']?>">
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
                                        name="image"
                                        value="<?php echo $food['image']?>">
                                    </div>
                                </div>
                            </div>
                    
                            <div class="row">
                                <div class="input-field col s5">
                                    <select name="isAvailable">
                                        <option disabled selected>Choose Option</option>
                                        <option value="0">Not Available</option>
                                        <option value="1">Available</option>
                                    </select>
                                </div>
                        
                                <div class="input-field col s5">
                                    <select name="category_id">
                                        <option value="<?php echo $food['category_id']?>"selected><?php echo $food['types']?></option>
                        
                                        <?php foreach($categories as $category): ?>
                                            <option value="<?php echo $category['id']?>">
                                                <?php echo $category['types']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                    
                                <button class="btn col s1" 
                                style="margin: 10px 0; padding: 0">
                                    <i class="material-icons">edit</i>
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

                <div class="divider"></div>

                <!-- SHOW DETAILS -->
                <div class="card-content">
                    <div class="right">
                        <?php if(isset($_SESSION['user_data']) && $_SESSION['user_data']['isAdmin']): ?>
                            <div class="switch" style="margin-bottom: 10px">
                                <form action="../web.php"
                                method="POST">
                                    <input type="hidden" 
                                    name="id" 
                                    value="<?php echo $food['id']?>">
        
                                    <input type="hidden" name="action" value="isAvailable">

                                    <?php if($food['isAvailable'] == 1): ?>
                                    <label>
                                        N/Available
                                        <input type="checkbox" name="isAvailable" checked>
                                        <span class="lever"></span>
                                        Available
                                    </label>
                                    <?php endif; ?>

                                    <?php if($food['isAvailable'] == 0): ?>
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
                            <?php if(isset($_SESSION['user_data']['id']) && $_SESSION['user_data']['isAdmin']): ?>
                                <a href="../web.php?id=<?php echo $food['id']?>&action=delete_img">
                                    <i class="material-icons right" style="margin: 0">delete</i>
                                </a>
                            <?php endif; ?>
                            <img src="<?php echo $food['image']; ?>" 
                            style="width: 160px; height: 160px; margin-bottom: 10px" 
                            class="right">
                        <?php endif; ?>
                    </div>

                    <span class="card-title" 
                    style="font-size: 36px">
                        <?php echo $food['name']?>
                    </span>

                    <b>Description: </b>
                    <p style="margin-bottom: 5px">
                        <?php echo $food['description']; ?>
                    </p>

                    <span>
                        <b>Price:</b> RM <?php echo $food['price']?>
                    </span>

                    <p>
                        <b>Category:</b> 
                        <?php echo $food['types']; ?>
                    </p><br>

                    <!-- ADD TO CART BUTTON -->
                    <?php if(!$_SESSION['user_data']['isAdmin']): ?>
                    <form action="../web.php" 
                    method="POST" 
                    style="margin-bottom: 0">
                        <input type="hidden" 
                        name="action" 
                        value="add_to_cart">

                        <input type="hidden" 
                        name="id" 
                        value="<?php echo $food['id']; ?>">

                        <input type="hidden" 
                        name="price" 
                        value="<?php echo $food['price'];?>">

                            
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

                        <br><br><br>

                        <?php if($food['isAvailable'] == 1): ?>
                        <button style="font-size: 2px; border: none; background-color: transparent; color: blue; margin-bottom: 0">
                            Add to Cart
                            <i class="tiny material-icons">
                                add_shopping_cart
                            </i>
                        </button>    
                        <?php endif; ?>                
                    </form>
                    <?php endif; ?>
                </div>

                <div class="divider"></div>

                <!-- COMMENT -->
                <div class="card-content" 
                style="padding-top: 10px">
                    <h5>
                        <u>Comments 
                            <i class="material-icons">comment</i>
                        </u>
                    </h5>
                    
                    <!-- ADD COMMENT -->
                    <div class="card yellow lighten-5" 
                    style="padding: 10px; margin: 0">
                        <form action="/web.php" 
                        style="padding: 10px 0 20px 0" 
                        method="POST">
                            <input type="hidden" 
                            name="id" 
                            value="<?php echo $food['id']?>">

                            <input type="hidden" 
                            name="action" 
                            value="comment">

                            <div class="input-field col s10">
                                <input type="text" 
                                name="comment" 
                                id="comment" 
                                placeholder="Please leave a comment..." 
                                required>
                                <label for="comment">Comment</label>
                            </div>

                            <button class="btn" 
                            style="margin-top: 10px">
                                <i class="material-icons">send</i>
                            </button>
                        </form>
                    </div>

                    <br>

                    <!-- SHOW COMMENT -->
                    <ul class="collection">
                        <?php foreach($reviews as $review): ?>
                        <li class="collection-item avatar yellow lighten-5">
                            <img src="<?php echo $review['image']?>" class="circle">
                                <?php echo $review['date'] . ' ' . $review['time']; ?>
                                <small class="blue-text">
                                <?php if($review['isEdited'] == 1): ?>
                                    [Edited]
                                <?php endif; ?>
                                </small>
                            </p>
        
                            <?php if($_SESSION['user_data']['username'] == $review['user_name']): ?>
                                <a href="#commentEdit-<?php echo $review['id']?>" class="modal-trigger">
                                    <i class="tiny material-icons right">edit</i>
                                </a>
                            <?php endif; ?>
        
                            <div id="commentEdit-<?php echo $review['id']?>" class="modal">
                                <form action="../web.php" method="POST">
                                    <div class="modal-content">
                                        <h6><?php echo $review['user_name']; ?>'s Comment</h6>
        
                                        <input type="hidden" name="action" value="edit_comment">
        
                                        <input type="hidden" name="id" 
                                        value="<?php echo $review['id']?>">
        
                                        <input type="hidden" 
                                        name="user_name" 
                                        value="<?php echo $review['user_name']?>">
        
                                        <div class="input-field">
                                            <input type="text" 
                                            name="comment" 
                                            value="<?php echo $review['comment']; ?>" id="comment">
                                            <label for="comment">Comment</label>
                                        </div>
        
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn">Edit</button>
                                        <a href="" class="modal-close btn-flat grey lighten-2">Close</a>
                                    </div>
                                </form>
                            </div>
        
                            <span>
                                <b style="font-size: 15px"><?php echo $review['user_name']; ?></b>
                                <?php if($review['user_name'] == $_SESSION['user_data']['username']): ?>
                                    <small>[You]</small>
                                <?php endif; ?>
                            </span> 
                            <p><?php echo $review['comment']; ?></p>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    }
    require_once 'layout.php';
?>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        let elems = document.querySelectorAll('.modal');
        let instances = M.Modal.init(elems, {});

        let selects = document.querySelectorAll('select');
        let selectInstances = M.FormSelect.init(selects, {});

        let card = document.querySelector('.card-panel');
        setTimeout(() => {
            <?php unset($_SESSION['message']); ?>
            <?php unset($_SESSION['class']); ?>
            card.classList.toggle('hide');
        }, 2000)
    });
</script>
