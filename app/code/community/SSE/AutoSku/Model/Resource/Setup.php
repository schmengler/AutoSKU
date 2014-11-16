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
 * Resource_Setup Model
 * @package SSE_AutoSku
 */
class SSE_AutoSku_Model_Resource_Setup extends Mage_Catalog_Model_Resource_Setup
{

    /**
     * Reset store config for product entity to set up the first sku value and the sku prefix
     *
     * @return
     */
    public function resetProductEntityStoreConfig($lastId = 'S99')
    {
        $productEntityType = Mage::getModel('eav/entity_type')
            ->loadByCode(Mage_Catalog_Model_Product::ENTITY);
        $entityStoreConfig = Mage::getModel('eav/entity_store')
            ->loadByEntityStore($productEntityType->getId(), 0);
        $entityStoreConfig->setEntityTypeId($productEntityType->getId())
            ->setStoreId(0)
            ->setIncrementPrefix('S')
            ->setIncrementLastId($lastId)
            ->save();

    }

}