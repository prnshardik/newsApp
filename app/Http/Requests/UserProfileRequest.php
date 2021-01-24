<?php

    namespace App\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;

    class UserProfileRequest extends FormRequest{

        public function authorize(){
            return true;
        }

        public function rules(){
            return [
                'firstname' => 'required',
                'lastname' => 'required',
                'address' => 'required',
                'phone_no' => 'required',
                'country_id' => 'required ',
                'state_id' => 'required ',
                'city_id' => 'required',
            ];
        }

        public function messages(){
            return [
                'firstname.required' => 'Please Enter First Name',
                'lastname.required' => 'Please Enter Last Name',
                'address' => 'Please Enter Address',
                'phone_no' => 'Please Enter Mobile Number',
                'country_id' => 'Please Select Country',
                'state_id' => 'Please Select State ',
                'city_id' => 'Please Select City'
            ];
        }
    }
