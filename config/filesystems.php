<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application for file storage.
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Below you may configure as many filesystem disks as necessary, and you
    | may even configure multiple disks for the same driver. Examples for
    | most supported storage drivers are configured here for reference.
    |
    | Supported drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'throw' => false,
        ],

        'uploads' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL') . '/uploads',
            'visibility' => 'public',
            'throw' => true,
        ],

        'internal' => [
            'driver' => 'local',
            'root' => storage_path('app/private'),
            'url' => env('APP_URL') . '/internal',
            'visibility' => 'private',
            'throw' => true,
        ],

        'pegawai' => [
            'driver' => 'local',
            'root' => '../../central_assets/pegawai',
            'url' => env('URL_ASSET_CENTRAL') . 'pegawai/',
            'visibility' => 'public',
            'throw' => true,
        ],

        'central' => [
            'driver' => 'local',
            'root' => '../../central_assets/uploads',
            'url' => env('URL_ASSET_CENTRAL') . 'uploads/',
            'visibility' => 'public',
            'throw' => true,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('uploads') => storage_path('app/public'),
        public_path('internal') => storage_path('app/private'),
    ],

    'assets' => [
        'uploads' => env('APP_URL') . '/uploads/',
        'central' => env('URL_ASSET_CENTRAL'),
    ],

];
