<?php

require_once 'vendor/autoload.php';
require_once 'ManufacturerResourceHelper.php';

use Tonic\Application;
use Tonic\Response;
use Tonic\Request;

use Doctrine\DBAL\DBALException;

/**
 * This class defines the resource which will provide a RESTful interface for all operations
 * based on single instances of the {@link Manufacturer} entity.
 * @uri /manufacturers/:id
 * @uri /manufacturers/:id/
 */
class ManufacturerResource extends AbstractSingleEntityResource {

    /**
     * Constructor used by tonic.
     * @param Tonic\Application $app
     * @param Tonic\Request $request
     */
    function __construct(Application $app, Request $request) {
        parent::__construct($app, $request, new ManufacturerResourceHelper());
    }

    /**
     * Updates a single manufacturer
     *
     * @method PUT
     * @accepts application/json
     * @provides application/json
     */
    public function update() {
        try {
            $jsonData = $this->prepareEntityObjectUpdate();

            // do the entity updates
            $manufacturer = $this->getEntityManager()->find($this->getResourceHelper()->getEntityName(), $this->id);
            $manufacturer->setName($jsonData["name"]);

            return $this->saveEntityObject($manufacturer);
        } catch (EntityObjectValidationException $e) {
            return new Response(Response::NOTACCEPTABLE, json_encode($e->getValidationErrors()));
        }
    }

}
