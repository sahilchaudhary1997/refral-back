<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AddAdminCourseVideosRequest extends FormRequest
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
            'course' => 'required|string',
            'title' => 'required|string|max:155',
            'videotype' => 'required',
            'description' => 'required|string|max:500',
            'coursevideo' => 'required',          
        ];
    }
    
    public function messages()
    {
        return [
            'course.required' => 'A course is required',
            'title.required' => 'A title is required',
            'videotype.required' => 'A video type is required',
            'description.required' => 'A description is required',
            'coursevideo.required' => 'A course video is required',
        ];
    }
}
