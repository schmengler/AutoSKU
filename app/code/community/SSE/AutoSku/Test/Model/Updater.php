<?php
/**
 * This file is part of SSE_AutoSku for Magento.
 *
 * @license osl-3.0
 * @author Fabian Schmengler <fabian@schmengler-se.de> <@fschmengler>
 * @category SSE
 * @package SSE_AutoSku
 * @copyright Copyright (c) 2014 Schmengler Software Engineering (http://www.schmengler-se.de/)
 */

/**
 * Test case for updater script
 */
class SSE_AutoSku_Test_Model_Updater extends EcomDev_PHPUnit_Test_Case
{
    /**
     * @var SSE_AutoSku_Model_Resource_Setup
     */
    protected static $setup;

    /**
     * Always start with the first increment id as set up by install script
     */
    public static function setUpBeforeClass()
    {
        self::$setup = Mage::getModel('sse_autosku/resource_setup', 'sse_autosku_setup');
        self::$setup->resetProductEntityStoreConfig();
    }
    /**
     * @test
     * @loadFixture importedProducts.yaml
     * @loadExpectation
     */
    public function testUpdateAll()
    {
        Mage::getModel('sse_autosku/updater')->updateAll();
        foreach (Mage::getModel('catalog/product')->getCollection() as $_product) {
            $this->assertEquals($this->expected('entity_id_' . $_product->getId())->getSku(), $_product->getSku(), 'SKU for entity_id=' . $_product->getId());
        }
    }
}