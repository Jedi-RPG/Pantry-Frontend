<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Receiving extends Application
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
		$this->data['pagebody'] = 'receiving_list';

		// build the list of authors, to pass on to our view
		$source = $this->Materials->all();

		$this->data['form_open'] = form_open('receiving/post');
		
		//$test = $this->Transactions->getMaterials();

        // Set table headers

        $items[] = array('Name','Cost/Case' ,'Stocked Cases', 'Cases Recieved');

        foreach ($source as $record)
        {
			$text_data = array('name' => $record['id'],'type' => 'number', 'value' => '0');
			$case = $record['amount'] / $record['itemPerCase'];
            $items[] = array ( '<a href="/receiving/get/' .
                               $record['id']. '">' .
                               $record['name'] . '</a>',
               $this->toDollars($record['price']), floor($case) ,form_input($text_data, "", "class='input'"));
        }

        $this->data['Materials_table'] = $this->table->generate($items);
		
		$this->data['order_button'] = form_submit('', 'Receive', "class='submit'");
		
		$this->data['clear_data'] = form_reset('','Clear', "class='submit'");
		
		$this->data['form_close'] = form_close();
		$this->render();
		

	}

	public function get($id) {
		
		$this->data['pagebody'] = 'receiving_single';
		
		$record = $this->Materials->get($id);
		
		$items[] = array('Name','Items Per Case' ,'Total Stocked Items');
		$items[] = array($record['name'],$record['itemPerCase'] ,$record['amount']);
		
		$this->data['Materials_table'] = $this->table->generate($items);
		
		
		$this->data['itemName'] = ($record['name']);

		$this->render();
	}
	
	public function post()
    {
		//var_dump($_POST);
		
		
		$this->data['pagebody'] = 'receiving_result';
		
		foreach ($_POST as $post_name => $post_value){
			$this->Transactions->setMaterials($post_name, $post_value);
			$orders[] = ($post_value);
		}
		
		
		$empty = "NOTHING WAS RECEIVED!";
		$empty = "<b>" . $empty . "</b><br>Please try again!";
	
		$items[] = array('Ordered Items', '# Ordered Cases');
		
		//$source = $this->Materials->all();
		$i = 1;
		$j = 1;
		foreach($orders as $cases)
		{
			if($cases != "" && $cases != 0){
				$source = $this->Materials->get($i);
				$items[] = array($source['name'],$cases);
				$j++;
			}
			$i++;
        }

		if($j == 1){
			$this->data['Materials_table'] = $empty;
		} else {
			$this->data['Materials_table'] = $this->table->generate($items);
		}

		$this->render();

    }

	public function clear() {
		$this->Materials->clear();
	}
}
