<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
             
              'name'=>'required|string',
              'email'=>'required|string|unique:employees|max:255',
              'position'=>'required|string',
              'project_id' => 'required|integer'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'name.min' => 'Name must not be less than 3 characters.',
            "email.required" => "Email is required",
            "email.unique" => "Email is already taken",
            "position.required" => "position is required",
            "project_id.required" => "Project id is required"
        ];
    }
}
