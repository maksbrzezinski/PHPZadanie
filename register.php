<?php
   error_reporting(E_ALL);
   ini_set('display_errors', 1);
?>

<?php
session_start();

require_once 'config.php';


if (isset($_POST['submitRegister'])) {
    $email = $_POST['email'];
    $login = $_POST['login'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $password = $_POST['password'];
    $birthdate = $_POST['birthdate'];
    $pesel = $_POST['pesel'];

    $conn = new mysqli($serverName, $dbUserName, $dbPassword, $dbName);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (email, login, name, surname, password, birthdate, pesel)
        VALUES ('$email', '$login', '$name', '$surname', '$hashedPassword', '$birthdate', '$pesel')";

    if ($conn->query($sql) === TRUE) {
        $registerMessage = 'Registration successful. You can now log in.';
    } else {
        $registerError = 'Error registering user: ' . $conn->error;
    }

    $conn->close();
}

?>

<html>
<head>
    <title>Register</title>
</head>
<body>
    <h1>Register</h1>
    <?php if (isset($registerError)) { echo '<p style="color: red;">' . $registerError . '</p>'; } ?>
    <?php if (isset($registerMessage)) { echo '<p style="color: green;">' . $registerMessage . '</p>'; } ?>
    <form method="post">
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="login" placeholder="Login" required>
        <input type="text" name="name" placeholder="Name" required>
        <input type="text" name="surname" placeholder="Surname" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="date" name="birthdate" required>
        <input type="text" name="pesel" placeholder="PESEL" required>
        <input type="submit" name="submitRegister" value="Register">
    </form>

    <p>Already registered? Click the button below to log in.</p>
    <a href="login.php"><button>Log in</button></a>
</body>
</html>