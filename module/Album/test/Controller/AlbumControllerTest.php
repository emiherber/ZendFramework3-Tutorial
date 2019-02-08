<?php

namespace AlbumTest\Controller;

/**
 * Description of AlbumControllerTest
 *
 * @author emi
 */
use Album\Controller\AlbumController;
use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Album\Model\AlbumTable;
use Zend\ServiceManager\ServiceManager;
use Album\Model\Album;
use Prophecy\Argument;

class AlbumControllerTest extends AbstractHttpControllerTestCase {

    protected $traceError = true;
    protected $albumTable;
    
    protected function ConfigureServiceManager(ServiceManager $services){
        $services->setAllowOverride(true);

        $services->setService('config', $this->updateConfig($services->get('config')));
        $services->setService(AlbumTable::class, $this->mockAlbumTable()->reveal());

        $services->setAllowOverride(false);
    }
    
    protected function updateConfig($config){
        $config['db'] = [];
        return $config;
    }
    
    protected function mockAlbumTable(){
        $this->albumTable = $this->prophesize(AlbumTable::class);
        return $this->albumTable;
    }
            
    function setUp() {
        // La configuración del módulo todavía debería ser aplicable para las pruebas.
        // Puede anular la configuración aquí con valores específicos de caso de prueba,
        // como plantillas de vista de ejemplo, pilas de ruta, opciones_módulo_listener,
        // etc.
        $configOverrides = [];
        $this->setApplicationConfig(ArrayUtils::merge(
            // Agarrando la configuración completa de la aplicación:
            include __DIR__ . '/../../../../config/application.config.php',
            $configOverrides
        ));
        parent::setUp();
        $this->ConfigureServiceManager($this->getApplicationServiceLocator());
    }

    function testIndexActionCanBeAccessed() {
        $this->albumTable->fetchAll()->willReturn([]);
        $this->dispatch('/album');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('Album');
        $this->assertControllerName(AlbumController::class);
        $this->assertControllerClass('AlbumController');
        $this->assertMatchedRouteName('album');
    }
    
    function testAddActionRedirectsAfterValidPost(){
        $this->albumTable
            ->saveAlbum(Argument::type(Album::class))
            ->shouldBeCalled();
        
        $postData = [
            'title' => '1989',
            'artist' => 'Taylor Swift',
            'id' => ''
        ];
        
        $this->dispatch('/album/add', 'POST', $postData);
        $this->assertResponseStatusCode(302);
        $this->assertRedirectTo('/album');
    }
}
