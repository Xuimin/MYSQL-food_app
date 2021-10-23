<?php
    $title = 'Edit Profile';
    require_once '../Controllers/AuthControllers.php';
    
    
    function get_content() {
        if(!isset($_SESSION['user_data'])) {
            header('Location: /');
        }
        
        $infos = user_info();

        // var_dump($infos);
        // die();
?>

<div class="container">
    <!-- SHOW ERROR MESSAGE -->
    <?php if(isset($_SESSION['message'])): ?>
        <div class="card-panel pulse <?php echo $_SESSION['class'] ?>">
            <?php echo $_SESSION['message']; ?>
        </div>
    <?php endif; ?>

    <!-- EDIT DETAILS (BOTH) -->
    <form action="../web.php" 
    method="POST"
    enctype="multipart/form-data"
    style="margin: 20px">
        <input type="hidden" 
        name="action" 
        value="edit_profile">

        <div class="center-align">
            <img class="circle" 
            src="<?php echo $infos['image']?>" style="width: 100px; height: 100px; border: 1px solid black">
            
            <!-- UPDATE PROFILE PIC (BOTH) -->
            <div class="input-field file-field">
                <div class="btn orange lighten-2">
                    <i class="material-icons">add_a_photo</i>
                    <input type="file" 
                    name="image" 
                    id="image">
                </div>
                <div class="file-path-wrapper">
                    <input type="text"
                    placeholder="Please upload your profile picture"
                    class="file-path validate"
                    value="<?php echo $infos['image']?>"
                    name="image">
                </div>
            </div>
        </div>
        
        <div class="input-field">
            <input type="text"
            name="username"
            id="username"
            value="<?php echo $infos['username']; ?>">
            <label for="username">Username</label>
        </div>

        <div class="input-field">
            <input type="text"
            name="address"
            id="address"
            value="<?php echo $infos['address']; ?>">
            <label for="address">Address</label>
        </div>

        <div class="input-field">
            <input type="text"
            name="contact"
            id="contact"
            placeholder="10 digits"
            value="<?php echo $infos['contact'];?>">
            <label for="contact">Contact Number</label>
        </div>

        <div class="input-field">
            <input type="date"
            name="birthday"
            id="birthday"
            value="<?php echo $infos['birthday'];?>"
            max="<?php echo date('Y-m-d'); ?>">
            <label for="birthday">Birthday</label>
        </div>

        <button class="btn">
            Update
            <i class="material-icons right">send</i>
        </button>
    </form>
</div>

<?php
    }
    require_once 'layout.php'
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