<?php

namespace App\Http\Requests\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;


class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    /*
    public function authorize(): bool
    {
        if(auth()->user() && auth()->user()->role_id == 1)
        {
            return true;
        }
        return false;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'full_name'=>'bail|required|string|min:5|max:157|unique:users',
            'mobile'=>'bail|required|string|min:11|max:11|unique:users',
            'email'=>'bail|required|string|min:5|unique:users',
            'password'=>'bail|required|string|min:8|max:32',

        ];
    }
/*
    protected function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors(),
            'status' => false,
            'message' => 'اطلاعات وارد شده نادرست است'
        ],403));

    }
*/
    public function messages()
    {
        return [
            'full_name.required' => 'نام نباید خالی باشد',
            'full_name.unique' => 'نام نباید تکراری باشد',
            'full_name.min' => 'نام کمتر از 5 کارکتر باشد',

            'mobile.required' => ' موبایل نباید خالی باشد',
            'mobile.min'=>'موبایل نباید کمتر از 11 کارکتر باشد',
            'mobile.max'=>'موبایل نباید بیشتر از 11 کارکتر باشد',
            'mobile.unique' => 'شماره موبایل تکراری است',

            'email.required' => ' ایمیل نباید خالی باشد',
            'email.min' => 'ایمیل نباید کمتر از 5 کارکتر باشد',
            'email.unique' => 'ایمیل نکراری می باشد',


            'password.required'=>'رمز عبور الزامی می باشد',
            'password.unique' => 'رمز عبور تکراری است',
            'password.min'=>'رمز عبور نباید کمتر از 8 کاراکتر باشد',
            'password.max' => 'رمز عبور نباید بیشتر از 32 کاراکتر باشد'

        ];

    }

}
