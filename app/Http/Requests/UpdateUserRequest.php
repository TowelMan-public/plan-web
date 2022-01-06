<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        $rules = [
            'userName' => 'required|max:100',
            'userNickName' => 'required|max:100',
        ];

        $password = $this->all()['password'];
        if($password !== null){
            $rules += [
                'password' => 'required|max:100',
                'oneMorePassword' => 'required|max:100|same:password',
            ];
        }

        return $rules;
    }
}