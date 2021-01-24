<?php

    namespace App\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;

    class AdminProfileRequest extends FormRequest{

        public function authorize(){
            return true;
        }

        public function rules(){
            return [
                'firstname' => 'required',
                'lastname' => 'required'
            ];
        }

        public function messages(){
            return [
                'firstname.required' => 'Please Enter First Name',
                'lastname.required' => 'Please Enter Last Name'
            ];
        }
    }
