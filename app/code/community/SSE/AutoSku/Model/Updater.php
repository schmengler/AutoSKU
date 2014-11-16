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
        $empty = array(null, '');
        $emptyAlias = Mage::getStoreConfig(SSE_AutoSku_Model_Entity_Attribute_Backend_Increment::XML_EMPTY_ALIAS);

        /* @var $productsWithEmptySku Mage_Catalog_Model_Resource_Product_Collection */
        $productsWithEmptySku = Mage::getModel('catalog/product')->getCollection();
        $productsWithEmptySku->addAttributeToSelect('entity_id', 'sku')
            ->addAttributeToFilter('sku', array(array('in' => $empty), array('like' => $emptyAlias)))
            ->addOrder('entity_id', Varien_Data_Collection_Db::SORT_ORDER_ASC);
        foreach ($productsWithEmptySku as $product) {
            /* @var $product Mage_Catalog_Model_Product */
            $product->unsetData('sku');
            $product->getResource()->isPartialSave(true);
            $product->getResource()->save($product);
        }
    }

}