<?php

    namespace App\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;

    class CityRequest extends FormRequest{

        public function authorize(){
            return true;
        }

        public function rules(){
            if($this->method() == 'PATCH'){
                return [
                    'name' => 'required',
                    'country_id' => 'required',
                    'state_id' => 'required'
                ];
            }else{
                return [
                    'name' => 'required',
                    'country_id' => 'required',
                    'state_id' => 'required'
                ];
            }
        }

        public function messages(){
            return [
                'name.required' => 'Please enter name',
                'country_id.required' => 'Please select country',
                'state_id.required' => 'Please select state'
            ];
        }
    }
