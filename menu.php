<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="styles.css"/>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .topnav {
  overflow: hidden;
  background-color: #333;
}

.topnav a {
  float: left;
  display: block;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}

.topnav a:hover {
  background-color: #e16724;
  color: black;
}

.topnav a.active {
  background-color: #e16724;
  color: white;
}

.topnav .icon {
  display: none;
}

@media screen and (max-width: 600px) {
  .topnav a:not(:first-child) {display: none;}
  .topnav a.icon {
    float: right;
    display: block;
  }
}

@media screen and (max-width: 600px) {
  .topnav.responsive {position: relative;}
  .topnav.responsive .icon {
    position: absolute;
    right: 0;
    top: 0;
  }
  .topnav.responsive a {
    float: none;
    display: block;
    text-align: left;
  }
}

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        .food-item {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .food-name {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }

        .food-type {
            color: #666;
            margin-bottom: 10px;
        }

        .food-description {
            margin-bottom: 10px;
            color: #444;
        }

        .food-price {
            font-weight: bold;
            color: #e15723;
        }

        .add-to-cart-btn {
            background-color: #e15723;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .add-to-cart-btn:hover {
            background-color: #c64c21;
        }
    </style>
</head>
<body>

<div class="topnav" id="myTopnav">
  <a href="#home" class="active">Home</a>
  <a href="signup.html">Sign Up</a>
  <a href="contact.html">Contact</a>
  <a><li style="float:right"><a href="payment_form.html">Payment</a></li>
  <a href="javascript:void(0);" class="icon" onclick="myFunction()">
    <i class="fa fa-bars"></i>
  </a>
</div>

<h1>Indian Food Menu</h1>

<form action="" method="GET">
    <label for="filter">Filter:</label>
    <select name="filter" id="filter">
        <option value="all">All</option>
        <option value="vegetarian">Vegetarian</option>
        <option value="non_vegetarian">Non-Vegetarian</option>
    </select>
    <button type="submit">Apply Filter</button>
</form>

<?php
// Include database connection
include 'db_connect.php';

// Filter condition based on user selection
$filter_condition = "";
if (isset($_GET['filter'])) {
    $filter = $_GET['filter'];
    if ($filter == 'vegetarian') {
        $filter_condition = " WHERE type = 'vegetarian'";
    } elseif ($filter == 'non_vegetarian') {
        $filter_condition = " WHERE type = 'non-vegetarian'";
    }
}

// SQL query to fetch products based on the filter condition
$sql = "SELECT * FROM products" . $filter_condition;
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="food-item">';
        echo '<h3 class="food-name">' . $row['name'] . '</h3>';
        echo '<p class="food-type">Type: ' . $row['type'] . '</p>';
        echo '<p class="food-description">Description: ' . $row['description'] . '</p>';
        echo '<p class="food-price">Price: Rs.' . $row['price'] . '</p>';
        echo '<button class="add-to-cart-btn">Add to Cart</button>';
        echo '</div>';
    }
} else {
    echo '<p>No products available.</p>';
}

$conn->close();
?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');

        addToCartButtons.forEach(button => {
            button.addEventListener('click', function () {
                const productId = this.getAttribute('data-id');
                const productName = this.getAttribute('data-name');
                const productPrice = this.getAttribute('data-price');

                // Send AJAX request to add item to cart
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'add_to_cart.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            alert('Item added to cart successfully.');
                        } else {
                            alert('Error adding item to cart.');
                        }
                    }
                };
                xhr.send('id=' + encodeURIComponent(productId) + '&name=' + encodeURIComponent(productName) + '&price=' + encodeURIComponent(productPrice));
            });
        });
    });
</script>
</body>
</html>
