<?php

namespace Blog\Model;

/**
 * Description of PostRepository
 *
 * @author emi
 */
class PostRepository implements PostRepositoryInterface {

    /**
     * {@inherintDoc}
     */
    function findAllPosts() {
        return array_map(function ($post){
            return new Post(
                $post['title'],
                $post['text'],
                $post['id']
            );
        }, $this->data);
    }

    /**
     * {@inherintDoc}
     */
    function findPost($id) {
        if(!isset($this->data[$id])){
            throw new \DomainException(sprintf('Post by id "%s" not fount', $id));
        }
        
        return new Post(
            $this->data[$id]['title'],
            $this->data[$id]['text'],
            $this->data[$id]['id']
        );
    }

    private $data = [
        1 => [
            'id' => 1,
            'title' => 'Hello World #1',
            'text' => 'This is our first blog post!',
        ],
        2 => [
            'id' => 2,
            'title' => 'Hello World #2',
            'text' => 'This is our second blog post!',
        ],
        3 => [
            'id' => 3,
            'title' => 'Hello World #3',
            'text' => 'This is our third blog post!',
        ],
        4 => [
            'id' => 4,
            'title' => 'Hello World #4',
            'text' => 'This is our fourth blog post!',
        ],
        5 => [
            'id' => 5,
            'title' => 'Hello World #5',
            'text' => 'This is our fifth blog post!',
        ],
    ];

}
