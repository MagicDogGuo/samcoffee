<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - Sam's Café</title>
    <link rel="stylesheet" href="css/modern.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Edu+AU+VIC+WA+NT+Pre:wght@700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
</head>

<body>

    <?php
        include ('getAppParameters.php');
        // The serverInfo.php is likely for debugging on the server, can be left as is.
		include('serverInfo.php');
    ?>

    <header class="main-header">
        <div class="logo">Sam's Café</div>
        <nav class="main-nav">
            <a href="index.php">Home</a>
            <a href="menu.php">Menu</a>
            <a href="orderHistory.php">Order History</a>
        </nav>
    </header>

    <main>
        <section class="content-section" id="order-confirmation">
            <?php
            // Create a connection to the database.
            $conn = new mysqli($db_url, $db_user, $db_password, $db_name);

            // Check the connection.
            if ($conn->connect_error) {
                die("<p style='text-align:center; color: red;'>Connection failed: " . $conn->connect_error . "</p>");
            }

            // Get order information from submitted form.
            $productIds = isset($_POST["productId"]) ? $_POST["productId"] : [];
            $productNames = isset($_POST["productName"]) ? $_POST["productName"] : [];
            $prices = isset($_POST["price"]) ? $_POST["price"] : [];
            $quantities = isset($_POST["quantity"]) ? $_POST["quantity"] : [];

            // Calculate order item amounts and total order amount.
            $amounts = [];
            $totalAmount = 0.00;
            $hasItems = false;

            for ($i = 0; $i < count($quantities); $i++) {
                $itemAmount = (float)$prices[$i] * (int)$quantities[$i];
                $amounts[$i] = $itemAmount;
                $totalAmount += $itemAmount;
                if ((int)$quantities[$i] > 0) {
                    $hasItems = true;
                }
            }

            if (!$hasItems) {
                echo "<div class='order-confirmation-box'><h2>Oops!</h2><p>It seems you haven't selected any items. Please go back to the menu to place an order.</p></div>";
            } else {
                // Insert ORDER row.
                date_default_timezone_set($timeZone);
                $currentTimeStamp = date('Y-m-d H:i:s');

                $stmt = $conn->prepare("INSERT INTO `order` (order_date_time, amount) VALUES (?, ?)");
                $stmt->bind_param("sd", $currentTimeStamp, $totalAmount);

                if ($stmt->execute()) {
                    $orderNumber = $conn->insert_id;
                    $stmt->close();

                    // Insert ORDER_ITEM rows.
                    $itemNo = 1;
                    $insertItemSql = "INSERT INTO order_item (order_number, order_item_number, product_id, quantity, amount) VALUES (?, ?, ?, ?, ?)";
                    $stmt = $conn->prepare($insertItemSql);

                    for ($i = 0; $i < count($quantities); $i++) {
                        if ((int)$quantities[$i] > 0) {
                            $stmt->bind_param("iiiid", $orderNumber, $itemNo, $productIds[$i], $quantities[$i], $amounts[$i]);
                            if (!$stmt->execute()) {
                                die ("Error processing item: " . $stmt->error);
                            }
                            $itemNo++;
                        }
                    }
                    $stmt->close();

                    // Display confirmation message and order details
                    echo "<div class='order-confirmation-box'>";
                    echo "<h2>Thank you for your order!</h2>";
                    echo "<p>It will be available for pickup within 15 minutes. Your order number and details are shown below.</p>";
                    echo "</div>";

                    echo '<div class="order-block">';
                    echo '  <div class="order-header">';
                    echo '      <span><strong>Order:</strong> #' . htmlspecialchars($orderNumber) . '</span>';
                    echo '      <span><strong>Date:</strong> ' . htmlspecialchars(substr($currentTimeStamp, 0, 10)) . '</span>';
                    echo '      <span><strong>Time:</strong> ' . htmlspecialchars(substr($currentTimeStamp, 11, 8)) . '</span>';
                    echo '      <span><strong>Total:</strong> ' . htmlspecialchars($currency) . number_format($totalAmount, 2) . '</span>';
                    echo '  </div>';
                    echo '  <table class="order-items-table">';
                    echo '      <thead><tr><th>Item</th><th class="item-price">Price</th><th class="item-quantity">Quantity</th><th class="item-total">Amount</th></tr></thead>';
                    echo '      <tbody>';

                    for ($i = 0; $i < count($quantities); $i++) {
                        if ((int)$quantities[$i] > 0) {
                            echo '<tr>';
                            echo '    <td class="item-name">' . htmlspecialchars($productNames[$i]) . '</td>';
                            echo '    <td class="item-price">' . htmlspecialchars($currency) . number_format($prices[$i], 2) . '</td>';
                            echo '    <td class="item-quantity">' . htmlspecialchars($quantities[$i]) . '</td>';
                            echo '    <td class="item-total">' . htmlspecialchars($currency) . number_format($amounts[$i], 2) . '</td>';
                            echo '</tr>';
                        }
                    }

                    echo '      </tbody></table>';
                    echo '</div>';

                } else {
                    die ("Error placing order: " . $stmt->error);
                }
            }
            // Close the connection.
            $conn->close();
            ?>
        </section>
    </main>

    <footer class="site-footer">
        <p>&copy; 2025, Sam Kuo, Inc. All rights reserved.</p>
    </footer>

</body>
</html>
