<?php
namespace XeroOauth2\Model\Entity;

use Cake\ORM\Entity;

/**
 * XeroOauthToken Entity
 *
 * @property int $id
 * @property string|null $access_token
 * @property string|null $tenant_id
 * @property string|null $refresh_token
 * @property string|null $id_token
 * @property string|null $expires_at
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \XeroOauth2\Model\Entity\Tenant $tenant
 */
class XeroOauthToken extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'access_token' => true,
        'tenant_id' => true,
        'refresh_token' => true,
        'id_token' => true,
        'expires_at' => true,
        'created' => true,
        'modified' => true,
        'tenant' => true
    ];
}
