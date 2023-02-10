<?php
   error_reporting(E_ALL);
   ini_set('display_errors', 1);
?>

<?php
require_once 'config.php';
$conn = new mysqli($serverName, $dbUserName, $dbPassword, $dbName);

// Get all the users from the database
$sql = "SELECT * FROM users";
$result = mysqli_query($conn, $sql);
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Return the users as JSON
if (isset($_GET["getUsers"])) {
  header('Content-Type: application/json');
  echo json_encode($users);
  exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
      $("#getUsers").click(function() {
        $.ajax({
          url: "getUsers.php?getUsers",
          success: function(data) {
            console.log(data);
            // Display the users
            $("#users").html("");
            for (var i = 0; i < data.length; i++) {
              $("#users").append("<li>" + data[i].name + "</li>");
            }
          }
        });
      });
    });
  </script>
</head>
<body>
  <button id="getUsers">Get users</button>
  <ul id="users"></ul>
</body>
</html>