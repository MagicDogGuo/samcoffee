<?php
// 預設訊息
$message = "";
$messageClass = "";

// 建立與資料庫的連線
$conn = new mysqli("ec2-54-67-98-168.us-west-1.compute.amazonaws.com", "admin", "Re:Start!9", "cafe_db");

// 檢查連線是否成功
if ($conn->connect_error) {
    $message = "Connection failed: " . htmlspecialchars($conn->connect_error);
    $messageClass = "error";
} else {
    $message = "Connection successful!";
    $messageClass = "success";
}

// 關閉連線
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MySQL Connection Test</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .success {
            color: green;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <h3>Testing MySQL Connection</h3>
    <p class="<?php echo $messageClass; ?>">
        <?php echo $message; ?>
    </p>
</body>
</html>
