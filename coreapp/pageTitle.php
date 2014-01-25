<?php

  
if (!function_exists('page_title')) {

    function page_title($title=null ){
        
        header("Title : $title");
        
        return true;
    }

}


?>
