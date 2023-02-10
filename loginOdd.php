<?php
  // Start session
  session_start();

  // Check if the form was submitted
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Check if both fields are filled in
    if (!empty($_POST['email']) && !empty($_POST['password'])) {

      // Get the data from the form
      $email = mysqli_real_escape_string($conn, $_POST['email']);
      $password = mysqli_real_escape_string($conn, $_POST['password']);

      $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

      if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
      }

      // Search for the user in the database
      $sql = "SELECT * FROM users WHERE email = '$email'";
      $result = mysqli_query($conn, $sql);
      $user = mysqli_fetch_assoc($result);

      // If the user exists
      if ($user) {
        // Verify the password
        if (password_verify($password, $user['password'])) {
          // Login success
          $_SESSION['user_id'] = $user['id'];
          header('location: welcome.php');
          exit;
        } else {
          // Login failed
          $error = 'Incorrect password';
        }
      } else {
        // Login failed
        $error = 'Incorrect email';
      }
    } else {
      // Login failed
      $error = 'Please fill in both fields';
    }
  }
?>

<!-- Login form -->
<form action="login.php" method="post">
  <label for="email">Email:</label>
  <input type="email" name="email" id="email">
  <br>
  <label for="password">Password:</label>
  <input type="password" name="password" id="password">
  <br>
  <button type="submit">Login</button>
</form>

<!-- Error message -->
<?php if (isset($error)): ?>
  <p><?php echo $error; ?></p>
<?php endif; ?>