<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|min:2|max:60',
            'email' => 'required|email',
            'phone' => 'required|regex:/^\+380\d{3}\d{2}\d{2}\d{2}$/',
            'position_id' => 'integer',
            'photo' => 'mimes:jpeg,jpg|max:5048'
        ];
    }

    public function messages() {

        return [
            'name.required' => 'Вы не ввели имя',
            'name.min' => 'Вы ввели слишком короткое имя',
            'name.max' => 'Вы ввели слишком длинное имя',
            'email.required' => 'Вы не ввели Email',
            'email.email' => 'Не похоже на Email',
            'phone.required' => 'Вы не ввели телефон',
            'phone.regex' => 'Не похоже на Телефон',
            'photo.mimes' => 'Фотография должна быть формата jpg/jpeg',
            'photo.max' => 'Максимальный размер фотографии 5MB',
        ];
    }
}
