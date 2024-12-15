<?php
include('db.php');
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header('Location: admin.php');
    exit();
}

// Handle form submission and file upload
if (isset($_POST['submit'])) {
    $target_dir = "uploads/";  // Directory for storing uploaded images
    $image_name = basename($_FILES["image"]["name"]);
    $image_extension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

    // Generate a unique filename to avoid conflicts
    $unique_image_name = uniqid() . "." . $image_extension;
    $target_file = $target_dir . $unique_image_name;

    // Check if the file is an image
    $image_check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($image_check !== false) {
        $upload_ok = 1;
    } else {
        echo "File is not an image.<br>";
        $upload_ok = 0;
    }

    // Check if file size is less than 5MB
    if ($_FILES["image"]["size"] > 5000000) {
        echo "Sorry, your file is too large.<br>";
        $upload_ok = 0;
    }

    // Check file extension (allow only certain types)
    if (!in_array($image_extension, ["jpg", "jpeg", "png", "gif"])) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
        $upload_ok = 0;
    }

    // If everything is ok, try to upload the file
    if ($upload_ok == 1) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Successfully uploaded image

            // Get form data
            $product_name = mysqli_real_escape_string($connection, $_POST['product_name']);
            $product_description = mysqli_real_escape_string($connection, $_POST['description']);
            $price_usd = mysqli_real_escape_string($connection, $_POST['price_usd']);
            $price_ksh = mysqli_real_escape_string($connection, $_POST['price_ksh']);
            $sizes = mysqli_real_escape_string($connection, $_POST['sizes']);
            $colors = mysqli_real_escape_string($connection, $_POST['colors']);
            $available_units = mysqli_real_escape_string($connection, $_POST['available_units']);

            // Insert product data into the database
            $sql = "INSERT INTO products (name, description, image, price_usd, price_ksh, sizes, colors, available_units) 
                    VALUES ('$product_name', '$product_description', '$unique_image_name', '$price_usd', '$price_ksh', '$sizes', '$colors', '$available_units')";
            if ($connection->query($sql) === TRUE) {
                echo "New product added successfully!<br>";
            } else {
                echo "Error: " . $sql . "<br>" . $connection->error . "<br>";
            }
        } else {
            echo "Sorry, there was an error uploading your file.<br>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - Tsavo</title>
    <link rel="stylesheet" href="product.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="categories.php">Categories</a></li>
                <li><a href="cart.php">Cart</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
    </header>

    <div class="form-container">
        <h1>Add New Product</h1>
        <form action="add_product.php" method="POST" enctype="multipart/form-data">
            <label for="product_name">Product Name:</label>
            <input type="text" name="product_name" id="product_name" required><br><br>

            <label for="description">Description:</label>
            <textarea name="description" id="description" required></textarea><br><br>

            <label for="price_usd">Price (USD):</label>
            <input type="number" name="price_usd" id="price_usd" required step="0.01"><br><br>

            <label for="price_ksh">Price (KSH):</label>
            <input type="number" name="price_ksh" id="price_ksh" required step="0.01"><br><br>

            <label for="sizes">Available Sizes (Comma separated):</label>
            <input type="text" name="sizes" id="sizes" required><br><br>

            <label for="colors">Available Colors (Comma separated):</label>
            <input type="text" name="colors" id="colors" required><br><br>

            <label for="available_units">Available Units:</label>
            <input type="number" name="available_units" id="available_units" required><br><br>

            <label for="image">Select image to upload:</label>
            <input type="file" name="image" id="image" required><br><br>

            <input type="submit" value="Upload Product" name="submit">
        </form>
    </div>

</body>
</html>

<?php
// Close DB connection
$connection->close();
?>
