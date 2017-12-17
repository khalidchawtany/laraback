<?php

namespace Kjdion84\Laraback\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name'];

    // permissions relationship
    public function permissions()
    {
        return $this->belongsToMany(config('laraback.models.permission'));
    }
}