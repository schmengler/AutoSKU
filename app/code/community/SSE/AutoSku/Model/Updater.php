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
 * Updater Model
 * @package SSE_AutoSku
 */
class SSE_AutoSku_Model_Updater extends Mage_Core_Model_Abstract
{

    /**
     * Update SKU for all products with empty or temporary SKUs
     * 
     * @return
     */
    public function updateAll()
    {
        /* @var $iterator Mage_Core_Model_Resource_Iterator */
        $iterator = Mage::getResourceModel('core/iterator');
        /* @var $productModel Mage_Catalog_Model_Product */
        $productModel = Mage::getModel('catalog/product');
        $productModel->getResource()->isPartialSave(true);
        
        $productsToUpdate = $this->getProductsWithEmptySkuCollection();
        $iterator->walk($productsToUpdate->getSelect(), [function($iteratorArgs) use ($productModel) {
            $productModel->setData($iteratorArgs['row']);
            $productModel->getResource()->save($productModel);
        }]);
    }

    /**
     * Prepares product collection
     * 
     * @return Mage_Catalog_Model_Resource_Product_Collection
     */
    public function getProductsWithEmptySkuCollection ()
    {
        $empty = [null, ''];
        $emptyAlias = Mage::getStoreConfig(SSE_AutoSku_Model_Entity_Attribute_Backend_Increment::XML_EMPTY_ALIAS);

        /* @var $productsWithEmptySku Mage_Catalog_Model_Resource_Product_Collection */
        $productsWithEmptySku = Mage::getModel('catalog/product')->getCollection();
        $productsWithEmptySku->addAttributeToSelect('entity_id', 'sku')
            ->addAttributeToFilter('sku', [['in' => $empty], ['like' => $emptyAlias]])
            ->addOrder('entity_id', Varien_Data_Collection_Db::SORT_ORDER_ASC);
        return $productsWithEmptySku;
    }
}