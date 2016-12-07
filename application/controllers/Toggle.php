<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Toggle
 *
 * @author Pika
 */
class Toggle extends Application {
    
	public function index()	{
		$origin = $_SERVER['HTTP_REFERER'];
		$role = $this->session->userdata('userrole');
                
		if ($role == 'Guest') {
                    $role = 'User';
                }elseif($role == 'User'){
                    $role = 'Admin';
                }else{
                    $role = 'Guest';
                }
                
		$this->session->set_userdata('userrole', $role);
		redirect($origin);
	}
}