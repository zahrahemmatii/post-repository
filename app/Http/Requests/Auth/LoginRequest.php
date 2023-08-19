<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        if (auth()->user())
        {
            return false;
        }
        return true;
    }

    public function rules(): array
    {
        return [
            'mobile' => 'bail|required|string|min:11|max:11|exists:users',
            'password' => 'bail|required|string|min:8|max:32'
        ];
    }


    public function messages()
    {
        return [
            'mobile.exists' => 'کاربری با این شناسه کاربری پیدا نشد',
        ];
    }
}
