<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Application
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("Order");
    }

    public function index()
    {
        // This is the view we want shown
        $this->data['pagebody'] = 'dashboard';

        $this->data['materials_cost'] = $this->calc_value('Receiving', 'Materials');
        $this->data['revenue'] = $this->calc_value('Sales', 'Products');

        $this->data['recipes_cost'] = $this->calc_products_cost();     
          
        $this->data['products_stocked'] = $this->num_items('Products');
        $this->data['recipes_count'] = $this->num_items('Recipes');

        $this->render();

    }

    /*
     * param: 'Materials' or 'Products'
     * Returns sum of item values from input model
     */
    private function calc_value($page, $model){
        $sum = 0;

        // identify all of the order files
        $this->load->helper('directory');
        $candidates = directory_map(ORDER_DIR . $page);
        $parms = array();

        // iterate through each order
        foreach ($candidates as $filename) {
           // restore that order object
           $order = new Order();
           $order->loadXML(ORDER_DIR . '/' . $page . '/' . $filename);
        
           // iterate through each item in an order
            foreach ($order->items as $id => $amount){
                $item = $this->$model->get($id);
                $sum += $item->price * $amount;
            }
        }
        return $this->toDollars($sum, 2);
    }

    /*
     * Returns cost of materials for all products produced
     */
    private function calc_products_cost(){
        $sum = 0;

        // identify all of the order files
        $this->load->helper('directory');
        $candidates = directory_map(ORDER_DIR . 'Production');
        $parms = array();

        // iterate through each order
        foreach ($candidates as $filename) {
           // restore that order object
           $order = new Order();
           $order->loadXML(ORDER_DIR . '/' . 'Production' . '/' . $filename);
        
           // iterate through each item in an order
            foreach ($order->items as $id => $product_amount){
                
                // get recipe information for this product
                $recipe = $this->Recipes->get($id);
                $material_1_id = $recipe->MaterialOneId;
                $material_1_amt = $recipe->AmountOne;
                $material_2_id = $recipe->MaterialTwoId;
                $material_2_amt = $recipe->AmountTwo;

                // get material information from db and calculate costs
                $material_1 = $this->Materials->get($material_1_id);
                $material_2 = $this->Materials->get($material_2_id);
                $sum += $material_1->price * $material_1_amt * $product_amount;
                $sum += $material_2->price * $material_2_amt * $product_amount;
            }
        }
        return $this->toDollars($sum, 2);
    }

    /*
     * param: model name
     * Returns count of different items stocked
     */
    private function num_items($type){
        return count($this->$type->all());
    }
}
