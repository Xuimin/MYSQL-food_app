<ul id="myinfo" class="sidenav">
    <li>
        <div class="user-view">
            <div class="background">
                <img src="../../Asset/Image/food.jpg">
            </div>

            <a href="#user">
                <img class="circle" src="<?php echo $_SESSION['user_data']['image']?>">
            </a>
            <a href="#name">
                <span class="white-text name" style="font-size: 30px; display: inline">
                    <?php echo $_SESSION['user_data']['username']; ?>
                </span>
            </a>
            <a href="../Views/profile.php" data-target="edit">
                <i class="material-icons">edit</i>
            </a>
        </div>
    </li>

    <?php if(isset($_SESSION['user_data']['address']) != NULL && isset($_SESSION['user_data']['contact']) != NULL && isset($_SESSION['user_data']['birthday']) != NULL ): ?>
        <br>
        <div style="margin: 0 20px">
            <small style="display: block">Address <i class="material-icons tiny">place</i></small>
            <span><?php echo $_SESSION['user_data']['address']; ?></span><br><br>

            <small style="display: block">Contact Number <i class="material-icons tiny">phone_android</i></small>
            <span><?php echo $_SESSION['user_data']['contact']; ?></span><br><br>

            <small style="display: block">Birthday <i class="material-icons tiny">cake</i></small>
            <span><?php echo $_SESSION['user_data']['birthday']; ?></span><br><br>
        </div>

    <?php else: ?>
        <div style="margin: 0 20px">
            <small style="display: block">Address <i class="material-icons tiny">place</i></small>
            <span>NOT SET
                <a href="../Views/profile.php">
                    <i class="tiny material-icons">edit</i>
                </a>
            </span><br><br>

            <small style="display: block">Contact Number <i class="material-icons tiny">phone_android</i></small>
            <span>NOT SET
                <a href="../Views/profile.php">
                    <i class="tiny material-icons">edit</i>
                </a>
            </span><br><br>

            <small style="display: block">Birthday <i class="material-icons tiny">cake</i></small>
            <span>NOT SET
                <a href="../Views/profile.php">
                    <i class="tiny material-icons">edit</i>
                </a>
            </span><br><br>
        </div>
        
    <?php endif; ?>

    <div class="divider"></div>

    <?php if(isset($_SESSION['user_data'])): ?>

        <?php if(!$_SESSION['user_data']['is_admin']): ?>
            <li class="tab"><a href="/Views/favorite.php">Favorite</a></li>
            <li class="tab"><a href="/Views/cart.php">Cart</a></li>
            <li class="tab"><a href="/Views/transactions.php">Transactions</a></li>
            <li class="tab"><a href="/Views/orders.php">Orders</a></li>
            <li class="tab"><a href="/Views/history.php">History</a></li>
            <li class="tab"><a href="/Views/feedback_form.php">Give feedback</a></li>
        <?php endif; ?>

        <?php if($_SESSION['user_data']['is_admin']): ?>
            <li class="tab"><a href="/Views/all_orders.php">All Orders</a></li>
            <li class="tab"><a href="/Views/feedback.php">View Feedback
            </a></li>
        <?php endif; ?>

    <?php endif; ?>
    
</ul>

    <a href="#" 
    data-target="myinfo" class="sidenav-trigger">
        <i class="material-icons">person</i>
    </a>