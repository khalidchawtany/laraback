<?php

namespace Kjdion84\Laraback\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = ['group', 'name'];

    // create group
    public function createGroup($group, $names = [])
    {
        foreach ($names as $name) {
            $this->create([
                'group' => $group,
                'name' => $name,
            ]);
        }
    }

    // roles relationship
    public function roles()
    {
        return $this->belongsToMany(config('laraback.models.role'));
    }
}