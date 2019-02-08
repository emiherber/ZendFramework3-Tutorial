<?php

namespace Album\Model;

/**
 * Description of Album
 *
 * @author emi
 */
use DomainException;
use Zend\Filter\{
    StringTrim,
    StripTags,
    ToInt
};
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator\StringLength;

class Album implements InputFilterAwareInterface {

    private $id;
    private $artist;
    private $title;
    private $inputFilter;

    function getId() {
        return $this->id;
    }

    function getArtist() {
        return $this->artist;
    }

    function getTitle() {
        return $this->title;
    }

    function exchangeArray(array $data) {
        $this->id = !empty($data['id']) ? $data['id'] : NULL;
        $this->artist = !empty($data['artist']) ? $data['artist'] : NULL;
        $this->title = !empty($data['title']) ? $data['title'] : NULL;
    }
    
    //Como no se utiliza se emite una excepcion.
    function setInputFilter(InputFilterInterface $inputFilter) {
        throw new DomainException(sprintf(
            '%s does not allow injection of an alternate input filter', 
            __CLASS__
        ));
    }
    
    function getArrayCopy(){
        return [
            'id' => $this->id,
            'artist' => $this->artist,
            'title' => $this->title
        ];
    }

    function getInputFilter() {
        if ($this->inputFilter) {
            return $this->inputFilter;
        }

        $inputFilter = new InputFilter();
        $inputFilter->add([
            'name' => 'id',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class]
            ]
        ]);
        $inputFilter->add([
            'name' => 'artist',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class]
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 100
                    ]
                ]
            ]
        ]);
        $inputFilter->add([
            'name' => 'title',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 100,
                    ]
                ]
            ]
        ]);
        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }

}
