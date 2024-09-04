<?php
// Database connection
$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "school_db";

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $graduation_year = $_POST['graduation-year'];
    $educational_background = $_POST['educational-background'];
    $professional_history = $_POST['professional-history'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "Passwords do not match.";
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insert user into the database
    $sql = "INSERT INTO users (username, password, graduation_year, educational_background, professional_history) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $username, $hashed_password, $graduation_year, $educational_background, $professional_history);

    if ($stmt->execute()) {
        echo "Registration successful!";
        header("Location: login.html");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
