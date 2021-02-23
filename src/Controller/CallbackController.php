<?php

namespace XeroOauth2\Controller;

use Cake\Core\Configure;
use GuzzleHttp\Client;
use XeroAPI\XeroPHP\Api\IdentityApi;
use XeroAPI\XeroPHP\Configuration;
use XeroOauth2\Error\InvalidStateException;
use XeroOauth2\Error\MissingAuthorizationCodeException;

/**
 * Callback Controller
 *
 * @property \XeroOauth2\Controller\Component\StorageComponent $Storage
 */
class CallbackController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     * @throws \XeroAPI\XeroPHP\ApiException
     * @throws \League\OAuth2\Client\Provider\Exception\IdentityProviderException
     * @throws \XeroOauth2\Error\MissingAuthorizationCodeException
     * @throws \XeroOauth2\Error\InvalidStateException
     * @throws \Exception
     */
    public function index()
    {
        $provider = $this->XeroOauth->getProvider();
        $queryParams = $this->request->getQuery();

        if (!isset($queryParams['code'])) { // If we don't have an authorization code then get one
            throw new MissingAuthorizationCodeException('Something went wrong, no authorization code found');
        } elseif (empty($queryParams['state']) || ($queryParams['state'] !== $this->_session->read('oauth2state'))) {
            // Check given state against previously stored one to mitigate CSRF attack
            $this->_session->delete('oauth2state');

            throw new InvalidStateException('Invalid state');
        }

        // Try to get an access token using the authorization code grant.
        $accessToken = $provider->getAccessToken('authorization_code', [
            'code' => $queryParams['code']
        ]);

        $config = Configuration::getDefaultConfiguration()->setAccessToken((string)$accessToken->getToken());
        $identityApi = new IdentityApi(
            new Client(),
            $config
        );

        $result = $identityApi->getConnections();

        // Store token details
        $this->loadComponent('XeroOauth2.Storage');

        if ($this->Storage->getAccessToken() === null) {
            $this->Storage->updateToken(
                $accessToken->getToken(),
                $result[0]->getTenantId(),
                $accessToken->getRefreshToken(),
                $accessToken->getValues()['id_token'],
                $accessToken->getExpires()
            );

            return $this->redirect(Configure::read('XeroOauth2.successUrl'));
        }

        $this->Storage->setToken(
            $accessToken->getToken(),
            $result[0]->getTenantId(),
            $accessToken->getRefreshToken(),
            $accessToken->getValues()['id_token'],
            $accessToken->getExpires()
        );

        return $this->redirect(Configure::read('XeroOauth2.successUrl'));
    }
}
