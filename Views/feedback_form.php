<?php
    $title = 'Give Feedback';

    function get_content() {
        if(!isset($_SESSION['user_data'])) {
            header('Location: /');
        }
?>

<div class="container">
    <!-- FEEDBACK FORM -->
    <div class="card" 
    style="margin: 50px 0 100px 0; padding: 30px">
    <h5 class="center-align">Feedback Form</h5>
    <p class="center-align">Hello there. Please feel free to provide feedback so that <br> we can make some improvement...  Your opinion is greatly valued.</p>
        <div class="col m6 offset-m3">
            <div class="card-content">
                <form method="POST"
                action="/web.php">
                    <input type="hidden"
                    name="action"
                    value="feedback">
    
                    <div class="input-field col s12">
                        <textarea id="textarea1" 
                        class="materialize-textarea"
                        name='feedback'
                        required></textarea>
                        <label for="textarea1">Textarea</label>
                    </div>
    
                    <button class="btn">
                        Submit
                        <i class="material-icons right">send</i>
                    </button>
                </form>
            </div>
        </div>
    </div>
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