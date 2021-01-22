<?php

    namespace App\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;

    class PermissionRequest extends FormRequest{
        public function authorize(){
            return true;
        }

        public function rules(){
                if($this->method() == 'PATCH'){
                    return [
                        'name' => 'required',
                        'guard_name' => 'required'
                    ];
                }else{
                    return [
                        'name' => 'required',
                        'guard_name' => 'required'
                    ];
                }
            }

            public function messages(){
                return [
                    'name.required' => 'Please enter name',
                    'guard_name.required' => 'Please enter guard name'
                ];
            }
    }
