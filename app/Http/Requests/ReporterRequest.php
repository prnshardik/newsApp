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
                    'name' => 'required',
                    'unique_id' => 'required | unique:reporter',
                    'address' => 'required',
                    'phone_no' => 'required',
                    'email' => 'required |email',
                    'country_id' => 'required ',
                    'state_id' => 'required ',
                    'city_id' => 'required',
                    'receipt_book_start_no' => 'required',
                    'receipt_book_end_no' => 'required',
                ];
            }else{
                return [
                    'name' => 'required',
                    'unique_id' => 'required |unique:reporter,unique_id,' . $this->id,
                    'address' => 'required',
                    'phone_no' => 'required',
                    'email' => 'required |email',
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
                'name.required' => 'Please enter name',
                'unique_id.required' => 'Please enter unique id',
                'unique_id.unique' => 'This Unique Id is already registered',
                'address.required' => 'Please enter address',
                'phone_no.required' => 'Please enter mobile number',
                'email.required' => 'Please enter Email ID',
                'email.email' => 'Please enter valid Email ID',
                'country_id.required' => 'Please select Country',
                'state_id.required' => 'Please select State',
                'city_id.required' => 'Please select City',
                'receipt_book_start_no.required' => 'Please enter receipt start no',
                'receipt_book_end_no.required' => 'Please enter receipt end no',
            ];
        }
    }
