<?php
   error_reporting(E_ALL);
   ini_set('display_errors', 1);
?>

<?php
session_start();

require_once 'config.php';

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

// Check if the user has submitted the login form
if (isset($_POST['submit_login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header('Location: dashboard.php');
            exit;
        } else {
            $login_error = 'Incorrect password';
        }
    } else {
        $login_error = 'Email not found';
    }

    $conn->close();
}
?>

<html>
<head>
    <title>Login/Register</title>
</head>
<body>
    <h1>Login</h1>
    <?php if (isset($login_error)) { echo '<p style="color: red;">' . $login_error . '</p>'; } ?>
    <form action="index.php" method="post">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" name="submit_login" value="Login">
    </form>

</body>
</html>