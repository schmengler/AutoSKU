<?php
/**
 * This file is part of SSE_AutoSku for Magento.
 *
 * @license     osl-3.0
 * @author      Jeroen van Leusden – H&O <info@h-o.nl>
 * @category    SSE
 * @package     SSE_AutoSku
 * @copyright   Copyright (c) 2014 Schmengler Software Engineering (http://www.schmengler-se.de/)
 */

/* @var $installer SSE_AutoSku_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

/*
 * Set backend input type for sku attribute to be read-only
 */
$installer->updateAttribute(Mage_Catalog_Model_Product::ENTITY, 'sku', [
    'frontend_input'    => 'text',
    'note'              => 'Locked by SSE_AutoSku'
]);

$installer->endSetup();
