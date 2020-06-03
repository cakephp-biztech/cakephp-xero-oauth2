<?php

namespace XeroOauth2\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

/**
 * Storage component
 */
class StorageComponent extends Component
{
    /**
     * Table object.
     *
     * @var null|\XeroOauth2\Model\Table\XeroOauthTokensTable
     */
    protected $_table = null;

    /**
     * {@inheritDoc}
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->_table = TableRegistry::getTableLocator()->get('XeroOauth2.XeroOauthTokens');
    }

    /**
     * Returns `oauth2` session data from storage.
     *
     * @return array
     */
    public function tokenDetails()
    {
        return $this->_table->getTokenDetails();
    }

    /**
     * Set token details into storage.
     *
     * @param string $token Access token.
     * @param null|string $tenantId Tenant id.
     * @param string $refreshToken Refresh token.
     * @param string $idToken Id token value.
     * @param int|null $expires Expiration timestamp.
     * @return array
     */
    public function setToken($token, $tenantId, $refreshToken, $idToken, $expires = null)
    {
        return $this->_table->storeXeroTokens([
            'access_token' => $token,
            'tenant_id' => $tenantId,
            'refresh_token' => $refreshToken,
            'id_token' => $idToken,
            'expires_at' => $expires,
        ]);
    }

    /**
     * Update token details into storage.
     *
     * @param string $token Access token.
     * @param null|string $tenantId Tenant id.
     * @param string $refreshToken Refresh token.
     * @param string $idToken Id token value.
     * @param int|null $expires Expiration timestamp.
     * @return array
     */
    public function updateToken($token, $tenantId, $refreshToken, $idToken, $expires = null)
    {
        return $this->_table->updateXeroTokens([
            'access_token' => $token,
            'tenant_id' => $tenantId,
            'refresh_token' => $refreshToken,
            'id_token' => $idToken,
            'expires_at' => $expires,
        ]);
    }

    /**
     * Returns token details from storage.
     *
     * @return array|null
     */
    public function getToken()
    {
        $tokenDetails = $this->tokenDetails();

        if (!empty($tokenDetails) || ($tokenDetails['expires_at'] !== null && $tokenDetails['expires_at'] <= time())) {
            return null;
        }

        return $tokenDetails;
    }

    /**
     * Returns access token value from storage.
     *
     * @return string|null
     */
    public function getAccessToken()
    {
        return $this->_table->getAccessToken();
    }

    /**
     * Returns refresh token value from storage.
     *
     * @return string
     */
    public function getRefreshToken()
    {
        return $this->_table->getRefreshToken();
    }

    /**
     * Returns expiration timestamp from storage.
     *
     * @return int|null
     */
    public function getExpires()
    {
        return $this->_table->getExpiresAt();
    }

    /**
     * Returns xero tenant id from storage.
     *
     * @return string
     */
    public function getXeroTenantId()
    {
        return $this->_table->getTenantId();
    }

    /**
     * Returns id token value from storage.
     *
     * @return string
     */
    public function getIdToken()
    {
        return $this->_table->getIdToken();
    }

    /**
     * Checks if token has been expired.
     *
     * @return bool
     */
    public function isExpired()
    {
        if (!empty($this->tokenDetails())) {
            if (time() > $this->getExpires()) {
                return true;
            }

            return false;
        }

        return true;
    }
}
