<?php

    namespace App\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;

    class TalukasRequest extends FormRequest{
        public function authorize(){
            return true;
        }

        public function rules(){
            if($this->method() == 'PATCH'){
                return [
                    'name' => 'required|unique:talukas,name,'.$this->id,
                    'district_id' => 'required'
                ];
            }else{
                return [
                    'name' => 'required|unique:talukas,name',
                    'district_id' => 'required'
                ];
            }
        }

        public function messages(){
            return [
                'name.required' => 'Please enter name',
                'name.unique' => 'Please enter unique name',
                'district_id.required' => 'Please enter select district'
            ];
        }
    }
