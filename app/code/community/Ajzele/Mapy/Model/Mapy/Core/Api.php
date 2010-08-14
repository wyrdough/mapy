<?php
/**
 * @category    Ajzele
 * @package     Ajzele_Mapy
 * @copyright   Copyright (c) Branko Ajzele (http://activecodeline.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Mapy Core Api
 *
 * @category   Ajzele
 * @package    Ajzele_Mapy
 * @author     Branko Ajzele <ajzele@gmail.com>
 */
class Ajzele_Mapy_Model_Mapy_Core_Api extends Mage_Api_Model_Resource_Abstract
{
	/**
	 * 
	 * Retrieve the version of Magento.
	 * @param string $asType Should be 'array' if we want the method to return array
	 * @return mixed Either string or array (if the passed param is 'array')
	 */
	public function currentVersion($asType = '')
	{
		if($asType == 'array') {
			return Mage::getVersionInfo();
		}
		
		return Mage::getVersion();
	}
	
	/**
	 * Retrieve the version of Zend Framework.
	 * Returns string like '1.9.6'
	 * 
	 * @return string
	 */
	public function currentZendVersion()
	{
		return Zend_Version::VERSION;
	}	
	
	/**
	 * Generate url by route and parameters.
	 * Basicaly calls for Mage::getUrl($route = '', $params = array());
	 * 
	 * @param $route string
	 * @param $params array
	 */
    public function getUrl($route = '', $params = array())
    {
    	return Mage::getUrl($route, $params);
    }
    
    /**
     * Retrieve info array of all existing websites
     *
     * @return Mage_Core_Model_Config
     */    
	public function getWebsites($asType = 'array')
	{
		switch ($asType) {
			case 'xml':
				 return Mage::getModel('core/website')->getCollection()->toXml();
			case 'optionArray':
				return Mage::getModel('core/website')->getCollection()->toOptionArray();
			case 'optionHash':
				return Mage::getModel('core/website')->getCollection()->toOptionHash();
			default:
				return Mage::getModel('core/website')->getCollection()->toArray();	
		}
	}    
	
    /**
     * Retrieve info array of all existing stores
     *
     * @return Mage_Core_Model_Config
     */    
	public function getStores($asType = 'array')
	{
		switch ($asType) {
			case 'xml':
				 return Mage::getModel('core/store')->getCollection()->toXml();
			case 'optionArray':
				return Mage::getModel('core/store')->getCollection()->toOptionArray();
			case 'optionHash':
				return Mage::getModel('core/store')->getCollection()->toOptionHash();
			default:
				return Mage::getModel('core/store')->getCollection()->toArray();	
		}
	}		
	
	
    /**
     * Retrieve config value for store by path
     *
     * @param string $path
     * @param mixed $store
     * @return mixed
     */
    public function getStoreConfig($path, $store = null)
    {
    	/**
    	 * return looks like:
    	 * 
			$response array(6) {
			  ["account_share"] => array(1) {
			    ["scope"] => string(1) "1"
			  }
			  ["create_account"] => array(7) {
			    ["confirm"] => string(1) "0"
			    ["default_group"] => string(1) "1"
			    ["email_domain"] => string(9) "gmail.com"
			    ["email_identity"] => string(7) "general"
			    ["email_template"] => string(38) "customer_create_account_email_template"
			    ["email_confirmation_template"] => string(51) "customer_create_account_email_confirmation_template"
			    ["email_confirmed_template"] => string(48) "customer_create_account_email_confirmed_template"
			  }
			  ["default"] => array(1) {
			    ["group"] => string(1) "1"
			  }
			  ["password"] => array(2) {
			    ["forgot_email_identity"] => string(7) "support"
			    ["forgot_email_template"] => string(39) "customer_password_forgot_email_template"
			  }
			  ["address"] => array(8) {
			    ["street_lines"] => string(1) "2"
			    ["prefix_show"] => string(0) ""
			    ["prefix_options"] => string(0) ""
			    ["middlename_show"] => string(0) ""
			    ["suffix_show"] => string(0) ""
			    ["suffix_options"] => string(0) ""
			    ["dob_show"] => string(0) ""
			    ["gender_show"] => string(0) ""
			  }
			  ["startup"] => array(1) {
			    ["redirect_dashboard"] => string(1) "1"
			  }
			}
    	 * 
    	 */
        return Mage::getStoreConfig($path, $store);
    }	
    
    /**
     * Retrieve enabled developer mode
     *
     * @return bool
     */    
    public function getIsDeveloperMode()
    {
    	return Mage::getIsDeveloperMode();
    }
	
	public function test()
	{
		return Mage::getEvents();
	}
	
}