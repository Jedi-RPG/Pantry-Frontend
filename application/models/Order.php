<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Order
 *
 * @author Pika
 */
class Order extends CI_Model{
    //put your code here
    function __construct() {
        parent::__construct();
        
        $this->number = 0;
        $this->datetime = null;
        $this->type = "Order";
        $this->items = array();
    }
    
    public function addItem($which, $amount) {
        // ignore empty requests
        if ($which == null) return;

        // add the menu item code to our order if not already there
        if (!isset($this->items[$which]))
            $this->items[$which] = $amount;
        else {
            // increment the order quantity
            $this->items[$which] += $amount;
        }
    }
    
    public function setType($which) {
        $this->type = $which;
    }
    
    //Fills up order data with an XML file
    public function loadXML($filename) {
        $xml = simplexml_load_file($filename);
        $this->number = (int) $xml->number;
        $this->datetime = (string) $xml->datetime;
        $this->type = (string) $xml->type;
        $this->items = array();
        
        foreach ($xml->item as $item) {
            $key = (string) $item->code;
            $quantity = (int) $item->quantity;
            $this->items[$key] = $quantity;
        }
    }

    public function generateReceipt() {
        $total = 0;
        $result = $this->data['pagetitle'] . '  ' . PHP_EOL;
        //$result .= date(DATE_ATOM) . PHP_EOL;
        $result .= $this->datetime . PHP_EOL . PHP_EOL;
        $result .= 'Type: ' . $this->type . PHP_EOL . PHP_EOL;
        $result .= $this->type . ' Number: ' . $this->number . PHP_EOL;
        $result .= PHP_EOL . 'Items:'. PHP_EOL . PHP_EOL;
        foreach($this->items as $key => $value) {
            
            if($this->type == "Receiving") {
                $product = $this->Materials->get($key);
            }else{
                $product = $this->Products->get($key);
            }
            
            if($this->type == "Sales") {
                $result .= '- ' . $value . ' ' . $product->name . " at $" . number_format($product->price, 2) . " per unit.". PHP_EOL;
            }elseif($this->type == "Receiving"){
                $result .= '- ' . $value . ' case of ' . $product->name . PHP_EOL;
            }else{
                $result .= '- ' . $value . ' ' . $product->name . PHP_EOL;
            }
            $total += $value * $product->price;
        }
        
        if($this->type == "Sales") {
            $result .= PHP_EOL . 'Grand Total: $' . number_format($total, 2) . PHP_EOL;
        }
        
        return $result;
    }
    
    public function saveOrder() {
        // figure out the order to use
        while ($this->number == 0) {
            // pick random 3 digit #
            $test = rand(100,999);
            // use this if the file doesn't exist
            if (!file_exists('../data/order/'. $this->type . $test.'.xml'))
                    $this->number = $test;
        }
        // and establish the checkout time
        $this->datetime = date(DATE_RFC2822);

        // start empty
        $xml = new SimpleXMLElement('<order/>');
        // add the main properties
        $xml->addChild('number',$this->number);
        $xml->addChild('datetime',$this->datetime);
        $xml->addChild('type', $this->type);
        foreach ($this->items as $key => $value) {
            $lineitem = $xml->addChild('item');
            $lineitem->addChild('code',$key);
            $lineitem->addChild('quantity',$value);
        }

        // save it
        $xml->asXML('../data/order/' . $this->type . $this->number . '.xml');
    }
}
