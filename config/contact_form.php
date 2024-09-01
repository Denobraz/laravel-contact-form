<?php

return [
    'save_contact_forms' => false,
    'save_cookies' => true,
    'save_ip' => true,
    'save_user_agent' => true,
    'save_referer' => true,

    'types' => [
        'default' => [
            'data' => [
                'name' => 'string|required',
                'email' => 'string|required|email',
                'phone' => 'string|nullable',
                'message' => 'string|nullable',
            ],
            'messages' => [
                // If you want to override the default message for some field
                // 'name.required' => 'Name is required',
            ],
            'attributes' => [
                // If you want to override the default attribute name for some field
                // 'name' => 'Name',
            ],
            'callbacks' => [
                Denobraz\LaravelContactForm\Callbacks\DummyContactFormCallback::class,
            ]
        ]
    ]
];
