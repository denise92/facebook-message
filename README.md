# Laravel Facebook Message

> Laravel 5 Package for Facebook messenger-platform with Laravel.

> This is package for Laravel and Lumen 5.0, 5.1, 5.2, & 5.3

> **Note:** Before you start, you should follow Facebook message setup.

1. [Create an App and a Page](https://developers.facebook.com/docs/messenger-platform/guides/setup)

2. Have a https:// url.

## Installation

[PHP](https://php.net) 5.5.9+, and [Composer](https://getcomposer.org) are required.

Add the Laravel Facebook Message package.

Run:

```
composer require denise92/facebook-message
```

### Service Provider

In your app config, add the `FacebookMessageServiceProvider` to the providers array.

```php
'providers' => [
    Denise92\FacebookMessage\FacebookMessageServiceProvider::class,
    ];
```

For **Lumen**, add the provider to your `bootstrap/app.php` file.

```php
$app->register(Denise92\FacebookMessage\FacebookMessageServiceProvider::class);
```


### Configuration File

After [Create an App and a Page](https://developers.facebook.com/docs/messenger-platform/guides/setup), you'll need to provide the app ID, page ID and Access token. In Laravel you can publish the configuration file with `artisan`.

```bash
$ php artisan vendor:publish --provider="Denise92\FacebookMessage\FacebookMessageServiceProvider" --tag="config"
```

> **Where's the file?** Laravel 5 will publish the config file to `/config/facebook_message.php`.

In **Lumen** you'll need to manually copy the config file from `vendor/denise92/facebook-message/src/config/FacebookMessage.php`, and rename to `facebook_message.php` in your config folder. Lumen doesn't have a `/config` folder by default so you'll need to create it if you haven't already.

#### Required config values

You'll need to update the `fb_app_id`, `fb_page_id` and `fb_access_token` values in the config file with [your app ID, page ID and access token](https://developers.facebook.com/apps).

By default the configuration file will look to environment variables for your app ID and secret. It is recommended that you use environment variables to store this info in order to protect your app secret from attackers. Make sure to update your `/.env` file with your app ID & secret.

```
FB_APP_ID=1234567890
FB_PAGE_ID=987654321
FB_VERIFY_TOKEN=any-string-you-like
FB_ACCESS_TOKEN=YourPagesAccessToken
```


### How to setup webhook from Facebook:

Callback URL: https://your-web.com/fb/webhook

This url is defined in src/route.php, you can rewrite it if you like:

```
Route::get('test/webhook', '\Denise92\FacebookMessage\FacebookMessageController@webhook');
Route::post('test/webhook', '\Denise92\FacebookMessage\FacebookMessageController@conversation');
```

Verify Token: any-string-you-like

Subscription Fields: You can checked all.

Then press Save button. If Facebook get the verify code from https://your-web.com/fb/webhook, than you can start chat with your Pages message bot now.

