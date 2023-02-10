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

// Check if the user has submitted the registration form
// if (isset($_POST['submit_register'])) {
//     $email = $_POST['email'];
//     $login = $_POST['login'];
//     $name = $_POST['name'];
//     $surname = $_POST['surname'];
//     $password = $_POST['password'];
//     $birthdate = $_POST['birthdate'];
//     $pesel = $_POST['pesel'];

//     $conn = new mysqli($servername, $username, $password, $dbname);

//     if ($conn->connect_error) {
//         die("Connection failed: " . $conn->connect_error);
//     }

//     $hashed_password = password_hash($password, PASSWORD_BCRYPT);

//     $sql = "INSERT INTO users (email, login, name, surname, password, birthdate, pesel)
//         VALUES ('$email', '$login', '$name', '$surname', '$hashed_password', '$birthdate', '$pesel')";

//     if ($conn->query($sql) === TRUE) {
//         $register_message = 'Registration successful. You can now log in.';
//     } else {
//         $register_error = 'Error registering user: ' . $conn->error;
//     }

//     $conn->close();
// }
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
<!-- <h1>Register</h1>
<?php if (isset($register_error)) { echo '<p style="color: red;">' . $register_error . '</p>'; } ?>
<?php if (isset($register_message)) { echo '<p style="color: green;">' . $register_message . '</p>'; } ?>
<form action="index.php" method="post">
    <input type="email" name="email" placeholder="Email" required>
    <input type="text" name="login" placeholder="Login" required>
    <input type="text" name="name" placeholder="Name" required>
    <input type="text" name="surname" placeholder="Surname" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="date" name="birthdate" required>
    <input type="text" name="pesel" placeholder="PESEL" required>
    <input type="submit" name="submit_register" value="Register">
</form> -->
</body>
</html>