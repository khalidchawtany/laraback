<?php

/* bread_model_namespace */

use Illuminate\Database\Eloquent\Model;
use Kjdion84\Laraback\Traits\Timezone;

class bread_model_class extends Model
{
    use Timezone;

    protected $fillable = ["/* bread_fillable */"];
}