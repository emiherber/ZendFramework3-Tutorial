<?php

namespace Blog\Model;

/**
 * Description of ZendDbSqlRepository
 *
 * @author emi
 */
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Hydrator\HydratorInterface;
use InvalidArgumentException;
use RuntimeException;
use Zend\Db\Sql\Sql;

class ZendDbSqlRepository implements PostRepositoryInterface {

    /**
     *
     * @var AdapterInterface 
     */
    private $db;

    /**
     *
     * @var HydratorInterface 
     */
    private $hydrator;

    /**
     *
     * @var Post
     */
    private $postPrototype;

    /**
     * @param AdapterInterface $db
     */
    function __construct(AdapterInterface $db, HydratorInterface $hydrator, Post $postPrototype) {
        $this->db = $db;
        $this->hydrator = $hydrator;
        $this->postPrototype = $postPrototype;
    }

    /**
     * {@inheritDoc}
     */
    function findAllPosts() {
        $sql = new Sql($this->db);
        $select = $sql->select('posts');
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        if (!$result instanceof ResultInterface || !$result->isQueryResult()) {
            return [];
        }

        $resultSet = new HydratingResultSet(
            $this->hydrator, $this->postPrototype
        );
        $resultSet->initialize($result);
        return $resultSet;
    }

    /**
     * {@inheritDoc}
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    function findPost(int $id) {
        $sql = new Sql($this->db);
        $select = $sql->select('posts');
        $select->where(['id = ?' => $id]);
        
        $statement = $sql->prepareStatementForSqlObject($select);
        $reult = $statement->execute();
        
        if(!$reult instanceof ResultInterface || !$reult->isQueryResult()){
            throw new \RuntimeException(sprintf(
                'Failed retrieving blog post with identifier "%s"; unknown database error.',
                $id
            ));
        }
        
        $resultSet = new HydratingResultSet($this->hydrator, $this->postPrototype);
        $resultSet->initialize($resultSet);
        $post = $resultSet->current();
        
        if(!$post){
            throw new \InvalidArgumentException(sprintf(
                'Blog post with identifier "%s" not found.', 
                $id
            ));
        }
        return $post;
    }

}
