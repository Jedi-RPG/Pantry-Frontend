<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sales extends Application
{

    function __construct()
	{
		parent::__construct();
	}

	/**
	 * Homepage for our app
	 */
	public function index()
	{
		// this is the view we want shown
		$this->data['pagebody'] = 'sale_list';
        //create table with list of products
		$this->create_form('Products');

		$this->render();
	}

	private function create_form($type) {

        //Open form
        $this->data['form_open'] = form_open('sales/sales');

        // Get list of items

        $source = $this->$type->all();

        // Set table headers
        $items[] = array('Name', 'Description', 'Stock', 'Price', 'Quantity');

        // Add table rows
        foreach ($source as $record)
        {
            $num_input = array('type' => 'number', 'value' => '0', 'class' => 'num-field', 'name' => $record->id);
            
            $items[] = array('<a href="/sales/get/' .
                              $record->id. '">' .
                              $record->name . '</a>',
                              $record->desc,
                              $record->stock,
                              $this->toDollars($record->price),
                              form_input($num_input, "", "class='input'"));
        }

        //Generate the materials table
        $this->data[$type.'_table'] = $this->table->generate($items);
        //submit button
        $this->data['order_button'] = form_submit('', 'Order', "class='submit'");
        //clear form
        $this->data['clear_data'] = form_reset('','Clear', "class='submit'");
        //close form
        $this->data['form_close'] = form_close();
    }

    public function get($id){
        $this->data['pagebody'] = 'sale_single';

        $source = $this->Products->get($id);

        $items[] = array('Name', 'Description', 'Price');
        $items[] = array($source->name, $source->desc, $this->toDollars($source->price));

        $this->data['stock_table'] = $this->table->generate($items);

        $this->render();
    }

    public function sales(){
        $this->data['pagebody'] = 'sale_confirmation';
        //$inventory[] = array();
        foreach($_POST as $post_name => $post_value){    
            $inventory[] = array('key' => $post_name, 'value' => $post_value);
        }
        $outcome = array();
        $totalSum = 0;
        $okToProcess = 0;
    
        foreach($inventory as $product){
            $record = $this->Products->get($product['key']);
            $quantityOrdered = $product['value'];

            if(($quantityOrdered != 0) && ($quantityOrdered <= $record->stock)){
                $okToProcess = $quantityOrdered;   
            }else if($quantityOrdered == 0){
                $okToProcess = 0;
            }else{
                $okToProcess = -1;
            }

            if($okToProcess == -1){
                $outcome[] = array('line' => "Not enough stocks to process the order: " . $record->name . "</br>");
            }else if($okToProcess == 1){
                $outcome[] = array('line' => "You ordered " . $okToProcess . ' ' . $record->name . " at " . $this->toDollars($record->price) . "per unit." . "</br>");
            }else if($okToProcess > 1){
                $outcome[] = array('line' => "You ordered " . $okToProcess . ' ' . $record->name . "s at " . $this->toDollars($record->price) . "per unit." . "</br>");
            }            
            
            if($okToProcess > 0){
                $totalSum += $record->price * $okToProcess;    
            }            
        }
        $outcome[] = array('line' => "<br><strong>Grand Total:</strong> " . $this->toDollars($totalSum));
        $this->data['result'] = $outcome;
        $this->render();
    }

    public function clear() {
        $this->Products->clear();
    }
}