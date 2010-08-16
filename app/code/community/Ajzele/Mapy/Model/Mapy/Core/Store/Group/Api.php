<?php
/**
 * @category    Ajzele
 * @package     Ajzele_Mapy
 * @copyright   Copyright (c) Branko Ajzele (http://activecodeline.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Mapy Core Store Group Api
 * 
 * Sort of exposing or serving as API version of app/code/core/Mage/Core/Model/Store/Group.php file
 *
 * @category   Ajzele
 * @package    Ajzele_Mapy
 * @author     Branko Ajzele <ajzele@gmail.com>
 */
class Ajzele_Mapy_Model_Mapy_Core_Store_Group_Api extends Mage_Api_Model_Resource_Abstract
{
	
	public function delete($groupId)
	{
		$g = Mage::getModel('core/store_group')->load($groupId);
		
		try {
			//bypass "Cannot complete this operation from non-admin area."
			Mage::register('isSecureArea', true);
			$g->delete();
			Mage::unregister('isSecureArea');
			return true;
		}
		catch (Exception $e) {
			return false;
		}
	}
	
	public function update($groupId, array $data) 
	{
		$g = Mage::getModel('core/store_group')->load($groupId);
		
		try {
			//bypass "Cannot complete this operation from non-admin area."
			Mage::register('isSecureArea', true);
			
			foreach ($data as $k => $v) {
				$g->setData($k, $v);	
			}
			
			$g->save();
			Mage::unregister('isSecureArea');
			return true;
		}
		catch (Exception $e) {
			return false;
		}
	}
	
	
    /**
     * Is can delete group.
     * 
     * API call goes like $client->call('call', array($session, 'mapy_core_store_group.isCanDelete', 3));
     *
     * @return bool
     */	
    public function isCanDelete($groupId)
    {
    	$g = Mage::getModel('core/store_group')->load($groupId);

		try {
			return $g->isCanDelete(); 
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
		$g = Mage::getModel('core/store_group');
		
		foreach ($data as $k => $v) {
			$g->setData($k, $v);	
		}		

		try {
			$g->save();
			return $g->getId(); 
		}
		catch (Exception $e) {
			return 0;
		}
	}
	
    public function getStores($groupId)
    {
    	try {
			$g = Mage::getModel('core/store_group')->load($groupId);
			$storesCollection = $g->getStoreCollection();
			$stores = array();
			
			foreach($storesCollection as $store) {
				$stores[] = $store->debug();
			}
			
			/**
				$response array(5) {
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
				  [3] => array(7) {
				    ["store_id"] => string(1) "6"
				    ["code"] => string(6) "niceee"
				    ["website_id"] => string(1) "1"
				    ["group_id"] => string(1) "1"
				    ["name"] => string(13) "My test store"
				    ["sort_order"] => string(1) "0"
				    ["is_active"] => string(1) "0"
				  }
				  [4] => array(7) {
				    ["store_id"] => string(1) "5"
				    ["code"] => string(9) "cool_shop"
				    ["website_id"] => string(1) "1"
				    ["group_id"] => string(1) "1"
				    ["name"] => string(14) "Cool shop lang"
				    ["sort_order"] => string(2) "12"
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
	 * 
	 * Get fully loaded object like array
	 * @param integer $storeId
	 */
	public function getMageCoreModelStoreGroupAsArray($groupId)
	{
		try {
			$g = Mage::getModel('core/store_group')->load($groupId);
			return $g->toArray();
		} 
		catch (Exception $e) {
			return array();
		}
	}
	
}