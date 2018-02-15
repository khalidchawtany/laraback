<?php

namespace Kjdion84\Laraback\Models;

use Illuminate\Database\Eloquent\Model;
use Kjdion84\Laraback\Traits\Timezone;

class Permission extends Model
{
    use Timezone;

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