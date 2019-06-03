<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NominaRequest extends FormRequest
{
    /**
     * NominaRequest constructor.
     */
    public function __construct(Route $route)
    {
        $this->route = $route;
    }


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
        $id = $this->route->parameter ('user');
        return [
            'persona_mes' => Rule::unique('nomina_directa', 'persona_mes')->ignore($id)
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'persona_mes.unique' => 'registro duplicado',
        ];
    }
}
