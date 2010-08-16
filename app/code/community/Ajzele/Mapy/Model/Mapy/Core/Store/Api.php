<?php
/**
 * @category    Ajzele
 * @package     Ajzele_Mapy
 * @copyright   Copyright (c) Branko Ajzele (http://activecodeline.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Mapy Core Store Api
 * 
 * Sort of exposing or serving as API version of app/code/core/Mage/Core/Model/Store.php file
 *
 * @category   Ajzele
 * @package    Ajzele_Mapy
 * @author     Branko Ajzele <ajzele@gmail.com>
 */
class Ajzele_Mapy_Model_Mapy_Core_Store_Api extends Mage_Api_Model_Resource_Abstract
{
	
	/**
	 * API call goes like $client->call('call', array($session, 'mapy_core_store.delete', 6));
	 * 
	 * @param indeger $storeId
	 */
	public function delete($storeId)
	{
		$s = Mage::getModel('core/store')->load($storeId);
		
		try {
			//bypass "Cannot complete this operation from non-admin area."
			Mage::register('isSecureArea', true);
			$s->delete();
			Mage::unregister('isSecureArea');
			return true;
		}
		catch (Exception $e) {
			return false;
		}
	}

    public function isCanDelete($storeId)
    {
    	$s = Mage::getModel('core/store')->load($storeId);

		try {
			return $s->isCanDelete(); 
		}
		catch (Exception $e) {
			return false;
		}
    }		
	
	public function update($storeId, array $data) 
	{
		$s = Mage::getModel('core/store')->load($storeId);
		
		try {
			//bypass "Cannot complete this operation from non-admin area."
			Mage::register('isSecureArea', true);
			
			foreach ($data as $k => $v) {
				$s->setData($k, $v);	
			}
			
			$s->save();
			Mage::unregister('isSecureArea');
			return true;
		}
		catch (Exception $e) {
			return false;
		}
	}	
	
	/**
	 * 
	 * API call goes like $response = $client->call('call', array($session, 'mapy_core_store.create', array(array('website_id'=>'1', 'group_id'=>'1', 'code'=>'niceee', 'name'=>'My test store'))));
	 * @param array $data
	 */
	public function create(array $data)
	{
		$s = Mage::getModel('core/store');
		
		foreach($data as $k => $v) {
			$s->setData($k, $v);
		}
		
		try {
			$s->save();
			return $s->getId(); 
		}
		catch (Exception $e) {
			return 0;
		}
	}
	
	
	/**
	 * 
	 * Get fully loaded object like array
	 * @param integer $storeId
	 */
	public function getMageCoreModelStoreAsArray($storeId)
	{
		try {
			$s = Mage::getModel('core/store')->load($storeId);
			/**
				$response array(7) {
				  ["store_id"] => string(1) "3"
				  ["code"] => string(6) "french"
				  ["website_id"] => string(1) "1"
				  ["group_id"] => string(1) "1"
				  ["name"] => string(6) "French"
				  ["sort_order"] => string(1) "0"
				  ["is_active"] => string(1) "1"
				}
			 */
			return $s->toArray();
		} 
		catch (Exception $e) {
			return array();
		}
	}
	
    /**
     * Get root category id
     *
     * @return int Zero if none
     */
    public function getRootCategoryId($storeId)
    {
    		try {
			$s = Mage::getModel('core/store')->load($storeId);
			
			return $s->getRootCategoryId();
		} 
		catch (Exception $e) {
			return 0;
		}
    }	
	
    /**
     * Format price with currency filter (taking rate into consideration)
     *
     * @param   integer $storeId
     * @param   double $price
     * @param   bool $includeContainer
     * @return  string
     */	
    public function formatPrice($storeId, $price, $includeContainer = true)
    {
		try {
			$s = Mage::getModel('core/store')->load($storeId);
			
			/**
			 * $includeContainer = true => $response string(36) "<span class="price">SLRs39.99</span>"
			 * $includeContainer = true => $response string(9) "SLRs39.99"
			 */
			return $s->formatPrice($price, $includeContainer);
		} 
		catch (Exception $e) {
			return '';
		}
    }	
	
	
    /**
     * Retrieve store configuration data
     *
     * @param   integer $storeId
     * @param   string $path
     * @return  array
     */
    public function getConfig($storeId, $path)
    {
		try {
			$s = Mage::getModel('core/store')->load($storeId);
			/**
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
			 */
			return $s->getConfig($path);
		} 
		catch (Exception $e) {
			return array();
		}
    }	
	
    /**
     * Get allowed store currency codes
     *
     * If base currency is not allowed in current website config scope,
     * then it can be disabled with $skipBaseNotAllowed
     * 
     * @param integer $storeId
     * @param bool $skipBaseNotAllowed
     * @return array
     */	
    public function getAvailableCurrencyCodes($storeId, $skipBaseNotAllowed = false)
    {
        try {
			$s = Mage::getModel('core/store')->load($storeId);
			/**
				$response array(8) {
				  [0] => string(3) "THB"
				  [1] => string(3) "TOP"
				  [2] => string(3) "TTD"
				  [3] => string(3) "TND"
				  [4] => string(3) "TRY"
				  [5] => string(3) "TMM"
				  [6] => string(3) "USD"
				  [7] => string(3) "LKR"
				}
			 */
			return $s->getAvailableCurrencyCodes($skipBaseNotAllowed);
		} 
		catch (Exception $e) {
			return array();
		}
    }	
	
    /**
     * Retrieve store base currency
     *
     * @return Mage_Directory_Model_Currency
     */
    public function getBaseCurrency($storeId)
    {
    	try {
			$s = Mage::getModel('core/store')->load($storeId);
			//$s->getCurrentCurrency() => Mage_Directory_Model_Currency
			
			/**
				$response array(1) {
				  ["currency_code"] => string(3) "LKR"
				}
			 */
			return $s->getBaseCurrency()->toArray();
		} 
		catch (Exception $e) {
			return array();
		}
    }	
	
    /**
     * Retrieve store current currency
     *
     * @return array
     */
    public function getCurrentCurrency($storeId)
    {
    	
    	try {
			$s = Mage::getModel('core/store')->load($storeId);
			//$s->getCurrentCurrency() => Mage_Directory_Model_Currency
			
			/**
				$response array(1) {
				  ["currency_code"] => string(3) "LKR"
				}
			 */
			return $s->getCurrentCurrency()->toArray();
		} 
		catch (Exception $e) {
			return array();
		}
    }	
}