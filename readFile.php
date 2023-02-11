<!-- This file reads content of the 'zadanie.txt' file -->

<?php
$filename = 'zadanie.txt';
$fileContents = file_get_contents($filename);
echo $fileContents;
?>