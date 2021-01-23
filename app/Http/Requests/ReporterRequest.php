<?php

    namespace App\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;

    class ReporterRequest extends FormRequest{
        public function authorize(){
            return true;
        }

        public function rules(){
            if($this->method() == 'PATCH'){
                return [
                    'firstname' => 'required',
                    'lastname' => 'required',
                    'unique_id' => 'required|unique:reporter,unique_id,'.$this->id,
                    'address' => 'required',
                    'phone_no' => 'required',
                    'email' => 'required|email',
                    'country_id' => 'required ',
                    'state_id' => 'required ',
                    'city_id' => 'required',
                    'receipt_book_start_no' => 'required',
                    'receipt_book_end_no' => 'required',
                ];
            }else{
                return [
                    'firstname' => 'required',
                    'lastname' => 'required',
                    'unique_id' => 'required|unique:reporter',
                    'address' => 'required',
                    'phone_no' => 'required',
                    'email' => 'required|email',
                    'country_id' => 'required ',
                    'state_id' => 'required ',
                    'city_id' => 'required',
                    'receipt_book_start_no' => 'required',
                    'receipt_book_end_no' => 'required',
                ];
            }
        }

        public function messages(){
            return [
                'firstname.required' => 'Please enter firstname',
                'lastname.required' => 'Please enter lastname',
                'unique_id.required' => 'Please enter unique id',
                'unique_id.unique' => 'This unique ID is already registered',
                'address.required' => 'Please enter address',
                'phone_no.required' => 'Please enter mobile number',
                'email.required' => 'Please enter email address',
                'email.email' => 'Please enter valid email address',
                'country_id.required' => 'Please select country',
                'state_id.required' => 'Please select state',
                'city_id.required' => 'Please select city',
                'receipt_book_start_no.required' => 'Please enter receipt start no',
                'receipt_book_end_no.required' => 'Please enter receipt end no',
            ];
        }
    }
