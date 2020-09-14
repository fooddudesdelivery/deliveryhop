<?php
 class perfmon extends base {
   function perfmon() {
     global $zco_notifier;
     if (!defined('PERFMON_CUSTOMER_ID') || (PERFMON_CUSTOMER_ID == 0)) return; 
     if (!isset($_SESSION['customer_id']) || $_SESSION['customer_id'] == '') return; 
     if (PERFMON_CUSTOMER_ID == $_SESSION['customer_id']) { 
        $zco_notifier->attach($this, array('*'));
     } 
   }

   /* This version prints out the difference between times in 
      hundreds of microseconds in a CSV format.
   */
   function update(&$callingClass, $eventID) { 
       global $lasttime; 
       $separator = ",";  // Could be " " if csv not desired

       $currtime = microtime(true);
       if (isset($lasttime)) { 
          $timediff = (int)($currtime*10000) - (int)($lasttime*10000); 
       } else { 
          $timediff = 0;
       } 
       $lasttime = $currtime; 
       // This style includes the last timestamp 
       // $line = $separator . $timediff . $separator . $eventID . $separator . $lasttime;
       $line = $separator . $timediff . $separator . $eventID;
       error_log($line);
   }
 }
?>
