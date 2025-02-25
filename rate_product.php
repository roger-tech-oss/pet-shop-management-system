<?php
// rate_product.php

// Connect to the database (adjust your credentials as needed)
$mysqli = new mysqli("localhost", "root", "", "pet_shop_db");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Get rating and products_id from POST request
$products_id = (int) $_POST['product_id'];
$rating = (int) $_POST['rating'];

// Validate input
if ($rating < 1 || $rating > 5) {
    die("Invalid rating. Please provide a rating between 1 and 5.");
}

// Insert rating into database
$stmt = $mysqli->prepare("INSERT INTO ratings (products_id, rating) VALUES (?, ?)");
$stmt->bind_param("ii", $products_id, $rating);

if ($stmt->execute()) {
    echo "Thank you for rating!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$mysqli->close();
?>
