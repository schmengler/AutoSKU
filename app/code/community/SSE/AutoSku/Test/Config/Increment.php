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
 * Test case for increment model configuration
 *
 * @package SSE_AutoSku
 */
class SSE_AutoSku_Test_Config_Increment extends EcomDev_PHPUnit_Test_Case {

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
     */
    public function testSkuNotRequired()
    {
        /* @var $skuAttribute Mage_Catalog_Model_Entity_Attribute */
        $skuAttribute = Mage::getModel('catalog/entity_attribute');
        $skuAttribute->loadByCode(Mage_Catalog_Model_Product::ENTITY, 'sku');
        $this->assertEquals(0, $skuAttribute->getIsRequired(), 'SKU should not be a required attribute');
    }
    /**
     * @test
     * @dataProvider dataProvider
     */
    public function testAddProducts($productData)
    {
        /* @var $newProduct Mage_Catalog_Model_Product */
        $newProduct = Mage::getModel('catalog/product');
        $newProduct->setData($productData);
        $newProduct->save();
        $this->assertGreaterThan(0, $newProduct->getId(),
             'product should be saved');
        $this->assertEquals('S100', $newProduct->getSku(),
             'SKU of first product');

        $newProduct = Mage::getModel('catalog/product');
        $newProduct->setData($productData);
        $newProduct->save();
        $this->assertGreaterThan(0, $newProduct->getId(),
             'product should be saved');
        $this->assertEquals('S101', $newProduct->getSku(),
             'SKU of second product');
    }
    /**
     * @test
     * @dataProvider dataProvider
     */
    public function testLargeSku($productData)
    {
    	self::$setup->resetProductEntityStoreConfig('S999');
        /* @var $newProduct Mage_Catalog_Model_Product */
        $newProduct = Mage::getModel('catalog/product');
        $newProduct->setData($productData);
        $newProduct->save();
        $this->assertGreaterThan(0, $newProduct->getId(),
             'product should be saved');
        $this->assertEquals('S1000', $newProduct->getSku(),
             'SKU of new product');
    }
    /**
     * @test
     * @dataProvider dataProvider
     */
    public function testAddProductsSimultaneously($productData)
    {
        $newProduct1 = Mage::getModel('catalog/product');
        $newProduct1->setData($productData);
        $newProduct2 = Mage::getModel('catalog/product');
    	$newProduct2->setData($productData);

    	$newProduct1->save();
    	$newProduct2->save();
    	$this->assertTrue($newProduct1->getSku() != $newProduct2->getSku(), 'SKUs should be different');
    }
    /**
     * @test
     * @dataProvider dataProvider
     * @loadFixture product.yaml
     */
    public function testCollisionFromManualEntry($productData)
    {
    	self::$setup->resetProductEntityStoreConfig('S99');
        /* @var $existingProduct Mage_Catalog_Model_Product */
    	$existingProduct = Mage::getModel('catalog/product');
    	$existingProduct = $existingProduct->loadByAttribute('sku', 'S100');
    	$this->assertGreaterThan(0, $existingProduct->getId(), 'product with SKU S100 exists.');

    	// delete product with SKU S101 from previous tests
    	$existingProduct = $existingProduct->loadByAttribute('sku', 'S101');
    	if ($existingProduct->getId()) {
    		$existingProduct->delete();
    	}

        /* @var $newProduct Mage_Catalog_Model_Product */
        $newProduct = Mage::getModel('catalog/product');
        $newProduct->setData($productData);
        $newProduct->save();
        $this->assertGreaterThan(0, $newProduct->getId(),
             'product should be saved');
        $this->assertEquals('S101', $newProduct->getSku(),
             'SKU of new product should skip over existing SKU');
    }
    public function testImportValidation()
    {
    	$this->markTestIncomplete();
    }
}
