<?php

/**
 * ControllerExtensionModulePopup
 *
 * Class for the admin area of Popup.
 * Allows the user to edit the popup text and set the start & end date of that popup.
 *
 * @author Natalie de Weerd <natalie@fsedesign.co.uk>
 *
 */

 
class ControllerExtensionModulePopup extends Controller{
	
	private $error = array();
	
	/*
	 * __controller function
	 */
	
	public function index() { 
	
		$this->load->language('extension/module/popup'); // Loading the language file for popup
		
		$this->document->setTitle($this->language->get('heading_title')); // Set the title of the page to the heading title in the Language file i.e., Popup
		
		$this->load->model('setting/setting'); // Load the Setting Model  (All of the OpenCart Module & General Settings are saved using this Model )
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			// Validates permissions and check if data is coming by save (POST) method
			
			$this->model_setting_setting->editSetting('popup', $this->request->post); // Parse all the coming data to Setting Model to save it in database.
			$this->session->data['success'] = $this->language->get('text_success'); // To display the success text on data save
			$this->response->redirect($this->url->link('extension/module/popup', 'token=' . $this->session->data['token'], 'SSL'));
			
		}
		
		$data = $this->load->language('extension/module/popup'); // load languages from language file and add them straight to $data array.
		
		// This Block returns the warning if any
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		// This Block returns the error code if any
		if (isset($this->error['code'])) {
			$data['error_code'] = $this->error['code'];
		} else {
			$data['error_code'] = '';
		}
		
		/* Making of Breadcrumbs to be displayed on site*/
		$data['breadcrumbs'] = array();
	 
		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);
	 
		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);
	 
		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/popup', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);
		
		// Redirects on save & cancel
		$data['action'] = $this->url->link('extension/module/popup', 'token=' . $this->session->data['token'], 'SSL');
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		
		
		// This bock checks if the text has been set. If it has, show it, otherwise show the default.
		if (isset($this->request->post['popup_textbox'])) {
			$data['popup_textbox'] = $this->request->post['popup_textbox'];
		} else {
			$data['popup_textbox'] = $this->config->get('popup_textbox');
		}
		
		// This bock checks if the text has been set. If it has, show it, otherwise show the default.
		if (isset($this->request->post['popup_textbox__title'])) {
			$data['popup_textbox__title'] = $this->request->post['popup_textbox__title'];
		} else {
			$data['popup_textbox__title'] = $this->config->get('popup_textbox__title');
		}
		
		if (isset($this->request->post['popup_date_start'])) {
			$data['popup_date_start'] = $this->request->post['popup_date_start'];
		} else {
			$data['popup_date_start'] = $this->config->get('popup_date_start');
		}
		
		if (isset($this->request->post['popup_date_end'])) {
			$data['popup_date_end'] = $this->request->post['popup_date_end'];
		} else {
			$data['popup_date_end'] = $this->config->get('popup_date_end');
		}
		
		// This block parses the status (enabled / disabled)
        if (isset($this->request->post['popup_status'])) {
            $data['popup_status'] = $this->request->post['popup_status'];
        } else {
            $data['popup_status'] = $this->config->get('popup_status');
        }
		
		$this->load->model('design/layout'); // Loading the Design Layout Models		
		$data['layouts'] = $this->model_design_layout->getLayouts(); // Getting all the Layouts available on system
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('extension/module/popup.tpl', $data)); // Rendering the Output
	
	}
	
	/*
	 * Function that validates the data when Save Button is pressed 
	 */
	
    protected function validate() {
 
        // Block to check the user permission to manipulate the module
        if (!$this->user->hasPermission('modify', 'extension/module/popup')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
 
        // Block to check if the popup_text_field is properly set to save into database, otherwise the error is returned
        if (!$this->request->post['popup_textbox']) {
            $this->error['code'] = $this->language->get('error_code');
        }
		
		if (!$this->request->post['popup_textbox__title']) {
            $this->error['code'] = $this->language->get('error_code');
        }
		
		if (!$this->request->post['popup_date_start']) {
            $this->error['code'] = $this->language->get('error_code');
        }
		
		if (!$this->request->post['popup_date_end']) {
            $this->error['code'] = $this->language->get('error_code');
        }
		
        // Block returns true if no error is found, else false if any error detected
        if (!$this->error) {
            return true;
        } else {
            return false;
        }
		
    }
	
}
 
 
?>