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
                    'receipt_book_start_no' => 'required|unique:reporter,receipt_book_start_no,'.$this->id,
                    'receipt_book_end_no' => 'required|unique:reporter,receipt_book_end_no,'.$this->id,
                    'district_id' => 'required',
                    'taluka_id' => 'required',
                    'city_id' => 'required'
                ];
            }else{
                return [
                    'firstname' => 'required',
                    'lastname' => 'required',
                    'unique_id' => 'required|unique:reporter',
                    'address' => 'required',
                    'phone_no' => 'required',
                    'email' => 'required|email',
                    'receipt_book_start_no' => 'required|unique:reporter,receipt_book_start_no',
                    'receipt_book_end_no' => 'required|unique:reporter,receipt_book_end_no',
                    'district_id' => 'required',
                    'taluka_id' => 'required',
                    'city_id' => 'required'
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
                'receipt_book_start_no.required' => 'Please enter receipt start no',
                'receipt_book_end_no.required' => 'Please enter receipt end no',
                'district_id.required' => 'Please enter district',
                'taluka_id.required' => 'Please enter taluka',
                'city_id.required' => 'Please select city',
            ];
        }
    }
