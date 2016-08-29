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

    'force_enable' => false,

    /*
    |--------------------------------------------------------------------------
    | Route
    |--------------------------------------------------------------------------
    |
    | The preview route path
    |
    */

    'route' => '_preview',

    /*
    |--------------------------------------------------------------------------
    | Middleware
    |--------------------------------------------------------------------------
    |
    | The route middleware applied to the preview route
    |
    */

    'middleware' => ['web'],

];
