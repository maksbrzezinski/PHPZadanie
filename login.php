<?php
   error_reporting(E_ALL);
   ini_set('display_errors', 1);
?>

<?php
session_start();

require_once 'config.php';


if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}


if (isset($_POST['submitLogin'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $conn = new mysqli($serverName, $dbUserName, $dbPassword, $dbName);

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
            $loginError = 'Incorrect password';
        }
    } else {
        $loginError = 'Email not found';
    }

    $conn->close();
}
?>

<html>
<head>
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <?php if (isset($loginError)) { echo '<p style="color: red;">' . $loginError . '</p>'; } ?>
    <form method="post">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" name="submitLogin" value="Login">
    </form>

    <p>If you are not registered click the button below to register.</p>
    <a href="register.php"><button>Register</button></a>
</body>
</html>