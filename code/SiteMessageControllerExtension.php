<?php

class SiteMessageControllerExtension extends Extension {
	
	/**
	 * Before the class is initialised, insert required CSS/Javascript
	 * @return NULL
	 */
	public function onAfterInit() {

		Requirements::css(SITEMESSAGES_DIR . '/css/fonts.css');
		Requirements::css(SITEMESSAGES_DIR . '/css/main.css');
		Requirements::javascript('framework/thirdparty/jquery/jquery.js');
		Requirements::javascript(SITEMESSAGES_DIR . '/javascript/sitemessages.js');

	}
	
	/**
	 * Get all site messages that have not be closed (cookie stored) to be displayed on the page
	 * @return DataList A DataList of site messages
	 */
	public function getSiteMessages() {

		$today = date('Y-m-d H:i:s');
		$unique_cookies = array();
		
		// Create an array of sm_ cookies found in the browser
		foreach($_COOKIE as $key => $value) {
			
			if($this->getValidCookie($key) && $value == "closed") {
				$unique_cookies[] = $key;
			}
		}
		
		// Get site messages from the database
		$messages = SiteMessage::get()
			->where("Permanent = 1 OR (Start < '$today' AND End > '$today')")
			->exclude('Unique', $unique_cookies);
		
		// Prepare site message DataList for the template
		if($messages) {
			
			$all_messages = $this->owner->customise(
				array(
					"SiteMessages" => $messages
				)
			);
			
			return $all_messages->renderWith("SiteMessage");
			
		}else {
			return FALSE;
		}

	}
	
	/**
	 * Select the sm_ prefixed cookies from the browser
	 * @param  String $cookie The cookie name to be checked
	 * @return Boolean        If TRUE, the cookie is prefixed with sm_
	 */
	public function getValidCookie($cookie) {
		
		$prefix = substr($cookie, 0, 3);
		if($prefix == "sm_") {
			return TRUE;
		}
		
	}

}