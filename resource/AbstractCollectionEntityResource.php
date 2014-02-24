<?php

require_once 'AbstractEntityResource.php';

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\DBALException;

use Tonic\Application;
use Tonic\Resource;
use Tonic\Response;
use Tonic\Request;

/**
 * Abstract super class for all RESTful resources which are based on a collection of an entity's objects.
 */
abstract class AbstractCollectionEntityResource extends AbstractEntityResource {

    /**
     * Constructor used by tonic.
     * @param Tonic\Application $app
     * @param Tonic\Request $request
     * @param AbstractResourceHelper $resourceHelper
     */
    function __construct(Application $app, Request $request, AbstractResourceHelper $resourceHelper) {
        parent::__construct($app, $request, $resourceHelper);
    }

    /**
     * Adds a new damage type
     *
     * @method POST
     * @accepts application/json
     */
    public function add() {
        // json decode to associative array
        $properties = json_decode($this->request->data, true);
        $errors = $this->getResourceHelper()->validate($properties);
        if (!empty($errors)) {
            return new Response(AbstractResource::UNPROCESSABLE_ENTITY, json_encode($errors));
        } else {
            try {
                $damageType = $this->getResourceHelper()->createNewEntityInstance($properties);
                $this->getEntityManager()->persist($damageType);
                $this->getEntityManager()->flush();
                return new Response(Response::CREATED, json_encode($damageType->getJson()));
            } catch (DBALException $e) {
                return $this->handleUniqueKeyException($e);
            }
        }
    }

}
