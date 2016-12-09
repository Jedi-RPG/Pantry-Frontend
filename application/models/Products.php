<?php

/**
 * This is a "CMS" model for quotes, but with bogus hard-coded data,
 * so that we don't have to worry about any database setup.
 * This would be considered a "mock database" model.
 *
 * @author jim
 */
class Products extends CI_Model {

	//var $data = array(
	//	array(	'id' => '1', 
	//			'name' => 'health potion',
	//			'amount' => 1,
	//			'desc' => 'Restores 150 Health over 15 seconds',
	//			'price' => 50)
	//);

	// Constructor
	public function __construct()
	{
		parent::__construct();
	}

	// returns a recipe using recipeId
	public function get($id)
	{
		$query = $this->db->get_where('product', array('id' => $id));
		$result = $query->row();
		return $result;
	}

	// retrieve all of the recipes
	public function all()
	{
		$query = $this->db->get('product');
		return $result = $query->result();
	}


	// clears transactions
    public function clear() {
        $this->session->unset_userdata('products');
        echo 'products transactions cleared!';
    }

}
