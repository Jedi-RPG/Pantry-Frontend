<?php

/**
 * core/MY_Controller.php
 *
 * Default application controller
 *
 * @author		JLP
 * @copyright           2010-2016, James L. Parry
 * ------------------------------------------------------------------------
 */
class Application extends CI_Controller
{

	/**
	 * Constructor.
	 * Establish view parameters & load common helpers
	 */

	function __construct()
	{
		parent::__construct();

		//  Set basic view parameters
		$this->data = array ();
		$this->data['pagetitle'] = 'RPGCrafter';
		$this->data['ci_version'] = (ENVIRONMENT === 'development') ? 'CodeIgniter Version <strong>'.CI_VERSION.'</strong>' : '';

		$current_page = base_url(uri_string());
		$current_page = substr($current_page,1);
		$index = strpos($current_page, "/");
		if($index != false){
			$current_page = substr($current_page,0,$index);
		}
		$this->data['dActive'] = $current_page == '' ? "class = 'active'" : "";
		$this->data['aActive'] = $current_page == 'admin' ? "class = 'active'" : "";
		$this->data['rActive'] = $current_page == 'receiving' ? "class = 'active'" : "";
		$this->data['pActive'] = $current_page == 'production' ? "class = 'active'" : "";
		$this->data['sActive'] = $current_page == 'sales' ? "class = 'active'" : "";

	}

	/**
	 * Render this page
	 */
	function render($template = 'template')
	{
        //previous button
        $previous = array('onclick' =>'javascript:window.history.go(-1)');
        $this->data['previous'] = form_button($previous, 'Previous', "class='submit'");

		$this->data['content'] = $this->parser->parse($this->data['pagebody'], $this->data, true);
		$this->parser->parse('template', $this->data);
	}

    /*
     * Display string as currency
     */
    function toDollars($value){
        return '$' . number_format($value, 2);
    }

}
