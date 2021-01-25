<?php

    namespace App\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;

    class SubscriptionRequest extends FormRequest{

        public function authorize(){
            return true;
        }

        public function rules(){
            if($this->method() == 'PATCH'){
                return [
                    'start_date' => 'required',
                    'end_date' => 'required'
                ];
            }else{
                return [
                    'start_date' => 'required',
                    'end_date' => 'required'
                ];
            }
        }

        public function messages(){
            return [
                'start_date.required' => 'Please enter start date',
                'end_date.required' => 'Please enter end date'
            ];
        }
    }
