<?php

/* bread_model_namespace */

use App\Models\User;
use App\Models\BaseModel;

class bread_model_class extends BaseModel
{

    protected $fillable = ["/* bread_fillable */"];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
