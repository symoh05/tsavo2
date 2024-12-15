<?php
// Get the category from the URL
$category = $_GET['category'];

// Fetch products based on category
include('db.php');
$sql = "SELECT * FROM products WHERE category = '$category'";
$result = $connection->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tsavo - <?php echo ucfirst($category); ?> Products</title>
    <link rel="stylesheet" href="style.css">
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
            </ul>
        </nav>
    </header>

    <h1><?php echo ucfirst($category); ?> Products</h1>
    <div class="product-container">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $imagePath = 'uploads/' . htmlspecialchars($row['image']);
                echo '<div class="product">';
                echo '<a href="product.php?id=' . $row['id'] . '"><img src="' . $imagePath . '" alt="' . htmlspecialchars($row['name']) . '" class="product-image"></a>';
                echo '<h3>' . htmlspecialchars($row['name']) . '</h3>';
                echo '<p>' . htmlspecialchars($row['description']) . '</p>';
                $priceKsh = number_format($row['price'] * 150, 2);
                echo '<p>Price: $' . number_format($row['price'], 2) . ' / Ksh ' . $priceKsh . '</p>';
                echo '</div>';
            }
        } else {
            echo '<p>No products in this category.</p>';
        }
        ?>
    </div>
</body>
</html>

<?php
// Close the database connection
$connection->close();
?>
