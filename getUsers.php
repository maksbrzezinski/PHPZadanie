<?php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  require_once 'config.php';
  $conn = new mysqli($serverName, $dbUserName, $dbPassword, $dbName);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql = "SELECT id, name, surname, birthdate, pesel FROM users";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $userDetails = array();
    while($row = $result->fetch_assoc()) {
      $userDetails[$row["id"]] = $row;
    }

    echo "<ul>";
    foreach($userDetails as $id => $user) {
      echo "<li><span class='userId'>$id</span> ";
      echo "<button class='revealUserDetails'>Reveal</button>";
      echo "<div class='userDetails' style='display: none'>";
      echo "<p>Name: {$user['name']}</p>";
      echo "<p>Surname: {$user['surname']}</p>";
      echo "<p>Birthdate: {$user['birthdate']}</p>";
      echo "<p>PESEL: {$user['pesel']}</p>";
      echo "</div>";
      echo "</li>";
    }
    echo "</ul>";
  } else {
    echo "No users found.";
  }

  $conn->close();
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    $(".revealUserDetails").click(function() {
      var $userDetails = $(this).siblings(".userDetails");
      if ($userDetails.is(":visible")) {
        $userDetails.hide();
      } else {
        $userDetails.show();
      }
    });
  });
</script>
