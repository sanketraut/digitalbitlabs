<?php

namespace Digitalbit\Forms;

use Validator;

class FormBuilder
{
    protected $element = [];
    protected $attributes;
    protected $formOpen = null;
    protected $formClose = '</form>';

    /**
     * Create a new Skeleton Instance
     */
    public function __construct()
    {
        // allow elements to be pushed to the array
        $this->element[] = &$this->element;
    }

    // Add elements to the form
    public function addElement($element) {
        if(isset($element['attributes'])) {
            $this->attributes = null;
            foreach($element['attributes'] as $name => $attrib) {
                $this->attributes .= $name .'="'. $attrib .'" ';
                if($name == 'name') {
                    $element['name'] = $attrib;
                }
            }
        }
        $element['attributes'] = $this->attributes;
        $element['class'] = isset($element['class'])?$element['class']:'col-md-12';

        $this->element[] = $element;
    }

    public function getValidationRules() {
        $rules = [];
        for($cnt = 1; $cnt < sizeof($this->element); $cnt++) {
            if(isset($this->element[$cnt]['name']) && isset($this->element[$cnt]['rules'])) {
              $rules['rules'][$this->element[$cnt]['name']] = $this->element[$cnt]['rules'];  
            }

            if(isset($this->element[$cnt]['label']) && isset($this->element[$cnt]['rules'])) {
                $rules['label'][$this->element[$cnt]['name']] = $this->element[$cnt]['label'];  
            }
        }
        return $rules;
    }

    public function validateForm($data, $rules) {      
        $messages = [
            'required' => ':attribute cannot be left blank.',
        ];  
        return Validator::make($data, $rules['rules'], $messages, $rules['label'])->validate();
    }

    public function setParameters($arguments) {
        $this->formOpen = '<form ';
        foreach($arguments as $name => $attrib) {
            $this->formOpen .= $name .'="'. $attrib .'" ';
        }                    
        $this->formOpen .= '>';
    }

    /*
    *   FormBuilder package to create forms
    */
    public function renderForm($options = []) {
        
        $data['withPanel'] = isset($options['withPanel'])?$options['withPanel']:false;

        $data['panelTitle'] = isset($options['panelTitle'])?$options['panelTitle']:'Form';

        for($count = 1; $count < sizeof($this->element); $count++) {
            $data['elementList'][$count] = $this->element[$count];
        }
        $data['formOpen'] = $this->formOpen;
        $data['formClose'] = $this->formClose;
        usort($data['elementList'],function($a,$b){
            if(isset($a['weight']) && isset($b['weight'])) {
                return $a['weight'] - $b['weight'];
            }
        });
        // echo '<pre>'; print_r($data['elementList']); exit();
        return view('forms::form', $data);
    }

        
}
