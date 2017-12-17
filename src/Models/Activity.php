<?php

namespace Kjdion84\Laraback\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = ['user_id', 'model_id', 'model_class', 'data', 'log'];
    protected $casts = ['data' => 'json'];

    // user relationship
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}