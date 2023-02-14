<?php
   error_reporting(E_ALL);
   ini_set('display_errors', 1);
?>

<?php
require_once 'config.php';

   $conn = new mysqli($serverName, $dbUserName, $dbPassword, $dbName);

   if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
   }

   $password = password_hash('secret', PASSWORD_BCRYPT);

   $sql = "CREATE TABLE users (
      id INT AUTO_INCREMENT PRIMARY KEY,
      email VARCHAR(255) NOT NULL,
      login VARCHAR(255) NOT NULL,
      name VARCHAR(255) NOT NULL,
      surname VARCHAR(255) NOT NULL,
      password VARCHAR(255) NOT NULL,
      birthdate DATE NOT NULL,
      pesel VARCHAR(11) NOT NULL,
      created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
      updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
   )";

   if ($conn->query($sql) === TRUE) {
      echo "Table users created successfully";
   } else {
      echo "Error creating table: " . $conn->error;
   }

   $conn->close();
?>
