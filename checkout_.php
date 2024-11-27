<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://www.paypal.com/sdk/js?client-id=Aa4mmJEFZs7fq20i1o2OKmGTNGZIYUMDVUy-cwjNtHzsCqacqoOUsBN3jT2cdm0dIoj1QKPEL1ufvE74&currency=USD"></script>
    <!--<script src="https://sandbox.paypal.com/sdk/js?client-id=AXUJPlFDYKUgda8epgQAKYRHD0UT4EqLl0zXQidVEugPHlYdfVM7Da4jW7xefX-OH-irw5ulCp2fLlBT&currency=USD"></script> -->
</head>
<body>
    <div id="paypal-button-container"></div>
    <script>
        paypal.Buttons({
            style: {
                layout: 'vertical',
                color:  'blue',
                shape:  'pill',
                label:  'pay'
            },
            createOrder:function(data,actions){
                return actions.order.create({
                    purchase_units:[{
                        amount:{
                            value:222
                        }
                    }]
                });
            },
            onApprove:function(data, actions){
                actions.order.capture().then(function(detalles){
                    window.location.href="completado.html"
                });
            },
            onCancel:function(data){
                alert("Pago cancelado");
                console.log(data);
            }
        }).render('#paypal-button-container');
    </script>
</body>
</html>