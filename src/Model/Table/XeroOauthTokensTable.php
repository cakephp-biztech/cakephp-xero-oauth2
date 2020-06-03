<?php
namespace XeroOauth2\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * XeroOauthTokens Model
 *
 * @method \XeroOauth2\Model\Entity\XeroOauthToken get($primaryKey, $options = [])
 * @method \XeroOauth2\Model\Entity\XeroOauthToken newEntity($data = null, array $options = [])
 * @method \XeroOauth2\Model\Entity\XeroOauthToken[] newEntities(array $data, array $options = [])
 * @method \XeroOauth2\Model\Entity\XeroOauthToken|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \XeroOauth2\Model\Entity\XeroOauthToken saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \XeroOauth2\Model\Entity\XeroOauthToken patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \XeroOauth2\Model\Entity\XeroOauthToken[] patchEntities($entities, array $data, array $options = [])
 * @method \XeroOauth2\Model\Entity\XeroOauthToken findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class XeroOauthTokensTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('xero_oauth_tokens');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', 'create');

        $validator
            ->scalar('access_token')
            ->maxLength('access_token', 255)
            ->allowEmptyString('access_token');

        $validator
            ->scalar('refresh_token')
            ->maxLength('refresh_token', 255)
            ->allowEmptyString('refresh_token');

        $validator
            ->scalar('id_token')
            ->maxLength('id_token', 255)
            ->allowEmptyString('id_token');

        $validator
            ->scalar('expires_at')
            ->maxLength('expires_at', 255)
            ->allowEmptyString('expires_at');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        return $rules;
    }

    /**
     * Stores oauth tokens into table.
     *
     * @param array $data Tokens data to store into table.
     * @return array
     */
    public function storeXeroTokens($data)
    {
        $entity = $this->newEntity();
        $entity = $this->patchEntity($entity, $data, ['validate' => false]);

        return $this->save($entity)->toArray();
    }

    /**
     * Update oauth tokens into table.
     *
     * @param array $data Tokens data to store into table.
     * @return array
     */
    public function updateXeroTokens($data)
    {
        $entity = $this->find()->first();
        $entity = $this->patchEntity($entity, $data, ['validate' => false]);

        return $this->save($entity)->toArray();
    }

    /**
     * Returns token details from table.
     *
     * @param array $select Fields to select.
     * @return array
     */
    public function getTokenDetails($select = [])
    {
        return $this->find()
            ->select($select)
            ->disableHydration()
            ->first();
    }

    /**
     * Returns access token value from table.
     *
     * @return string|null
     */
    public function getAccessToken()
    {
        $tokenDetails = $this->getTokenDetails(['access_token']);

        if (empty($tokenDetails)) {
            return null;
        }

        return $tokenDetails['access_token'];
    }

    /**
     * Returns refresh token value from table.
     *
     * @return string|null
     */
    public function getRefreshToken()
    {
        $tokenDetails = $this->getTokenDetails(['refresh_token']);

        if (empty($tokenDetails)) {
            return null;
        }

        return $tokenDetails['refresh_token'];
    }

    /**
     * Returns refresh token value from table.
     *
     * @return string|null
     */
    public function getExpiresAt()
    {
        $tokenDetails = $this->getTokenDetails(['expires_at']);

        if (empty($tokenDetails)) {
            return null;
        }

        return $tokenDetails['expires_at'];
    }

    /**
     * Returns tenant id value from table.
     *
     * @return string|null
     */
    public function getTenantId()
    {
        $tokenDetails = $this->getTokenDetails(['tenant_id']);

        if (empty($tokenDetails)) {
            return null;
        }

        return $tokenDetails['tenant_id'];
    }

    /**
     * Returns id token value from table.
     *
     * @return string|null
     */
    public function getIdToken()
    {
        $tokenDetails = $this->getTokenDetails(['id_token']);

        if (empty($tokenDetails)) {
            return null;
        }

        return $tokenDetails['id_token'];
    }
}
