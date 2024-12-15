<?php
// Get the product ID from the URL
$productId = $_GET['id'];

// Fetch product details
include('db.php');
$sql = "SELECT * FROM products WHERE id = $productId";
$result = $connection->query($sql);
$product = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tsavo - Product Details</title>
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

    <div class="product-details">
        <h1><?php echo htmlspecialchars($product['name']); ?></h1>
        <img src="uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-image">
        <p><?php echo htmlspecialchars($product['description']); ?></p>
        <p>Price: $<?php echo number_format($product['price'], 2); ?></p>
        <button>Add to Cart</button>
    </div>
</body>
</html>

<?php
// Close the database connection
$connection->close();
?>
