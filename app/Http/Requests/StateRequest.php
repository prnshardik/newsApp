<?php

    namespace App\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;

    class StateRequest extends FormRequest{

        public function authorize(){
            return true;
        }

        public function rules(){
            if($this->method() == 'PATCH'){
                return [
                    'name' => 'required',
                    'country_id' => 'required'
                ];
            }else{
                return [
                    'name' => 'required',
                    'country_id' => 'required'
                ];
            }
        }

        public function messages(){
            return [
                'name.required' => 'Please enter name',
                'country_id.required' => 'Please select country'
            ];
        }
    }
