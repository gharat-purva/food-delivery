<?php
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
$firstName = $_POST['first-name'];
$lastName = $_POST['last-name'];
$email = $_POST['email'];
$password = $_POST['password'];
$phone = $_POST['phone'];
$homeAddress = $_POST['home-address'];

// Prepare SQL query to insert data into the database
$sql = "INSERT INTO register (first_name, last_name, email, password, phone, home_address) VALUES (?, ?, ?, ?, ?, ?)";

// Create a prepared statement
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $firstName, $lastName, $email, $password, $phone, $homeAddress);

// Execute the prepared statement
if ($stmt->execute()) {
    echo "Sign-up successful";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the prepared statement and the database connection
$stmt->close();
$conn->close();
?>
