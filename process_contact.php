<?php
// Establish database connection
$servername = "localhost"; // Replace with your database server name
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "web_dev"; // Replace with your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the form data
    $queryType = $_POST["myQuery"];
    $name = $_POST["myName"];
    $email = $_POST["myEmail"];
    $phone = $_POST["myPhone"];
    $isMember = isset($_POST["eligible"]) ? 1 : 0;
    $message = $_POST["mesg"];

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO contact_form (query_type, name, email, phone, is_member, message) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssis", $queryType, $name, $email, $phone, $isMember, $message);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Form data inserted successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
