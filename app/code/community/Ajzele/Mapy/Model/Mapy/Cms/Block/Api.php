<?php
/**
 * @category    Ajzele
 * @package     Ajzele_Mapy
 * @copyright   Copyright (c) Branko Ajzele (http://activecodeline.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Mapy Cms Block Api
 * 
 * Sort of exposing or serving as API version of app/code/core/Mage/Cms/Model/Block.php file
 *
 * @category   Ajzele
 * @package    Ajzele_Mapy
 * @author     Branko Ajzele <ajzele@gmail.com>
 */
class Ajzele_Mapy_Model_Mapy_Cms_Block_Api extends Mage_Api_Model_Resource_Abstract
{
	
	/**
	 * 
	 * Example API call might look like this $client->call('call', array($session, 'mapy_cms_block.create', array(array('title'=>'My sample block', 'identifier'=>'my-block-id', 'content'=>'Block HTML or plain content', 'is_active'=>'1', 'store_id'=>array('1')))));
	 * 
	 * @param array $data
	 */
	public function create(array $data)
	{
		$b = Mage::getModel('cms/block');
		foreach ($data as $k => $v) {
			$b->setData($k, $v);	
		}
		
		try {
			$b->save();
			return $b->getId(); 
		}
		catch (Exception $e) {
			return 0;
		}
		
	}	
	
	
	/**
	 * 
	 * If for some reason you wish to update the CMS block via Mapy API, 
	 * you can do so by calling this method. Please note that $data is 
	 * array of key-values matching the data stored in Mage_Cms_Model_Block object. 
	 * Look in sample $response dump shown under the "public function info($blockId)" 
	 * to see what kind of data you can set and update.
	 * 
	 * Sample call $client->call('call', array($session, 'mapy_cms_block.update', array(6, array('is_active'=>'0'))));
	 * 
	 * @param integer $blockId
	 * @param array $data
	 */
	public function update($blockId, array $data)
	{
		$b = Mage::getModel('cms/block');
		try {
			$b->load($blockId);
			foreach($data as $k => $v) {
				$b->setData($k, $v);
			}
			$b->save();
			return true;
		}
		catch (Exception $e) {
			return false;
		}		
		return false;
	}
	
	public function getCollection($removeContent = true)
	{
		//Remove 'content' field to reduce the size of response
		$collection = Mage::getModel('cms/block')->getCollection();
		$blocks = array();
		foreach ($collection as $b) {
			$b = $b->toArray();
			if($removeContent) {
				unset($b['content']);	
			}
			$blocks[] = $b;
		}
		return $blocks;
	}
	
	public function delete($blockId)
	{
		$b = Mage::getModel('cms/block');
		try {
			$b->load($blockId);
			$b->delete();
			return true;
		} catch (Exception $e) {
			return false;
		}
		return false;
	}
	
	public function info($blockId) 
	{
		$b = Mage::getModel('cms/block');
		try {
			$b->load($blockId);
			/**
				$response array(8) {
				  ["block_id"] => string(1) "3"
				  ["title"] => string(19) "Electronics Landing"
				  ["identifier"] => string(19) "electronics-landing"
				  ["content"] => string(3382) "<div class="left" style="width:284px; margin-right:25px;">
				<h3 style="margin-bottom:0;"><a href="{{store direct_url="electronics/cell-phones.html"}}"><img src="{{skin url='images/media/head_electronics_cellphones.gif}}" alt="Cell Phones" style="display:block; border:0;"/></h3>
				<p><img src="{{skin url='images/media/electronics_cellphones.jpg}}" alt="" usemap="#Map" border="0"/></p>
				</div>
				<div class="left" style="width:284px;">
				<h3 style="margin-bottom:0;"><a href="{{store direct_url="electronics/cameras/digital-cameras.html"}}"><img src="{{skin url='images/media/head_electronics_digicamera.gif}}" alt="Digital Cameras" style="display:block; border:0;"/></a></h3>
				<p><img src="{{skin url='images/media/electronics_digitalcameras.jpg}}" alt="" usemap="#Map2" border="0"/></p>
				</div>
				<div class="right" style="width:284px;">
				<h3 style="margin-bottom:0;"><a href="{{store direct_url="electronics/computers/laptops.html"}}"><img src="{{skin url='images/media/head_electronics_laptops.gif}}" alt="Laptops" style="display:block; border:0;"/></a></h3>
				<p><img src="{{skin url='images/media/electronics_laptops.jpg}}" alt="" usemap="#Map3" border="0"/></p>
				</div>
				<div class="clear"></div>
				
				<map name="Map">
				  <area shape="rect" coords="14,154,78,182" href="{{store direct_url="electronics/cell-phones.html?manufacturer=3"}}">
				  <area shape="rect" coords="12,177,80,209" href="{{store direct_url="electronics/cell-phones.html?manufacturer=20"}}">
				  <area shape="rect" coords="104,158,167,181" href="{{store direct_url="electronics/cell-phones.html?manufacturer=2"}}">
				  <area shape="rect" coords="103,181,179,208" href="{{store direct_url="electronics/cell-phones.html?manufacturer=101"}}">
				 <area shape="rect" coords="16,203,273,432" href="{{store direct_url="electronics/cell-phones/blackberry-8100-pearl.html"}}">
				</map>
				
				<map name="Map2">
				  <area shape="rect" coords="14,152,75,179" href="{{store direct_url="electronics/cameras/digital-cameras.html?manufacturer=33"}}">
				  <area shape="rect" coords="109,154,163,183" href="{{store direct_url="electronics/cameras/digital-cameras.html?manufacturer=31"}}">
				  <area shape="rect" coords="14,177,73,208" href="{{store direct_url="electronics/cameras/digital-cameras.html?manufacturer=32"}}">
				  <area shape="rect" coords="106,180,177,211" href="{{store direct_url="electronics/cameras/digital-cameras.html?manufacturer=34"}}">
				</map>
				
				
				<map name="Map3">
				  <area shape="rect" coords="15,155,58,179" href="{{store direct_url="electronics/computers/laptops?computer_manufacturers=79"}}">
				  <area shape="rect" coords="114,152,159,180" href="{{store direct_url="electronics/computers/laptops?computer_manufacturers=76"}}">
				  <area shape="rect" coords="13,178,67,205" href="{{store direct_url="electronics/computers/laptops?computer_manufacturers=77"}}">
				  <area shape="rect" coords="114,180,178,205" href="{{store direct_url="electronics/computers/laptops?computer_manufacturers=74"}}">
				  <area shape="rect" coords="13,310,154,434" href="{{store direct_url="electronics/computers/laptops/acer-ferrari-3200-notebook-computer-pc.html"}}">
				  <area shape="rect" coords="167,310,279,440" href="{{store direct_url="electronics/computers/laptops/toshiba-satellite-a135-s4527-155-4-notebook-pc-intel-pentium-dual-core-processor-t2080-1-gb-ram-120-gb-hard-drive-supermulti-dvd-drive-vista-premium.html"}}">
				</map>"
				  ["creation_time"] => string(19) "2007-08-28 14:33:10"
				  ["update_time"] => string(19) "2008-08-08 13:08:37"
				  ["is_active"] => string(1) "1"
				  ["store_id"] => array(1) {
				    [0] => string(1) "0"
				  }
				}
			 */
			return $b->toArray();
		}
		catch (Exception $e) {
			return array();
		}
	}
}