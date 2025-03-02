<?php

namespace bread_model_namespace\Models;

use Illuminate\Support\Facades\Queue;
use Jacob\Logbook\Traits\LogChanges;
use Lovata\Toolbox\Traits\Helpers\TraitCached;
use Model;
use October\Rain\Database\Traits\Purgeable;
use October\Rain\Database\Traits\Validation;

/**
 * Class bread_model_class
 *
 * @mixin \October\Rain\Database\Builder
 * @mixin \Eloquent
 *
 * @property int $id
 * @property \October\Rain\Argon\Argon $created_at
 * @property \October\Rain\Argon\Argon $updated_at
 */
class bread_model_class extends Model
{
    use LogChanges;
    use Purgeable;
    use TraitCached;
    use Validation;

    /** @var string */
    public $table = 'bread_table_name';

    /** @var array */
    public $implement = [
        '@RainLab.Translate.Behaviors.TranslatableModel',
        '@Lox.Coc.Classes.Behaviors.TrackableModel',
    ];

    /** @var array */
    public $translatable = [];

    /**
     * @var array List of attributes to purge.
     */
    protected $purgeable = [];

    /** @var array */
    public $attributeNames = [];

    /** @var array */
    public $rules = [

        // 'date' => 'required|date',
        // 'number' => 'nullable',
    ];

    public $customMessages = [
        'required' => 'The :attribute field is required.',
    ];

    /** @var array */
    public $slugs = [];

    /** @var array */
    public $jsonable = [];

    /** @var array */
    public $fillable = [
    "/* bread_fillable */"
    ];

    /** @var array */
    public $cached = [];

    /** @var array */
    public $dates = [
        'created_at',
        'updated_at',
    ];

    /** @var array */
    public $casts = [
        'created_at' => 'date',
        'updated_at' => 'date',
    ];

    /** @var array */
    public $visible = [];

    /** @var array */
    public $hidden = [];

    /** @var array */
    public $hasOne = [];

    /** @var array */
    public $hasMany = [];

    /** @var array */
    public $belongsTo = [];

    /** @var array */
    public $hasOneThrough = [];

    /** @var array */
    public $belongsToMany = [];

    /** @var array */
    public $morphTo = [];

    /** @var array */
    public $morphOne = [];

    /** @var array */
    public $morphMany = [];

    /** @var array */
    public $attachOne = [];

    /** @var array */
    public $attachMany = [];

    /** @var array fields to ignore */
    protected $ignoreFieldsLogbook = [
        'updated_at',
    ];

    public $logBookModelName = 'bread_model_class';

}
