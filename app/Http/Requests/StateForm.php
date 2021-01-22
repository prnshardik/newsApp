<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StateForm extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
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
                'name.required' => 'Please Enter Name',
                'country_id.required' => 'Please Select Country'
            ];
        }
}
