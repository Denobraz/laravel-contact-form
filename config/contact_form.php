<?php

return [
    'save_contact_forms' => false,
    'save_cookies' => true,
    'save_ip' => true,
    'save_user_agent' => true,
    'save_referer' => true,

    'types' => [
        /**
        'default' => [
            'data' => [
                'name' => 'string|required',
                'email' => 'string|required|email',
                'phone' => 'string|nullable',
                'message' => 'string|nullable',
            ],
            'messages' => [
                'name.required' => 'Name is required',
            ],
            'attributes' => [
                'name' => 'Name',
                'email' => 'Email',
                'phone' => 'Phone',
                'message' => 'Message',
            ],
            'callbacks' => [
                Denobraz\LaravelContactForm\Callbacks\DummyContactFormCallback::class,
            ]
        ]
         **/
    ]
];
