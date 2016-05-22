<?php

namespace CodeDelivery\Http\Requests;

use CodeDelivery\Http\Requests\Request;

class AdminClientRequest extends Request
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
            'user.name' => 'required|min:3',
            'user.email' => 'required',
            'phone' => 'required|min:8',
            'address' => 'required|min:3',
            'city' => 'required|min:3',
            'state' => 'required|min:3',
            'zipcode' => 'required|min:5'
        ];
    }
}
