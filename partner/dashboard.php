<?php require_once('../config.php'); ?>
<?php
  
    $orders = $conn->query("SELECT o.id, concat(c.firstname,' ',c.lastname) as client_name, o.date_created, o.status FROM `orders` o join clients c on c.id = o.client_id where o.delivery_partner_id = '{$_SESSION['login_id']}' ");
   
   $status = [
        0 => 'Pending',
        1 => 'Packed',
        2 => 'Out for Delivery',
        3 => 'Delivered',
        4 => 'Cancelled'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders Dashboard</title>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }
        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: relative;
        }
        h2 {
            margin-top: 0;
            text-align: center;
            color: #333;
        }
        .logout-button {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 10px 15px;
            background-color: #d9534f;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
        }
        .logout-button:hover {
            background-color: #c9302c;
        }
    </style>
</head>
<body>

<div class="dashboard-container">
    <a href="logout.php" class="logout-button">Logout</a> <!-- Logout button -->
    <h2>Orders Dashboard</h2>
    <table id="ordersTable" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Status</th>
                <th>Order Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
          <?php while($row = $orders->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['client_name'] ?></td>
                <td><?= $status[$row['status']] ?></td>
                <td><?= date("d-F-Y H:i",strtotime($row['date_created']))?></td> 
                <td><a href="view_order.php?id=<?= $row['id'] ?>" class="btn btn-primary">View</a></td>   
            </tr>
          <?php endwhile; ?>  
        </tbody>
    </table>
</div>

<!-- jQuery and DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#ordersTable').DataTable();
    });
</script>

</body>
</html>


