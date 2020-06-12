<?php
require_once(Mage::getModuleDir('controllers','Mage_Customer').DS.'AccountController.php');

class Gareth_SpamProtect_AccountController extends Mage_Customer_AccountController
{
	/** 
	 * The minimum value allowed for the maximum length config value. If this
	 * default is changed, mst also amend the comment in system.xml for 
	 * max_string_length entry.
	 * 
	 * @var integer
	 */
	const MINIMUM_MAX_LENGTH = 10;
	
	/**
	 * Create customer account action
	 */
	public function createPostAction()
	{
		/* @var Gareth_SpamProtect_Helper_Data $helper */
		$helper = Mage::helper('gareth_spamprotect/data');
		$bad_strings = $helper->getDisallowedStrings();
		$max_length = $helper->getMaxStringLength();
		
		/**
		 * Serialised array type does not load defaults if no value in DB.
		 * If this default is changed, must also amend the comment in system.xml
		 * for disallowed_strings entry.
		 */
		if (empty($bad_strings))
		{
			$bad_strings = array('http://', 'https://');
		}
		
		$params_to_check = array('firstname', 'middlename', 'lastname', 'email');
		foreach ($params_to_check as $param_name)
		{
			$param_value = $this->getRequest()->getParam($param_name);
			if ($max_length >= self::MINIMUM_MAX_LENGTH && strlen($param_value) > $max_length)
			{
				$this->_getSession()->addError($helper->__('Spambot protection: Please ensure %s is %d characters or less', $param_name, $max_length));
				
				// <routers> from comnfig.xml / controller name / action name
				return $this->_redirect('*/*/create');
			}
		}
		
		$params_to_check = array('firstname', 'middlename', 'lastname', 'email', 'password', 'confirmation');
		foreach ($params_to_check as $param_name)
		{
			$param_value = $this->getRequest()->getParam($param_name);
			foreach ($bad_strings as $bad_string)
			{
				if (strpos($param_value, $bad_string) !== false)
				{
					$this->_getSession()->addError($helper->__('Spambot protection: Please do not use "%s" in %s', $bad_string, $param_name));
					
					// <routers> from comnfig.xml / controller name / action name
					return $this->_redirect('*/*/create');
				}
			}
		}
		
		// All OK carry on to do default stuff
		return parent::createPostAction();
	}
}