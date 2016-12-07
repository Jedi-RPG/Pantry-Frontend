<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Application
{

    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        // This is the view we want shown
        $this->data['pagebody'] = 'admin_list';

        $this->create_form('Materials');
        $this->create_form('Recipes');
        $this->create_form('Products');

        $this->render();
    }

    private function create_form($type) {

        //Open form
        $this->data['form_open'] = form_open('admin/post', '', array('name' => 'list-form'));

        // Get list of items

        $source = $this->$type->all();

        // Set table headers
        $items[] = array('Edit Item', 'Delete');

        // Add table rows
        foreach ($source as $record)
        {
            $chk_data = array('name' => 'c_' . $record['id']);

            $items[] = array('<a href="/admin/edit/' .
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
        $this->data['admin_edit_form_open'] = form_open('admin/post', '', array('name' => 'edit-form'));
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

    public function post()
    {

        $this->data['pagebody'] = 'admin_result';

        $result = array();

        if ($_POST['name'] == 'list-form'){

            foreach(array_keys($_POST) as $entry)
            {
                if ($entry[0] == 'c') {
                    //array_push($checked, $entry);
                    $result[] = array('line' => 'Id ' . substr($entry,2) . ' will be deleted </br>');
                } else if ($entry[0] == 'a' && !empty($_POST[$entry])) {
                    $result[] = array('line' => 'New item ' . $_POST[$entry] . ' will be created');
                }
            }
        } else {

            foreach(array_keys($_POST) as $entry)
            {
                if ($entry == 'name' || ($entry[0] != 'c' && empty($_POST[$entry])))
                    continue;

                switch($entry[0]) {
                    case 'n': {
                        $result[] = array('line' =>
                            explode("_", $entry)[1] .' id ' . explode("_", $entry)[2] .  '\'s property "'
                            . explode("_", $entry)[3] . '" will be changed to "' . $_POST[$entry] . '".</br>');
                        break;
                    }
                    case 'v': {
                        $result[] = array('line' =>
                            explode("_", $entry)[1] .' id ' . explode("_", $entry)[2] .  '\'s value "'
                            . explode("_", $entry)[3] . '" will be changed to "' . $_POST[$entry] . '".</br>');
                        break;
                    }
                    case 'c': {
                        $result[] = array('line' =>
                            explode("_", $entry)[1] . ' id ' . explode("_", $entry)[2] .
                            ' property "' . explode("_", $entry)[3] . '" will be deleted. </br>');
                        break;
                    }
                    case 'y': $newname = $_POST[$entry]; break;
                    case 'z': $newvalue = $_POST[$entry]; break;
                }
                if (isset($newname) && isset($newvalue))
                    $result[] = array('line' => 'Property ' . $newname .
                        ' with value ' . $newvalue . ' will be created.');
            }
        }
        $this->data['admin_results'] = $result;

        $this->render();

    }

}
