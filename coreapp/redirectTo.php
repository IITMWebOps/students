<?php

    if (!function_exists('redirect_to')) {
        
        function redirect_to( $path, $routechange = false ) {
          
            if($routechange){
             
                header("Location: $path",true,200); 
            }
            else {
            
                $path = $path[0] == '/' ? '/' . APP_SUBPATH . $path : $path;
                header("Location: $path");
            }
            exit();
        }

    }

?>

