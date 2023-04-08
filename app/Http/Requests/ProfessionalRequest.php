<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProfessionalRequest extends FormRequest
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
            'name' => 'required|max:50',
			'email' => 'required|email|max:255|unique:users',
			'password' => 'required|max:50',
			'confirm_password' => 'required|same:password',
			'business' => 'required',
			'phone' => 'required|numeric',
			'address' => 'required',
			'city' => 'required',
			'postcode' => 'required|regex:/^(?!.*[DFIOQU])[A-VXY][0-9][A-Z] +?[0-9][A-Z][0-9]/',
			
			
        ];
    }
}
