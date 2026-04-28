<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => 'required',
        ];
    }
    public function messages(): array
    {
        return [
            'email.required' => ':attributeを入力してください',
            'email.email' => ':attributeが正しくありません',
            'password.required' => ':attributeを入力してください',
        ];
    }
    public function authenticate(): void
    {
        if (!Auth::attempt($this->only(['email', 'password']))){
            throw validationException::withMessages(['failed' => __('auth.failed')]);
        }
    }
}
