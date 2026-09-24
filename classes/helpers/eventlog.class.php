<?php

/**
 * Description of eventlog
 *
 * @author  Marco Gulino
 * @version 1.0 2012-06-27
 */
class EventLog {
    
    public static function writeEntry($p_message, $p_entry_type = 'event', $p_details = ''){
       echo $p_message; 
    }
    
}

?>
