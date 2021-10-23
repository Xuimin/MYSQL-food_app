<?php 
    session_start(); 
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!--Import Google Icon Font-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" 
        rel="stylesheet">

        <!-- Materialize CSS -->
        <link rel="stylesheet" 
        href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

        <!-- Google Form -->
        <link rel="preconnect" 
        href="https://fonts.googleapis.com">
        <link rel="preconnect" 
        href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Kalam:wght@300&display=swap" 
        rel="stylesheet">

        <!-- Add icon library -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <!-- Own Css -->
        <link rel="stylesheet" type="text/css" href="../Asset/Css/style.css">

        <title>Food Ordering App | <?php echo $title; ?></title>
    </head>

    <body>
        <?php require_once 'Template/nav.php';?>
        
        <div class="container">
            <?php if(isset($_SESSION['user_data'])): ?>
                <h6 style="position: absolute; top: 105px">
                    <?php require_once 'Template/user_info.php'; ?>
    
                    <?php echo $_SESSION['user_data']['username']; ?>
                </h6>

            <?php else: ?>
                <?php echo '<h6 style="position: absolute; top: 105px">Please login/create an account</h6>'?>

            <?php endif; ?>

            <?php if($title !== "Home"): ?>
                <h2 class="center-align"
                style="margin-top: 100px">
                    <?php echo $title; ?>
                </h2>
            <?php endif; ?>
        </div>

        <main>
            <?php echo get_content(); ?>
        </main>

        <?php require_once 'Template/footer.php';?>

        <!-- Materialize Js -->
        <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js">
        </script>
    </body>
</html>