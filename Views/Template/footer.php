<footer class="page-footer orange darken-2"
style="margin-top: 150px">
    <div class="container">
        <div class="row">
            <div class="col s12 xl6">
                <h5 class="white-text center-align">About XcellentEat</h5>
                <p class="center-align">
                    You don't need a silver fork to eat good food. Good thing is XcellentEat strives to provide you with the best possible dining experience...
                    Find the dish you've been desiring
                
                    <br><br>
                    Our Working days / hours: 
                    <br>
                    Monday to Friday (11am - 5pm)
                </p>
                <p class="center-align"> 
                    Follow Us On:
                    <a href="#" class="fa fa-facebook"></a>
                    <a href="#" class="fa fa-instagram"></a>
                    <a href="#" class="fa fa-twitter"></a>
                    ...
                </p>

            </div>
            <div class="col s12 xl6 center-align">
                <h5>Want more? Go to...</h5>

                <li class="tab" ><a href="/" class="active">Home</a></li>

                <?php if(isset($_SESSION['user_data'])): ?>

                    <?php if(!$_SESSION['user_data']['isAdmin']): ?>
                        <li class="tab"><a href="/Views/favorite.php">Favorite</a></li>
                        <li class="tab"><a href="/Views/cart.php">Cart</a></li>
                        <li class="tab"><a href="/Views/transactions.php">Transactions</a></li>
                        <li class="tab"><a href="/Views/orders.php">Orders</a></li>
                        <li class="tab"><a href="/Views/history.php">History</a></li>
                        <li class="tab"><a href="/Views/feedback_form.php">Give feedback</a></li>
                    <?php endif; ?>

                    <?php if($_SESSION['user_data']['isAdmin']): ?>
                        <li class="tab"><a href="/Views/all_orders.php">All Orders</a></li>
                        <li class="tab"><a href="/Views/feedback.php">View Feedback
                        </a></li>
                    <?php endif; ?>

                <?php endif; ?>

            </div>
        </div>
    </div>
    <div class="footer-copyright">
            <div class="container">
            For Educational Purposes Only
            <span class="right">XcellentEat | All rights reserved &copy;</span>
            </div>
          </div>
</footer>