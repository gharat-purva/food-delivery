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
            background-color: #fffaf1;
            color: #333;
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
            color: #333;
            margin-left: 500px;
            margin-top: 20px;
        }

        .rounded-image {
            border-radius: 50%;
            display: block;
            margin: 0 auto;
            text-align: center;
            height: 150px;
        }

        .cart {
            background-color: #fff;
            color: #333;
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
            background-color: #fff;
            color: #333;
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

        .remove-icon {
            color: #fff;
            cursor: pointer;
        }

        .remove-icon:hover {
            color: #c64c21;
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
        <li><a href="menu.php">Menu</a></li>
        <li style="float:right"><a href="process.php">Profile</a></li>
    </ul>
</nav>

<body>
<?php
// Database connection
$conn = new mysqli("127.0.0.1", "root", "", "web_dev");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user details from register table

$sql = "SELECT * FROM register";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output user details
    $row = $result->fetch_assoc();
    echo '
        <div class="profile-container">
            <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" class="rounded-image"></img>
            <p><span class="profile-label">Name:</span> '.$row["first_name"].' '.$row["last_name"].'</p>
            <p><span class="profile-label">Email:</span> '.$row["email"].'</p>
            <p><span class="profile-label">Phone Number:</span> '.$row["phone"].'</p>
            <p><span class="profile-label">Home Delivery Address:</span> '.$row["home_address"].'</p>
        </div>';

    // Assign total price and total items from the database to variables
    $totalPrice = $row["total_price"];
    $totalItems = $row["total_items"];
} else {
    echo "No user details found.";
}


// Close connection
$conn->close();
?>

<?php
// Database connection
$conn = new mysqli("127.0.0.1", "root", "", "web_dev");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle remove from cart form submission
if(isset($_POST['remove_from_cart'])) {
    $cart_item_id = $_POST['cart_item_id'];
    // Delete the item from the shopping cart
    $delete_sql = "DELETE FROM shopping_cart WHERE id = $cart_item_id";
    if ($conn->query($delete_sql) === TRUE) {
        // Update total amount and total items after removing item from cart
        $update_total_sql = "UPDATE register 
                             SET total_price = (SELECT SUM(price) FROM shopping_cart),
                                 total_items = (SELECT SUM(quantity) FROM shopping_cart)
                             WHERE email = '".$row["email"]."'";
        $conn->query($update_total_sql);
        echo '<div class="message">Item removed from cart successfully.</div>';
    } else {
        echo '<div class="message">Error removing item from cart: ' . $conn->error . '</div>';
    }
}

// Fetch items in the cart for the current user
$cart_sql = "SELECT shopping_cart.id, products.name, shopping_cart.quantity, shopping_cart.price
             FROM shopping_cart
             INNER JOIN products ON shopping_cart.product_id = products.id";
$cart_result = $conn->query($cart_sql);

if ($cart_result->num_rows > 0) {
    // Output items in the cart
    echo '<div class="cart">
            <h2>My Cart</h2>
            <div class="menu-card">';
    while ($cart_row = $cart_result->fetch_assoc()) {
        echo '<div class="dish">
                <div class="dish-name">'.$cart_row["name"].'</div>
                <div class="dish-description">Quantity: '.$cart_row["quantity"].'</div>
                <div class="dish-price">Price: Rs. '.$cart_row["price"].'</div>
                <form action="#" method="POST">
                    <input type="hidden" name="cart_item_id" value="'.$cart_row["id"].'">
                    <button class="remove-from-cart-btn" type="submit" name="remove_from_cart">
                        <i class="fas fa-trash-alt remove-icon"></i>
                    </button>
                </form>
              </div>';
    }
    echo '</div></div>';
} else {
    echo "Cart is empty.";
}

// Close connection
$conn->close();
?>

<div class="horizontal-container">
    <div class="total-amount">Total Amount: Rs. <?php echo $totalPrice; ?></div>
    <div class="total-amount">Total Items: <?php echo $totalItems; ?></div>
    <a href="payment_form.html" class="checkout-btn">Checkout</a>
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
