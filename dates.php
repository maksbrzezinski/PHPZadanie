<?php
   date_default_timezone_set('UTC');
   $today = new DateTime();
   $endOfYear = new DateTime('January 1 2024');
   $interval = new DateInterval('P1D');
   $period = new DatePeriod($today, $interval, $endOfYear);

   echo '<ul>';
   foreach ($period as $date) {
      echo '<li>' . $date->format('Y-m-d') . '</li>';
   }
   echo '</ul>';
?>