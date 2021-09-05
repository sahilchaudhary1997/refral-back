<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminAdvisoryNotificationRequest extends FormRequest
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
           // 'section' => 'required|string|max:155',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
           // 'stoploss' => 'numeric',
            //'target' => 'numeric'    
        ];
    }
	
	public function messages()
    {
        return [
            //'section.required' => 'A Section is required.',
            'quantity.required'  => 'A quantity is required.',
            'quantity.numeric'  => 'The quantity must be a number.',
            'price.required'  => 'A price is required.',
            'price.numeric'  => 'The price must be a number.',
            //'stoploss.numeric'  => 'The stop loss must be a number.',
           // 'target.numeric'  => 'The target must be a number.',    
        ];
    }
}
