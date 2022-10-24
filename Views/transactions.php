<?php
    $title = "Transactions";
    require_once "../Controllers/connection.php";
    
    function get_content() {
        if(!isset($_SESSION['user_data'])) {
            header('Location: /');
        }
        
        $query = "SELECT * FROM transactions
        WHERE is_deleted = 0
        AND user_id = {$_SESSION['user_data']['id']}";
        $result = mysqli_query($GLOBALS['cn'], $query);
        $transactions = mysqli_fetch_all($result, MYSQLI_ASSOC);

        // var_dump($transactions);
        // die();

        if(isset($_SESSION['user_data'])) {
            $query3 = "SELECT * FROM openclose";
            $result3 = mysqli_query($GLOBALS['cn'], $query3);
            $shop = mysqli_fetch_assoc($result3);  
            
            // var_dump($shop);
            // die();
        }
?>

<div class="container">
    <!-- SHOW ERROR MESSAGE -->
    <?php if(isset($_SESSION['message'])): ?>
        <div class="card-panel pulse <?php echo $_SESSION['class'] ?>"id="card-panel">
            <?php echo $_SESSION['message']; ?>
        </div>
    <?php endif; ?>
    
    <div class="row">
        <?php foreach($transactions as $i => $transaction): ?>
            <?php if($transaction['is_paid'] == 0): ?>
            <div class="card-panel"
            style="background-color: rgba(252, 212, 137, 0.582)">
                <h5><u>Waiting for payment</u></h5>
                <a href="#modalDel" class="modal-trigger"><i class="material-icons right">delete</i></a>

                <div id="modalDel" class="modal">
                    <div class="modal-content">
                        <h4>Delete item</h4>
                        <p>Are you sure you want to delete this transaction?</p>
                    </div>
                    <div class="modal-footer">
                        <a href="../web.php?id=<?php echo $transaction['id']?>&action=delete_transaction" class="btn">Delete</a>
                        <a href="" class="modal-close btn-flat grey lighten-2">Close</a>
                    </div>
                </div>

                <table class="highlight">
                    <thead>
                        <tr>
                            <th>Food_ordered</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        <tr>
                            <td><?php echo $transaction['item'];?></td>
                            <td>RM <?php echo $transaction['payment']?></td>
                        </tr>
                    </tbody>
                </table>

                <?php if($shop['shop_status'] == 1): ?>
                    <div id="paypal-button-container" class="center-align" style="margin-top: 20px">

                    </div>
                <?php endif; ?>

            </div>
        
        <?php else: ?>
            <div class="card-panel"
            style="background-color: rgba(253, 253, 190, 0.637)">
                <h3>All Payment Done</h3>
                <a href="/">Back to homepage</a>
            </div>
        <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <?php if($transactions == NULL): ?>
        <div class="center-align"
        style="margin: 80px">
            <h4>No transaction Pending</h4>
            <a href="/"> << Go Back to Homepage</a>
        </div>
    <?php endif;?>
</div>



<script src="https://www.paypal.com/sdk/js?client-id=AThmumG_BfTYFO2L1X-PkO-IzpGVcwzfmKjfCpTU4_vb0iSuNgJBgTM4Ds6lOluC4HYzjnC5_40BH48n"></script>


<script type="text/javascript">
    paypal.Buttons({
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: <?php echo number_format($transactions[$i]['payment'], 2); ?>
                    }
                }]
            })
        },
        onApprove: function(data, actions) {
			return actions.order.capture().then( function(details) {
				alert("Transaction completed by " + details.payer.name.given_name);
                
                // Creating a form using javascript
                let formData = new FormData();
                formData.append('id', <?php echo $transaction['id'] ?>);
                formData.append('action', 'transaction');
                
                fetch('../web.php', {
                    method: "POST",
                    body: formData
                }) 
                .then(res => res.text())
                .then(message => alert('Transaction Completed!'));
			})
		}
    }).render('#paypal-button-container');
</script>

<?php
    }
    require_once 'layout.php';
?>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        let elems = document.querySelectorAll('.modal');
        let instances = M.Modal.init(elems, {});

        let card = document.querySelector('#card-panel');
        setTimeout(() => {
            <?php unset($_SESSION['message']); ?>
            <?php unset($_SESSION['class']); ?>
            card.classList.toggle('hide');
        }, 2000)
    });
</script>