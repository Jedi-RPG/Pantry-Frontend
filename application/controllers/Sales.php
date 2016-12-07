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
            $num_input = array('type' => 'number', 'value' => '0', 'class' => 'num-field', 'name' => $record['id']);
            
            $items[] = array('<a href="/sales/get/' .
                              $record['id']. '">' .
                              $record['name'] . '</a>',
                              $record['desc'],
                              $record['amount'],
                              $this->toDollars($record['price']),
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
        $items[] = array($source['name'], $source['desc'], $this->toDollars($source['price']));

        $this->data['stock_table'] = $this->table->generate($items);

        $this->render();
    }

    public function sales(){
        $this->data['pagebody'] = 'sale_confirmation';
        //$inventory[] = array();
        foreach($_POST as $post_name => $post_value){
            $this->Transactions->setProducts($post_name, $post_value);
            $inventory[] = array('key' => $post_name, 'value' => $post_value);
        }

        $result = array();
        $sum = 0;
        foreach($inventory as $source){
            $record = $this->Products->get($source['key']);

            if($source['value'] == 1){
                $result[] = array('line' => "You ordered " . $source['value'] . ' ' .  $record['name'] .
                    " at " . $this->toDollars($record['price'])  . " per unit." . "</br>");
            }else if($source['value'] > 1){
                $result[] = array('line' => "You ordered " . $source['value'] . ' ' .  $record['name'] .
                    "s at " . $this->toDollars($record['price'])  . " per unit." . "</br>");
            }

            $sum += $record['price'] * $source['value'];
        }
        $result[] = array('line' => "<br><strong>Grand Total:</strong> " . $this->toDollars($sum));
        $this->data['result'] = $result;

        $this->render();
    }

    public function clear() {
        $this->Products->clear();
    }
}