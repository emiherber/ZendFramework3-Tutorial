<?php

namespace Blog\Form;

/**
 * Description of PostForm
 *
 * @author emi
 */
use Zend\Form\Form;

class PostForm extends Form{
    function init() {
        parent::init();
        $this->add([
            'name' => 'post',
            'type' => PostFieldset::class,
            'options' => [
                'use_as_base_fieldset' => true,
            ]
        ]);
        
        $this->add([
            'type' => 'submit',
            'name' => 'submit',
            'attributes' => [
                'value' => 'Insert new Post'
            ]
        ]);
    }
}
