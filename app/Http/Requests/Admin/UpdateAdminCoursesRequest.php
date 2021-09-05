<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminCoursesRequest extends FormRequest
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
            'title' => 'required|string|max:155',
            'moduletype' => 'required',
            'leveltype' => 'required',
            'markets' => 'required',
            //'category' => 'required',
			'indiafees' => 'required|numeric',
            'worldfees' => 'required|numeric',
			'courseduration' => 'required|numeric',
        ];
    }
	
	public function messages()
    {
        return [
            'title.required' => 'A title is required.',
            'moduletype.required'  => 'A module is required.',
            'leveltype.required'  => 'A level is required.',
            'markets.required'  => 'A market is required.',
           // 'category.required'  => 'A category is required.',
            'indiafees.required'  => 'A india fees is required.',
            'indiafees.numeric'  => 'The india fees must be a number.',
            'worldfees.required'  => 'A world fees is required.',
            'worldfees.numeric'  => 'The world fees must be a number.',
			'courseduration.required'  => 'A course duration is required',
			'courseduration.numeric'  => 'The course duration must be a number.',
        ];
    }
}
