<?php

/**
 * ModelExtensionModulePopup
 *
 * Model class for Popup
 * Supporting functions all stored here.
 *
 * @author Natalie de Weerd <natalie@fsedesign.co.uk>
 *
 */
 
class ModelExtensionModulePopup extends Controller {
	
	
	/**
	 * Checks the date range and determines if "now" is within the start and end dates provided.
	 *
	 * @param   $startDate		Date	Start date in Y-m-d format
	 * @param   $endDate		Date	End date in Y-m-d format
	 *
	 * @author Natalie de Weerd <natalie@fsedesign.co.uk>
	 * @return Boolean
	 */

	public function checkDateRange($startDate,$endDate){
		
		$now = time();
		$start = strtotime($startDate);
		$end = strtotime($endDate);
		
		if($start <= $now && $now <= $end){
			// date is within range
			return true;
		} else {
			return false;
		}
		
	}

}

?>