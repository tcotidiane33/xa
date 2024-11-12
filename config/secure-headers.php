<?php
return [
    'csp' => [
        'script-src' => [
            'self' => true,
            'https://www.google.com/recaptcha/',
            'https://www.gstatic.com/recaptcha/',
        ],
        'frame-src' => [
            'self' => true,
            'https://www.google.com/recaptcha/',
        ],
        'img-src' => [
            'self' => true,
            'data' => true,
        ],
    ],
    // Autres configurations...
];