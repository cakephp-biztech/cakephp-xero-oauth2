<?php

namespace XeroOauth2\Controller;

/**
 * Authorize Controller
 */
class AuthorizeController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $provider = $this->XeroOauth->getProvider();
        $options = [
            'scope' => ['openid email profile offline_access accounting.settings accounting.transactions accounting.contacts accounting.journals.read accounting.reports.read accounting.attachments']
        ];

        // This returns the authorizeUrl with necessary parameters applied (e.g. state).
        $authorizationUrl = $provider->getAuthorizationUrl($options);

        // Save the state generated for you and store it to the session.
        // For security, on callback we compare the saved state with the one returned to ensure they match.
        $this->_session->write('oauth2state', $provider->getState());

        return $this->redirect($authorizationUrl);
    }
}
