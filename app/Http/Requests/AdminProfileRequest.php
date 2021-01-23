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
                'firstname.required' => 'Please enter name',
                'lastname.required' => 'Please select country'
            ];
        }
    }
