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
        $this->create_form('Recipes');
        $this->create_form('Products');

        $this->error_messages = array();

        $this->render();
    }

    private function create_form_materials(){
        $this->session->unset_userdata('record');

        // $this->data['form_open'] = form_open('maintenance/delete_material', '', array('name' => 'list-form'));
        $source = $this->Materials->all();

        // Set table headers
        $items[] = array('Edit Item', 'Delete');

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

        //close form
        $this->data['form_close'] = form_close();       
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
        
        // $record = (array) $record;
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

    private function create_form($type) {
        //Open form
        $this->data['form_open'] = form_open('maintenance/post', '', array('name' => 'list-form'));

        // Get list of items
        $source = $this->$type->all();

        // Set table headers
        $items[] = array('Edit Item', 'Delete');

        // Add table rows
        foreach ($source as $record)
        {
            $chk_data = array('name' => 'c_' . $record['id']);

            $items[] = array('<a href="/maintenance/edit/' .
                             strtolower($type) . '/' .
                             $record['id']. '">' .
                             $record['name'] . '</a>',
                form_checkbox($chk_data, "", "", "class='checkbox'"));

        }

        // Add new items
        $items[] = array('');
        $items[] = array('Add New Item', '', '');
        $new_data = array('name' => 'a_');
        $items[] = array(form_input('a_', "", "class='input'"),
            '', form_submit('', 'Submit', "class='submit'"));
        

        //Generate the materials table
        $this->data[$type.'_table'] = $this->table->generate($items);

        //close form
        $this->data['form_close'] = form_close();

    }

    public function edit_item($type, $id){
        $this->data['pagebody'] = 'admin_single';
        $record = $this->$type->get($id);

        // Create form for editing an item
        $this->data['admin_edit_form_open'] = form_open('maintenance/post', '', array('name' => 'edit-form'));
        $items[] = array('Property Name', 'Value', 'Update Name', 'Update Value', 'Delete');

        foreach (array_keys($record) as $key){
            if ($key != 'materials' && $key != 'id') {
                $items[] = array($key,
                                 $record[$key],
                                 form_input($this->set_input_params('n', 'input', $id, $type, $key)),
                                 form_input($this->set_input_params('v', 'input', $id, $type, $record[$key])),
                                 form_checkbox($this->set_input_params('c', 'checkbox', $id, $type, $key)));
            } else if ($key == 'materials') {
                $materials = $record[$key];
            }
        }
        $items[] = array('');
        $items[] = array('Add new property');
        $items[] = array(form_input($this->set_input_params('y', 'input', $id, $type, '')),
                         form_input($this->set_input_params('z', 'input', $id, $type, '')));
        $items[] = array(form_reset('', 'Clear', "class='submit'"),
                         form_submit('', 'Submit', "class='submit'"), '' , '');
        // Display table
        $this->data['admin_main_edit'] = $this->table->generate($items);

        // Create table for editing recipe ingredients
        if (isset($materials)) {

            $ingredients[] = array('Name', 'Amount Needed',
                'Update Name', 'Update Amount Used', 'Delete');
            foreach ($materials as $item => $attrib) {
                $ingredients[] = array($attrib['name'], $attrib['amount'],
                    form_input($this->set_input_params('n', 'input', $id, $type, $attrib['name'])),
                    form_input($this->set_input_params('v', 'input', $id, $type, $attrib['amount'])),
                    form_checkbox($this->set_input_params('c', 'checkbox', $id, $type, $attrib['name'])));
            }
            $ingredients[] = array('');
            $ingredients[] = array('Add new ingredient');
            $ingredients[] = array(form_input($this->set_input_params('y_', 'input', $id, $type, '')),
                                   form_input($this->set_input_params('z_', 'input', $id, $type, '')));
            $ingredients[] = array(form_reset('', 'Clear', "class='submit'"),
                form_submit('', 'Submit', "class='submit'"), '' , '');
        }


        // Display table to modify ingredients only if a recipe was selected
        $this->data['admin_ingredients_edit'] =
            isset($materials) ? $this->table->generate($ingredients) : NULL;
        $this->data['admin_edit_form_close'] = form_close();
        $this->render();
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

    function delete_material($id) {

        $this->Materials->delete($id);

        $this->index();
    }

}