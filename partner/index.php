<?php
require_once('../config.php');

if(isset($_POST['partner_code'])){
    $partner_code = $_POST['partner_code'];
    $partner = $conn->query("SELECT * FROM `delivery_partners` where `partner_code` = '{$partner_code}' ");

    if($partner->num_rows > 0){
        foreach($partner->fetch_assoc() as $k => $v){
            $$k = $v;
        }
    } else{
        echo "<script>alert('Invalid Partner Code'); window.location.href = './';</script>";
    }

    if(isset($id)){
        $_SESSION['login_id'] = $id;
        $_SESSION['login_name'] = $first_name.' '.$last_name;
        $_SESSION['login_type'] = 1;
        $_SESSION['login_email'] = $email;
        $_SESSION['login_phone'] = $phone;
        $_SESSION['login_code'] = $partner_code;
        echo "<script>alert('Login Successfull'); window.location.href = './';</script>";
    }
}

if(isset($_SESSION['login_id'])){
    redirect('partner/dashboard.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Partner Login</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
        }
        .login-container {
            width: 100%;
            max-width: 320px;
            padding: 40px 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
        }
        .login-container h2 {
            margin: 0 0 20px;
            color: #333;
        }
        .login-container input[type="text"] {
            width: calc(100% - 20px);
            padding: 12px 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        .login-container button {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
        .login-container button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Delivery Partner Login</h2>
    <form action="#" method="post">
        <input type="text" name="partner_code" placeholder="Enter Partner Code" required>
        <button type="submit">Login</button>
    </form>
</div>

</body>
</html>
