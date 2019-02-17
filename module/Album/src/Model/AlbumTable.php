<?php

namespace Album\Model;

/**
 * Description of AlbumTable
 *
 * @author emi
 */
use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class AlbumTable {

    private $tableGateway;

    function __construct(TableGatewayInterface $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    function fetchAll($paginated = false) {
        if($paginated){
            return $this->fetchPaginatedResults();
        }
        return $this->tableGateway->select();
    }
    
    private function fetchPaginatedResults(){
        //Crear un nuevo objeto de 
        //selección para la tabla:
        $select = new Select($this->tableGateway->getTable());
        
        //Creo un nuevo conjunto de resultados basado 
        //en la entidad del Álbum: 
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Album());
        
        //Creo un nuevo objeto adaptador de paginación:
        $paginatiorAdapter = new DbSelect(
            //Nuestro objeto seleccionado configurado:
            $select,
            //El adaptador para ejecutarlo contra:
            $this->tableGateway->getAdapter(),
            //El conjunto de resultados para hidratar:
            $resultSetPrototype
        );
        
        $paginator = new Paginator($paginatiorAdapter);
        return $paginator;
    }
    
    function getAlbum(int $id) {
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (!$row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier $d', 
                $id
            ));
        }
        return $row;
    }

    function saveAlbum(Album $album){
        $data = [
            'artist' => $album->getArtist(),
            'title' => $album->getTitle()
        ];
        $id = (int) $album->getId();
        
        if($id === 0){
            $this->tableGateway->insert($data);
            return;
        }
        
        try {
            $this->getAlbum($id);
        } catch (RuntimeException $ex) {
            throw new RuntimeException(sprintf(
               'Cannot update album with identifier $d; does not exist', 
                $id
            ));
        }
        $this->tableGateway->update($data,['id' => $id]);
    }
    
    function deleteAlbum(int $id){
        $this->tableGateway->delete(['id' => $id]);
    }
}
