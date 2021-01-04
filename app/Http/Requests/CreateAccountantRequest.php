<?php

namespace Vanguard\Http\Requests;

use Vanguard\Http\Requests\Request;
use Vanguard\User;

class CreateAccountantRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'email' => 'required|email|unique:users,email',
            'username' => 'nullable',
            'password' => 'required|min:6|confirmed',
            'birthday' => 'nullable|date',
            'verified' => 'boolean'
        ];

        if ($this->get('country_id')) {
            $rules += ['country_id' => 'exists:countries,id'];
        }

        return $rules;
    }
}
