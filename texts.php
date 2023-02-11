<!-- This file displays random text from an array  -->

<?php
   $texts = array("Text 1", "Text 2", "Text 3", "Text 4", "Text 5");
   $randomIndex = array_rand($texts);
   $randomText = $texts[$randomIndex];

   echo $randomText;
?>