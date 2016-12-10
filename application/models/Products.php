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

	function rules() {
		$config = [
			['field'=>'id', 'label'=>'Product code', 'rules'=> 'required|integer'],
			['field'=>'name', 'label'=>'Product name', 'rules'=> 'required'],
			['field'=>'stock', 'label'=>'Stock', 'rules'=> 'required|integer'],
			['field'=>'desc', 'label'=>'Description', 'rules'=> 'required'],
			['field'=>'price', 'label'=>'Price', 'rules'=> 'required|decimal']
		];
		return $config;
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

		// Update a record in the DB
	function update($record)
	{
		// convert object to associative array, if needed
		if (is_object($record))
		{
			$data = get_object_vars($record);
		} else
		{
			$data = $record;
		}
		// update the DB table appropriately
		$key = $data["id"];
		$this->db->where('id', $key);
		return $this->db->update('product', $data);
	}

	// Create a new data object.
	// Only use this method if intending to create an empty record and then
	// populate it.
	function create()
	{
		$names = ['id','name', 'stock','desc','price'];
		$object = new StdClass;
		foreach ($names as $name)
			$object->$name = "";
		return $object;
	}


	// Determine if a key exists
	function exists($key, $key2 = null)
	{
		$this->db->where('id', $key);
		$query = $this->db->get('product');
		if ($query->num_rows() < 1)
			return false;
		return true;
	}

	// Add a record to the DB
	function add($record)
	{
		// convert object to associative array, if needed
		if (is_object($record))
		{
			$data = get_object_vars($record);
		} else
		{
			$data = $record;
		}
		// update the DB table appropriately
		$key = $data['id'];
		return $this->db->insert('product', $data);
	}

	// Delete a record from the DB
	function delete($key, $key2 = null)
	{
		$this->db->where('id', $key);
		return $this->db->delete('product');
	}

}
