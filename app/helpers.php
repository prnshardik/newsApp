<?php

    if(!function_exists('_site_footer')){
        function _site_footer(){
            echo date('Y')." © <b>". _site_name() ."</b> - All rights reserved.";
        }
    }

    if(!function_exists('_site_name')){
        function _site_name(){
            return "NewsApp";
        }
    }

?>
