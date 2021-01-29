<?php

    namespace App\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;

    class DistrictsRequest extends FormRequest{
        public function authorize(){
            return true;
        }

        public function rules(){
            if($this->method() == 'PATCH'){
                return [
                    'name' => 'required|unique:districts,name,'.$this->id
                ];
            }else{
                return [
                    'name' => 'required|unique:districts,name'
                ];
            }
        }

        public function messages(){
            return [
                'name.required' => 'Please enter name',
                'name.unique' => 'Please enter unique name'
            ];
        }
    }
