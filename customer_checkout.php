<!-- checkout.php -->
<?php
$pricePerPizza = 10; // Example price

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $quantity = (int) $_POST['quantity'];
    $total = $quantity * $pricePerPizza;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
</head>
<body>
    <h1>Checkout Summary</h1>
    <p>Quantity: <?php echo $quantity; ?></p>
    <p>Price per pizza: $<?php echo $pricePerPizza; ?></p>
    <p><strong>Total: $<?php echo $total; ?></strong></p>
</body>
</html>
