<?php
/**
 * @category    Ajzele
 * @package     Ajzele_Mapy
 * @copyright   Copyright (c) Branko Ajzele (http://activecodeline.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Mapy Core Website Api
 * 
 * Sort of exposing or serving as API version of app/code/core/Mage/Core/Model/Website.php file
 *
 * @category   Ajzele
 * @package    Ajzele_Mapy
 * @author     Branko Ajzele <ajzele@gmail.com>
 */
class Ajzele_Mapy_Model_Mapy_Core_Website_Api extends Mage_Api_Model_Resource_Abstract
{
	/**
	 * API call goes like $client->call('call', array($session, 'mapy_core_website.delete', 2));
	 * 
	 * @param indeger $storeId
	 */	
	public function delete($websiteId)
	{
		$w = Mage::getModel('core/website')->load($websiteId);
		
		try {
			//bypass "Cannot complete this operation from non-admin area."
			Mage::register('isSecureArea', true);
			$w->delete();
			Mage::unregister('isSecureArea');
			return true;
		}
		catch (Exception $e) {
			return false;
		}
	}	
	
	
	public function update($websiteId, array $data) 
	{
		$w = Mage::getModel('core/website')->load($websiteId);
		
		try {
			//bypass "Cannot complete this operation from non-admin area."
			Mage::register('isSecureArea', true);
			
			foreach ($data as $k => $v) {
				$w->setData($k, $v);	
			}
			
			$w->save();
			Mage::unregister('isSecureArea');
			return true;
		}
		catch (Exception $e) {
			return false;
		}
	}	

	public function create(array $data)
	{
		$w = Mage::getModel('core/website');
		
		foreach($data as $k => $v) {
			$w->setData($k, $v);
		}
		
		try {
			$w->save();
			return $w->getId(); 
		}
		catch (Exception $e) {
			return 0;
		}
	}	
	
	
    /**
     * Retrieve website store codes
     *
     * @return array
     */	
	public function getStoreCodes($websiteId)
	{
		try {
			$w = Mage::getModel('core/website')->load($websiteId);
			if($w->getId()) {
				/**
					$response array(3) {
					  [1] => string(7) "default"
					  [3] => string(6) "french"
					  [2] => string(6) "german"
					}
				 */				
				return $w->getStoreCodes();	
			}
		}
		catch (Exception $e) {
			return array();			
		}
	}
	
    /**
     * Retrieve website store list
     *
     * @return array
     */	
    public function getStores($websiteId)
    {
        try {
			$w = Mage::getModel('core/website')->load($websiteId);
			
			$storesCollection = $w->getStores();
			$stores = array();
			
			foreach($storesCollection as $store) {
				$store = Mage::getModel('core/store')->load($store->getId());
				$stores[] = $store->toArray();
				unset($store); 
			}
			
			/**
				$response array(3) {
				  [0] => array(7) {
				    ["store_id"] => string(1) "1"
				    ["code"] => string(7) "default"
				    ["website_id"] => string(1) "1"
				    ["group_id"] => string(1) "1"
				    ["name"] => string(7) "English"
				    ["sort_order"] => string(1) "0"
				    ["is_active"] => string(1) "1"
				  }
				  [1] => array(7) {
				    ["store_id"] => string(1) "3"
				    ["code"] => string(6) "french"
				    ["website_id"] => string(1) "1"
				    ["group_id"] => string(1) "1"
				    ["name"] => string(6) "French"
				    ["sort_order"] => string(1) "0"
				    ["is_active"] => string(1) "1"
				  }
				  [2] => array(7) {
				    ["store_id"] => string(1) "2"
				    ["code"] => string(6) "german"
				    ["website_id"] => string(1) "1"
				    ["group_id"] => string(1) "1"
				    ["name"] => string(6) "German"
				    ["sort_order"] => string(1) "0"
				    ["is_active"] => string(1) "1"
				  }
				}
			 */
			return $stores;
		} 
		catch (Exception $e) {
			return array();
		}
    }	
	
    /**
     * Get website config data
     *
     * @param string $path
     * @return array
     */	
    public function getConfig($websiteId, $path) 
    {
        try {
			$w = Mage::getModel('core/website')->load($websiteId);
			return $w->getConfig($path);
			/** example response for $path = 'email'
				$response array(6) {
				  ["account_share"] => array(1) {
				    ["scope"] => string(1) "1"
				  }
				  ["create_account"] => array(7) {
				    ["confirm"] => string(1) "0"
				    ["default_group"] => string(1) "1"
				    ["email_domain"] => string(15) "emaildomain.com"
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
				    ["prefix_show"] => array(0) {
				    }
				    ["prefix_options"] => array(0) {
				    }
				    ["middlename_show"] => array(0) {
				    }
				    ["suffix_show"] => array(0) {
				    }
				    ["suffix_options"] => array(0) {
				    }
				    ["dob_show"] => array(0) {
				    }
				    ["gender_show"] => array(0) {
				    }
				  }
				  ["startup"] => array(1) {
				    ["redirect_dashboard"] => string(1) "1"
				  }
				}
			 */
		} 
		catch (Exception $e) {
			return array();
		}
    }	
	
	
    /**
     * is can delete website
     *
     * @return bool
     */
    public function isCanDelete($websiteId)
    {
        try {
			$w = Mage::getModel('core/website')->load($websiteId);
			return $w->isCanDelete();
		} 
		catch (Exception $e) {
			return false;
		}
    }	
	
    /**
     * Get list of all websites
     */
	public function getCollection()
	{
		$websites = array();
		
		$collection = Mage::getModel('core/website')->getCollection();
		
		foreach($collection as $website) {
			//Load full object data
			//$website = Mage::getModel('core/website')->load($website->getId());
			$websites[] = $website->toArray();				
		}
		return $websites;
	}
	
    /**
     * Retrieve website base currency
     *
     * @return Mage_Directory_Model_Currency
     */
    public function getBaseCurrency($websiteId)
    {
    	try {
			$w = Mage::getModel('core/website')->load($websiteId);
			/**
				$response array(1) {
				  ["currency_code"] => string(3) "LKR"
				}
			 */
			// $w->getBaseCurrency() => Mage_Directory_Model_Currency
			return $w->getBaseCurrency()->toArray();
		} 
		catch (Exception $e) {
			return array();
		}
    }	
	
	/**
	 * 
	 * Get fully loaded object like array
	 * @param integer $websiteId
	 */
	public function getMageCoreModelWebsiteAsArray($websiteId)
	{
		try {
			$w = Mage::getModel('core/website')->load($websiteId);
			/**
				$response array(6) {
				  ["website_id"] => string(1) "1"
				  ["code"] => string(4) "base"
				  ["name"] => string(12) "Main Website"
				  ["sort_order"] => string(1) "0"
				  ["default_group_id"] => string(1) "1"
				  ["is_default"] => string(1) "1"
				}
			 */
			return $w->toArray();
		} 
		catch (Exception $e) {
			return array();
		}
	}
}