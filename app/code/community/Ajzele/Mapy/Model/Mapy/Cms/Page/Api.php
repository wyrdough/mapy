<?php
/**
 * @category    Ajzele
 * @package     Ajzele_Mapy
 * @copyright   Copyright (c) Branko Ajzele (http://activecodeline.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Mapy Cms Page Api
 * 
 * Sort of exposing or serving as API version of app/code/core/Mage/Cms/Model/Page.php file
 *
 * @category   Ajzele
 * @package    Ajzele_Mapy
 * @author     Branko Ajzele <ajzele@gmail.com>
 */
class Ajzele_Mapy_Model_Mapy_Cms_Page_Api extends Mage_Api_Model_Resource_Abstract
{
	/**
	 * 
	 * Example API call might look like this $client->call('call', array($session, 'mapy_cms_page.create', array(array('title'=>'Sample title', 'identifier'=>'sample-cms', 'store_id'=>array('1'), 'is_active'=>'1', 'root_template'=>'one_column', 'content'=>'Some content goes here'))));
	 * Key 'root_template' seems to be the trickiest.
	 * @param array $data
	 */
	public function create(array $data)
	{
		$p = Mage::getModel('cms/page');
		foreach ($data as $k => $v) {
			$p->setData($k, $v);	
		}
		
		try {
			$p->save();
			return $p->getId(); 
		}
		catch (Exception $e) {
			return 0;
		}
		
	}
	
