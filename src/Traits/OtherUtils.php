<?php

namespace Kjdion84\Laraback\Traits;

trait OtherUtils
{
    public function hasAnyFlagSet()
    {
        foreach ($this->options() as $option) {
            if ($option == true) {
                return true;
            }
        }

        return false;
    }

    public function userWants($key)
    {
        $queryCommand = $this->hasAnyFlagSet();

        return $this->option($key) || ! $queryCommand && $this->confirm($key.' ?');
    }
}
