<?php

namespace Album\Controller;

/**
 * Description of AlbumController
 *
 * @author emi
 */
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Album\Model\AlbumTable;
use Album\Form\AlbumForm;
use Album\Model\Album;

class AlbumController extends AbstractActionController {

    private $table;

    function __construct(AlbumTable $table) {
        $this->table = $table;
    }

    function indexAction() {
        return new ViewModel([
            'albums' => $this->table->fetchAll(),
            'title' => 'My albums'
        ]);
    }

    //Ahora obtenemos el formulario para mostrarlo 
    //y luego procesarlo en el envío
    function addAction() {
        $form = new AlbumForm();
        //Seteamos la etiqueta del boton a 'add'
        $form->get('submit')->setValue('add');
        $request = $this->getRequest();
        //Si no es post mostramos el formulario
        if (!$request->isPost()) {
            return ['form' => $form];
        }
        
        $album = new Album();
        $form->setInputFilter($album->getInputFilter());
        $form->setData($request->getPost());
        //Si falla la validacion se envian los errores
        //al formulario
        if(!$form->isValid()){
            return ['form' => $form];
        }
        
        $album->exchangeArray($form->getData());
        $this->table->saveAlbum($album);
        return $this->redirect()->toRoute('album');
    }

    function editAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if(0 == $id){
            return $this->redirect()->toRoute('album',['action' => 'add']);
        }
        
        // Recuperar el álbum con el id especificado. Al hacerlo así se plantea.
        // una excepción si no se encuentra el álbum, lo que debería resultar
        // en redireccionar a la página de destino.
        try{
            $album = $this->table->getAlbum($id);
        } catch (Exception $ex) {
            return $this->redirect()->toRoute('album', ['action' => 'index']);
        }
        
        $form = new AlbumForm();
        $form->bind($album);
        $form->get('submit')->setValue('edit');
        
        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];
        
        if(!$request->isPost()){
            return $viewData;
        }
        
        $form->setInputFilter($album->getInputFilter());
        $form->setData($request->getPost());
        
        if(!$form->isValid()){
            return $viewData;
        }
        
        $this->table->saveAlbum($album);
        return $this->redirect()->toRoute('album', ['action' => 'index']);
    }

    function deleteAction() {
        
    }

}
