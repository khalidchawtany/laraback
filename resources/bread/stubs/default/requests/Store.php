<?php

/* bread_request_namespace */

use App\Http\Requests\CustomFormRequest;

class Storebread_model_class extends CustomFormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [

            /* bread_rule_store */

        ];
    }
}



