<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Sam's Café</title>
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
			<a href="index.php" class="active">Home</a>
			<a href="#about">About Us</a>
			<a href="#contact">Contact Us</a>
			<a href="menu.php">Menu</a>
			<a href="orderHistory.php">Order History</a>
		</nav>
	</header>

	<main>
		<section class="content-section" id="welcome">
			<h2>Welcome to Our Café</h2>
			<div class="welcome-gallery">
				<img src="images/Coffee-and-Pastries.jpg" alt="A cup of coffee and assorted pastries">
				<img src="images/Cake-Vitrine.jpg" alt="A display case with various cakes">
				<img src="images/Cookies.jpg" alt="A collection of freshly baked cookies">
				<img src="images/Cup-of-Hot-Chocolate.jpg" alt="A warm cup of hot chocolate">
				<img src="images/Strawberry-Tarts.jpg" alt="Fresh strawberry tarts">
				<img src="images/Strawberry-Blueberry-Tarts.jpg" alt="Tarts with strawberries and blueberries">
			</div>
			<p class="welcome-text">
				Our café offers an assortment of delicious and delectable pastries and coffees that will put a smile on your face. From cookies to croissants, tarts and cakes, each treat is especially prepared to excite your tastebuds and brighten your day!
			</p>
		</section>

		<section class="content-section" id="about">
			<h2>About Us</h2>
			<div class="about-us-content">
				<img src="images/SamKuoShop.jpg" alt="A picture of Sam Kuo's shop">
				<p>
					Sam has been adding sweetness to their customers' lives since 2025. Sam's recipes have been passed down from his mother and use simple and fresh ingredients to produce delightful flavors. He will personally greet you with a welcoming smile when you visit!
				</p>
			</div>
		</section>

		<section class="content-section" id="contact">
			<h2>Contact Us</h2>
			<div class="contact-info">
				<img src="images/Coffee-Shop.jpg" height="auto" width="150" alt="The exterior of the coffee shop" style="border-radius: 8px; margin-bottom: 1rem;">
				<p>
					321 Any Street<br>
					Any Town, New Zealand<br><br>
					Tel: +64-21-027-933-55
				</p>
				<h3>Hours</h3>
				<p>
					Weekdays: 6:00am - 6:00pm<br>
					Saturday: 7:00am - 7:00pm<br>
					Closed on Sundays
				</p>
			</div>
		</section>
	</main>

	<footer class="site-footer">
		<p>&copy; 2025, Sam Kuo, Inc. All rights reserved.</p>
	</footer>

</body>
</html>
