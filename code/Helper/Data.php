<?php
class Gareth_SpamProtect_Helper_Data extends Mage_Core_Helper_Abstract
{
	const XML_PATH_DISALLOWED_STRINGS_TABLE = 'web/spamprotect/disallowed_strings';
	const XML_PATH_MAX_STRING_LENGTH = 'web/spamprotect/max_string_length';
	
	/**
	 * Returns the Maximum string size to allow.
	 *
	 * @return int
	 */
	public function getMaxStringLength()
	{
		return (intval(Mage::getStoreConfig(self::XML_PATH_MAX_STRING_LENGTH)));
	}
	
	/**
	 * Returns an array of strings that should be disallowed.
	 * 
	 * @return array
	 */
	public function getDisallowedStrings()
	{
		$strings = array();
		$table = $this->getDisallowedStringsConfigTable();
		foreach($table as $item)
		{
			$strings[] = $item['string'];
		}
		
		return $strings;
	}
	
	/**
	 * Returns un-serialized data of the XML_PATH_DISALLOWED_STRINGS_TABLE
	 * config table
	 *
	 * @return array(array("string"=>value1),array("string"=>value2),...)
	 */
	public function getDisallowedStringsConfigTable()
	{
		$config = Mage::getStoreConfig(self::XML_PATH_DISALLOWED_STRINGS_TABLE);
		
		if (!$config)
		{
			return array();
		}
		
		try
		{
			$config = Mage::helper('core/unserializeArray')->unserialize($config);
		}
		catch (Exception $exception)
		{
			Mage::logException($exception);
			Mage::Log('Exception retrieving '.self::XML_PATH_DISALLOWED_STRINGS_TABLE.' config: '.$exception, Zend_Log::NOTICE, 'gareth.log');
			$config = array(); // Return empty array if failed to un-serialize data
		}
		
		return $config;
	}
	
}
