<?php

namespace Blog\Model;

/**
 * Description of Post
 *
 * @author emi
 */
class Post {

    /**
     *
     * @var int 
     */
    private $id;

    /**
     *
     * @var string 
     */
    private $text;

    /**
     *
     * @var string
     */
    private $title;

    function __construct($title, $text, int $id = null) {
        $this->title = $title;
        $this->text = $text;
        $this->id = $id;
    }

    /**
     * 
     * @return int|null
     */
    function getId() {
        return $this->id;
    }

    /**
     * 
     * @return string
     */
    function getText() {
        return $this->text;
    }

    /**
     * 
     * @return string
     */
    function getTitle() {
        return $this->title;
    }

}
