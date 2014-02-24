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
 * Abstract super class for all RESTful resources which are based on a single object of an entity.
 */
abstract class AbstractSingleEntityResource extends AbstractEntityResource {

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
     * Gets a single manufacturer
     *
     * @method GET
     * @provides application/json
     */
    public function display() {
        $entityObj = $this->getEntityManager()->find($this->getEntityName(), $this->id);
        return json_encode($entityObj->getJson());
    }

}
