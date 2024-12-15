<?php
session_start();

// Initialize the cart if not already done
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add item to the cart
if (isset($_GET['action']) && $_GET['action'] == 'add') {
    $productId = $_GET['id'];
    // Check if the product already exists in the cart
    if (!isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] = 1;
    } else {
        $_SESSION['cart'][$productId]++;
    }
}

// Remove item from cart
if (isset($_GET['action']) && $_GET['action'] == 'remove') {
    $productId = $_GET['id'];
    unset($_SESSION['cart'][$productId]);
}

// Get product details for display
include('db.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tsavo - Cart</title>
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

    <h1>Your Shopping Cart</h1>
    <div class="cart-items">
        <?php
        $totalPrice = 0;
        if (!empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $productId => $quantity) {
                $sql = "SELECT * FROM products WHERE id = $productId";
                $result = $connection->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $totalPrice += $row['price'] * $quantity;
                    echo '<div class="cart-item">';
                    echo '<img src="uploads/' . htmlspecialchars($row['image']) . '" class="cart-item-image">';
                    echo '<p>' . htmlspecialchars($row['name']) . '</p>';
                    echo '<p>Quantity: ' . $quantity . '</p>';
                    echo '<p>Price: $' . number_format($row['price'], 2) . '</p>';
                    echo '<a href="cart.php?action=remove&id=' . $productId . '">Remove</a>';
                    echo '</div>';
                }
            }
            echo '<h3>Total Price: $' . number_format($totalPrice, 2) . '</h3>';
        } else {
            echo '<p>Your cart is empty.</p>';
        }
        ?>
    </div>

    <button>Proceed to Checkout</button>
</body>
</html>

<?php
// Close the database connection
$connection->close();
?>
