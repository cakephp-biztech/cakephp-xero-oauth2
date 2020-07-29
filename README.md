# Xero OAuth2 API plugin for CakePHP 3.x

[![Latest Stable Version](https://poser.pugx.org/ishan-biztech/cakephp-xero-oauth2/v)](//packagist.org/packages/ishan-biztech/cakephp-xero-oauth2)
[![Total Downloads](https://poser.pugx.org/ishan-biztech/cakephp-xero-oauth2/downloads)](//packagist.org/packages/ishan-biztech/cakephp-xero-oauth2)
[![License](https://poser.pugx.org/ishan-biztech/cakephp-xero-oauth2/license)](//packagist.org/packages/ishan-biztech/cakephp-xero-oauth2)
[![Latest Unstable Version](https://poser.pugx.org/ishan-biztech/cakephp-xero-oauth2/v/unstable)](//packagist.org/packages/ishan-biztech/cakephp-xero-oauth2)

This plugin provides access to Xero OAuth2 API for [CakePHP](https://cakephp.org/). This plugin is wrapper around [Xero PHP official SDK](https://github.com/XeroAPI/xero-php-oauth2/).

## Requirements

- CakePHP 3.5 or greater
- PHP 5.6 or greater

## Installation

1. You can install this plugin into your CakePHP application using [composer](https://getcomposer.org)
    ```
    composer require ishan-biztech/cakephp-xero-oauth2
    ```

2. After installation, [load the plugin](https://book.cakephp.org/3/en/plugins.html#loading-a-plugin)
    ```php
    Plugin::load('XeroOauth2', ['routes' => true]);
    ```
    Or, you can load the plugin using the shell command:
    ```
    bin/cake plugin load -r XeroOauth2
    ```
3. Run plugin migration to create table
    ```
   bin/cake migrations migrate -p XeroOauth2
   ```

## Setup
Now create new file to set your Xero App details.

Create new file `xero_config.php` in `config` directory:

```php
<?php

/**
 * Do not forget to replace "https://example.com" with your website URL
 */
return [
    'XeroOauth2' => [
        'clientId' => 'your-client-id',
        'clientSecret' => 'your-client-secret',
        'baseUri' => 'https://example.com',
        'scope' => [
            'openid',
            'email',
            'profile',
            'offline_access',
            'accounting.settings',
            'accounting.contacts',
            // Any other scopes needed for your application goes here
        ],
        // Must end with `/success` so do not remove it while replacing it with your website URL
        'successUrl' => 'http://example.com/success'
    ]
];
```

After creating the configuration file, make sure to load the file in your `bootstrap.php` using `Configure::load('xero_config', 'default');`.

**Important:**

When you create your Xero API App you must have to specify 'OAuth 2.0 redirect URI' to https://your-website.com/xero-oauth2/callback (replace "https://your-website.com" with your website URL).

## Usage

This plugin ships with `XeroOauth` component which can be used to get the instance of:
- `\XeroAPI\XeroPHP\Api\AccountingApi` via `accountingApi()` method
- `\XeroAPI\XeroPHP\Api\AssetApi` via `assetApi()` method
- `\XeroAPI\XeroPHP\Api\IdentityApi` via `identityApi()` method
- `\XeroAPI\XeroPHP\Api\ProjectApi` via `projectApi()` method

#### Load `XeroOauth` component:

```php
$this->loadComponent('XeroOauth2.XeroOauth');
$accountingApi = $this->XeroOauth->accountingApi();
```

Once you have an instance of `\XeroAPI\XeroPHP\Api\AccountingApi::class` you're dealing directly with Xero's official SDK.

The Accounting API requires we pass through a tenant ID on each request. You can get value of that using `Storage` component. Also, you can get additional token details from this component as well.

```php
$this->loadComponent('XeroOauth2.Storage');
$tenantId = $this->Storage->getXeroTenantId();
```

Following examples shows how to get contacts from Accounting API:

_**src/Controller/ContactsController.php**_
```php
<?php
namespace App\Controller;

class ContactsController extends AppController
{
    public function index()
    {
        $this->loadComponent('XeroOauth2.Storage');
        $this->loadComponent('XeroOauth2.XeroOauth');

        $tenantId = $this->Storage->getXeroTenantId();
        $accountingApi = $this->XeroOauth->accountingApi();

        foreach ($accountingApi->getContacts($tenantId)->getContacts() as $contact) {
            debug([
                'id' => $contact->getContactId(),
                'name' => $contact->getName(),
                'email' => $contact->getEmailAddress(),
            ]);
        }
    }
}
```

You can also check XeroAPI Oauth2 App repository's [example file](https://github.com/XeroAPI/xero-php-oauth2-app/blob/master/example.php).

## Reference
- Official Xero PHP SDK: https://github.com/XeroAPI/xero-php-oauth2
- Example: https://github.com/XeroAPI/xero-php-oauth2-app/blob/master/example.php

## Issues
Feel free to submit issues and enhancement requests.
