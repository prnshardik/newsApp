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

    if(!function_exists('_get_role_name')){
        function _get_role_name(){
            $role = \DB::table('roles')->select('name')->where(['id' => auth()->user()->role_id])->first();
            return ucfirst($role->name);
        }
    }

?>
