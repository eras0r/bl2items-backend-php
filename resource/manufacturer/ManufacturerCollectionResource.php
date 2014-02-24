<?php

require_once 'vendor/autoload.php';
require_once 'ManufacturerResourceHelper.php';

use Tonic\Application;
use Tonic\Response;
use Tonic\Request;

use Doctrine\DBAL\DBALException;


/**
 * This class defines the resource which will provide a RESTful interface for all operations
 * based on collections of the {@link Manufacturer} entity.
 * @uri /manufacturers
 * @uri /manufacturers/
 */
class ManufacturerCollectionResource extends AbstractCollectionEntityResource {

    /**
     * Constructor used by tonic.
     * @param Tonic\Application $app
     * @param Tonic\Request $request
     */
    function __construct(Application $app, Request $request) {
        parent::__construct($app, $request, new ManufacturerResourceHelper());
    }

    /**
     * Gets a list containing all manufacturer.
     *
     * @json
     * @method GET
     * @provides application/json
     */
    public function getAll() {
        $manufacturerRepository = $this->getEntityManager()->getRepository($this->getResourceHelper()->getEntityName());
        $manufacturers = array();

        foreach ($manufacturerRepository->findBy(array(), array('name' => 'asc')) as $m) {
            $manufacturers[] = $m->getJson();
        }

        return json_encode($manufacturers);
    }

}

?>
