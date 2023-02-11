<!-- This file displays a list of users' IDs and a button to reveal their details  -->

<?php
   error_reporting(E_ALL);
   ini_set('display_errors', 1);
?>

<?php
require_once 'config.php';
$conn = new mysqli($serverName, $dbUserName, $dbPassword, $dbName);

// Get all the users' IDs from the database
if (isset($_GET["getAllUserIds"])) {
    $sql = "SELECT id FROM users";
    $result = mysqli_query($conn, $sql);
    $userIds = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $userIds[] = $row["id"];
    }
    // Output the list of user IDs as JSON
    header('Content-Type: application/json');
    echo json_encode($userIds);
    exit;
}
else if (isset($_GET["getUserDetails"]) && isset($_GET["id"])) {
    $id = $_GET["id"];
    $sql = "SELECT name, surname, birthdate, pesel FROM users WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    // Output the user details as JSON
    header('Content-Type: application/json');
    echo json_encode($row);
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
// JavaScript code
$(document).ready(function() {
  $.ajax({
    url: "getUsers.php?getAllUserIds=1",
    success: function(data) {
      console.log(data);
      // Display the users' id
      $("#users").html("");
      for (var i = 0; i < data.length; i++) {
        $("#users").append("<li data-id='" + data[i] + "'>" + data[i] + "<button style='margin-left:15px;'class='getUserDetails' data-id='" + data[i] + "'>Reveal</button></li>");
      }
      
      // Listen for a click event on each button
      $(".getUserDetails").click(function() {
        var userId = $(this).data("id");
        $.ajax({
          url: "getUsers.php?getUserDetails=1&id=" + userId,
          success: function(data) {
            console.log(data);
            // Display the user details
            $("#userDetails").html("");
            $("#userDetails").append("<p>Name: " + data.name + "</p>");
            $("#userDetails").append("<p>Surname: " + data.surname + "</p>");
            $("#userDetails").append("<p>Birthdate: " + data.birthdate + "</p>");
            $("#userDetails").append("<p>PESEL: " + data.pesel + "</p>");
          }
        });
      });
    }
  });
});

  </script>
</head>
<body>
  <ul id="users"></ul>
  <div id="userDetails"></div>
</body>
</html>
