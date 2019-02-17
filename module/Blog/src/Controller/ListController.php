<?php

namespace Blog\Controller;

/**
 * Description of ListController
 *
 * @author emi
 */

use Zend\Mvc\Controller\AbstractActionController;
use Blog\Model\PostRepositoryInterface;
use Zend\View\Model\ViewModel;

class ListController extends AbstractActionController{
    /**
     *
     * @var PostRepositoryInterface
     */
    private $postRepository;
    
    function __construct(PostRepositoryInterface $postRepository) {
        $this->postRepository = $postRepository;
    }
    
    function indexAction() {
        parent::indexAction();
        return new ViewModel([
            'posts' => $this->postRepository->findAllPosts()
        ]);
    }
}
