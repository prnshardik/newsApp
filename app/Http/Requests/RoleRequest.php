<?php

    namespace App\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;

    class RoleRequest extends FormRequest{
        public function authorize(){
            return true;
        }

        public function rules(){
                if($this->method() == 'PATCH'){
                    return [
                        'name' => 'required'                    ];
                }else{
                    return [
                        'name' => 'required|unique:roles,name'
                    ];
                }
            }

            public function messages(){
                return [
                    'name.required' => 'Please enter name'
                ];
            }
    }
