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

/* @var $installer SSE_AutoSku_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

/*
 * Set backend input type for sku attribute to be read-only
 */
$installer->updateAttribute(Mage_Catalog_Model_Product::ENTITY, 'sku', array(
    'frontend_input' => 'label',
));

$installer->endSetup();
