<?php

/**
 * ControllerExtensionModulePopup
 *
 * Controller class for Popup
 *
 * @author Natalie de Weerd <natalie@fsedesign.co.uk>
 *
 */
 
class ControllerExtensionModulePopup extends Controller {
	
	/**
	 * __construct function. Runs when controller is called.
	 *
	 * @author Natalie de Weerd <natalie@fsedesign.co.uk>
	 * @return view popup.tpl
	 */
	
	public function index(){
		
		// Load styles & scripts
		$this->document->addScript('catalog/view/javascript/popup.js');
		$this->document->addStyle('catalog/view/theme/default/stylesheet/popup.css');
		
		// Load model
		$this->load->model('extension/module/popup');
		
		$status = $this->config->get('popup');
	 
		$data['popup__title'] = html_entity_decode($this->config->get('popup_textbox__title')); 
		$data['popup__text'] = html_entity_decode($this->config->get('popup_textbox'));
		$data['popup_date_start'] = html_entity_decode($this->config->get('popup_date_start'));
		$data['popup_date_end'] = html_entity_decode($this->config->get('popup_date_end'));
		
		$result = $this->model_extension_module_popup->checkDateRange($data['popup_date_start'], $data['popup_date_end']);
		
		if($result){
			
			// If today is within range, show popup
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/extension/module/popup.tpl')) {
				return $this->load->view($this->config->get('config_template') . '/template/extension/module/popup.tpl', $data);
			} else {
				return $this->load->view('extension/module/popup.tpl', $data);
			}
			
		} else {
			
			// No popup!
			
		}	
		
	}

}

?>