<?php
class Login_2 {
	public function logged_in_2()
    {
    	$_this =& get_instance();
    	if ($_this->session->userdata('masuk') == TRUE) {
    		redirect('Admin','refresh');
    	}
    }
}