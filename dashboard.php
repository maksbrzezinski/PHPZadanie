<?php
   error_reporting(E_ALL);
   ini_set('display_errors', 1);
?>

<?php

require_once 'config.php';
$conn = new mysqli($serverName, $dbUserName, $dbPassword, $dbName);


session_start();
$user_id = $_SESSION["user_id"];


$sql = "SELECT * FROM users WHERE id=$user_id";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);


if (isset($_POST["submit"])) {

  $password = mysqli_real_escape_string($conn, $_POST["password"]);
  $name = mysqli_real_escape_string($conn, $_POST["name"]);
  $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

  $sql = "UPDATE users SET";
  if(!empty($password)) {
    $sql .= " password='$hashedPassword',";
  }
  if(!empty($name)) {
    $sql .= " name='$name',";
  }
  
  $sql = rtrim($sql, ",");
  $sql .= " WHERE id=$user_id";
  mysqli_query($conn, $sql);
}
?>

<h1>Dashboard</h1>
<p>User ID: <?php echo $user["id"]; ?></p>
<form action="" method="post">
  <div>
    <label for="password">New password:</label>
    <input type="password" name="password" id="password">
  </div>
  <div>
    <label for="name">New name:</label>
    <input type="text" name="name" id="name" value="<?php echo $user["name"]; ?>">
  </div>
  <input type="submit" name="submit" value="Update">
</form>