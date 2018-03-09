<?php

// flash message to session
if (!function_exists('flash')) {
    function flash($class, $message)
    {
        request()->session()->flash('flash', [$class, $message]);
    }
}

// log activity in database
if (!function_exists('activity')) {
    function activity($log, $data = [], $model = null)
    {
        if (isset($data['_token'])) unset($data['_token']);
        if (isset($data['_method'])) unset($data['_method']);

        app(config('laraback.models.activity'))->create([
            'user_id' => auth()->check() ? auth()->user()->id : null,
            'model_id' => $model ? $model->id : null,
            'model_class' => $model ? get_class($model) : null,
            'data' => $data,
            'log' => $log,
        ]);
    }
}

// spit out nice list of timezones with offset
if (!function_exists('timezones')) {
    function timezones() {
        $timezones = [];

        foreach (timezone_identifiers_list() as $timezone) {
            $datetime = new \DateTime('now', new DateTimeZone($timezone));
            $timezones[] = [
                'sort' => str_replace(':', '', $datetime->format('P')),
                'name' => $timezone,
                'label' => '(UTC '.$datetime->format('P').') '.str_replace('_', ' ', implode(', ', explode('/', $timezone))),
            ];
        }

        usort($timezones, function($a, $b) {
            return $a['sort'] - $b['sort'] ?: strcmp($a['name'], $b['name']);
        });

        return json_decode(json_encode($timezones));
    }
}