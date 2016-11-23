<?php
/**
 * This file is part of SSE_AutoSku for Magento.
 *
 * @license osl-3.0
 * @author Fabian Schmengler <fabian@schmengler-se.de> <@fschmengler>
 * @category SSE
 * @package SSE_AutoSku
 * @copyright Copyright (c) 2015 Schmengler Software Engineering (http://www.schmengler-se.de/)
 */

/**
 * Observer
 * @package SSE_AutoSku
 */
class SSE_AutoSku_Model_Observer
{
    /**
     * Sets sku_autogenerate parameter
     * 
     * The parameter would usually be set via checkbox in the "quick create" form
     * but since the SKU field is now a label instead of a text field, it is not included.
     * 
     * @see Mage_Adminhtml_Block_Catalog_Product_Edit_Tab_Super_Config_Simple
     * @see event controller_action_predispatch_adminhtml_catalog_product_quickCreate
     * @param Varien_Event_Observer $observer
     */
    public function setAutogenerateSku(Varien_Event_Observer $observer)
    {
        $request = $observer->getControllerAction()->getRequest();
        $simpleProductRequest = $request->getParam('simple_product');
        $simpleProductRequest['sku_autogenerate'] = '1';
        $request->setParam('simple_product', $simpleProductRequest);
    }

    /**
     * Lock product attributes
     *
     * @event catalog_product_edit_action
     * @param Varien_Event_Observer $observer $observer
     */
    public function lockAttributes(Varien_Event_Observer $observer) {
        $event      = $observer->getEvent();
        $product    = $event->getProduct();
        $product->lockAttribute('sku');
    }
}
