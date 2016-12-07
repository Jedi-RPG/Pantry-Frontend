<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Application
{

    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        // This is the view we want shown
        $this->data['pagebody'] = 'dashboard';

        $this->data['materials_cost'] = $this->calc_value('Materials');

        $this->data['recipes_cost'] = $this->calc_products_cost();

        $this->data['revenue'] = $this->calc_value('Products');

        $this->data['products_stocked'] = $this->num_items('Products');

        $this->data['recipes_count'] = $this->num_items('Recipes');

        $this->render();

    }
      /*
       * Deprecated: no longer logging transactions
       */
//    public function calculate_value_purchased($type, $getInventory){
//        $inventory = $getInventory;
//        $sum = 0;
//        for ($i = 2; $i <= count($inventory); $i++){
//            if ($inventory[$i]!= 0){
//                $record = $this->$type->get($i);
//                $sum += $record['price'] * $inventory[$i];
//            }
//        }
//        return $sum;
//    }

    /*
     * param: 'Materials' or 'Products'
     * Returns sum of item values from input model
     */
    private function calc_value($type){
        $item_list = $this->$type->all();
        $sum = 0;
        foreach ($item_list as $record){
            if ($type == 'Materials'){
                $sum += $record['price'] * $record['amount'] / $record['itemPerCase'];
            } else {
                $sum += $record['price'] * $record['amount'];
            }

        }

        return $this->toDollars($sum, 2);
    }

    /*
     * Returns cost of materials for all products produced
     */
    private function calc_products_cost(){
        $item_list = $this->Products->all();
        $sum = 0;
        foreach ($item_list as $record){
            $num_made = $record['amount'];
            $cost_single = $this->calc_ingredients_cost($record['id']);
            $sum += $num_made * $cost_single;
        }

        return $this->toDollars($sum, 2);
    }

    /*
     * param: id of recipe
     * Returns cost of ingredients for one crafted item from input recipe
     */
    private function calc_ingredients_cost($id){
        $materials = $this->Recipes->get($id)['materials'];
        $sum = 0;
        foreach ($materials as $item => $attrib){
            $material = $this->Materials->getMaterialWithName($attrib['name']);
            $sum += $material['price'] / $material['itemPerCase'] * $attrib['amount'];
        }

        return $sum;
    }

    /*
     * param: model name
     * Returns count of different items stocked
     */
    private function num_items($type){
        return count($this->$type->all());
    }
}
