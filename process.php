<?php
$darkMode = isset($_COOKIE['dark_mode']) && $_COOKIE['dark_mode'] === 'true';
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "web_dev";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// Prepare SQL query to fetch user data from the database
$sql = "SELECT * FROM register WHERE email='$email' AND password='$password'";
$result = $conn->query($sql);

// Check if the user exists
if ($result->num_rows > 0) {
    // Fetch the user details
    $row = $result->fetch_assoc();
?>

<!-- HTML code -->
<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>

    <style>
        /* Add your CSS styles here */
        body {
            font-family: Arial, sans-serif;
            background-color: <?php echo $darkMode ? '#333' : '#fffaf1'; ?>;
            color: <?php echo $darkMode ? '#ffffff' : '#333'; ?>;
            margin: 0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        ul {
            list-style-type: none;
            margin: 0;
            padding: 0px;
            overflow: hidden;
            background-color: #333;
        }

        li {
            float: left;
            border-right: none;
        }

        li a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        li a:hover:not(.active) {
            background-color: #eb7846;
        }

        .active {
            background-color: #e16724;
        }

        h1 {
            color: <?php echo $darkMode ? '#ffffff' : '#333'; ?>;
            margin-left: 500px;
            margin-top: 20px;
        }

        .rounded-image {
            border-radius: 10px;
            display: block;
            margin: 0 auto;
            text-align: center;
            height: 150px;
        }

        .cart {
            background-color: <?php echo $darkMode ? '#333' : '#fff'; ?>;
            color: <?php echo $darkMode ? '#ffffff' : '#333'; ?>;
            padding: 20px;
            margin-top: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .profile-container {
            background-color: #fff;
            padding: 20px;
            margin-top: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .horizontal-container {
            background-color: <?php echo $darkMode ? '#333' : 'initial'; ?>;
            color: <?php echo $darkMode ? '#ffffff' : 'initial'; ?>;
            padding: 20px;
            margin-top: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .menu-card {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            grid-gap: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .dish {
            background-color: #f2f2f2;
            padding: 10px;
        }

        .dish-name {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .dish-description {
            margin-bottom: 10px;
        }

        .dish-price {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .add-to-cart-btn {
            background-color: #333;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .add-to-cart-btn:hover {
            background-color: #e15723;
        }

        .remove-from-cart-btn {
            background-color: #ff3333;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .remove-from-cart-btn:hover {
            background-color: #c64c21;
        }

        .total-amount {
            font-weight: bold;
            margin-top: 10px;
        }

        .message {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #4CAF50;
            color: white;
            padding: 15px;
            border-radius: 5px;
            z-index: 9999;
        }
    </style>
</head>
<nav>
    <ul>
        <li><a href="home.html">Home</a></li>
        <li><a href="signup.html">Sign Up</a></li>
        <li><a href="contact.html">Contact</a></li>
        <li style="float:right"><a href="process.php">Profile</a></li>
    </ul>
</nav>

<body class="<?php echo $darkMode ? 'dark-mode' : ''; ?>">
<div class="profile-container">
    <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" class="rounded-image"></img>
    <p><span class="profile-label">Name:</span> <?php echo $row['first_name'] . ' ' . $row['last_name']; ?></p>
    <p><span class="profile-label">Email:</span> <?php echo $row['email']; ?></p>
    <p><span class="profile-label">Phone Number:</span> <?php echo $row['phone']; ?></p>
    <p><span class="profile-label">Home Delivery Address:</span> <?php echo $row['home_address']; ?></p>
</div>

<div class="cart">
    <h2>Food Menu</h2>
    <div class="menu-card">
        <?php
        // Prepare SQL query to fetch products from the database
        $sql = "SELECT * FROM products";
        $result = $conn->query($sql);

        // Check if there are any products in the database
        if ($result->num_rows > 0) {
            // Output each product as a dish card
            while ($row = $result->fetch_assoc()) {
                echo '
            <div class="dish">
              <div class="dish-name">' . $row['name'] . '</div>
              <div class="dish-description">' . $row['description'] . '</div>
              <div class="dish-price">Rs.' . $row['price'] . '</div>
              <form action="process.php" method="POST">
                <input type="hidden" name="email" value="' . $email . '">
                <input type="hidden" name="product_id" value="' . $row['id'] . '">
                <input type="number" name="quantity" min="1" max="10" value="1">
                <input type="hidden" name="price" value="' . $row['price'] . '">
                <button class="add-to-cart-btn" type="submit">Add to Cart</button>
              </form>
            </div>
            
          ';
            }
        } else {
            echo 'No products available.';
        }
        ?>
    </div>
</div>

<div class="horizontal-container">
    <?php
    // Calculate the total amount
    $sql = "SELECT SUM(quantity * price) AS total FROM shopping_cart WHERE email='$email'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $totalAmount = $row['total'];

    // Display the total amount
    echo '<div class="total-amount">Total Amount: Rs.' . $totalAmount . '</div>';
    ?>
    <a href="cart.php" class="checkout-btn">Go to Cart</a>
</div>

<script>
    // Function to show message dynamically
    function showMessage(message) {
        // Create a new element for the message
        const messageElement = document.createElement('div');
        messageElement.textContent = message;
        messageElement.classList.add('message');

        // Append the message element to the body
        document.body.appendChild(messageElement);

        // Remove the message after 3 seconds
        setTimeout(function () {
            messageElement.remove();
        }, 3000);
    }
</script>

</body>
</html>

<?php
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Process the form submission

    // Check if the remove from cart form is submitted
    if (isset($_POST['cart_item_id'])) {
        $cartItemId = $_POST['cart_item_id'];

        // Delete the item from the shopping cart table
        $deleteSql = "DELETE FROM shopping_cart WHERE id = $cartItemId";
        if ($conn->query($deleteSql) === TRUE) {
            echo "<script>showMessage('Item removed from cart successfully.');</script>";
        } else {
            echo "Error: " . $deleteSql . "<br>" . $conn->error;
        }
    } else {
        // Handle adding items to cart
        $email = $_POST['email'];
        $product_id = $_POST['product_id'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];

        // Insert the selected item into the shopping cart table
        $sql = "INSERT INTO shopping_cart (email, product_id, quantity, price) VALUES ('$email', $product_id, $quantity, $price)";
        if ($conn->query($sql) === TRUE) {
            echo "<script>window.location.href = 'cart.php';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
} else {
    echo "Invalid email or password";
}

// Your existing code for adding items to the cart goes here...

// Update total items and total price in the register table
$updateRegisterQuery = "UPDATE register SET total_items = (SELECT SUM(quantity) FROM shopping_cart WHERE email='$email'), total_price = (SELECT SUM(quantity * price) FROM shopping_cart WHERE email='$email') WHERE email='$email'";
if ($conn->query($updateRegisterQuery) === TRUE) {
    // Success message
} else {
    // Error message
}

$conn->close();
?>