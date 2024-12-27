<?php

@include 'config.php';


if (isset($_POST['order_btn'])) {

    $name = $_POST['name'];
    $number = $_POST['number'];
    $email = $_POST['email'];
    $method = $_POST['method'];
    $flat = $_POST['flat'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $country = $_POST['country'];

    $cart_query = mysqli_query($conn, "SELECT * FROM `cart`");
    $price_total = 0;
    $product_name = []; // Initialize the array to store product details
    if (mysqli_num_rows($cart_query) > 0) {
        while ($product_item = mysqli_fetch_assoc($cart_query)) {
            $product_name[] = $product_item['name'] . ' (' . $product_item['quantity'] . ')';
            $product_price = $product_item['price'] * $product_item['quantity'];
            $price_total += $product_price;
        }
    }

    $total_product = implode(', ', $product_name);

    $detail_query = mysqli_query($conn, "INSERT INTO `order` (name, number, email, method, flat, street, city, country, total_products, total_price) VALUES ('$name','$number','$email','$method','$flat','$street','$city','$country','$total_product','$price_total')") or die('query failed');

    if ($cart_query && $detail_query) {
        echo "
        <div class='order-message-container'>
        <div class='message-container'>
           <h3>Thank you for shopping!</h3>
           <div class='order-detail'>
              <span>" . $total_product . "</span>
              <span class='total'> Total: $" . $price_total . "/- </span>
           </div>
           <div class='customer-details'>
              <p>Your name: <span>" . $name . "</span> </p>
              <p>Your number: <span>" . $number . "</span> </p>
              <p>Your email: <span>" . $email . "</span> </p>
              <p>Your address: <span>" . $flat . ", " . $street . ", " . $city . ", " . $country . "</span> </p>
              <p>Your payment mode: <span>" . $method . "</span> </p>
              <p>(*Pay when product arrives*)</p>
           </div>
           <center>
           <a href='print_slip.php' class='btn'>Print Slip</a>
           </center>
        </div>
        </div>
        ";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'header.php'; ?>

<div class="container">
    <section class="checkout-form">
        <h1 class="heading">Complete your order</h1>
        <form action="" method="post">
            <div class="display-order">
                <?php
                $select_cart = mysqli_query($conn, "SELECT * FROM `cart`");
                $total = 0;
                $grand_total = 0;
                if (mysqli_num_rows($select_cart) > 0) {
                    while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                        $total_price = $fetch_cart['price'] * $fetch_cart['quantity'];
                        $grand_total = $total += $total_price;
                ?>
                        <span><?= $fetch_cart['name']; ?> (<?= $fetch_cart['quantity']; ?>)</span>
                <?php
                    }
                } else {
                    echo "<div class='display-order'><span>Your cart is empty!</span></div>";
                }
                ?>
                <span class="grand-total">Grand total: $<?= $grand_total; ?>/-</span>
            </div>

            <div class="flex">
                <div class="inputBox">
                    <span>Your name</span>
                    <input type="text" placeholder="Enter your name" name="name" required>
                </div>
                <div class="inputBox">
                    <span>Your number</span>
                    <input type="number" placeholder="Enter your number" name="number" required>
                </div>
                <div class="inputBox">
                    <span>Your email</span>
                    <input type="email" placeholder="Enter your email" name="email" required>
                </div>
                <div class="inputBox">
                    <span>Payment method</span>
                    <select name="method">
                        <option value="cash on delivery" selected>Cash on delivery</option>
                        <option value="credit card">Credit card</option>
                        <option value="paypal">Paypal</option>
                    </select>
                </div>
                <div class="inputBox">
                    <span>Address line</span>
                    <input type="text" placeholder="E.g. flat no., street name" name="flat" required>
                </div>
                <div class="inputBox">
                    <span>City</span>
                    <input type="text" placeholder="E.g. Mumbai" name="city" required>
                </div>
                <div class="inputBox">
                    <span>Country</span>
                    <input type="text" placeholder="E.g. India" name="country" required>
                </div>
            </div>
            <center>
                <input type='submit' value='Order Now' name='order_btn' class='btn'>
            </center>
        </form>
    </section>
</div>

<script src="js/script.js"></script>
</body>
</html>