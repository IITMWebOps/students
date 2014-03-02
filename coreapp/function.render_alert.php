
<?php

    if (!function_exists('render_alert')) {
        
        function render_alert( $text = null ) {
          
            if($text){
             
                header("Alert : $text"); 
            }
            else {

                trigger_error(__FUNCTION__ . " : Invalid Arguments supplied");
            }
        }

    }

?>

