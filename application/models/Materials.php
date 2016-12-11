<?php

define('REST_SERVER', 'http://backend.local');  // the REST server host
define('REST_PORT', $_SERVER['SERVER_PORT']);   // the port you are running the server on

class Materials extends CI_Model {

	// Constructor
	public function __construct()
	{
		parent::__construct();
		$this->load->library(['curl', 'format', 'rest']);
	}

	function rules() {
		$config = [
			['field'=>'id', 'label'=>'Material code', 'rules'=> 'required|integer'],
			['field'=>'name', 'label'=>'Material name', 'rules'=> 'required'],
			['field'=>'price', 'label'=>'Material price', 'rules'=> 'required'],
			['field'=>'itemPerCase', 'label'=>'Materials per case', 'rules'=> 'required|integer'],
			['field'=>'amount', 'label'=>'Total amount of material', 'rules'=> 'required|integer']
		];
		return $config;
	}

	public function get($key)
	{
		$this->rest->initialize(array('server' => REST_SERVER));
		$this->rest->option(CURLOPT_PORT, REST_PORT);
		return $this->rest->get('/Material_list/item/id/' . $key);
	}

	// retrieve all of the quotes
	public function all()
	{
		$this->rest->initialize(array('server' => REST_SERVER));
		$this->rest->option(CURLOPT_PORT, REST_PORT);
		return $this->rest->get('/Material_list');
	}

    public function clear() {
        $this->session->unset_userdata('materials');
        echo 'materials transactions cleared!';
    }

	// Update a record in the DB
   function update($record)
   {
       $this->rest->initialize(array('server' => REST_SERVER));
       $this->rest->option(CURLOPT_PORT, REST_PORT);
       return $this->rest->put('/Material_list/item/id/' . $record->id, json_encode($record));
   }

	// Create a new data object.
	// Only use this method if intending to create an empty record and then
	// populate it.
	function create()
	{
		$names = ['id','name', 'price','itemPerCase','amount'];
		$object = new StdClass;
		foreach ($names as $name)
			$object->$name = "";
		return $object;
	}

	// Determine if a key exists
	function exists($key, $key2 = null)
	{
		$this->rest->initialize(array('server' => REST_SERVER));
		$this->rest->option(CURLOPT_PORT, REST_PORT);
		$result = $this->rest->get('/Material_list/item/id/' . $key);
		return !isset($result->error);
	}

	// Add a record to the DB
	function add($record)
	{
		$this->rest->initialize(array('server' => REST_SERVER));
		$this->rest->option(CURLOPT_PORT, REST_PORT);
		return $this->rest->post('/Material_list/item/id/' . $record->id, json_encode($record));
	}

	// Delete a record from the DB
	function delete($key, $key2 = null)
	{
		$this->rest->initialize(array('server' => REST_SERVER));
		$this->rest->option(CURLOPT_PORT, REST_PORT);
		return $this->rest->delete('/Material_list/item/id/' . $key);
	}

}
