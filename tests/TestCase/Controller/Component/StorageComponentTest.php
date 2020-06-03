<?php
namespace XeroOauth2\Test\TestCase\Controller\Component;

use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;
use XeroOauth2\Controller\Component\StorageComponent;

/**
 * XeroOauth2\Controller\Component\StorageComponent Test Case
 */
class StorageComponentTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \XeroOauth2\Controller\Component\StorageComponent
     */
    public $Storage;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->Storage = new StorageComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Storage);

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
