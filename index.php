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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <style>
        /* Add your CSS styles here */
        body {
            font-family: Arial, sans-serif;
            background-color: <?php echo $darkMode ? '#333' : '#fffaf1'; ?>;
            color: <?php echo $darkMode ? '#ffffff' : '#333'; ?>;
            margin: 0;
        }

        /* Other CSS styles */

    </style>
</head>

<body class="<?php echo $darkMode ? 'dark-mode' : ''; ?>">
    <div class="profile-container">
        <!-- User profile information -->
    </div>

    <div class="cart">
        <h2>Food Menu</h2>
        <div class="menu-card">
            <!-- Display menu items here -->
            <?php
            // Fetch and display menu items
            // Replace this with your actual menu item retrieval code
            ?>
            <div class="dish">
                <div class="dish-name">Item Name</div>
                <div class="dish-description">Item Description</div>
                <div class="dish-price">Rs. Item Price</div>
                <form id="add-to-cart-form" method="POST">
                    <input type="hidden" name="email" value="<?php echo $email; ?>">
                    <input type="hidden" name="password" value="<?php echo $password; ?>">
                    <input type="hidden" name="product_id" value="1">
                    <input type="number" name="quantity" min="1" max="10" value="1">
                    <input type="hidden" name="price" value="100"> <!-- Replace with actual price -->
                    <button class="add-to-cart-btn" type="button" onclick="addToCart()">Add to Cart</button>
                </form>
            </div>
        </div>
    </div>

    <div id="cart-summary">
        <!-- Cart summary will be loaded here -->
    </div>

    <script>
        function addToCart() {
            // Serialize form data
            var formData = $('#add-to-cart-form').serialize();

            // Send AJAX request
            $.ajax({
                type: 'POST',
                url: 'process.php', // Change to the correct URL
                data: formData,
                success: function(response) {
                    // Show notification message
                    alert('Item added to cart successfully.');

                    // Reload the cart summary
                    $('#cart-summary').load('cart_summary.php'); // Change to the correct URL
                },
                error: function(xhr, status, error) {
                    // Handle errors
                    alert('Error adding item to cart.');
                }
            });
        }
    </script>

</body>
</html>

<?php
} else {
    echo "Invalid email or password";
}

$conn->close();
?>
