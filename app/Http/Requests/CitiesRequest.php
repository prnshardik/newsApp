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
                    'name' => 'required|unique:cities,name,'.$this->id,
                    'pincode' => 'required|unique:cities,pincode,'.$this->id,
                    'district_id' => 'required',
                    'taluka_id' => 'required'
                ];
            }else{
                return [
                    'name' => 'required|unique:cities,name',
                    'pincode' => 'required|unique:cities,pincode',
                    'district_id' => 'required',
                    'taluka_id' => 'required',
                ];
            }
        }

        public function messages(){
            return [
                'name.required' => 'Please enter name',
                'name.unique' => 'Please enter unique name',
                'pincode.required' => 'Please enter pincode',
                'pincode.unique' => 'Please enter unique pincode',
                'district_id.required' => 'Please select district',
                'taluka_id.unique' => 'Please select taluka',
            ];
        }
    }
