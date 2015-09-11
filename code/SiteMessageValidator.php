<?php

class SiteMessageValidator extends RequiredFields {
	
	/**
	 * Custom validation for the SiteMessage CMS form
	 * @param  Mixed	$data
	 * @return Boolean Returns TRUE/FALSE based on errors found in the validator
	 */
	function php($data) {
		
		$valid = TRUE;
		
		// If there is button text but no page to link to
		if($data['ButtonText'] && !$data['PageID']) {
			$this->validationError(
				"PageID",
				_t("SiteMessage.PAGEIDERROR", "Please choose a page to link to or remove the button text."),
				"error"
			);
			
			// Return false
			$valid = FALSE;
		}
		
		// If there is no button text but a page to link to
		if(!$data['ButtonText'] && $data['PageID']) {
			$this->validationError(
				"ButtonText",
				_t("SiteMessage.BUTTONTEXTERROR", "Please enter button text or remove the page to link to."),
				"error"
			);
			
			// Return false
			$valid = FALSE;
		}
		
		return $valid;
		
	}
	
}