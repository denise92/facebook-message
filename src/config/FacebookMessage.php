<?php

return [
    'fb_app_id' => env('FB_APP_ID'),
    'fb_page_id' => env('FB_PAGE_ID'),
    'fb_verify_token' => env('FB_VERIFY_TOKEN', 'facebook_message_bot'),
    'fb_access_token' => env('FB_ACCESS_TOKEN'),
    'default_reply' => 'Hello world!',
    'conversation' => [
        'Hi' => 'Hello.',
        'Hello' => 'How are you.',
        'help' => 'May I help you?',
    ],
];