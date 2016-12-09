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

	public function getMaterialWithName($name)
	{
		// iterate over the data until we find the one we want
		foreach ($this->data as $record)
			if ($record['name'] == $name)
				return $record;
		return null;
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

	// Add a record to the DB
	function add($record)
	{
		$this->rest->initialize(array('server' => REST_SERVER));
		$this->rest->option(CURLOPT_PORT, REST_PORT);
		return $this->rest->post('/Material_list/item/id/' . $record->id, json_encode($record));
	}
}
