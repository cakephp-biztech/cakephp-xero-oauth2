<?php
namespace XeroOauth2\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use XeroOauth2\Model\Table\XeroOauthTokensTable;

/**
 * XeroOauth2\Model\Table\XeroOauthTokensTable Test Case
 */
class XeroOauthTokensTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \XeroOauth2\Model\Table\XeroOauthTokensTable
     */
    public $XeroOauthTokens;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.XeroOauth2.XeroOauthTokens',
        'plugin.XeroOauth2.Tenants'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('XeroOauthTokens') ? [] : ['className' => XeroOauthTokensTable::class];
        $this->XeroOauthTokens = TableRegistry::getTableLocator()->get('XeroOauthTokens', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->XeroOauthTokens);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
