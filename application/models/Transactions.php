<?php

/**
 * This is a "CMS" model for quotes, but with bogus hard-coded data,
 * so that we don't have to worry about any database setup.
 * This would be considered a "mock database" model.
 *
 * @author jim
 */
class Transactions extends CI_Model {

	// Constructor
	public function __construct()
	{
		parent::__construct();
	}

	public function getProducts(){
		return $this->session->products;
	}

	public function setProducts($id, $value)
    {
        //get previous saved data
        $data = $this->session->products;

        //add new data
        $data[$id] = isset($data[$id]) ? $data[$id] += $value : $value;

        //save to session
        $this->session->set_userdata('products', $data);
	}

	public function getRecipes()
    {
        return $this->session->recipes;
	}

	public function setRecipes($id, $value)
    {
        //get previous saved data
        $data = $this->session->recipes;

        //add new data
        $data[$id] = isset($data[$id]) ? $data[$id] += $value : $value;

        //save to session
        $this->session->set_userdata('recipes', $data);
	}

	public function getMaterials()
    {
        return $this->session->materials;
	}

	public function setMaterials($id, $value)
    {
        //get previous saved data
	    $data = $this->session->materials;

        //add new data
        $data[$id] = isset($data[$id]) ? $data[$id] += $value : $value;

        //save to session
        $this->session->set_userdata('materials', $data);
	}
}
