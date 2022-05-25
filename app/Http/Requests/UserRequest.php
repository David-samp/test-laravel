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
     * @return array
     */
    public function rules()
    {
        $userId = $this->user ? $this->user->id : null;
        return [
            'email' => 'required|email|max:100|unique:users,email,' . $userId,
            'first_name' => 'max:100|string|nullable',
            'last_name' => 'max:100|string|nullable',
            'roles'=>'required|array'
        ];
    }
}
