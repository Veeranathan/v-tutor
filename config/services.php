<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */
    'stripe' => [
        'stripe-secret' => env('STRIPE_SECRET'),
        'stripe-publishable' => env('STRIPE_PUBLISHABLE'),
    ],
    'zoom' => [
        'base_url' => env('ZOOM_BASE_URL', 'https://api.zoom.us/v2'),
        'account_id' => env('ZOOM_ACCOUNT_ID'),
        'client_id' => env('ZOOM_CLIENT_ID'),
        'client_secret' => env('ZOOM_CLIENT_SECRET'),
    ],
    'microsoft' => [
        'client_id' => env('MICROSOFT_CLIENT_ID'),
        'client_secret' => env('MICROSOFT_CLIENT_SECRET'),
        'redirect' => env('MICROSOFT_REDIRECT_URI'),
        'tenant' => env('MICROSOFT_TENANT_ID'),
        'proxy' => env('PROXY'),
        // Drive integration keys
        'ms_client_id' => env('MS_CLIENT_ID'),
        'ms_client_secret' => env('MS_CLIENT_SECRET'),
        'ms_tenant_id' => env('MS_TENANT_ID'),
        'ms_site_id' => env('MS_SITE_ID'),
        'ms_drive_id' => env('MS_DRIVE_ID'),
    ],
    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],
    'firebase' => [
        'api_key' => env('FIREBASE_API_KEY'),
        'auth_domain' => env('FIREBASE_AUTH_DOMAIN'),
        'project_id' => env('FIREBASE_PROJECT_ID'),
        'storage_bucket' => env('FIREBASE_STORAGE_BUCKET'),
        'messaging_sender_id' => env('FIREBASE_MESSAGING_SENDER_ID'),
        'app_id' => env('FIREBASE_APP_ID'),
        'vapid_key' => env('FIREBASE_VAPID_KEY'),
        'file' => env('FIREBASE_CREDENTIALS'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'addressr' => [
        'key' => env('ADDRESSR_RAPIDAPI_KEY'),
        'host' => env('ADDRESSR_RAPIDAPI_HOST'),
    ],
    'zoho' => [
        'client_id'     => env('ZOHO_CLIENT_ID'),
        'client_secret' => env('ZOHO_CLIENT_SECRET'),
        'redirect_uri'  => env('ZOHO_REDIRECT_URI'),
        'accounts_base' => env('ZOHO_ACCOUNTS_BASE'),
        'desk_base'     => env('ZOHO_DESK_BASE'),
        'org_id'        => env('ZOHO_ORG_ID'),
        'default_department_id' => env('ZOHO_DEFAULT_DEPARTMENT_ID'),
    ],

    'addressr' => [
        'key' => env('ADDRESSR_RAPIDAPI_KEY'),
        'host' => env('ADDRESSR_RAPIDAPI_HOST'),
    ],
    'zoho' => [
        'client_id'     => env('ZOHO_CLIENT_ID'),
        'client_secret' => env('ZOHO_CLIENT_SECRET'),
        'redirect_uri'  => env('ZOHO_REDIRECT_URI'),
        'accounts_base' => env('ZOHO_ACCOUNTS_BASE'),
        'desk_base'     => env('ZOHO_DESK_BASE'),
        'org_id'        => env('ZOHO_ORG_ID'),
        'default_department_id' => env('ZOHO_DEFAULT_DEPARTMENT_ID'),
    ],
    'daily' => [
        'key' => env('DAILY_API_KEY'),
        'domain' => env('DAILY_DOMAIN'),
    ],

];
