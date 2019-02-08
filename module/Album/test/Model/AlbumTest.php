<?php

namespace AlbumTest\Model;

/**
 * Description of AlbumTest
 *
 * @author emi
 */
use Album\Model\Album;
use PHPUnit\Framework\TestCase;

class AlbumTest extends TestCase {

    function testInitialAlbumValuesAreNull() {
        $album = new Album();
        $this->assertNull($album->getArtist(), '"artist" should be null by default');
        $this->assertNull($album->getId(), '"id" should be null by default');
        $this->assertNull($album->getTitle(), '"title" should be null by default');
    }

    function testExchangeArraySetsPropertiesCorrectly() {
        $album = new Album();
        $data = [
            'artist' => 'some artist',
            'id' => 123,
            'title' => 'some title'
        ];

        $album->exchangeArray($data);

        $this->assertSame(
                $data['artist'], $album->getArtist(), '"artist" was not set correctly'
        );

        $this->assertSame(
                $data['id'], $album->getId(), '"id" was not set correctly'
        );

        $this->assertSame(
                $data['title'], $album->getTitle(), '"title" was not set correctly'
        );
    }

    function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent() {
        $album = new Album();

        $album->exchangeArray([
            'artist' => 'some artist',
            'id' => 123,
            'title' => 'some title',
        ]);
        $album->exchangeArray([]);

        $this->assertNull($album->getArtist(), '"artist" should default to null');
        $this->assertNull($album->getId(), '"id" should default to null');
        $this->assertNull($album->getTitle(), '"title" should default to null');
    }

    function testGetArrayCopyReturnsAnArrayWithPropertyValues() {
        $album = new Album();
        $data = [
            'artist' => 'some artist',
            'id' => 123,
            'title' => 'some title'
        ];

        $album->exchangeArray($data);
        $copyArray = $album->getArrayCopy();

        $this->assertSame($data['artist'], $copyArray['artist'], '"artist" was not set correctly');
        $this->assertSame($data['id'], $copyArray['id'], '"id" was not set correctly');
        $this->assertSame($data['title'], $copyArray['title'], '"title" was not set correctly');
    }

    function testInputFiltersAreSetCorrectly() {
        $album = new Album();

        $inputFilter = $album->getInputFilter();

        $this->assertSame(3, $inputFilter->count());
        $this->assertTrue($inputFilter->has('artist'));
        $this->assertTrue($inputFilter->has('id'));
        $this->assertTrue($inputFilter->has('title'));
    }

}
