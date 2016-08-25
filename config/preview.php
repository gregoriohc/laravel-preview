<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Force enable
    |--------------------------------------------------------------------------
    |
    | The preview route is only enabled if the app is in debug mode and
    | in local environment. Use this option to override that behaviour.
    |
    */

    'force_enable' => env('PREVIEW_FORCE_ENABLE', false),

];