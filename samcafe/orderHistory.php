<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History - Sam's Café</title>
    <link rel="stylesheet" href="css/modern.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Edu+AU+VIC+WA+NT+Pre:wght@700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
</head>

<body>

    <?php
        include ('getAppParameters.php');
    ?>

    <header class="main-header">
        <div class="logo">Sam's Café</div>
        <nav class="main-nav">
            <a href="index.php">Home</a>
            <a href="index.php#about">About Us</a>
            <a href="index.php#contact">Contact Us</a>
            <a href="menu.php">Menu</a>
            <a href="orderHistory.php" class="active">Order History</a>
        </nav>
    </header>

    <main>
        <section class="content-section" id="order-history">
            <h2>Your Order History</h2>
            <div class="order-history-container">
            <?php

            // Create a connection to the database.
            $conn = new mysqli($db_url, $db_user, $db_password, $db_name);

            // Check the connection.
            if ($conn->connect_error) {
                die("<p style='text-align:center; color: red;'>Connection failed: " . $conn->connect_error . "</p>");
            }

            // Retrieve all orders in the database.
            $sql = "SELECT a.order_number, a.order_date_time, a.amount as order_total,
                           b.order_item_number, b.product_id, b.quantity, b.amount as item_amount,
                           c.product_name, c.price
                    FROM `order` a, order_item b, product c
                    WHERE a.order_number = b.order_number
                      AND c.id = b.product_id
                    ORDER BY a.order_number DESC, b.order_item_number ASC";

            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                $previousOrderNumber = 0;
                $firstTime = true;

                while($row = $result->fetch_assoc()) {
                    if ($row["order_number"] != $previousOrderNumber) {
                        if (!$firstTime) {
                            echo '</table></div>'; // Close previous table and block
                        }
                        echo '<div class="order-block">';
                        echo '  <div class="order-header">';
                        echo '      <span><strong>Order:</strong> #' . htmlspecialchars($row["order_number"]) . '</span>';
                        echo '      <span><strong>Date:</strong> ' . htmlspecialchars(substr($row["order_date_time"], 0, 10)) . '</span>';
                        echo '      <span><strong>Time:</strong> ' . htmlspecialchars(substr($row["order_date_time"], 11, 8)) . '</span>';
                        echo '      <span><strong>Total:</strong> ' . htmlspecialchars($currency) . number_format($row["order_total"], 2) . '</span>';
                        echo '  </div>';
                        echo '  <table class="order-items-table">';
                        echo '      <thead>';
                        echo '          <tr>';
                        echo '              <th class="item-name">Item</th>';
                        echo '              <th class="item-price">Price</th>';
                        echo '              <th class="item-quantity">Quantity</th>';
                        echo '              <th class="item-total">Amount</th>';
                        echo '          </tr>';
                        echo '      </thead>';
                        echo '      <tbody>';

                        $previousOrderNumber = $row["order_number"];
                        $firstTime = false;
                    }
                    echo '<tr>';
                    echo '    <td class="item-name">' . htmlspecialchars($row["product_name"]) . '</td>';
                    echo '    <td class="item-price">' . htmlspecialchars($currency) . number_format($row["price"], 2) . '</td>';
                    echo '    <td class="item-quantity">' . htmlspecialchars($row["quantity"]) . '</td>';
                    echo '    <td class="item-total">' . htmlspecialchars($currency) . number_format($row["item_amount"], 2) . '</td>';
                    echo '</tr>';
                }
                echo '      </tbody>';
                echo '  </table>';
                echo '</div>'; // Close the last order block

            } else {
                echo '<p style="text-align:center;">You have no orders at this time.</p>';
            }

            // Close the connection.
            $conn->close();
            ?>
            </div>
        </section>
    </main>

    <footer class="site-footer">
        <p>&copy; 2025, Sam Kuo, Inc. All rights reserved.</p>
    </footer>

</body>
</html>
