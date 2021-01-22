<?php

    namespace App\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;

    class CountryRequest extends FormRequest{
        public function authorize(){
            return true;
        }

        public function rules(){
            if($this->method() == 'PATCH'){
                return [
                    'name' => 'required',
                    'country_code' => 'required'
                ];
            }else{
                return [
                    'name' => 'required',
                    'country_code' => 'required'
                ];
            }
        }

        public function messages(){
            return [
                'name.required' => 'Please enter name',
                'country_code.required' => 'Please enter country code'
            ];
        }
    }
