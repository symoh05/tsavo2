<?php
// Include the database connection
include('db.php');

// Query to fetch all products from the database
$sql = "SELECT * FROM products";
$result = $connection->query($sql);  // Execute the query
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tsavo - Clothing, Shoes, Watches and More</title>
    <link rel="stylesheet" href="style.css">  <!-- Link to your CSS file -->
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="categories.php">Categories</a></li>
                <li><a href="cart.php">Cart</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="search.php">Search</a></li>
                <li><a href="login.php">Admin Dashboard</a></li>
            </ul>
        </nav>
    </header>

    <h1>Welcome to Tsavo</h1>
    <h2>Your one-stop shop for Clothing, Shoes, Watches, and More!</h2>

    <!-- Categories Section -->
    <div class="categories">
        <a href="category.php?category=menwear">Men's Wear</a>
        <a href="category.php?category=womenwear">Women's Wear</a>
        <a href="category.php?category=shoes">Shoes</a>
        <a href="category.php?category=watches">Watches</a>
        <a href="category.php?category=accessories">Accessories</a>
    </div>

    <!-- Product Section -->
    <div class="product-container">
        <?php
        // Check if there are any products in the database
        if ($result->num_rows > 0) {
            // Loop through each product and display it
            while ($row = $result->fetch_assoc()) {
                echo '<div class="product">';
                
                // Handle image path dynamically and safely
                $imagePath = 'uploads/' . htmlspecialchars($row['image']);
                
                // Display the product image (image filename stored in DB)
                echo '<a href="product.php?id=' . $row['id'] . '"><img src="' . $imagePath . '" alt="' . htmlspecialchars($row['name']) . '" class="product-image"></a>';
                
                // Display product name and description
                echo '<h3>' . htmlspecialchars($row['name']) . '</h3>';
                echo '<p>' . htmlspecialchars($row['description']) . '</p>';
                
                // Display available sizes and colors
                echo '<p><strong>Available Sizes:</strong> ' . htmlspecialchars($row['sizes']) . '</p>';
                echo '<p><strong>Available Colors:</strong> ' . htmlspecialchars($row['colors']) . '</p>';
                
                // Display price in USD and KSH
                $priceKsh = number_format($row['price_ksh'], 2);  // Use price_ksh directly from the database
                echo '<p><strong>Price:</strong> $' . number_format($row['price_usd'], 2) . ' / Ksh ' . $priceKsh . '</p>';
                
                // Display available units
                echo '<p><strong>Units Available:</strong> ' . htmlspecialchars($row['available_units']) . '</p>';
                
                // Add to Cart Button
                echo '<form method="POST" action="cart.php?action=add&id=' . $row['id'] . '">
                        <button type="submit" class="add-to-cart">Add to Cart</button>
                    </form>';
                
                echo '</div>';
            }
        } else {
            // Message when there are no products
            echo '<p>No products available.</p>';
        }
        ?>
    </div>

</body>
</html>

<?php
// Close the database connection
$connection->close();
?>
