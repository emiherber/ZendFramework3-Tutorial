<?php

namespace Blog\Form;

/**
 * Description of PostFieldset
 *
 * @author emi
 */
use Zend\Hydrator\ReflectionHydrator;
use Zend\Form\Fieldset;
use Blog\Model\Post;

class PostFieldset extends Fieldset{
    function init() {
        parent::init();
        
        $this->setHydrator(new ReflectionHydrator());
        $this->setObject(new Post('', ''));

        $this->add([
            'type' => 'hidden',
            'name' => 'id'
        ]);
        
        $this->add([
            'type' => 'text',
            'name' => 'title',
            'options' => [
                'label' => 'Post Title'
            ]
        ]);
        
        $this->add([
            'type' => 'textarea',
            'name' => 'text',
            'options' => [
                'label' => 'Post Text'
            ]
        ]);
    }
}
