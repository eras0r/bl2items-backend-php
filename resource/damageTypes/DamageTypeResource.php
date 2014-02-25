<?php

require_once 'vendor/autoload.php';
require_once 'DamageTypeResourceHelper.php';

use Tonic\Application;
use Tonic\Response;
use Tonic\Request;

use Doctrine\DBAL\DBALException;

/**
 * This class defines the resource which will provide a RESTful interface for all operations
 * based on single instances of the {@link DamageType} entity.
 * @uri /damageTypes/:id
 * @uri /damageTypes/:id/
 */
class DamageTypeResource extends AbstractSingleEntityResource {

    /**
     * Constructor used by tonic.
     * @param Tonic\Application $app
     * @param Tonic\Request $request
     */
    function __construct(Application $app, Request $request) {
        parent::__construct($app, $request, new DamageTypeResourceHelper());
    }

    /**
     * Updates a single damage type
     *
     * @method PUT
     * @accepts application/json
     * @provides application/json
     */
    public function update() {
        try {
            $jsonData = $this->prepareEntityObjectUpdate();

            // do the entity updates
            $damageType = $this->getEntityManager()->find($this->getResourceHelper()->getEntityName(), $this->id);
            $damageType->setName($jsonData["name"]);
            $damageType->setSortOrder($jsonData["sortOrder"]);

            return $this->saveEntityObject($damageType);
        } catch (EntityObjectValidationException $e) {
            return new Response(Response::NOTACCEPTABLE, json_encode($e->getValidationErrors()));
        }
    }

}
