<div class="navbar-fixed">

    <nav class="nav-extended orange darken-2">
        <div class="nav-wrapper container">
            <a href="#" 
            class="brand-logo" 
            style="font-size: 20px">
                <img src="/Asset/Image/food-icon.png" style="height: 40px; width: 40px; margin-top: 10px">cellentEat
            </a>
        
            <a href="#" 
            data-target="mobile-menu" 
            class="sidenav-trigger">
                <i class="material-icons">menu</i>
            </a>
        
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li><a href="/">Home</a></li>
        
                <?php if(!isset($_SESSION['user_data'])): ?>
                    <li><a href="/Views/register.php">Register</a></li>
                    <li><a href="/Views/login.php">Login</a></li>
        
                <?php else: ?>
                    <li><a href="/web.php/logout">Logout</a></li>
                <?php endif; ?>
            </ul>
        </div>
        
        <div class="nav-content container">
            <ul class="tabs tabs-transparent">
                <li class="tab"><a href="/" class="active">Home</a></li>
        
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
            </ul>
        </div>
    </nav>
</div>

<ul class="sidenav" id="mobile-menu">
    <li><a href="/">Home</a></li>

    <?php if(!isset($_SESSION['user_data'])): ?>
        <li><a href="/Views/register.php">Register</a></li>
        <li><a href="/Views/login.php">Login</a></li>

    <?php else: ?>
        <li><a href="/web.php/logout">Logout</a></li>
    <?php endif; ?>
</ul>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        let elems = document.querySelectorAll('.sidenav');
        let instances = M.Sidenav.init(elems, {});
    });
</script>
