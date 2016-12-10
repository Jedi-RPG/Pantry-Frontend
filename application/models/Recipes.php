<?php

/**
 * @author Matt
 */
class Recipes extends CI_Model {
	// Constructor
	public function __construct()
	{
		parent::__construct();
	}

	function rules() {
		$config = [
			['field'=>'id', 'label'=>'Recipe code', 'rules'=> 'required|integer'],
			['field'=>'MaterialOneId', 'label'=>'Material one id', 'rules'=> 'required|integer'],
			['field'=>'AmountOne', 'label'=>'Material one amount', 'rules'=> 'required|integer'],
			['field'=>'MaterialTwoId', 'label'=>'Material two id', 'rules'=> 'required|integer'],
			['field'=>'AmountTwo', 'label'=>'Material two amount', 'rules'=> 'required|integer']
		];
		return $config;
	}

	// returns a recipe using recipeId
	public function get($id)
	{
		$query = $this->db->get_where('recipe', array('id' => $id));
		$result = $query->row();
		return $result;
	}

	// retrieve all of the recipes
	public function all()
	{
		$query = $this->db->get('recipe');
		return $result = $query->result();
	}

    public function clear() {
        $this->session->unset_userdata('recipes');
        echo 'recipes transactions cleared!';
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
		return $this->db->update('recipe', $data);
	}

}
