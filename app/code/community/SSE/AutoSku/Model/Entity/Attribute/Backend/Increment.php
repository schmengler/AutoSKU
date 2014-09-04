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
 * Entity_Attribute_Backend_Increment Model
 * @package SSE_AutoSku
 */
class SSE_AutoSku_Model_Entity_Attribute_Backend_Increment extends
        Mage_Eav_Model_Entity_Attribute_Backend_Increment {

	const XML_EMPTY_ALIAS = 'catalog/autosku/empty_alias';
	
    // Schmengler Software Engineering Tag NEW_CONST

    // Schmengler Software Engineering Tag NEW_VAR

    /**
     * Set new increment id to the attribute itself. The original class always uses the increment_id
     * attribute, regardless of which attribute has the increment backend model.
     *
     * Additionally, it will check for duplicates and treat the configured "empty alias" like an empty value,
     * i.e. generate an increment id in this case.
     *
     * @param Varien_Object $object
     * @return SSE_AutoSku_Model_Entity_Attribute_Backend_Increment
     */
    public function beforeSave($object)
    {
        $code = $this->getAttribute()->getName();
        if (preg_match('/' . str_replace('%', '.*', preg_quote(Mage::getStoreConfig(self::XML_EMPTY_ALIAS), '/')) . '/', $object->getData($code))) {
        	$object->setData($code, null);
        }
        if ($object->getId() && $object->getData($code)) {
    		return $this;
    	}
        $object->setIncrementId($object->getData($code));
        while (!$object->getIncrementId()) {
        	$this->getAttribute()->getEntity()->setNewIncrementId($object);
        	$this->checkDuplicateValue($object);

        }
        $object->setData($code, $object->getIncrementId());
        return $this;
    }

    /**
     * Check if increment id already exists, unset it if this is the case
     *
     * @param Varien_Object $object
     * @return SSE_AutoSku_Model_Entity_Attribute_Backend_Increment
     */
    protected function checkDuplicateValue($object)
    {
    	/* @var $resource Mage_Eav_Model_Entity_Abstract */
    	$resource = $object->getResource();
        $code = $this->getAttribute()->getName();

    	/* @var $adapter Varien_Db_Adapter_Interface */
    	$adapter = $object->getResource()->getWriteConnection();
    	$bind    = array($code => $object->getIncrementId());

    	/*
    	 * increment id should be a static attribute (field in entity table), so we access it directly
    	 */
    	$select = $adapter->select()
	    	->from($resource->getEntityTable(), array($resource->getEntityIdField()))
	    	->where("$code = :$code");

    	$result = $adapter->fetchOne($select, $bind);
    	if ($result) {
    		$object->setIncrementId(null);
    	}
    	return $this;
    }

    // Schmengler Software Engineering Tag NEW_METHOD

}
