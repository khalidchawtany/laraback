<?php

namespace Kjdion84\Laraback\Traits;

trait LarabackUser
{
    // roles relationship
    public function roles()
    {
        return $this->belongsToMany(config('laraback.models.role'));
    }

    // activities relationship
    public function activities()
    {
        return $this->hasMany(config('laraback.models.activity'));
    }

    // gate permissions
    public function hasPermission($name)
    {
        // admin role always has permission
        if ($this->roles->contains('name', 'Admin')) {
            return true;
        }

        // user permissions are role-based
        $permission = app(config('laraback.models.permission'))->where('name', $name)->first();

        if ($permission) {
            return $permission->roles->intersect($this->roles)->count() > 0;
        }

        return false;
    }
}