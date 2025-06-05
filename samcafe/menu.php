<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - Sam's Café</title>
    <link rel="stylesheet" href="css/modern.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Edu+AU+VIC+WA+NT+Pre:wght@700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
</head>

<body>

    <?php
        // Get the application environment parameters
        include ('getAppParameters.php');
    ?>

    <header class="main-header">
        <div class="logo">Sam's Café</div>
        <nav class="main-nav">
            <a href="index.php">Home</a>
            <a href="index.php#about">About Us</a>
            <a href="index.php#contact">Contact Us</a>
            <a href="menu.php" class="active">Menu</a>
            <a href="orderHistory.php">Order History</a>
        </nav>
    </header>

    <main>
        <section class="content-section" id="menu">
            <h2>Our Menu</h2>
            <?php
            // Create a connection to the database.
            $conn = new mysqli($db_url, $db_user, $db_password, $db_name);

            // Check the connection.
            if ($conn->connect_error) {
                die("<p style='text-align:center; color: red;'>Connection failed: " . $conn->connect_error . "</p>");
            }

            // Get all rows from the product table.
            $sql = "SELECT a.id, a.product_name, a.description, a.price, b.product_group_number, b.product_group_name, a.image_url
                    FROM product a, product_group b
                    WHERE b.product_group_number = a.product_group
                    ORDER BY b.product_group_number, a.id";

            $result = $conn->query($sql);
            $numOfItems = $result ? $result->num_rows : 0;

            if ($numOfItems > 0) {
                echo '<form id="orderForm" action="processOrder.php" method="post" onsubmit="return validateOrder()">';
                echo '<div class="menu-grid">';

                $previousProductGroupNumber = 0;

                while($row = $result->fetch_assoc()) {
                    if ($row["product_group_number"] != $previousProductGroupNumber) {
                        echo '<h3 class="menu-group-header">' . $row["product_group_name"] . '</h3>';
                        $previousProductGroupNumber = $row["product_group_number"];
                    }

                    $price = number_format($row["price"], 2);

                    echo '<div class="product-card">';
                    echo '    <img src="' . htmlspecialchars($row["image_url"]) . '" alt="' . htmlspecialchars($row["product_name"]) . '">';
                    echo '    <div class="container">';
                    echo '        <h2>' . htmlspecialchars($row["product_name"]) . '</h2>';
                    echo '        <p class="price">' . htmlspecialchars($currency) . $price . '</p>';
                    echo '        <p class="description">' . htmlspecialchars($row["description"]) . '</p>';
                    echo '        <input type="hidden" name="productId[]" value="' . htmlspecialchars($row["id"]) . '">';
                    echo '        <input type="hidden" name="productName[]" value="' . htmlspecialchars($row["product_name"]) . '">';
                    echo '        <input type="hidden" name="price[]" value=' . $price . '>';
                    echo '        <label>Quantity: <input name="quantity[]" type="number" class="quantity-input" min="0" max="15" value="0" maxlength="2" onchange="updateTotal(' . (int)$row["id"] . ', this.value, ' . $price . ')"></label>';
                    echo '    </div>';
                    echo '</div>';
                }

                echo '</div>'; // end .menu-grid

                echo '<div class="order-summary">';
                echo '    <p>Order Total: ' . htmlspecialchars($currency) . '<span id="orderTotal">0.00</span></p>';
                echo '    <input type="Submit" value="Submit Order" class="button">';
                echo '    <input type="Reset" value="Reset Order" class="button" onclick="resetForm()">';
                echo '</div>';
                echo '</form>';

            } else {
                echo '<p style="text-align:center;">There are no items on the menu.</p>';
            }

            // Close the connection.
            $conn->close();
            ?>
        </section>
    </main>

    <footer class="site-footer">
        <p>&copy; 2025, Sam Kuo, Inc. All rights reserved.</p>
    </footer>

    <script>
        // Ensure the script doesn't run into errors if there are no items
        const numOfItems = <?php echo $numOfItems; ?>;
        let itemTotals = numOfItems > 0 ? new Array(numOfItems).fill(0.00) : [];

        function calculateOrderTotal() {
            return itemTotals.reduce((total, current) => total + current, 0);
        }

        function resetForm() {
            if (document.getElementById("orderForm")) {
                document.getElementById("orderForm").reset();
            }
            if (document.getElementById("orderTotal")) {
                document.getElementById("orderTotal").innerHTML = "0.00";
            }
            itemTotals.fill(0.00);
        }

        function updateTotal(itemIndex, quantity, price) {
            // Find the correct index in the array based on product ID if needed,
            // but for now we assume the loop index matches if generated in order.
            // A more robust way would be to map product IDs to array indices.
            // For this implementation, we'll assume itemIndex is the correct one.
            const realIndex = itemIndex - 1; // Assuming product IDs start from 1
            if (realIndex >= 0 && realIndex < itemTotals.length) {
                const amount = Number(quantity) * Number(price);
                itemTotals[realIndex] = amount;
            }
            
            const totalAmount = calculateOrderTotal().toFixed(2);
            if (document.getElementById("orderTotal")) {
                document.getElementById("orderTotal").innerHTML = totalAmount;
            }
        }

        function validateOrder() {
            if (calculateOrderTotal() <= 0.0) {
                alert('Please select at least one item to buy.');
                return false;
            }
            return true;
        }

        // Initialize total on page load
        if (document.getElementById("orderTotal")) {
             document.getElementById("orderTotal").innerHTML = "0.00";
        }
    </script>

</body>
</html>
