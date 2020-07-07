<?php 

class template {

	private $template_id = null;
	private $email_type = null;
	private $cdn_path = null;

	function __construct($template_id, $email_type){
		$this->template_id = $template_id;
		$this->email_type = $email_type;
		$this->cdn_path = WORKING_DIRECTORY . '/email_templates';
	}

	function get_content(){
		ob_start();
		require_once(sprintf("%s/%s/%s.php", $this->cdn_path, $this->email_type, $this->template_id));
		return ob_get_clean();
	}
}
