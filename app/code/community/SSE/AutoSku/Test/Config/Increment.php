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
     * @test
     */
    public function testSkuNotRequired() {
        $this->markTestIncomplete();
    }
    /**
     * @test
     * @dataProvider dataProvider
     */
    public function testAddProducts($productData) {
        /* @var $newProduct Mage_Catalog_Model_Product */
        $newProduct = Mage::getModel('catalog/product');
        $newProduct->setData($productData);
        $newProduct->save();
        $this
                ->assertGreaterThan(0, $newProduct->getId(),
                        'product should be saved');
        $this
                ->assertEquals('S100', $newProduct->getSku(),
                        'SKU of first product');

        $newProduct = Mage::getModel('catalog/product');
        $newProduct->setData($productData);
        $newProduct->save();
        $this
                ->assertGreaterThan(0, $newProduct->getId(),
                        'product should be saved');
        $this
                ->assertEquals('S101', $newProduct->getSku(),
                        'SKU of second product');
    }
    /**
     * @test
     * @loadFixture products.yaml
     */
    public function testLargeSku() {
        $this->markTestIncomplete();
    }
    /**
     * @test
     */
    public function testAddProductsSimultaneously() {
        $this->markTestIncomplete();
    }
}
