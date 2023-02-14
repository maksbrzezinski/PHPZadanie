<?php
   error_reporting(E_ALL);
   ini_set('display_errors', 1);
?>


<?php
function appendToFile($text) {
    $fileName = 'zadanie.txt';
    $handle = fopen($fileName, 'a');
    if (!$handle) {
        return false;
    }
    $result = fwrite($handle, $text . PHP_EOL);
    fclose($handle);
    return ($result !== false);
    }

    $text = "This is a new line of text to be added.";
    $result = appendToFile($text);
    if ($result) {
    echo "Text added successfully.";
    } else {
    echo "Error adding text.";
    }

?>