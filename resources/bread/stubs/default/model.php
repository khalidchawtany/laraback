<?php

/* bread_model_namespace */

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class bread_model_class extends Model
{
    use LogsActivity;

    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;

    protected $fillable = ["/* bread_fillable */"];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
