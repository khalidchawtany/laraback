<?php

namespace Kjdion84\Laraback\Traits;

use Carbon\Carbon;

trait Timezone
{
    public function getCreatedAtAttribute($value)
    {
        return $this->timezone($value);
    }

    public function getUpdatedAtAttribute($value)
    {
        return $this->timezone($value);
    }

    public function getDeletedAtAttribute($value)
    {
        return $this->timezone($value);
    }

    // convert date to user timezone
    public function timezone($value)
    {
        $carbon = Carbon::parse($value);

        if (auth()->check() && auth()->user()->timezone) {
            $carbon->tz(auth()->user()->timezone);
        }

        return $carbon->toDateTimeString();
    }
}