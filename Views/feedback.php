<?php 
    $title = 'Feedback';
    function get_content() {
        if(!isset($_SESSION['user_data'])) {
            header('Location: /');
        }
        
        require_once '../Controllers/connection.php';
        $query = "SELECT feedback.*, feedback.id AS feedback_id, users.username, users.id
        FROM feedback
        JOIN users ON feedback.user_id = users.id
        ORDER BY feedback.id DESC";
        $result = mysqli_query($cn, $query);
        $feedbacks = mysqli_fetch_all($result, MYSQLI_ASSOC);

        // var_dump($feedbacks);
        // die()
?>

<?php if(isset($feedbacks)): ?>
    <div class="container">
        <!-- SHOW ERROR MESSAGE -->
        <?php if(isset($_SESSION['message'])): ?>
            <div class="card-panel pulse <?php echo $_SESSION['class'] ?>">
                <?php echo $_SESSION['message']; ?>
            </div>
        <?php endif; ?>

        <?php foreach($feedbacks as $feedback): ?>
        <div class="card"
        style="margin: 30px 0">
            <div class="card-content col s9">
                <h6><?php echo $feedback['username']; ?></h6>
                <p><?php echo $feedback['feedback']; ?></p>

                <a href="../web.php?id=<?php echo $feedback['feedback_id']?>&action=read" 
                class="right">
                    <?php   
                        if($feedback['isRead'] == 0) {
                            echo 'Mark as read' . '<i class="material-icons right">markunread</i>';
                        } else {
                            echo 'Read' . '<i class="material-icons right">check</i>';
                        }
                    ?>
                </a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<?php if($feedbacks == NULL): ?>
    <h4 class="center-align"
    style="margin: 80px 0">No feedback from users</h4>
<?php endif; ?>

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