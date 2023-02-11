<!-- This file adds a user to the database  -->

<?php
   error_reporting(E_ALL);
   ini_set('display_errors', 1);
?>


<?php
require_once 'config.php';

// Create connection
$conn = new mysqli($serverName, $dbUserName, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = "test@example.com";
$login = "testuser";
$name = "John";
$surname = "Doe";
$password = password_hash("password123", PASSWORD_BCRYPT);
$birthdate = "2000-01-01";
$pesel = 12345678902;

$sql = "INSERT INTO users (email, login, name, surname, password, birthdate, pesel)
VALUES ('$email', '$login', '$name', '$surname', '$password', '$birthdate', '$pesel')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>