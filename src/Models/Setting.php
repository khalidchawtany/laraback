<?php

namespace Kjdion84\Laraback\Models;

use Illuminate\Database\Eloquent\Model;
use Kjdion84\Laraback\Traits\Timezone;

class Setting extends Model
{
    use Timezone;

    protected $fillable = ['key', 'value'];
}