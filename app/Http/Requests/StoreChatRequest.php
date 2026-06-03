<?php

namespace App\Http\Requests;

use Faker\Guesser\Name;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StoreChatRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'nullable|string|max:100',
            'title' => 'nullable|string|max:100',
            'is_group' => 'required|boolean',
            'recipients' => 'required|array',
            'recipients.*' => 'integer|exists:users,id',
            'message' => 'required|string|max:500',
        ];
    }

    public function messages()
    {
        return [
            'name.string' => 'El campo title debe ser una cadena de texto.',
            'name.max' => 'El campo title no debe exceder los 100 caracteres.',
            'title.string' => 'El campo title debe ser una cadena de texto.',
            'title.max' => 'El campo title no debe exceder los 100 caracteres.',
            'is_group.required' => 'El campo is_group es obligatorio.',
            'is_group.boolean' => 'El campo is_group debe ser un valor booleano.',
            'recipients.required' => 'El campo recipients es obligatorio.',
            'recipients.array' => 'El campo recipients debe ser un array.',
            'recipients.*.integer' => 'Cada elemento en recipients debe ser un entero.',
            'recipients.*.exists' => 'Un usuario en recipients no existe.',
            'message.required' => 'El campo message es obligatorio.',
            'message.string' => 'El campo message debe ser una cadena de texto.',
            'message.max' => 'El campo message no debe exceder los 500 caracteres.',
        ];
    }
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->badRequest('Validation Failure', $validator->errors()));
    }

}
