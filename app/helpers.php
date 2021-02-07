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

    if(!function_exists('_site_logo')){
        function _site_logo(){
            return \URL('/backend/img/logo.png');
        }
    }

    if(!function_exists('_user_profile')){
        function _user_profile(){
            if(auth()->user()->role_id == 1){
                $profile =  \URL('/backend/img/logo.png');
                return $profile;
            }elseif(auth()->user()->role_id == 2){
                $path = URL('/uploads/reporter').'/';
                $data = \DB::table('reporter')
                                ->select(
                                    DB::Raw("CASE
                                            WHEN ".'profile'." != '' THEN CONCAT("."'".$path."'".", ".'profile'.")
                                            ELSE CONCAT("."'".$path."'".", 'default.png')
                                        END as profile")
                                    )
                                ->where(['user_id' => auth()->user()->id])
                                ->first();
                return $data->profile;
            }else{
                $profile =  \URL('/backend/img/admin-avatar.png');
                return $profile;
            }
        }
    }

    if(!function_exists('_get_role_name')){
        function _get_role_name(){
            $role = \DB::table('roles')->select('name')->where(['id' => auth()->user()->role_id])->first();
            return ucfirst($role->name);
        }
    }

    if(!function_exists('_reporter_unique_id')){
        function _reporter_unique_id(){
            $data = \DB::table('reporter')->select('unique_id')->where(['user_id' => auth()->user()->id])->first();
            return $data->unique_id;
        }
    }

?>
