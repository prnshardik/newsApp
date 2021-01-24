<?php

    namespace App\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;

    class ProfileRequest extends FormRequest{

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
                'firstname.required' => 'Please enter firstname',
                'lastname.required' => 'Please enter lastname'
            ];
        }
    }
