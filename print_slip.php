<?php
@include 'config.php';

// Fetch all cart items and customer details for the latest order
$order_query = mysqli_query($conn, "SELECT * FROM `order` ORDER BY id DESC LIMIT 1");
if (!$order_query || mysqli_num_rows($order_query) == 0) {
    die('No orders found.');
}

$order = mysqli_fetch_assoc($order_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>.</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .slip { border: 1px solid #333; padding: 20px; max-width: 400px; margin: auto; }
        .slip h2 { text-align: center; margin-bottom: 20px; }
        .slip p { margin: 5px 0; }
        .slip .total { font-weight: bold; }
        .print-btn { margin-top: 20px; display: inline-block; padding: 10px 20px; background: #333; color: #fff; text-decoration: none; text-align: center; }
    </style>
</head>
<body>

<div class="slip">
    <h2>Order Slip</h2>
    <p><strong>Name:</strong> <?php echo $order['name']; ?></p>
    <p><strong>Number:</strong> <?php echo $order['number']; ?></p>
    <p><strong>Email:</strong> <?php echo $order['email']; ?></p>
    <p><strong>Address:</strong> <?php echo $order['flat'] . ', ' . $order['street'] . ', ' . $order['city'] . ', ' . $order['country']; ?></p>
    <p><strong>Payment Method:</strong> <?php echo $order['method']; ?></p>
    <p><strong>Products:</strong> <?php echo $order['total_products']; ?></p>
    <p class="total"><strong>Total Price:</strong> $<?php echo $order['total_price']; ?>/-</p>
</div>
<center>
<a href='Products.php?delete_all'
   onclick="window.print();" 
   class="print-btn">
   Print
</a>
</center>
</body>
</html>
