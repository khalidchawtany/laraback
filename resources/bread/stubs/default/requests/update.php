<?php

/* bread_request_namespace */

use App\Helpers\CustomFormRequest;

class Updatebread_model_class extends CustomFormRequest
{
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

            'id' => 'bail|required',
            /* bread_rule_update */

        ];
    }
}


