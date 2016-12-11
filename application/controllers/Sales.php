<?php

defined('BASEPATH') OR exit('No direct script access allowed');
define("SALES_ORDER_DIR", "../data/order/Sales/");

class Sales extends Application
{

        function __construct()
	{
		parent::__construct();
                $this->load->model('Order');
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
                $this->data['summary'] = "<a href ='/sales/summary'>Summary</a>";
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
            $num_input = array('type' => 'number', 'value' => '0', 'min' => '0', 'class' => 'num-field', 'name' => $record->id);
            
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

        $order = new Order();
        $order->setType("Sales");
        
        foreach($_POST as $post_name => $post_value){
            $inventory[] = array('key' => $post_name, 'value' => $post_value);
        }
        
        $outcome = array();
        $totalSum = 0;
        $okToProcess = 0;        
    
        foreach($inventory as $product){
            $record = $this->Products->get($product['key']);
            $stockAvailable = $record->stock;            
            $quantityOrdered = $product['value'];

            if(($quantityOrdered != 0) && ($quantityOrdered <= $stockAvailable)){
                $okToProcess = $quantityOrdered;
                $newStock = $stockAvailable - $okToProcess;
                $record->stock = $newStock;
                $this->Products->update($record);   
            }else if($quantityOrdered == 0){
                $okToProcess = 0;
            }else{
                $okToProcess = -1;
            }

            if($okToProcess == -1){
                $outcome[] = array('line' => "Not enough stocks to process the order: " . $record->name . "</br>");
            }else if($okToProcess == 1){
                $outcome[] = array('line' => "You ordered " . $okToProcess . ' ' . $record->name . " at " . $this->toDollars($record->price) . " per unit." . "</br>");
                $order->addItem($record->id, $okToProcess);
            }else if($okToProcess > 1){
                $outcome[] = array('line' => "You ordered " . $okToProcess . ' ' . $record->name . "s at " . $this->toDollars($record->price) . " per unit." . "</br>");
                $order->addItem($record->id, $okToProcess);   
            }                        
            if($okToProcess > 0){
                $totalSum += $record->price * $okToProcess;    
            }            
        }

        //Save to xml
        $order->saveOrder();

        //Receipt
        //$this->data['receipt'] = $this->parsedown->parse($order->generateReceipt());

        $outcome[] = array('line' => "<br><strong>Grand Total:</strong> " . $this->toDollars($totalSum));
        $this->data['result'] = $outcome;
        $this->render();
    }

    public function clear() {
        $this->Products->clear();
    }
    
    public function summary() {
        // identify all of the order files
        $type = "Sales";
        
        $this->load->helper('directory');
        $candidates = directory_map(SALES_ORDER_DIR);
        $parms = array();
        foreach ($candidates as $filename) {
           // restore that order object
           $order = new Order();
           $order->loadXML(SALES_ORDER_DIR . $filename);
        // setup view parameters
           $parms[] = array(
               'number' => $order->number,
               'type' => $order->type,
               'datetime' => $order->datetime
            );
        }
        
        $this->data['type'] = $type;
        $this->data['orders'] = $parms;
        $this->data['pagebody'] = 'summary';
        $this->render('template');  // use the default template
    }
    
    public function examine($which) {
        $order = new Order();
        $order->loadXML(SALES_ORDER_DIR . $which . '.xml');
        $stuff = $order->generateReceipt();
        $this->data['receipt'] = $this->parsedown->parse($stuff);
        $this->data['pagebody'] = 'receipt';
        $this->render();
    }
}
