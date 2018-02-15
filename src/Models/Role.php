<?php

namespace Kjdion84\Laraback\Models;

use Illuminate\Database\Eloquent\Model;
use Kjdion84\Laraback\Traits\Timezone;

class Role extends Model
{
    use Timezone;

    protected $fillable = ['name'];

    // permissions relationship
    public function permissions()
    {
        return $this->belongsToMany(config('laraback.models.permission'));
    }
}