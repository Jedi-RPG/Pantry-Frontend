<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Maintenance extends Application
{

    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        // This is the view we want shown
        $this->data['pagebody'] = 'admin_list';

        // $this->create_form('Materials');
        $this->create_form_materials();
        // $this->create_form_recipes();
        $this->create_form('Recipes');
        $this->create_form('Products');

        $this->error_messages = array();

        $this->session->unset_userdata('record');
        $this->session->unset_userdata('post');
        $this->session->unset_userdata('type');

        $this->render();
    }

    private function create_form_materials(){
        $source = $this->Materials->all();

        // Set table headers
        $items[] = array('Edit Item');

        foreach($source as $record){

            $items[] = array('<a href="/maintenance/edit/materials/' .
                             $record->id . '">' .
                             $record->name . '</a>');
        }


        // Add new items
        $items[] = array('');
        $items[] = array('<a href="/maintenance/add_material/" role="button" class="Submit">Create new material</a>',
            '', '');

        //Generate the materials table
        $this->data['Materials_table'] = $this->table->generate($items);
    }

    public function edit_materials($id){
        $this->data['pagebody'] = 'admin_single';
        
        if($id != 0) {
            // for PUT
            $record = $this->Materials->get($id);
            $this->session->set_userdata('post', false); 
        } else {
            // for POST
            $record = $this->session->userdata('record');
            $this->session->set_userdata('post', true); 
        }
        
        $this->session->set_userdata('record',$record); 
        

        // Create form for editing an item
        $this->data['admin_edit_form_open'] = form_open('maintenance/post', '', array('name' => 'edit-form'));
        $items[] = array('Property Name', 'Value');

        foreach (get_object_vars($record) as $key => $value){   
                $items[] = array($key, form_input($key, $record->$key));
            
        }

        if ($id != 0) {
            $items[] = array('<a href="/maintenance/delete_material/' . $id .'" role="button" class="Submit">Delete</a>',
                             form_submit('', 'Submit', "class='submit'"), 
                             '' ,
                              '');
        } else {
            $items[] = array(form_reset('', 'Clear', "class='submit'"),
                             form_submit('', 'Submit', "class='submit'"), 
                             '','');
        }

        $this->data['admin_main_edit'] = $this->table->generate($items);
        $this->data['admin_edit_form_close'] = form_close();

        $this->show_any_errors();
        $this->render();
    }

    public function add_material() {
         $record = $this->Materials->create();
         $this->session->set_userdata('record', $record);
         $this->edit_materials(0);
    }

   private function delete_material($id) {

        $this->Materials->delete($id);

        $this->index();
    }

    private function create_form($type) {

        // Get list of items
        $records = $this->$type->all();


        // Set table headers
        $items[] = array('Edit Item');

        // Add table rows
        foreach ($records as $record)
        {
            
            if ($type == "Recipes"){
                $items[] = array('<a href="/maintenance/edit/recipes' . '/' .
                                 $record->id. '">' .
                                 $this->getProductName($record) . '</a>');
            } else {
                $items[] = array('<a href="/maintenance/edit/products' . '/' .
                                 $record->id. '">' .
                                 $record->name . '</a>');
            }
        }

        // Add new items
        $items[] = array('');
        $items[] = array('<a href="/maintenance/add/' . $type . '" role="button" class="Submit">Create new '. lcfirst($type) .'</a>',
            '', '');

        //Generate the recipes table
        $this->data[$type . '_table'] = $this->table->generate($items);
    }

   public function add($type) {
         $record = $this->$type->create();
         $this->session->set_userdata('record', $record);
         $this->edit(ucfirst($type), 0);
    }

    public function edit($type, $id) {
        $this->data['pagebody'] = 'admin_single';

        if ($type == "recipes"){
            $products = $this->Materials->all();
            $products = $this->create_dropdown_array($products);
        }

        if($id != 0) {
            // for update
            $record = $type == "recipes" ? $this->Recipes->get($id) : $this->Products->get($id);
            $this->session->set_userdata('post', false); 
        } else {
            // for create
            $record = $this->session->userdata('record');
            $this->session->set_userdata('post', true); 
        }
        $this->session->set_userdata('record',$record); 
        $this->session->set_userdata('type',$type); 
        

        // Create form for editing an item
        $this->data['admin_edit_form_open'] = form_open('maintenance/post_', '', '');
        $items[] = array('Property Name', 'Value');

        foreach (get_object_vars($record) as $key => $value){   
            if (strpos($key, 'Material') !== false && $type == "recipes"){
                $items[] = array($key, form_dropdown($key, $products, $record->$key));
            } else {
                $items[] = array($key, form_input($key, $record->$key));
            }        
        }

        if ($id != 0) {
            $items[] = array('<a href="/maintenance/delete/' . $type . "/" . $id .'" role="button" class="Submit">Delete</a>',
                             form_submit('', 'Submit', "class='submit'"), 
                             '' ,
                              '');
        } else {
            $items[] = array(form_reset('', 'Clear', "class='submit'"),
                             form_submit('', 'Submit', "class='submit'"), 
                             '','');
        }

        $this->data['admin_main_edit'] = $this->table->generate($items);
        $this->data['admin_edit_form_close'] = form_close();

        $this->show_any_errors();
        $this->render();
    }

   public function delete($type, $id) {
        $type = ucfirst($type);
        $this->$type->delete($id);

        $this->index();
    }

    private function create_dropdown_array($obj){
        $arr = array();
        foreach ($obj as $key => $value) {
            $arr[$value->id] = $value->name;
        }
        return $arr;
    }


    private function set_input_params($prefix, $class, $id, $type, $old) {
        return array(
            'class' => $class,
            'name' => $prefix . '_' . $type . '_' . $id . '_' . $old
        );
    }

    public function post() {

        $record = $this->session->userdata('record');
        $incoming = $this->input->post();
        $posting = $this->session->userdata('post');

        foreach(array_keys($incoming) as $entry) {
            $record->$entry = $incoming[$entry];
        }
        
        //validate
        $this->load->library('form_validation');
        $this->form_validation->set_rules($this->Materials->rules());
        if ($this->form_validation->run() != TRUE)
            $this->error_messages = $this->form_validation->error_array(); 

        if ($posting)
                if ($this->Materials->exists($record->id))
                        $this->error_messages[] = 'Duplicate key adding new material item';

        //save or not
        if (! empty($this->error_messages)) {
            $this->edit_materials(0);
            return;
        }

        if ($posting)
            $res = $this->Materials->add($record);
        else
            $res = $this->Materials->update($record);

        // $this->data['admin_results'] = $res[0];
        // $this->render();
        $this->index();
    }

    public function post_() {

        $record = $this->session->userdata('record');
        $incoming = $this->input->post();
        $posting = $this->session->userdata('post');
        $type = ucfirst($this->session->userdata('type'));

        foreach(array_keys($incoming) as $entry) {
            $record->$entry = $incoming[$entry];
        }
        
        //validate
        $this->load->library('form_validation');
        $this->form_validation->set_rules($this->$type->rules());
        if ($this->form_validation->run() != TRUE)
            $this->error_messages = $this->form_validation->error_array(); 

        if ($posting)
                if ($this->$type->exists($record->id))
                        $this->error_messages[] = 'Duplicate key adding new material item';

        //save or not
        if (! empty($this->error_messages)) {
            $this->edit(ucfirst($type), 0);
            return;
        }

        if ($posting)
            $res = $this->$type->add($record);
        else
            $res = $this->$type->update($record);

        $this->index();
    }

    function show_any_errors() {
        $result = '';
        if (empty($this->error_messages)) {
            $this->data['error_messages'] = '';
            return;
        }
        // add the error messages to a single string with breaks
        foreach($this->error_messages as $onemessage)
            $result .= $onemessage . '<br/>';
        // and wrap these per our view fragment
        $this->data['error_messages'] = $this->parser->parse('admin_errors',['error_messages' => $result], true);
    }

    private function getProductName($record){
        $product = $this->Products->get($record->id);
        if ($product == null){
            return "uncreated product";
        }

        return $product->name;
    }

}