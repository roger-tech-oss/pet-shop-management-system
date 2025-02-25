<?php
require_once('../config.php');

if(!isset($_SESSION['login_id'])){
    redirect('index.php');   
}

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $order = $conn->query("SELECT o.id as order_id, concat(c.firstname,' ',c.lastname) as client_name, o.date_created, o.status FROM `orders` o join clients c on c.id = o.client_id where o.id = $id ");
    foreach($order->fetch_assoc() as $k => $v){
        $$k = $v;
    }
}

if(isset($_GET['status'])){
    $status = $_GET['status'];
    $conn->query("UPDATE `orders` set `status` = $status where `id` = $order_id ");
    redirect('partner/view_order.php?id=' . $order_id);
}

$all_status = [
    0 => 'Pending',
    1 => 'Packed',
    2 => 'Out for Delivery',
    3 => 'Delivered',
    4 => 'Cancelled'
];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Order</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }
        .order-container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333;
        }
        .order-details {
            margin-top: 20px;
        }
        .order-details p {
            font-size: 16px;
            margin: 10px 0;
        }
        .back-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        .back-button:hover {
            background-color: #45a049;
        }
        .secondary-button {
            display: inline-block;
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            border: none;
            font-size: 14px;
            cursor: pointer;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .secondary-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="order-container">
    <h2>Order Details</h2>
    <div class="order-details">
        <p><strong>Order ID:</strong> <?php echo $order_id ?></p></p>
        <p><strong>Customer Name:</strong><?php echo $client_name ?> </p>
        <p><strong>Date Created:</strong> <?php echo $date_created ?> </p>
        <p><strong>Status:</strong> <?php echo $all_status[$status] ?> </p>
        
    </div>
    <a href="dashboard.php" class="back-button">Back to Orders</a>
    <a href="view_order.php?<?php echo "id=" . $order_id ."&&status=3"?>" class="secondary-button">Mark as delivered</a>
</div>

</body>
</html>
