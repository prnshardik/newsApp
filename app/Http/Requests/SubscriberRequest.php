<?php

    namespace App\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;

    class SubscriberRequest extends FormRequest{

        public function authorize(){
            return true;
        }

        public function rules(){
            if($this->method() == 'PATCH'){
                return [
                    'firstname' => 'required',
                    'lastname' => 'required',
                    'receipt_no' => 'required',
                    'address' => 'required',
                    'phone' => 'required|digits:10',
                    'pincode' => 'required',
                    'magazine' => 'required'
                ];
            }else{
                return [
                    'firstname' => 'required',
                    'lastname' => 'required',
                    'receipt_no' => 'required',
                    'address' => 'required',
                    'phone' => 'required|digits:10',
                    'pincode' => 'required',
                    'magazine' => 'required'
                ];
            }
        }

        public function messages(){
            return [
                'receipt_no.required' => 'Please enter receipt no',
                'address.required' => 'Please enter address',
                'phone.required' => 'Please enter phone',
                'pincode.required' => 'Please enter pincode',
                'magazine.required' => 'Please select magazine'
            ];
        }
    }
