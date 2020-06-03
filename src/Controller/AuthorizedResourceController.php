<?php

namespace XeroOauth2\Controller;

/**
 * AuthotizedResource Controller
 *
 * @property \XeroOauth2\Controller\Component\StorageComponent $Storage
 */
class AuthorizedResourceController extends AppController
{
    /**
     * Index method
     *
     * @return void
     * @throws \League\OAuth2\Client\Provider\Exception\IdentityProviderException
     */
    public function index()
    {
        $this->loadComponent('XeroOauth2.Storage');

        $tenantId = $this->Storage->getXeroTenantId();
        $accountingApi = $this->XeroOauth->accountingApi();

        foreach ($accountingApi->getContacts($tenantId)->getContacts() as $contact) {
            debug([
                'id' => $contact->getContactId(),
                'name' => $contact->getName(),
                'email' => $contact->getEmailAddress(),
            ]);
        }

        exit;
    }
}
