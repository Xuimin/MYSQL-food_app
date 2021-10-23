<?php 
    $title = 'Login';

    function get_content() {
        if(isset($_SESSION['user_data'])) {
            header('Location: /');
        } 
?>



<div class="container">
    <!-- SHOW ERROR MESSAGE -->
    <?php if(isset($_SESSION['message'])): ?>
        <div class="card-panel pulse <?php echo $_SESSION['class'] ?>"
        style="margin-top: 50px">
            <?php echo $_SESSION['message']; ?>
        </div>
    <?php endif; ?>

    <!-- LOGIN FORM -->
    <div class="card" 
    style="margin: 80px 0 100px 0; padding: 30px">
        <h5 class="center-align">Login form</h5>
        <div class="col m6 offset-m3">
            <div class="card-content">
                <form method="POST"
                action="/web.php">
                    <input type="hidden" 
                    name="action"
                    value="login">
    
                    <div class="input-field">
                        <input type="text" 
                        name="username"
                        id="username">
                        <label for="username" 
                        class="orange-text">Username</label>
                    </div>
        
                    <div class="input-field">
                        <input type="password" 
                        name="password"
                        id="password">
                        <label for="password" 
                        class="orange-text">Password</label>
                    </div>
        
                    <button class="btn">
                        Login
                        <i class="material-icons right">send</i>
                    </button>
                </form>
            </div>
        </div>
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