	/**
	 * 
	 * If for some reason you wish to update the CMS page via Mapy API, 
	 * you can do so by calling this method. Please note that $data is 
	 * array of key-values matching the data stored in Mage_Cms_Model_Page object. 
	 * Look in sample $response dump shown under the "public function info($pageId)" 
	 * to see what kind of data you can set and update.
	 * 
	 * Sample call $client->call('call', array($session, 'mapy_cms_page.update', array(6, array('is_active'=>'0'))));
	 * 
	 * @param integer $pageId
	 * @param array $data
	 */
	public function update($pageId, array $data)
	{
		$p = Mage::getModel('cms/page');
		try {
			$p->load($pageId);
			foreach($data as $k => $v) {
				$p->setData($k, $v);
			}
			$p->save();
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
		$collection = Mage::getModel('cms/page')->getCollection();
		$pages = array();
		foreach ($collection as $p) {
			$p = $p->toArray();
			if($removeContent) {
				unset($p['content']);	
			}
			$pages[] = $p;
		}
		return $pages;
	}
	
	public function delete($pageId)
	{
		$p = Mage::getModel('cms/page');
		try {
			$p->load($pageId);
			$p->delete();
			return true;
		} catch (Exception $e) {
			return false;
		}
		return false;
	}
	
	public function info($pageId) 
	{
		$p = Mage::getModel('cms/page');
		try {
			$p->load($pageId);
			/**
				$response array(19) {
				  ["page_id"] => string(1) "6"
				  ["title"] => string(14) "Enable Cookies"
				  ["root_template"] => string(10) "one_column"
				  ["meta_keywords"] => string(0) ""
				  ["meta_description"] => string(0) ""
				  ["identifier"] => string(14) "enable-cookies"
				  ["content_heading"] => string(0) ""
				  ["content"] => string(5391) "<div class="std">
				    <ul class="messages">
				        <li class="notice-msg">
				            <ul>
				                <li>Please enable cookies in your web browser to continue.</li>
				            </ul>
				        </li>
				    </ul>
				    <div class="page-title">
				        <h1><a name="top"></a>What are Cookies?</h1>
				    </div>
				    <p>Cookies are short pieces of data that are sent to your computer when you visit a website. On later visits, this data is then returned to that website. Cookies allow us to recognize you automatically whenever you visit our site so that we can personalize your experience and provide you with better service. We also use cookies (and similar browser data, such as Flash cookies) for fraud prevention and other purposes. If your web browser is set to refuse cookies from our website, you will not be able to complete a purchase or take advantage of certain features of our website, such as storing items in your Shopping Cart or receiving personalized recommendations. As a result, we strongly encourage you to configure your web browser to accept cookies from our website.</p>
				    <h2 class="subtitle">Enabling Cookies</h2>
				    <ul class="disc">
				        <li><a href="#ie7">Internet Explorer 7.x</a></li>
				        <li><a href="#ie6">Internet Explorer 6.x</a></li>
				        <li><a href="#firefox">Mozilla/Firefox</a></li>
				        <li><a href="#opera">Opera 7.x</a></li>
				    </ul>
				    <h3><a name="ie7"></a>Internet Explorer 7.x</h3>
				    <ol>
				        <li>
				            <p>Start Internet Explorer</p>
				        </li>
				        <li>
				            <p>Under the <strong>Tools</strong> menu, click <strong>Internet Options</strong></p>
				            <p><img src="{{skin url="images/cookies/ie7-1.gif"}}" alt="" /></p>
				        </li>
				        <li>
				            <p>Click the <strong>Privacy</strong> tab</p>
				            <p><img src="{{skin url="images/cookies/ie7-2.gif"}}" alt="" /></p>
				        </li>
				        <li>
				            <p>Click the <strong>Advanced</strong> button</p>
				            <p><img src="{{skin url="images/cookies/ie7-3.gif"}}" alt="" /></p>
				        </li>
				        <li>
				            <p>Put a check mark in the box for <strong>Override Automatic Cookie Handling</strong>, put another check mark in the <strong>Always accept session cookies </strong>box</p>
				            <p><img src="{{skin url="images/cookies/ie7-4.gif"}}" alt="" /></p>
				        </li>
				        <li>
				            <p>Click <strong>OK</strong></p>
				            <p><img src="{{skin url="images/cookies/ie7-5.gif"}}" alt="" /></p>
				        </li>
				        <li>
				            <p>Click <strong>OK</strong></p>
				            <p><img src="{{skin url="images/cookies/ie7-6.gif"}}" alt="" /></p>
				        </li>
				        <li>
				            <p>Restart Internet Explore</p>
				        </li>
				    </ol>
				    <p class="a-top"><a href="#top">Back to Top</a></p>
				    <h3><a name="ie6"></a>Internet Explorer 6.x</h3>
				    <ol>
				        <li>
				            <p>Select <strong>Internet Options</strong> from the Tools menu</p>
				            <p><img src="{{skin url="images/cookies/ie6-1.gif"}}" alt="" /></p>
				        </li>
				        <li>
				            <p>Click on the <strong>Privacy</strong> tab</p>
				        </li>
				        <li>
				            <p>Click the <strong>Default</strong> button (or manually slide the bar down to <strong>Medium</strong>) under <strong>Settings</strong>. Click <strong>OK</strong></p>
				            <p><img src="{{skin url="images/cookies/ie6-2.gif"}}" alt="" /></p>
				        </li>
				    </ol>
				    <p class="a-top"><a href="#top">Back to Top</a></p>
				    <h3><a name="firefox"></a>Mozilla/Firefox</h3>
				    <ol>
				        <li>
				            <p>Click on the <strong>Tools</strong>-menu in Mozilla</p>
				        </li>
				        <li>
				            <p>Click on the <strong>Options...</strong> item in the menu - a new window open</p>
				        </li>
				        <li>
				            <p>Click on the <strong>Privacy</strong> selection in the left part of the window. (See image below)</p>
				            <p><img src="{{skin url="images/cookies/firefox.png"}}" alt="" /></p>
				        </li>
				        <li>
				            <p>Expand the <strong>Cookies</strong> section</p>
				        </li>
				        <li>
				            <p>Check the <strong>Enable cookies</strong> and <strong>Accept cookies normally</strong> checkboxes</p>
				        </li>
				        <li>
				            <p>Save changes by clicking <strong>Ok</strong>.</p>
				        </li>
				    </ol>
				    <p class="a-top"><a href="#top">Back to Top</a></p>
				    <h3><a name="opera"></a>Opera 7.x</h3>
				    <ol>
				        <li>
				            <p>Click on the <strong>Tools</strong> menu in Opera</p>
				        </li>
				        <li>
				            <p>Click on the <strong>Preferences...</strong> item in the menu - a new window open</p>
				        </li>
				        <li>
				            <p>Click on the <strong>Privacy</strong> selection near the bottom left of the window. (See image below)</p>
				            <p><img src="{{skin url="images/cookies/opera.png"}}" alt="" /></p>
				        </li>
				        <li>
				            <p>The <strong>Enable cookies</strong> checkbox must be checked, and <strong>Accept all cookies</strong> should be selected in the &quot;<strong>Normal cookies</strong>&quot; drop-down</p>
				        </li>
				        <li>
				            <p>Save changes by clicking <strong>Ok</strong></p>
				        </li>
				    </ol>
				    <p class="a-top"><a href="#top">Back to Top</a></p>
				</div>
				"
				  ["creation_time"] => string(19) "2010-08-11 13:34:57"
				  ["update_time"] => string(19) "2010-08-11 13:34:57"
				  ["is_active"] => string(1) "1"
				  ["sort_order"] => string(1) "0"
				  ["layout_update_xml"] => NULL
				  ["custom_theme"] => NULL
				  ["custom_root_template"] => string(0) ""
				  ["custom_layout_update_xml"] => NULL
				  ["custom_theme_from"] => NULL
				  ["custom_theme_to"] => NULL
				  ["store_id"] => array(1) {
				    [0] => string(1) "0"
				  }
				}
			 */
			return $p->toArray();
		}
		catch (Exception $e) {
			return array();
		}
	}
}