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

    // Schmengler Software Engineering Tag NEW_CONST

    // Schmengler Software Engineering Tag NEW_VAR

    /**
     * Set new increment id to the attribute itself. The original class always uses the increment_id
     * attribute, regardless of which attribute has the increment backend modle.
     *
     * @param Varien_Object $object
     * @return SSE_AutoSku_Model_Entity_Attribute_Backend_Increment
     */
    public function beforeSave($object) {
        $code = $this->getAttribute()->getName();
        $object->setIncrementId($object->getData($code));
        parent::beforeSave($object);
        $object->setData($code, $object->getIncrementId());
    }

    // Schmengler Software Engineering Tag NEW_METHOD

}
