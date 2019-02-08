<?php

namespace Album\Model;

/**
 * Description of AlbumTable
 *
 * @author emi
 */
use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class AlbumTable {

    private $tableGateway;

    function __construct(TableGatewayInterface $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    function fetchAll() {
        return $this->tableGateway->select();
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
