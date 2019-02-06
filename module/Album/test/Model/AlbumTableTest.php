<?php

namespace AlbumTest\Model;

/**
 * Description of AlbumTableTest
 *
 * @author emi
 */
use Album\Model\AlbumTable;
use Album\Model\Album;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use Zend\Db\ResultSet\ResultSetInterface;
use Zend\Db\TableGateway\TableGatewayInterface;

class AlbumTableTest extends TestCase {

    
    protected function setUp() {
        $this->tableGateway = $this->prophesize(TableGatewayInterface::class);
        $this->albumTable = new AlbumTable($this->tableGateway->reveal());
    }

    function testFetchAllReturnsAllAlbums() {
        $resultSet = $this->prophesize(ResultSetInterface::class)->reveal();
        $this->tableGateway->select()->willReturn($resultSet);

        $this->assertSame($resultSet, $this->albumTable->fetchAll());
    }

    function testCanDeleteAnAlbumByItsId() {
        $this->tableGateway->delete(['id' => 123])->shouldBeCalled();
        $this->albumTable->deleteAlbum(123);
    }

    function testSaveAlbumWillInsertNewAlbumsIfTheyDontAlreadyHaveAnId() {
        $albumData = [
            'artist' => 'The Military Wives',
            'title' => 'In My Dreams'
        ];
        $album = new Album();
        $album->exchangeArray($albumData);

        $this->tableGateway->insert($albumData)->shouldBeCalled();
        $this->albumTable->saveAlbum($album);
    }

    function testSaveAlbumWillUpdateExistingAlbumsIfTheyAlreadyHaveAnId() {
        $albumData = [
            'id' => 123,
            'artist' => 'The Military Wives',
            'title' => 'In My Dreams',
        ];
        $album = new Album();
        $album->exchangeArray($albumData);

        $resultSet = $this->prophesize(ResultSetInterface::class);
        $resultSet->current()->willReturn($album);

        $this->tableGateway
            ->select(['id' => 123])
            ->willReturn($resultSet->reveal());
        $this->tableGateway
            ->update(
                array_filter($albumData, function ($key) {
                    return in_array($key, ['artist', 'title']);
                }, ARRAY_FILTER_USE_KEY), ['id' => 123]
            )->shouldBeCalled();

        $this->albumTable->saveAlbum($album);
    }

    function testExceptionIsThrownWhenGettingNonExistentAlbum() {
        $resultSet = $this->prophesize(ResultSetInterface::class);
        $resultSet->current()->willReturn(null);

        $this->tableGateway
            ->select(['id' => 123])
            ->willReturn($resultSet->reveal());

        $this->expectException(RuntimeException::class);
        $this->albumTable->getAlbum(123);
        $this->expectExceptionMessage('Could not find row with identifier 123');
    }

}
