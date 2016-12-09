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

}
