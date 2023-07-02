<?php

/* bread_request_namespace */

use App\Http\Requests\CustomFormRequest;

class Updatebread_model_class extends CustomFormRequest
{
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

            'id' => 'bail|required',
            /* bread_rule_update */

        ];
    }
}


