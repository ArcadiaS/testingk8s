<?php

namespace App\Http\Requests;

use App\Rules\TCKN;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
    public function rules()
    {
        return [
            'tckn' => ['required','integer','min:11', new TCKN],
            'email' => 'required|email|unique:users,email',
            'name' => 'required|string|max:155',
            'surname' => 'required|string|max:155',
            'password' => 'required|confirmed|min:8',
            'birth_date' => 'required|date',
            'address' => 'nullable'
        ];
    }
}
