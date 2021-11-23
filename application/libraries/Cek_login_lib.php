<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Cek_login_lib
{
    // jika status masuk masih FALSE
    public function logged_in_false()
    {
        $_this =& get_instance();
        if ($_this->session->userdata('masuk') != 'i_care') {
            redirect('c_login', 'refresh');
        }
    }

    // jika status masuk telah TRUE
    public function logged_in_true()
    {
        $_this =& get_instance();
        if ($_this->session->userdata('masuk') == 'i_care') {
            redirect("master", 'refresh');
        }
    }
}

/* End of file Cek_login_lib.php */
