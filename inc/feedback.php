<?php

include('../config.php');

if (isset($_POST['feedback'])) {
    $feedback = $_POST['feedback'];
    $product_id = $_POST['product_id'];
    $user_id = $_POST['user_id'];
    $conn->query("INSERT INTO `feedback` (`feedback`, `product_id`, `client_id`) VALUES ('$feedback', '$product_id', '$user_id')");
}

//redirect to product view page
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    redirect("index.php?p=view_product&id=$id");
}