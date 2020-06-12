<?php
/**
 * Spam Protect Magento extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is copyright Gareth Ladd 2020. Not for public dissemination
 * nor use.
 *
 * DISCLAIMER
 *
 * This program is private software. It comes without any warranty, to
 * the extent permitted by applicable law. You may not copy, modify nor
 * distribute it. The author takes no responsibility for any consequences of
 * unauthorised usage of this file or any part thereof.
 */

class Gareth_SpamProtect_Block_Adminhtml_Form_Field_DisallowedStringsTable
extends Mage_Adminhtml_Block_System_Config_Form_Field_Array_Abstract
{
	/**
	 * Prepare to render. Add custom config field columns, set template, add values.
	 */
	protected function _prepareToRender()
	{
		parent::_prepareToRender();
		
		/** @var Gareth_SpamProtect_Helper_Data $helper */
		$helper = Mage::helper('gareth_spamprotect/data');
		
		$this->addColumn('string', array(
				'style' => 'width:15em',
				'label' => $helper->__('String')
		));
		
		$this->_addAfter = false;
	}
}