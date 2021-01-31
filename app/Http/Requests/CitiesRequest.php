<?php

    namespace App\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;

    class CitiesRequest extends FormRequest{
        public function authorize(){
            return true;
        }

        public function rules(){
            if($this->method() == 'PATCH'){
                return [
                    'name' => 'required',
                    'pincode' => 'required',
                    'district_id' => 'required',
                    'taluka_id' => 'required'
                ];
            }else{
                return [
                    'name' => 'required',
                    'pincode' => 'required',
                    'district_id' => 'required',
                    'taluka_id' => 'required',
                ];
            }
        }

        public function messages(){
            return [
                'name.required' => 'Please enter name',
                'pincode.required' => 'Please enter pincode',
                'district_id.required' => 'Please select district',
                'taluka_id.required' => 'Please select taluka',
            ];
        }
    }