<?php

return [
    'url' => env(
        'TRUSTUP_IO_AUTH_URL', 
        env("TRUSTUP_IO_AUTHENTIFICATION_URL", 'https://auth.trustup.io')
    ),
    /**
     * Docker related config.
     * 
     * Define env variable TRUSTUP_IO_AUTH_DOCKER_ACTIVATED=1 to active docker integration.
     */
    'docker' => [
        'service' => "trustup-io-auth",
        "activated" => env("TRUSTUP_IO_AUTH_DOCKER_ACTIVATED", false)
    ]
];