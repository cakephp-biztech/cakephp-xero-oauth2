<?php

namespace XeroOauth2\Controller\Component;

use Cake\Controller\Component;
use Cake\Core\Configure;
use GuzzleHttp\Client as ClientAlias;
use League\OAuth2\Client\Provider\GenericProvider;
use XeroAPI\XeroPHP\Api\AccountingApi;
use XeroAPI\XeroPHP\Api\AssetApi;
use XeroAPI\XeroPHP\Api\IdentityApi;
use XeroAPI\XeroPHP\Api\ProjectApi;
use XeroAPI\XeroPHP\Configuration;
use XeroOauth2\Error\EmptyTokenException;

/**
 * XeroOauth component
 *
 * @property \XeroOauth2\Controller\Component\StorageComponent $Storage
 */
class XeroOauthComponent extends Component
{
    /**
     * Configurations array.
     *
     * @var array
     */
    protected $_defaultConfig = [
        'callbackRoute' => '/xero-oauth2/callback',
        'urlAuthorize' => 'https://login.xero.com/identity/connect/authorize',
        'urlAccessToken' => 'https://identity.xero.com/connect/token',
        'urlResourceOwnerDetails' => 'https://api.xero.com/api.xro/2.0/Organisation',
    ];

    /**
     * Other Components this component uses.
     *
     * @var array
     */
    public $components = ['XeroOauth2.Storage'];

    /**
     * Returns instance of generic provider.
     *
     * @return \League\OAuth2\Client\Provider\GenericProvider
     */
    public function getProvider()
    {
        $config = $this->getConfigurations();

        return new GenericProvider([
            'clientId' => $config['clientId'],
            'clientSecret' => $config['clientSecret'],
            'redirectUri' => $config['redirectUri'],
            'urlAuthorize' => $config['urlAuthorize'],
            'urlAccessToken' => $config['urlAccessToken'],
            'urlResourceOwnerDetails' => $config['urlResourceOwnerDetails'],
        ]);
    }

    /**
     * Returns configurations to use in provider.
     *
     * @return array
     */
    public function getConfigurations()
    {
        return [
            'clientId' => Configure::read('XeroOauth2.clientId'),
            'clientSecret' => Configure::read('XeroOauth2.clientSecret'),
            'redirectUri' => Configure::read('XeroOauth2.baseUri') . $this->getConfig('callbackRoute'),
            'urlAuthorize' => $this->getConfig('urlAuthorize'),
            'urlAccessToken' => $this->getConfig('urlAccessToken'),
            'urlResourceOwnerDetails' => $this->getConfig('urlResourceOwnerDetails'),
            'scope' => implode(' ', Configure::read('scope')),
        ];
    }

    /**
     * Returns tokens details from storage if is not expired,
     * regenerates access token from refresh token if expired,
     * redirects to `/xero-oauth2/authorization` if token details does not exists in storage,
     *
     * @return \Cake\Http\Response|array
     * @throws \League\OAuth2\Client\Provider\Exception\IdentityProviderException
     */
    protected function getDetails()
    {
        $tokenDetails = $this->Storage->tokenDetails();

        // Generate tokens
        if (empty($tokenDetails)) {
            throw new EmptyTokenException(
                'No tokens found, generate oauth tokens by visiting `/xero-oauth2/authorize` url'
            );
        }

        // Regenerate tokens from refresh token
        if ($this->Storage->isExpired()) {
            $newAccessToken = $this->getProvider()->getAccessToken('refresh_token', [
                'refresh_token' => $this->Storage->getRefreshToken()
            ]);

            // Save newly generated token details into storage
            $tokenDetails = $this->Storage->updateToken(
                $newAccessToken->getToken(),
                $tokenDetails['tenant_id'],
                $newAccessToken->getRefreshToken(),
                $newAccessToken->getValues()['id_token'],
                $newAccessToken->getExpires()
            );
        }

        return $tokenDetails;
    }

    /**
     * Returns instance of `\XeroAPI\XeroPHP\Api\AccountingApi` object.
     *
     * @return \XeroAPI\XeroPHP\Api\AccountingApi
     * @throws \League\OAuth2\Client\Provider\Exception\IdentityProviderException
     */
    public function accountingApi()
    {
        $tokenDetails = $this->getDetails();

        return new AccountingApi(
            new ClientAlias(),
            Configuration::getDefaultConfiguration()->setAccessToken($tokenDetails['access_token'])
        );
    }

    /**
     * Returns instance of `\XeroAPI\XeroPHP\Api\AssetApi` object.
     *
     * @return \XeroAPI\XeroPHP\Api\AssetApi
     * @throws \League\OAuth2\Client\Provider\Exception\IdentityProviderException
     */
    public function assetApi()
    {
        $tokenDetails = $this->getDetails();

        return new AssetApi(
            new ClientAlias(),
            Configuration::getDefaultConfiguration()->setAccessToken($tokenDetails['access_token'])
        );
    }

    /**
     * Returns instance of `\XeroAPI\XeroPHP\Api\IdentityApi` object.
     *
     * @return \XeroAPI\XeroPHP\Api\IdentityApi
     * @throws \League\OAuth2\Client\Provider\Exception\IdentityProviderException
     */
    public function identityApi()
    {
        $tokenDetails = $this->getDetails();

        return new IdentityApi(
            new ClientAlias(),
            Configuration::getDefaultConfiguration()->setAccessToken($tokenDetails['access_token'])
        );
    }

    /**
     * Returns instance of `\XeroAPI\XeroPHP\Api\ProjectApi` object.
     *
     * @return \XeroAPI\XeroPHP\Api\ProjectApi
     * @throws \League\OAuth2\Client\Provider\Exception\IdentityProviderException
     */
    public function projectApi()
    {
        $tokenDetails = $this->getDetails();

        return new ProjectApi(
            new ClientAlias(),
            Configuration::getDefaultConfiguration()->setAccessToken($tokenDetails['access_token'])
        );
    }
}
