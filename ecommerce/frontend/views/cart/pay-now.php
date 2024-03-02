<?php
       
        /** @var  \common\models\Orders $order;*/

       
       
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$orderAddress=$order->orderAddress;

?>
<script 

src="https://www.paypal.com/sdk/js?client-id=AWqEbtaA8p6cxuPN5w3vmg_GK0Nk2Ox6efPUTSACMSb6Q5OKQJ9iuek1T-LtPJny0O_8bMsoMwv0MBep">
</script>
<h3> Order <?php echo $order->firstname?> Sammsry</h3>
<div class="row ">


    <div class="col">
        <table class="table">
        <h5>Acount information</h5>
           <tr>
             <th>FirstName</th>
             <td><?php echo $order->firstname?></td>

           </tr>
           <tr>
             <th>Lastname</th>
             <td><?php echo $order->lastname?></td>

           </tr>
           <tr>
             <th>Email</th>
             <td><?php echo $order->email?></td>

           </tr>



        
            
        </table>
        <table class="table">
            <h5>Adressess information</h5>

            <tr>
             <th>Address</th>
             <td><?php echo $orderAddress->address?></td>

           </tr>
           <tr>
             <th>City</th>
             <td><?php echo $orderAddress->city?></td>

           </tr>
           <tr>
             <th>State</th>
             <td><?php echo $orderAddress->state?></td>

           </tr>
            <tr>
             <th>Country</th>
             <td><?php echo $orderAddress->country?></td>

           </tr>
           <tr>
             <th>Zipcode</th>
             <td><?php echo $orderAddress->zipcode?></td>

           </tr>
           
            
        </table>


    </div>
    <div class="col pr-3 pl-3">
        <table class="table table-sm">
        <h5>Prodects</h5>

            <thead>
                <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Quantity</th>
                <th>Price</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($order->orderItems as $item):?>
               
               <tr>
               <td>
                
                <img src="<?php echo $item->protectBy->getImageUrl()?>"
            style="width:50px"></td>
               <td><?php echo $item->prodect_name?></td>
               <td><?php echo $item->quantity?></td>
               <td><?php echo \yii::$app->formatter->asCurrency($item->quantity * $item->unit_price)?></td>
 
               </tr>
             <?php endforeach;?>
                
            </tbody>

           

        </table>
        <tr>
        <table class="table-horizontal">
            <dt>Total Items</dt>
            <dd><?php echo $order->getItemsQuantity()?></dd>
            <dt>Total Price</dt>
            <dd><?php echo \yii::$app->formatter->asCurrency($order->total_price) ?></dd>
        </table>
             <div id="paypal-button-container"></div>

    </div>
    
</div>


<script>
  paypal.Buttons({
    createOrder: function (data, actions) {
      // This function sets up the details of the transaction, including the amount and line item details.
      return actions.order.create({
        purchase_units: [{
          amount: {
            value: <?php echo $order->total_price ?>
          }
        }]
      });
    },
    onApprove: function (data, actions) {
      console.log(data, actions);
      // This function captures the funds from the transaction.
      return actions.order.capture().then(function (details) {
        console.log(details);
        const $form = $('#checkout-form');
        const formData = $form.serializeArray();
        formData.push({
          name: 'transactionId',
          value: details.id
        });
        formData.push({
          name: 'orderId',
          value: data.orderID
        });
        formData.push({
          name: 'status',
          value: details.status
        });
        $.ajax({
          method: 'post',
          url: '<?php echo \yii\helpers\Url::to(['/cart/submit-paypal','orderId'=>$order->id])?>',
          data: formData,
          success: function (res) {
            // This function shows a transaction success message to your buyer.
            alert("Thanks for your business");
            window.location.href = '';
          }
        })
      });
    }
  }).render('#paypal-button-container');
  // This function displays Smart Payment Buttons on your web page.
</script>

