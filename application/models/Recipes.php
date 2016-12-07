<?php

/**
 * @author Matt
 */
class Recipes extends CI_Model {

	var $data = array(
		array(	'id' => '1', 
				'name' => 'health potion',
				'materials' => array(
					'item1' => array(
						'name' => 'red herb',
						'amount' => 2
						),
					'item2' => array(
						'name' => 'empty bottle',
						'amount' => 1
						)
					),
				'desc' => 'Restores 150 Health over 15 seconds',
				'price' => 50),

		array(	'id' => '2', 
				'name' => 'mana potion',
				'materials' => array(
					'item1' => array(
						'name' => 'blue herb',
						'amount' => 3
						),
					'item2' => array(
						'name' => 'empty bottle',
						'amount' => 1
						)
					),
				'desc' => 'Restores 150 Mana over 15 seconds',
				'price' => 50),

		array(	'id' => '3', 
				'name' => 'iron sword',
				'materials' => array(
					'item1' => array(
						'name' => 'iron ingot',
						'amount' => 12
						),
					'item2' => array(
						'name' => 'leather',
						'amount' => 1
						)
					),
				'desc' => '+40 Attack Damage',
				'price' => 1300),

		array(	'id' => '4', 
				'name' => 'iron breastplate',
				'materials' => array(
					'item1' => array(
						'name' => 'iron ingot',
						'amount' => 15
						),
					'item2' => array(
						'name' => 'leather',
						'amount' => 5
						)
					),
				'desc' => '+40 Armor',
				'price' => 800),

		array(	'id' => '5', 
				'name' => 'iron greaves',
				'materials' => array(
					'item1' => array(
						'name' => 'iron ingot',
						'amount' => 10
						),
					'item2' => array(
						'name' => 'leather',
						'amount' => 1
						)
					),
				'desc' => 'Enhanced Movement: +25 Movement Speed',
				'price' => 300),

		array(	'id' => '6', 
				'name' => 'steel sword',
				'materials' => array(
					'item1' => array(
						'name' => 'steel ingot',
						'amount' => 12
						),
					'item2' => array(
						'name' => 'leather',
						'amount' => 1
						)
					),
				'desc' => '+75 Attack Damage',
				'price' => 2800),

		array(	'id' => '7', 
				'name' => 'steel breastplate',
				'materials' => array(
					'item1' => array(
						'name' => 'steel ingot',
						'amount' => 15
						),
					'item2' => array(
						'name' => 'leather',
						'amount' => 5
						)
					),
				'desc' => '+100 Armor',
				'price' => 2300),

		array(	'id' => '8', 
				'name' => 'steel greaves',
				'materials' => array(
					'item1' => array(
						'name' => 'steel ingot',
						'amount' => 10
						),
					'item2' => array(
						'name' => 'leather',
						'amount' => 2
						)
					),
				'desc' => 'Enhacned Movement: +55 Movement Speed',
				'price' => 900),

		array(	'id' => '9', 
				'name' => 'arrow',
				'materials' => array(
					'item1' => array(
						'name' => 'wood',
						'amount' => 1
						),
					'item2' => array(
						'name' => 'leather',
						'amount' => 1
						),
                                        'item3' => array(
						'name' => 'iron ingot',
						'amount' => 1
						)
					),
				'desc' => '+25 Attack Damage',
				'price' => 1000),

		array(	'id' => '10', 
				'name' => 'fire scroll',
				'materials' => array(
					'item1' => array(
						'name' => 'ruby dust',
						'amount' => 5
						),
					'item2' => array(
						'name' => 'scroll',
						'amount' => 1
						)
					),
				'desc' => 'Elemental Enchanting: +5% Fire Damage',
				'price' => 700),

		array(	'id' => '11', 
				'name' => 'water scroll',
				'materials' => array(
					'item1' => array(
						'name' => 'sapphire dust',
						'amount' => 5
						),
					'item2' => array(
						'name' => 'scroll',
						'amount' => 1
						)
					),
				'desc' => 'Elemental Enchanting: +5% Water Damage',
				'price' => 700),

		array(	'id' => '12', 
				'name' => 'lightning scroll',
				'materials' => array(
					'item1' => array(
						'name' => 'topaz dust',
						'amount' => 5
						),
					'item2' => array(
						'name' => 'scroll',
						'amount' => 1
						)
					),
				'desc' => 'Elemental Enchanting: +5% Lightning Damage',
				'price' => 700),

		array(	'id' => '13', 
				'name' => 'poison scroll',
				'materials' => array(
					'item1' => array(
						'name' => 'emerald dust',
						'amount' => 5
						),
					'item2' => array(
						'name' => 'scroll',
						'amount' => 1
						)
					),
				'desc' => 'Elemental Enchanting: +5% Poison Damage',
				'price' => 700)

	);

	// Constructor
	public function __construct()
	{
		parent::__construct();
	}

	// returns a recipe using recipeId
	public function get($id)
	{
		// iterate over the data until we find the one we want
		foreach ($this->data as $record)
			if ($record['id'] == $id)
				return $record;
		return null;
	}

	// retrieve all of the recipes
	public function all()
	{
		return $this->data;
	}

    public function clear() {
        $this->session->unset_userdata('recipes');
        echo 'recipes transactions cleared!';
    }

}
