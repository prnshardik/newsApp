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
                    'pincode' => 'required|unique:cities,pincode,'.$this->id
                ];
            }else{
                return [
                    'name' => 'required|unique:cities,name',
                    'pincode' => 'required|unique:cities,pincode'
                ];
            }
        }

        public function messages(){
            return [
                'name.required' => 'Please enter name',
                'name.unique' => 'Please enter unique name',
                'pincode.required' => 'Please enter name',
                'pincode.unique' => 'Please enter unique pincode'
            ];
        }
    }
