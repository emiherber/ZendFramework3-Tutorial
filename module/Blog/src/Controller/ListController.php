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
use InvalidArgumentException;

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
    
    function detailAction(){
        $id = $this->params()->fromRoute('id');
        
        try{
            $post = $this->postRepository->findPost($id);
        } catch (InvalidArgumentException $ex) {
            return $this->redirect()->toRoute('blog');
        }
        
        return new ViewModel(['post' => $post]);
    }
}
