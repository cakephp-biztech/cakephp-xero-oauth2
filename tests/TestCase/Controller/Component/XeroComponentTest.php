<?php
namespace XeroOauth2\Test\TestCase\Controller\Component;

use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;
use XeroOauth2\Controller\Component\XeroOauthComponent;

/**
 * XeroOauth2\Controller\Component\XeroComponent Test Case
 */
class XeroComponentTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \XeroOauth2\Controller\Component\XeroOauthComponent
     */
    public $Xero;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->Xero = new XeroOauthComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Xero);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
