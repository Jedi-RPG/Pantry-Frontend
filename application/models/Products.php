<?php

/**
 * This is a "CMS" model for quotes, but with bogus hard-coded data,
 * so that we don't have to worry about any database setup.
 * This would be considered a "mock database" model.
 *
 * @author jim
 */
class Products extends CI_Model {

	var $data = array(
		array(	'id' => '1', 
				'name' => 'health potion',
				'amount' => 1,
				'desc' => 'Restores 150 Health over 15 seconds',
				'price' => 50),

		array(	'id' => '2', 
				'name' => 'mana potion',
				'amount' => 100,
				'desc' => 'Restores 150 Mana over 15 seconds',
				'price' => 50),

		array(	'id' => '3', 
				'name' => 'iron sword',
				'amount' => 233,
				'desc' => '+40 Attack Damage',
				'price' => 1300),

		array(	'id' => '4', 
				'name' => 'iron breastplate',
				'amount' => 2129,
				'desc' => '+40 Armor',
				'price' => 800),

		array(	'id' => '5', 
				'name' => 'iron greaves',
				'amount' => 3,
				'desc' => 'Enhanced Movement: +25 Movement Speed',
				'price' => 300),

		array(	'id' => '6', 
				'name' => 'steel sword',
				'amount' => 99,
				'desc' => '+75 Attack Damage',
				'price' => 2800),

		array(	'id' => '7', 
				'name' => 'steel breastplate',
				'amount' => 1200,
				'desc' => '+100 Armor',
				'price' => 2300),

		array(	'id' => '8', 
				'name' => 'steel greaves',
				'amount' => 322,
				'desc' => 'Enhacned Movement: +55 Movement Speed',
				'price' => 900),

		array(	'id' => '9', 
				'name' => 'arrow',
				'amount' => 19,
				'desc' => '+25 Attack Damage',
				'price' => 1000),

		array(	'id' => '10', 
				'name' => 'fire scroll',
				'amount' => 80,
				'desc' => 'Elemental Enchanting: +5% Fire Damage',
				'price' => 700),

		array(	'id' => '11', 
				'name' => 'water scroll',
				'amount' => 500,
				'desc' => 'Elemental Enchanting: +5% Water Damage',
				'price' => 700),

		array(	'id' => '12', 
				'name' => 'lightning scroll',
				'amount' => 43,
				'desc' => 'Elemental Enchanting: +5% Lightning Damage',
				'price' => 700),

		array(	'id' => '13', 
				'name' => 'poison scroll',
				'amount' => 1234,
				'desc' => 'Elemental Enchanting: +5% Poison Damage',
				'price' => 700)

	);

	// Constructor
	public function __construct()
	{
		parent::__construct();
	}

	// retrieve a single quote
	public function get($id)
	{
		// iterate over the data until we find the one we want
		foreach ($this->data as $record)
			if ($record['id'] == $id)
				return $record;
		return null;
	}

	// retrieve all of the quotes
	public function all()
	{
		return $this->data;
	}

	// clears transactions
    public function clear() {
        $this->session->unset_userdata('products');
        echo 'products transactions cleared!';
    }

}
