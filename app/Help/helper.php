<?php
use  App\Models\Settings;
function setting($settingKey, $locale = null)
{

    $setting =Settings::where('key', $settingKey)->first();

    if ($setting) {
        return $setting->value;
    } else {
        return 'Setting not found';
    }
}
